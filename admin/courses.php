<?php
require_once __DIR__ . "/includes/admin_header.php";

$action = $_GET["action"] ?? "list";
$id = (int) ($_GET["id"] ?? 0);
$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["delete"])) {
        db_query("DELETE FROM courses WHERE id = ?", [(int) $_POST["delete"]]);
        $message = "Course deleted successfully.";
    } elseif (isset($_POST["save_course"])) {
        $title = content_limit(trim($_POST["title"] ?? ""), 120);
        $slug = slugify(content_limit($_POST["slug"] ?: $title, 150));
        $category_id = (int) ($_POST["category_id"] ?? 0);
        $discipline_id = (int) ($_POST["discipline_id"] ?? 0) ?: null;
        $description = content_limit(trim($_POST["description"] ?? ""), 500);
        $syllabus = content_limit(trim($_POST["syllabus"] ?? ""), 2000);
        $duration = content_limit(trim($_POST["duration"] ?? ""), 100);
        $status =
            ($_POST["status"] ?? "active") === "inactive"
                ? "inactive"
                : "active";
        $thumbnail = str_replace("../", "", $_POST["old_thumbnail"] ?? "");

        if (!empty($_FILES["thumbnail"]["name"])) {
            $upload = upload_image($_FILES["thumbnail"], "uploads");
            if ($upload["success"]) {
                $thumbnail = $upload["filename"];
            } else {
                $error = $upload["error"];
            }
        }
        if (!$title || !$category_id) {
            $error = "Course title and category are required.";
        }
        if (!$error) {
            if ($id > 0) {
                db_query(
                    "UPDATE courses SET title = ?, slug = ?, category_id = ?, discipline_id = ?, description = ?, syllabus = ?, duration = ?, thumbnail = ?, status = ? WHERE id = ?",
                    [
                        $title,
                        $slug,
                        $category_id,
                        $discipline_id,
                        $description,
                        $syllabus,
                        $duration,
                        $thumbnail,
                        $status,
                        $id,
                    ]
                );
                $message = "Course updated successfully.";
            } else {
                db_query(
                    "INSERT INTO courses (category_id, discipline_id, title, slug, description, syllabus, duration, thumbnail, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                    [
                        $category_id,
                        $discipline_id,
                        $title,
                        $slug,
                        $description,
                        $syllabus,
                        $duration,
                        $thumbnail,
                        $status,
                    ]
                );
                $message = "New course added successfully.";
            }
            $action = "list";
        }
    }
}

$categories = db_get_all("SELECT * FROM course_categories ORDER BY name ASC");
$disciplines = db_get_all(
    "SELECT * FROM disciplines WHERE status = 'active' ORDER BY sort_order ASC, name ASC"
);
$courses = db_get_all(
    "SELECT c.*, cat.name AS cat_name, d.name AS discipline_name FROM courses c LEFT JOIN course_categories cat ON c.category_id = cat.id LEFT JOIN disciplines d ON c.discipline_id = d.id ORDER BY c.id DESC"
);
$edit_course =
    $action === "edit" && $id > 0
        ? db_get_row("SELECT * FROM courses WHERE id = ?", [$id])
        : null;
?>
<div class="max-w-7xl">
    <?php if (
        $message
    ): ?><div class="bg-emerald-100 text-emerald-700 px-4 py-3 mb-4 rounded-xl text-sm"><?= e(
    $message
) ?></div><?php endif; ?>
    <?php if (
        $error
    ): ?><div class="bg-red-100 text-red-700 px-4 py-3 mb-4 rounded-xl text-sm"><?= e(
    $error
) ?></div><?php endif; ?>

    <?php if ($action === "list"): ?>
        <div class="flex flex-col sm:flex-row gap-3 justify-between mb-5"><div><h1 class="text-2xl font-bold">Courses manager</h1><p class="text-sm text-slate-500">Manage course content and images. Fees are intentionally not shown anywhere on the website.</p></div><div class="flex gap-2"><a href="disciplines.php" class="px-4 py-2 text-sm border rounded-xl">Manage disciplines</a><a href="?action=add" class="btn-accent px-5 py-2 text-sm">+ Add course</a></div></div>
        <div class="bg-white rounded-2xl shadow overflow-x-auto border"><table class="admin-table w-full text-sm"><thead><tr><th>Course</th><th>Category</th><th>Discipline</th><th>Duration</th><th>Status</th><th>Actions</th></tr></thead><tbody>
            <?php if (
                !$courses
            ): ?><tr><td colspan="6" class="text-center p-8 text-slate-500">No courses have been created yet.</td></tr><?php endif; ?>
            <?php foreach (
                $courses
                as $course
            ): ?><tr><td><div class="font-semibold"><?= e(
    $course["title"]
) ?></div><div class="text-xs text-slate-400">/<?= e(
    $course["slug"]
) ?></div></td><td><?= e($course["cat_name"] ?: "—") ?></td><td><?= e(
    $course["discipline_name"] ?: "—"
) ?></td><td><?= e($course["duration"]) ?></td><td><?= get_status_badge(
    $course["status"]
) ?></td><td><div class="flex gap-1.5"><a href="?action=edit&id=<?= (int) $course[
    "id"
] ?>" class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded">Edit</a><form method="POST" onsubmit="return confirm('Delete this course?')"><input type="hidden" name="delete" value="<?= (int) $course[
    "id"
] ?>"><button type="submit" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded">Delete</button></form></div></td></tr><?php endforeach; ?>
        </tbody></table></div>
    <?php else: ?>
        <div class="max-w-2xl"><div class="mb-4 flex justify-between"><h1 class="text-2xl font-bold"><?= $edit_course
            ? "Edit course"
            : "Add new course" ?></h1><a href="courses.php" class="text-sm">← Back to list</a></div>
            <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl border space-y-4"><input type="hidden" name="save_course" value="1"><?php if (
                $edit_course
            ): ?><input type="hidden" name="old_thumbnail" value="<?= e(
    $edit_course["thumbnail"]
) ?>"><?php endif; ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="block text-xs font-semibold mb-1">Course title</label><input type="text" name="title" maxlength="120" value="<?= e(
                    $edit_course["title"] ?? ""
                ) ?>" class="w-full border px-3 py-2 rounded-xl" required></div><div><label class="block text-xs font-semibold mb-1">Slug (URL)</label><input type="text" name="slug" maxlength="150" value="<?= e(
    $edit_course["slug"] ?? ""
) ?>" class="w-full border px-3 py-2 rounded-xl" placeholder="Auto-generated from title"></div></div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="block text-xs font-semibold mb-1">Course category</label><select name="category_id" class="w-full border px-3 py-2 rounded-xl" required><option value="">Select a category</option><?php foreach (
                    $categories
                    as $category
                ): ?><option value="<?= (int) $category[
    "id"
] ?>" <?= (int) ($edit_course["category_id"] ?? 0) === (int) $category["id"]
    ? "selected"
    : "" ?>><?= e(
    $category["name"]
) ?></option><?php endforeach; ?></select></div><div><label class="block text-xs font-semibold mb-1">Gymnastics discipline</label><select name="discipline_id" class="w-full border px-3 py-2 rounded-xl"><option value="">Not assigned</option><?php foreach (
    $disciplines
    as $discipline
): ?><option value="<?= (int) $discipline["id"] ?>" <?= (int) ($edit_course[
    "discipline_id"
] ?? 0) === (int) $discipline["id"]
    ? "selected"
    : "" ?>><?= e(
    $discipline["name"]
) ?></option><?php endforeach; ?></select></div></div>
                <div><label class="block text-xs font-semibold mb-1">Description</label><textarea name="description" rows="4" maxlength="500" class="w-full border px-3 py-2 rounded-xl"><?= e(
                    $edit_course["description"] ?? ""
                ) ?></textarea><p class="content-manager__hint">Maximum 500 characters.</p></div>
                <div><label class="block text-xs font-semibold mb-1">Program details (one item per line)</label><textarea name="syllabus" rows="5" maxlength="2000" class="w-full border px-3 py-2 rounded-xl"><?= e(
                    $edit_course["syllabus"] ?? ""
                ) ?></textarea></div>
                <div><label class="block text-xs font-semibold mb-1">Duration</label><input type="text" name="duration" maxlength="100" value="<?= e(
                    $edit_course["duration"] ?? ""
                ) ?>" class="w-full border px-3 py-2 rounded-xl"></div>
                <div><label class="block text-xs font-semibold mb-1">Thumbnail image</label><?php if (
                    !empty($edit_course["thumbnail"])
                ): ?><img src="../<?= e(
    $edit_course["thumbnail"]
) ?>" class="content-manager__preview" alt="Current course thumbnail"><?php endif; ?><input type="file" name="thumbnail" accept="image/jpeg,image/png,image/webp,image/gif" class="w-full text-sm mt-2"><p class="content-manager__hint">JPG, PNG, WEBP or GIF; max 5 MB.</p></div>
                <div><label class="block text-xs font-semibold mb-1">Status</label><select name="status" class="w-full border px-3 py-2 rounded-xl"><option value="active" <?= ($edit_course[
                    "status"
                ] ??
                    "active") ===
                "active"
                    ? "selected"
                    : "" ?>>Active</option><option value="inactive" <?= ($edit_course[
    "status"
] ??
    "") ===
"inactive"
    ? "selected"
    : "" ?>>Hidden</option></select></div>
                <div class="pt-3"><button type="submit" class="btn-primary px-8 py-2.5 text-sm">Save course</button><a href="courses.php" class="ml-3 text-sm text-slate-500">Cancel</a></div>
            </form>
        </div>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . "/includes/admin_footer.php"; ?>
