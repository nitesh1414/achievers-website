<?php
require_once __DIR__ . "/includes/admin_header.php";

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["delete_discipline"])) {
        db_query("DELETE FROM disciplines WHERE id = ?", [
            (int) $_POST["delete_discipline"],
        ]);
        $message = "Discipline and its apparatus list deleted.";
    } elseif (isset($_POST["delete_apparatus"])) {
        db_query("DELETE FROM apparatus WHERE id = ?", [
            (int) $_POST["delete_apparatus"],
        ]);
        $message = "Apparatus item deleted.";
    } elseif (isset($_POST["save_discipline"])) {
        $id = (int) ($_POST["id"] ?? 0);
        $name = content_limit(trim($_POST["name"] ?? ""), 100);
        $slug = slugify(content_limit($_POST["slug"] ?: $name, 100));
        $description = content_limit(trim($_POST["description"] ?? ""), 500);
        $sort_order = (int) ($_POST["sort_order"] ?? 0);
        $status =
            ($_POST["status"] ?? "active") === "inactive"
                ? "inactive"
                : "active";
        $image = str_replace("../", "", $_POST["old_image"] ?? "");
        if (!empty($_FILES["image"]["name"])) {
            $upload = upload_image($_FILES["image"], "uploads");
            if ($upload["success"]) {
                $image = $upload["filename"];
            } else {
                $error = $upload["error"];
            }
        }
        if (!$name) {
            $error = "Discipline name is required.";
        }
        if (!$error) {
            if ($id) {
                db_query(
                    "UPDATE disciplines SET name = ?, slug = ?, description = ?, image = ?, sort_order = ?, status = ? WHERE id = ?",
                    [
                        $name,
                        $slug,
                        $description,
                        $image,
                        $sort_order,
                        $status,
                        $id,
                    ]
                );
                $message = "Discipline updated.";
            } else {
                db_query(
                    "INSERT INTO disciplines (name, slug, description, image, sort_order, status) VALUES (?, ?, ?, ?, ?, ?)",
                    [$name, $slug, $description, $image, $sort_order, $status]
                );
                $message = "Discipline added.";
            }
        }
    } elseif (isset($_POST["save_apparatus"])) {
        $id = (int) ($_POST["id"] ?? 0);
        $discipline_id = (int) ($_POST["discipline_id"] ?? 0);
        $name = content_limit(trim($_POST["name"] ?? ""), 100);
        $gender = in_array(
            $_POST["gender"] ?? "",
            ["Women", "Men", "Mixed"],
            true
        )
            ? $_POST["gender"]
            : "Mixed";
        $description = content_limit(trim($_POST["description"] ?? ""), 255);
        $sort_order = (int) ($_POST["sort_order"] ?? 0);
        $status =
            ($_POST["status"] ?? "active") === "inactive"
                ? "inactive"
                : "active";
        if (!$discipline_id || !$name) {
            $error = "Discipline and apparatus name are required.";
        }
        if (!$error) {
            if ($id) {
                db_query(
                    "UPDATE apparatus SET discipline_id = ?, name = ?, gender = ?, description = ?, sort_order = ?, status = ? WHERE id = ?",
                    [
                        $discipline_id,
                        $name,
                        $gender,
                        $description,
                        $sort_order,
                        $status,
                        $id,
                    ]
                );
                $message = "Apparatus item updated.";
            } else {
                db_query(
                    "INSERT INTO apparatus (discipline_id, name, gender, description, sort_order, status) VALUES (?, ?, ?, ?, ?, ?)",
                    [
                        $discipline_id,
                        $name,
                        $gender,
                        $description,
                        $sort_order,
                        $status,
                    ]
                );
                $message = "Apparatus item added.";
            }
        }
    }
}

$disciplines = db_get_all(
    "SELECT * FROM disciplines ORDER BY sort_order ASC, name ASC"
);
$apparatus_items = db_get_all(
    "SELECT a.*, d.name AS discipline_name FROM apparatus a INNER JOIN disciplines d ON a.discipline_id = d.id ORDER BY d.sort_order ASC, a.gender ASC, a.sort_order ASC, a.name ASC"
);
$edit_discipline = isset($_GET["edit_discipline"])
    ? db_get_row("SELECT * FROM disciplines WHERE id = ?", [
        (int) $_GET["edit_discipline"],
    ])
    : null;
$edit_apparatus = isset($_GET["edit_apparatus"])
    ? db_get_row("SELECT * FROM apparatus WHERE id = ?", [
        (int) $_GET["edit_apparatus"],
    ])
    : null;
$show_discipline_form =
    (isset($_GET["action"]) && $_GET["action"] === "add-discipline") ||
    $edit_discipline;
$show_apparatus_form =
    (isset($_GET["action"]) && $_GET["action"] === "add-apparatus") ||
    $edit_apparatus;
?>
<div class="max-w-7xl">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 mb-5"><div><h1 class="text-2xl font-bold">Disciplines &amp; apparatus</h1><p class="text-sm text-slate-500">Build the courses-page discipline cards and their gender-wise apparatus lists, including WAG.</p></div><div class="flex flex-wrap gap-2"><a href="?action=add-discipline" class="btn-primary px-4 py-2 text-sm">+ Add discipline</a><a href="?action=add-apparatus" class="btn-accent px-4 py-2 text-sm">+ Add apparatus</a></div></div>
    <?php if (
        $message
    ): ?><div class="mb-4 px-4 py-3 bg-emerald-100 text-emerald-700 rounded-xl text-sm"><?= e(
    $message
) ?></div><?php endif; ?>
    <?php if (
        $error
    ): ?><div class="mb-4 px-4 py-3 bg-red-100 text-red-700 rounded-xl text-sm"><?= e(
    $error
) ?></div><?php endif; ?>

    <?php if ($show_discipline_form): ?>
        <form method="POST" enctype="multipart/form-data" class="max-w-2xl bg-white border rounded-2xl p-6 mb-7 space-y-4"><input type="hidden" name="save_discipline" value="1"><?php if (
            $edit_discipline
        ): ?><input type="hidden" name="id" value="<?= (int) $edit_discipline[
    "id"
] ?>"><input type="hidden" name="old_image" value="<?= e(
    $edit_discipline["image"]
) ?>"><?php endif; ?>
            <h2 class="font-bold text-lg"><?= $edit_discipline
                ? "Edit discipline"
                : "Add discipline" ?></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="block text-xs font-semibold mb-1">Discipline name</label><input name="name" maxlength="100" value="<?= e(
                $edit_discipline["name"] ?? ""
            ) ?>" class="w-full border px-3 py-2 rounded-xl" required></div><div><label class="block text-xs font-semibold mb-1">Slug</label><input name="slug" maxlength="100" value="<?= e(
    $edit_discipline["slug"] ?? ""
) ?>" class="w-full border px-3 py-2 rounded-xl" placeholder="Auto-generated"></div></div>
            <div><label class="block text-xs font-semibold mb-1">Description</label><textarea name="description" maxlength="500" rows="3" class="w-full border px-3 py-2 rounded-xl"><?= e(
                $edit_discipline["description"] ?? ""
            ) ?></textarea><p class="content-manager__hint">Maximum 500 characters.</p></div>
            <div><label class="block text-xs font-semibold mb-1">Discipline image (optional)</label><?php if (
                !empty($edit_discipline["image"])
            ): ?><img src="../<?= e(
    $edit_discipline["image"]
) ?>" class="content-manager__preview" alt="Current discipline image"><?php endif; ?><input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif" class="mt-2"></div>
            <div class="grid grid-cols-2 gap-4"><div><label class="block text-xs font-semibold mb-1">Sort order</label><input type="number" name="sort_order" value="<?= (int) ($edit_discipline[
                "sort_order"
            ] ??
                0) ?>" class="w-full border px-3 py-2 rounded-xl"></div><div><label class="block text-xs font-semibold mb-1">Status</label><select name="status" class="w-full border px-3 py-2 rounded-xl"><option value="active" <?= ($edit_discipline[
    "status"
] ??
    "active") ===
"active"
    ? "selected"
    : "" ?>>Active</option><option value="inactive" <?= ($edit_discipline[
    "status"
] ??
    "") ===
"inactive"
    ? "selected"
    : "" ?>>Hidden</option></select></div></div>
            <div><button class="btn-primary px-6 py-2 text-sm">Save discipline</button><a href="disciplines.php" class="ml-3 text-sm">Cancel</a></div>
        </form>
    <?php endif; ?>

    <?php if ($show_apparatus_form): ?>
        <form method="POST" class="max-w-2xl bg-white border rounded-2xl p-6 mb-7 space-y-4"><input type="hidden" name="save_apparatus" value="1"><?php if (
            $edit_apparatus
        ): ?><input type="hidden" name="id" value="<?= (int) $edit_apparatus[
    "id"
] ?>"><?php endif; ?>
            <h2 class="font-bold text-lg"><?= $edit_apparatus
                ? "Edit apparatus item"
                : "Add apparatus item" ?></h2>
            <?php if (
                !$disciplines
            ): ?><div class="rounded-xl bg-amber-100 p-3 text-amber-800 text-sm">Create a discipline before adding apparatus.</div><?php endif; ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="block text-xs font-semibold mb-1">Discipline</label><select name="discipline_id" class="w-full border px-3 py-2 rounded-xl" required <?php if (
                !$disciplines
            ) {
                echo "disabled";
            } ?>><option value="">Select discipline</option><?php foreach (
    $disciplines
    as $discipline
): ?><option value="<?= (int) $discipline["id"] ?>" <?= (int) ($edit_apparatus[
    "discipline_id"
] ?? 0) === (int) $discipline["id"]
    ? "selected"
    : "" ?>><?= e(
    $discipline["name"]
) ?></option><?php endforeach; ?></select></div><div><label class="block text-xs font-semibold mb-1">Gender list</label><select name="gender" class="w-full border px-3 py-2 rounded-xl"><option value="Women" <?= ($edit_apparatus[
    "gender"
] ??
    "") ===
"Women"
    ? "selected"
    : "" ?>>Women / WAG</option><option value="Men" <?= ($edit_apparatus[
    "gender"
] ??
    "") ===
"Men"
    ? "selected"
    : "" ?>>Men / MAG</option><option value="Mixed" <?= ($edit_apparatus[
    "gender"
] ??
    "Mixed") ===
"Mixed"
    ? "selected"
    : "" ?>>Mixed</option></select></div></div>
            <div><label class="block text-xs font-semibold mb-1">Apparatus name</label><input name="name" maxlength="100" value="<?= e(
                $edit_apparatus["name"] ?? ""
            ) ?>" class="w-full border px-3 py-2 rounded-xl" required></div>
            <div><label class="block text-xs font-semibold mb-1">Short description (optional)</label><input name="description" maxlength="255" value="<?= e(
                $edit_apparatus["description"] ?? ""
            ) ?>" class="w-full border px-3 py-2 rounded-xl"></div>
            <div class="grid grid-cols-2 gap-4"><div><label class="block text-xs font-semibold mb-1">Sort order</label><input type="number" name="sort_order" value="<?= (int) ($edit_apparatus[
                "sort_order"
            ] ??
                0) ?>" class="w-full border px-3 py-2 rounded-xl"></div><div><label class="block text-xs font-semibold mb-1">Status</label><select name="status" class="w-full border px-3 py-2 rounded-xl"><option value="active" <?= ($edit_apparatus[
    "status"
] ??
    "active") ===
"active"
    ? "selected"
    : "" ?>>Active</option><option value="inactive" <?= ($edit_apparatus[
    "status"
] ??
    "") ===
"inactive"
    ? "selected"
    : "" ?>>Hidden</option></select></div></div>
            <div><button class="btn-primary px-6 py-2 text-sm" <?= !$disciplines
                ? "disabled"
                : "" ?>>Save apparatus</button><a href="disciplines.php" class="ml-3 text-sm">Cancel</a></div>
        </form>
    <?php endif; ?>

    <div class="grid xl:grid-cols-2 gap-6">
        <section class="bg-white rounded-2xl border overflow-x-auto"><div class="px-5 py-4 border-b"><h2 class="font-bold">Disciplines</h2></div><table class="admin-table w-full text-sm"><thead><tr><th>Discipline</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead><tbody><?php
        if (
            !$disciplines
        ): ?><tr><td colspan="4" class="p-6 text-center text-slate-500">No disciplines yet.</td></tr><?php endif;
        foreach ($disciplines as $discipline): ?><tr><td><strong><?= e(
    $discipline["name"]
) ?></strong><br><span class="text-xs text-slate-500"><?= e(
    content_limit($discipline["description"], 75)
) ?></span></td><td><?= (int) $discipline[
    "sort_order"
] ?></td><td><?= get_status_badge(
    $discipline["status"]
) ?></td><td><a href="?edit_discipline=<?= (int) $discipline[
    "id"
] ?>" class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">Edit</a><form method="POST" class="inline" onsubmit="return confirm('Delete this discipline and all apparatus items?')"><input type="hidden" name="delete_discipline" value="<?= (int) $discipline[
    "id"
] ?>"><button class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">Delete</button></form></td></tr><?php endforeach;
        ?></tbody></table></section>
        <section class="bg-white rounded-2xl border overflow-x-auto"><div class="px-5 py-4 border-b"><h2 class="font-bold">Gender-wise apparatus</h2></div><table class="admin-table w-full text-sm"><thead><tr><th>Apparatus</th><th>Discipline</th><th>Gender</th><th>Actions</th></tr></thead><tbody><?php
        if (
            !$apparatus_items
        ): ?><tr><td colspan="4" class="p-6 text-center text-slate-500">No apparatus items yet.</td></tr><?php endif;
        foreach ($apparatus_items as $item): ?><tr><td><strong><?= e(
    $item["name"]
) ?></strong><?php if (
    $item["description"]
): ?><br><span class="text-xs text-slate-500"><?= e(
    $item["description"]
) ?></span><?php endif; ?></td><td><?= e(
    $item["discipline_name"]
) ?></td><td><?= e(
    $item["gender"]
) ?></td><td><a href="?edit_apparatus=<?= (int) $item[
    "id"
] ?>" class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">Edit</a><form method="POST" class="inline" onsubmit="return confirm('Delete this apparatus item?')"><input type="hidden" name="delete_apparatus" value="<?= (int) $item[
    "id"
] ?>"><button class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">Delete</button></form></td></tr><?php endforeach;
        ?></tbody></table></section>
    </div>
</div>
<?php require_once __DIR__ . "/includes/admin_footer.php"; ?>
