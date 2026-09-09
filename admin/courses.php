<?php
require_once __DIR__ . '/includes/admin_header.php';

$action = $_GET['action'] ?? 'list';
$id = intval($_GET['id'] ?? 0);
$msg = '';

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $del_id = intval($_POST['delete']);
        db_query("DELETE FROM courses WHERE id = ?", [$del_id]);
        $msg = "Course deleted successfully.";
    } elseif (isset($_POST['save_course'])) {
        $title = sanitize($_POST['title']);
        $slug = slugify($_POST['slug'] ?: $title);
        $category_id = intval($_POST['category_id']);
        $description = sanitize($_POST['description']);
        $syllabus = sanitize($_POST['syllabus']);
        $duration = sanitize($_POST['duration']);
        $fees = floatval($_POST['fees']);
        $status = $_POST['status'];
        
        // Handle thumbnail upload
        $thumbnail = $_POST['old_thumbnail'] ?? '';
        if (!empty($_FILES['thumbnail']['name'])) {
            $upload = upload_image($_FILES['thumbnail'], '../uploads');
            if ($upload['success']) $thumbnail = $upload['filename'];
        }

        $thumbnail = str_replace('../', '', $thumbnail);
        
        if ($id > 0) {
            db_query("UPDATE courses SET title=?, slug=?, category_id=?, description=?, syllabus=?, duration=?, fees=?, thumbnail=?, status=? WHERE id=?", 
                [$title, $slug, $category_id, $description, $syllabus, $duration, $fees, $thumbnail, $status, $id]);
            $msg = "Course updated successfully!";
        } else {
            db_query("INSERT INTO courses (category_id, title, slug, description, syllabus, duration, fees, thumbnail, status) VALUES (?,?,?,?,?,?,?,?,?)", 
                [$category_id, $title, $slug, $description, $syllabus, $duration, $fees, $thumbnail, $status]);
            $msg = "New course added successfully!";
        }
        $action = 'list';
    }
}

// Get data
$categories = db_get_all("SELECT * FROM course_categories ORDER BY name");
$courses = db_get_all("SELECT c.*, cat.name as cat_name FROM courses c LEFT JOIN course_categories cat ON c.category_id=cat.id ORDER BY c.id DESC");

// Edit data
$edit_course = null;
if ($action === 'edit' && $id > 0) {
    $edit_course = db_get_row("SELECT * FROM courses WHERE id=?", [$id]);
}
?>
<div class="max-w-7xl">
    <?php if ($msg): ?>
        <div class="bg-emerald-100 text-emerald-700 px-4 py-2 mb-4 rounded-xl text-sm"><?= $msg ?></div>
    <?php endif; ?>
    
    <?php if ($action === 'list'): ?>
        <div class="flex justify-between mb-4">
            <h2 class="text-2xl font-bold">Courses Manager</h2>
            <a href="?action=add" class="btn-accent px-6 py-2 text-sm">+ Add New Course</a>
        </div>
        
        <div class="bg-white rounded-2xl shadow overflow-hidden border">
            <table class="admin-table w-full text-sm">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Fees</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th class="w-28">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $c): ?>
                    <tr>
                        <td>
                            <div class="font-semibold"><?= htmlspecialchars($c['title']) ?></div>
                            <div class="text-xs text-slate-400">/<?= htmlspecialchars($c['slug']) ?></div>
                        </td>
                        <td><?= htmlspecialchars($c['cat_name'] ?? '—') ?></td>
                        <td><?= format_currency($c['fees']) ?></td>
                        <td><?= htmlspecialchars($c['duration']) ?></td>
                        <td><?= get_status_badge($c['status']) ?></td>
                        <td class="flex gap-1.5">
                            <a href="?action=edit&id=<?= $c['id'] ?>" class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded">Edit</a>
                            <form method="POST" class="inline" onsubmit="event.preventDefault(); confirmDelete(this.id);">
                                <input type="hidden" name="delete" value="<?= $c['id'] ?>">
                                <button type="submit" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
    <?php else: ?>
        <!-- Add/Edit Form -->
        <div class="max-w-2xl">
            <div class="mb-4 flex justify-between">
                <h2 class="text-2xl font-bold"><?= $edit_course ? 'Edit Course' : 'Add New Course' ?></h2>
                <a href="courses.php" class="text-sm">← Back to list</a>
            </div>
            
            <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl border space-y-4">
                <input type="hidden" name="save_course" value="1">
                <?php if ($edit_course): ?>
                    <input type="hidden" name="old_thumbnail" value="<?= htmlspecialchars($edit_course['thumbnail']) ?>">
                <?php endif; ?>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1">Course Title</label>
                        <input type="text" name="title" value="<?= htmlspecialchars($edit_course['title'] ?? '') ?>" class="w-full border px-3 py-2 rounded-xl" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1">Slug (URL)</label>
                        <input type="text" name="slug" value="<?= htmlspecialchars($edit_course['slug'] ?? '') ?>" class="w-full border px-3 py-2 rounded-xl" placeholder="auto-generated">
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold mb-1">Category</label>
                    <select name="category_id" class="w-full border px-3 py-2 rounded-xl" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= ($edit_course && $edit_course['category_id'] == $cat['id']) ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full border px-3 py-2 rounded-xl"><?= htmlspecialchars($edit_course['description'] ?? '') ?></textarea>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold mb-1">Syllabus (line by line)</label>
                    <textarea name="syllabus" rows="4" class="w-full border px-3 py-2 rounded-xl" placeholder="Week 1: Basics..."><?= htmlspecialchars($edit_course['syllabus'] ?? '') ?></textarea>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1">Duration</label>
                        <input type="text" name="duration" value="<?= htmlspecialchars($edit_course['duration'] ?? '') ?>" class="w-full border px-3 py-2 rounded-xl">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1">Fees (₹)</label>
                        <input type="number" step="0.01" name="fees" value="<?= htmlspecialchars($edit_course['fees'] ?? '0') ?>" class="w-full border px-3 py-2 rounded-xl">
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold mb-1">Thumbnail Image</label>
                    <?php if ($edit_course && $edit_course['thumbnail']): ?>
                        <div class="mb-2"><img src="<?= "../".htmlspecialchars($edit_course['thumbnail']) ?>" class="h-16 rounded object-cover"></div>
                    <?php endif; ?>
                    <input type="file" name="thumbnail" accept="image/*" class="w-full text-sm">
                    <p class="text-xs text-slate-400">JPG, PNG, WEBP (Max 5MB)</p>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold mb-1">Status</label>
                    <select name="status" class="w-full border px-3 py-2 rounded-xl">
                        <option value="active" <?= ($edit_course['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= ($edit_course['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                
                <div class="pt-3">
                    <button type="submit" class="btn-primary px-8 py-2.5 text-sm">Save Course</button>
                    <a href="courses.php" class="ml-3 text-sm text-slate-500">Cancel</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>