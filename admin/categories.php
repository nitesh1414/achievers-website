<?php
require_once __DIR__ . "/includes/admin_header.php";

$message = "";
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["delete"])) {
        db_query("DELETE FROM course_categories WHERE id = ?", [
            (int) $_POST["delete"],
        ]);
        $message =
            "Course category deleted. Courses are kept and become uncategorised.";
    } elseif (isset($_POST["save_category"])) {
        $id = (int) ($_POST["id"] ?? 0);
        $name = content_limit(trim($_POST["name"] ?? ""), 100);
        $slug = slugify(content_limit($_POST["slug"] ?: $name, 100));
        $description = content_limit(trim($_POST["description"] ?? ""), 500);
        $icon = content_limit(trim($_POST["icon"] ?? ""), 100);
        $status =
            ($_POST["status"] ?? "active") === "inactive"
                ? "inactive"
                : "active";
        if (!$name) {
            $error = "Category name is required.";
        }
        if (!$error) {
            if ($id) {
                db_query(
                    "UPDATE course_categories SET name = ?, slug = ?, description = ?, icon = ?, status = ? WHERE id = ?",
                    [$name, $slug, $description, $icon, $status, $id]
                );
                $message = "Course category updated.";
            } else {
                db_query(
                    "INSERT INTO course_categories (name, slug, description, icon, status) VALUES (?, ?, ?, ?, ?)",
                    [$name, $slug, $description, $icon, $status]
                );
                $message = "Course category added.";
            }
        }
    }
}
$categories = db_get_all(
    "SELECT c.*, COUNT(course.id) AS course_count FROM course_categories c LEFT JOIN courses course ON course.category_id = c.id GROUP BY c.id ORDER BY c.name ASC"
);
$edit = isset($_GET["edit"])
    ? db_get_row("SELECT * FROM course_categories WHERE id = ?", [
        (int) $_GET["edit"],
    ])
    : null;
?>
<div class="max-w-5xl"><div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6"><div><h1 class="text-2xl font-bold">Course categories</h1><p class="text-sm text-slate-500">Manage the course grouping labels used on the training pages.</p></div><a href="?action=add" class="btn-accent px-5 py-2 text-sm">+ Add category</a></div><?php
if (
    $message
): ?><div class="mb-4 p-3 bg-emerald-100 text-emerald-700 rounded-xl text-sm"><?= e(
    $message
) ?></div><?php endif;
if (
    $error
): ?><div class="mb-4 p-3 bg-red-100 text-red-700 rounded-xl text-sm"><?= e(
    $error
) ?></div><?php endif;
?>
<?php if (
    (isset($_GET["action"]) && $_GET["action"] === "add") ||
    $edit
): ?><form method="POST" class="max-w-xl bg-white border p-6 rounded-2xl mb-8 space-y-4"><input type="hidden" name="save_category" value="1"><?php if (
    $edit
): ?><input type="hidden" name="id" value="<?= (int) $edit[
    "id"
] ?>"><?php endif; ?><div><label class="text-xs font-semibold">Category name</label><input name="name" maxlength="100" value="<?= e(
    $edit["name"] ?? ""
) ?>" class="w-full border px-3 py-2 rounded-xl" required></div><div><label class="text-xs font-semibold">Slug</label><input name="slug" maxlength="100" value="<?= e(
    $edit["slug"] ?? ""
) ?>" class="w-full border px-3 py-2 rounded-xl" placeholder="Auto-generated"></div><div><label class="text-xs font-semibold">Description</label><textarea name="description" maxlength="500" rows="3" class="w-full border px-3 py-2 rounded-xl"><?= e(
    $edit["description"] ?? ""
) ?></textarea></div><div><label class="text-xs font-semibold">Icon name / emoji (optional)</label><input name="icon" maxlength="100" value="<?= e(
    $edit["icon"] ?? ""
) ?>" class="w-full border px-3 py-2 rounded-xl"></div><div><label class="text-xs font-semibold">Status</label><select name="status" class="w-full border px-3 py-2 rounded-xl"><option value="active" <?= ($edit[
    "status"
] ??
    "active") ===
"active"
    ? "selected"
    : "" ?>>Active</option><option value="inactive" <?= ($edit["status"] ??
    "") ===
"inactive"
    ? "selected"
    : "" ?>>Hidden</option></select></div><div><button class="btn-primary px-6 py-2 text-sm">Save category</button><a href="categories.php" class="ml-3 text-sm">Cancel</a></div></form><?php endif; ?>
<div class="bg-white border rounded-2xl overflow-x-auto"><table class="admin-table w-full text-sm"><thead><tr><th>Category</th><th>Description</th><th>Courses</th><th>Status</th><th>Actions</th></tr></thead><tbody><?php foreach (
    $categories
    as $category
): ?><tr><td><strong><?= e(
    $category["name"]
) ?></strong><br><span class="text-xs text-slate-400">/<?= e(
    $category["slug"]
) ?></span></td><td class="text-xs text-slate-600"><?= e(
    content_limit($category["description"], 115)
) ?></td><td><?= (int) $category[
    "course_count"
] ?></td><td><?= get_status_badge(
    $category["status"]
) ?></td><td><a href="?edit=<?= (int) $category[
    "id"
] ?>" class="text-xs px-3 py-1 bg-blue-100 text-blue-700 rounded">Edit</a><form method="POST" class="inline" onsubmit="return confirm('Delete this category?')"><input type="hidden" name="delete" value="<?= (int) $category[
    "id"
] ?>"><button class="text-xs px-3 py-1 bg-red-100 text-red-700 rounded">Delete</button></form></td></tr><?php endforeach; ?></tbody></table></div></div>
<?php require_once __DIR__ . "/includes/admin_footer.php"; ?>
