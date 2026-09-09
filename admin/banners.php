<?php
require_once __DIR__ . '/includes/admin_header.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        db_query("DELETE FROM banners WHERE id=?", [intval($_POST['delete'])]);
        $msg = "Banner deleted.";
    } elseif (isset($_POST['save_banner'])) {
        $title = sanitize($_POST['title']);
        $subtitle = sanitize($_POST['subtitle']);
        $link_url = sanitize($_POST['link_url']);
        $sort_order = intval($_POST['sort_order']);
        $status = $_POST['status'];

        $image = $_POST['old_image'] ?? '';
        
        if (!empty($_FILES['image']['name'])) {
            $upload = upload_image($_FILES['image'], '../uploads');
            if ($upload['success']) $image = $upload['filename'];
        }
        $image = str_replace('../', '', $image);

        if (!empty($_POST['id'])) {
            db_query(
                "UPDATE banners SET title=?, subtitle=?, link_url=?, sort_order=?, image=?, status=? WHERE id=?",
                [$title, $subtitle, $link_url, $sort_order, $image, $status, intval($_POST['id'])]
            );
            $msg = "Banner updated.";
        } else {
            db_query(
                "INSERT INTO banners (title, subtitle, image, link_url, sort_order, status) VALUES (?,?,?,?,?,?)",
                [$title, $subtitle, $image, $link_url, $sort_order, $status]
            );
            $msg = "Banner added.";
        }
    }
}

$banners = db_get_all("SELECT * FROM banners ORDER BY sort_order ASC");
$edit = null;
if (isset($_GET['edit'])) {
    $edit = db_get_row("SELECT * FROM banners WHERE id=?", [intval($_GET['edit'])]);
}
?>
<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5">
        <h2 class="text-2xl font-bold">Banner / Hero Slider</h2>

        <div class="flex flex-wrap gap-2">
            <a href="?action=add" class="btn-accent px-5 py-2 text-sm">+ Add New Banner</a>


        </div>
    </div>

    <?php if ($msg): ?><div class="mb-4 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-xl text-sm"><?= $msg ?></div><?php endif; ?>

    <?php if (isset($_GET['action']) && $_GET['action'] === 'add' || $edit): ?>
        <div class="max-w-lg mb-8">
            <form method="POST" enctype="multipart/form-data" class="bg-white p-5 rounded-2xl border space-y-4">
                <?php if ($edit): ?><input type="hidden" name="id" value="<?= $edit['id'] ?>"><input type="hidden" name="old_image" value="<?= "../".htmlspecialchars($edit['image']) ?>"><?php endif; ?>
                <input type="hidden" name="save_banner" value="1">

                <div><label class="text-xs font-semibold">Title</label><input name="title" value="<?= htmlspecialchars($edit['title'] ?? '') ?>" class="w-full border px-3 py-2 rounded-xl" required></div>
                <div><label class="text-xs font-semibold">Subtitle</label><input name="subtitle" value="<?= htmlspecialchars($edit['subtitle'] ?? '') ?>" class="w-full border px-3 py-2 rounded-xl"></div>
                <div><label class="text-xs font-semibold">Link URL</label><input name="link_url" value="<?= htmlspecialchars($edit['link_url'] ?? '') ?>" class="w-full border px-3 py-2 rounded-xl" placeholder="/courses"></div>

                <div class="grid grid-cols-2 gap-4">
                    <div><label class="text-xs font-semibold">Sort Order</label><input type="number" name="sort_order" value="<?= $edit['sort_order'] ?? '0' ?>" class="w-full border px-3 py-2 rounded-xl"></div>
                    <div><label class="text-xs font-semibold">Status</label>
                        <select name="status" class="w-full border px-3 py-2 rounded-xl">
                            <option value="active" <?= ($edit['status'] ?? 'active') == 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= ($edit['status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="text-xs font-semibold">Hero Image</label>
                    <?php if ($edit && $edit['image']): ?>
                        <img src="<?= "../".htmlspecialchars($edit['image']) ?>" class="h-20 mt-1 mb-1 rounded border" style="max-width:220px"><br>
                    <?php endif; ?>
                    <input type="file" name="image" accept="image/*">
                    <div class="text-[10px] text-slate-500 mt-1">Recommended: 1376×768px or larger</div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="btn-primary px-7 py-2 text-sm">Save Banner</button>
                    <a href="banners.php" class="px-5 py-2 text-sm">Cancel</a>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border overflow-hidden">
        <table class="admin-table w-full text-sm">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($banners as $b): ?>
                    <tr>
                        <td><img src="<?= "../".htmlspecialchars($b['image']) ?>" class="h-12 w-20 object-cover rounded border"></td>
                        <td><?= htmlspecialchars($b['title']) ?><br><span class="text-xs text-slate-400"><?= htmlspecialchars($b['subtitle']) ?></span></td>
                        <td><a href="<?= htmlspecialchars($b['link_url']) ?>" target="_blank" class="text-xs text-blue-500"><?= htmlspecialchars($b['link_url']) ?></a></td>
                        <td><?= $b['sort_order'] ?></td>
                        <td><?= get_status_badge($b['status']) ?></td>
                        <td class="flex gap-x-2">
                            <a href="?edit=<?= $b['id'] ?>" class="text-xs px-3 py-1 bg-blue-100 text-blue-700 rounded">Edit</a>
                            <form method="POST" onsubmit="event.preventDefault(); confirmDelete(this.id)">
                                <input type="hidden" name="delete" value="<?= $b['id'] ?>">
                                <button class="text-xs px-3 py-1 bg-red-100 text-red-700 rounded">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>