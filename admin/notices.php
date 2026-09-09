<?php
require_once __DIR__ . '/includes/admin_header.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        db_query("DELETE FROM notices WHERE id=?", [intval($_POST['delete'])]);
        $msg = "Notice deleted.";
    } elseif (isset($_POST['save'])) {
        $title = sanitize($_POST['title']);
        $content = sanitize($_POST['content']);
        $publish_date = $_POST['publish_date'];
        $status = $_POST['status'];
        
        $file_path = $_POST['old_file'] ?? '';
        if (!empty($_FILES['file']['name'])) {
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            
            $fname = uniqid('doc_') . '.' . $ext;
        
            $target = '../uploads/' . $fname;
            
            if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
                $file_path = 'uploads/' . $fname;
            }
        }
        
        if (!empty($_POST['id'])) {
            db_query("UPDATE notices SET title=?, content=?, file_path=?, publish_date=?, status=? WHERE id=?", [$title, $content, $file_path, $publish_date, $status, intval($_POST['id'])]);
            $msg = "Notice updated.";
        } else {
            db_query("INSERT INTO notices (title, content, file_path, publish_date, status) VALUES (?,?,?,?,?)", [$title, $content, $file_path, $publish_date, $status]);
            $msg = "Notice added.";
        }
    }
}

$notices = db_get_all("SELECT * FROM notices ORDER BY publish_date DESC");
$edit = isset($_GET['edit']) ? db_get_row("SELECT * FROM notices WHERE id=?", [intval($_GET['edit'])]) : null;
?>
<div>
    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold">Notice &amp; Download Manager</h2>
        <a href="?action=add" class="btn-accent px-5 py-2 text-sm">+ New Notice</a>
    </div>
    
    <?php if ($msg): ?><div class="mb-4 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-xl"><?= $msg ?></div><?php endif; ?>
    
    <?php if (isset($_GET['action']) || $edit): ?>
    <div class="max-w-xl bg-white border p-5 rounded-2xl mb-8">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="save" value="1">
            <?php if ($edit): ?>
                <input type="hidden" name="id" value="<?= $edit['id'] ?>">
                <input type="hidden" name="old_file" value="<?= "../" . htmlspecialchars($edit['file_path']) ?>">
            <?php endif; ?>
            
            <div><label class="block text-xs font-semibold">Title</label><input name="title" value="<?= htmlspecialchars($edit['title'] ?? '') ?>" class="w-full border px-3 py-2 rounded-xl" required></div>
            
            <div class="grid grid-cols-2 gap-4 mt-3">
                <div><label class="block text-xs font-semibold">Publish Date</label><input type="date" name="publish_date" value="<?= $edit['publish_date'] ?? date('Y-m-d') ?>" class="w-full border px-3 py-2 rounded-xl"></div>
                <div><label class="block text-xs font-semibold">Status</label>
                    <select name="status" class="w-full border px-3 py-2 rounded-xl">
                        <option value="published">Published</option>
                        <option value="unpublished">Unpublished</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-3"><label class="block text-xs font-semibold">Content / Announcement</label><textarea name="content" class="w-full border px-3 py-2 rounded-xl" rows="3"><?= htmlspecialchars($edit['content'] ?? '') ?></textarea></div>
            
            <div class="mt-3">
                <label class="block text-xs font-semibold">PDF / File (optional)</label>
                <?php if ($edit && $edit['file_path']): ?>
                    <div class="mb-1 text-xs"><a href="<?= "../".htmlspecialchars($edit['file_path']) ?>" target="_blank" class="text-blue-500">View current file</a></div>
                <?php endif; ?>
                <input type="file" name="file" accept=".pdf,.doc,.docx">
            </div>
            
            <button class="btn-primary px-6 py-2 mt-4 text-sm">Save Notice</button>
        </form>
    </div>
    <?php endif; ?>
    
    <div class="bg-white border rounded-2xl overflow-hidden">
        <table class="admin-table w-full text-sm">
            <thead><tr><th>Title</th><th>Date</th><th>File</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($notices as $n): ?>
                <tr>
                    <td class="font-semibold"><?= htmlspecialchars($n['title']) ?></td>
                    <td><?= $n['publish_date'] ?></td>
                    <td><?php if ($n['file_path']): ?><a href="<?= "../".$n['file_path'] ?>" target="_blank" class="text-blue-500">Download</a><?php else: ?>—<?php endif; ?></td>
                    <td><?= get_status_badge($n['status']) ?></td>
                    <td>
                        <a href="?edit=<?= $n['id'] ?>" class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded">Edit</a>
                        <form method="POST" onsubmit="confirmDelete(this.id)" class="inline">
                            <input type="hidden" name="delete" value="<?= $n['id'] ?>">
                            <button class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>