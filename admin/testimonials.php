<?php
require_once __DIR__ . '/includes/admin_header.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        db_query("DELETE FROM testimonials WHERE id=?", [intval($_POST['delete'])]);
        $msg = "Testimonial deleted.";
    } elseif (isset($_POST['save'])) {
        $name = sanitize($_POST['name']);
        $role = sanitize($_POST['role']);
        $quote = sanitize($_POST['quote']);
        $rating = max(1, min(5, intval($_POST['rating'])));
        $status = $_POST['status'];

        $photo = $_POST['old_photo'] ?? '';
        if (!empty($_FILES['photo']['name'])) {
            $upload = upload_image($_FILES['photo'], '../uploads');
            if ($upload['success']) $photo = $upload['filename'];
           // else echo "not uploaded";
        }

        if (!empty($_POST['id'])) {
            db_query("UPDATE testimonials SET name=?, role=?, quote=?, rating=?, photo=?, status=? WHERE id=?", 
                [$name, $role, $quote, $rating, $photo, $status, intval($_POST['id'])]);
            $msg = "Testimonial updated.";
        } else {
            db_query("INSERT INTO testimonials (name, role, quote, rating, photo, status) VALUES (?,?,?,?,?,?)", 
                [$name, $role, $quote, $rating, $photo, $status]);
            $msg = "Testimonial added.";
        }
    }
}

$testimonials = db_get_all("SELECT * FROM testimonials ORDER BY created_at DESC");
$edit = isset($_GET['edit']) ? db_get_row("SELECT * FROM testimonials WHERE id=?", [intval($_GET['edit'])]) : null;
?>
<div>
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold">Testimonials Manager</h2>
            <p class="text-sm text-slate-500">Manage customer reviews shown on homepage</p>
        </div>
        <a href="?action=add" class="btn-accent px-5 py-2 text-sm">+ Add Testimonial</a>
    </div>

    <?php if ($msg): ?>
        <div class="mb-4 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-xl text-sm"><?= $msg ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['action']) || $edit): ?>
    <div class="max-w-xl bg-white p-6 border rounded-2xl mb-8">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="save" value="1">
            <?php if ($edit): ?>
                <input type="hidden" name="id" value="<?= $edit['id'] ?>">
                <input type="hidden" name="old_photo" value="<?= htmlspecialchars($edit['photo'] ?? '') ?>">
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold mb-1">Name</label>
                    <input name="name" value="<?= htmlspecialchars($edit['name'] ?? '') ?>" class="w-full border px-3 py-2 rounded-xl" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Role / Relation</label>
                    <input name="role" value="<?= htmlspecialchars($edit['role'] ?? '') ?>" class="w-full border px-3 py-2 rounded-xl" placeholder="Parent of Aarav">
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-xs font-semibold mb-1">Testimonial Quote</label>
                <textarea name="quote" rows="3" class="w-full border px-3 py-2 rounded-xl" required><?= htmlspecialchars($edit['quote'] ?? '') ?></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-xs font-semibold mb-1">Rating</label>
                    <select name="rating" class="w-full border px-3 py-2 rounded-xl">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <option value="<?= $i ?>" <?= ($edit['rating'] ?? 5) == $i ? 'selected' : '' ?>><?= $i ?> ★</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold mb-1">Status</label>
                    <select name="status" class="w-full border px-3 py-2 rounded-xl">
                        <option value="active" <?= ($edit['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= ($edit['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <label class="block text-xs font-semibold mb-1">Photo (optional)</label>
                <?php if ($edit && !empty($edit['photo'])): ?>
                    <img src="<?= htmlspecialchars($edit['photo']) ?>" class="h-14 rounded mb-1 object-cover">
                <?php endif; ?>
                <input type="file" name="photo" accept="image/*" class="text-sm">
                <div class="text-[10px] text-slate-500">Leave blank to keep existing photo</div>
            </div>

            <div class="mt-5 flex gap-3">
                <button type="submit" class="btn-primary px-6 py-2 text-sm">Save Testimonial</button>
                <a href="testimonials.php" class="px-5 py-2 text-sm text-slate-600 hover:text-slate-800">Cancel</a>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border overflow-hidden">
        <table class="admin-table w-full text-sm">
            <thead>
                <tr>
                    <th class="w-12">Photo</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Quote</th>
                    <th class="text-center">Rating</th>
                    <th>Status</th>
                    <th class="w-28">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($testimonials)): ?>
                    <tr><td colspan="7" class="p-8 text-center text-slate-400">No testimonials yet. Click "+ Add Testimonial" to create one.</td></tr>
                <?php else: ?>
                    <?php foreach ($testimonials as $t): ?>
                    <tr>
                        <td>
                            <?php if (!empty($t['photo'])): ?>
                                <img src="<?= htmlspecialchars($t['photo']) ?>" class="w-10 h-10 object-cover rounded-full border">
                            <?php else: ?>
                                <div class="w-10 h-10 bg-slate-200 rounded-full flex items-center justify-center text-slate-400 text-xs">👤</div>
                            <?php endif; ?>
                        </td>
                        <td class="font-medium"><?= htmlspecialchars($t['name']) ?></td>
                        <td class="text-xs text-slate-500"><?= htmlspecialchars($t['role']) ?></td>
                        <td class="text-xs max-w-[280px] truncate"><?= htmlspecialchars(substr($t['quote'], 0, 80)) ?>...</td>
                        <td class="text-center text-amber-500">
                            <?= str_repeat('★', $t['rating']) ?>
                        </td>
                        <td><?= get_status_badge($t['status']) ?></td>
                        <td>
                            <div class="flex gap-1">
                                <a href="?edit=<?= $t['id'] ?>" class="px-2 py-0.5 text-xs bg-blue-100 text-blue-700 rounded">Edit</a>
                                <form method="POST" onsubmit="return confirm('Delete this testimonial?')" class="inline">
                                    <input type="hidden" name="delete" value="<?= $t['id'] ?>">
                                    <button class="px-2 py-0.5 text-xs bg-red-100 text-red-700 rounded">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>
