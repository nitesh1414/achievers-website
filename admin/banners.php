<?php
require_once __DIR__ . "/includes/admin_header.php";

$message = "";
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["delete"])) {
        db_query("DELETE FROM banners WHERE id = ?", [(int) $_POST["delete"]]);
        $message = "Banner deleted.";
    } elseif (isset($_POST["save_banner"])) {
        $title = content_limit(trim($_POST["title"] ?? ""), 70);
        $subtitle = content_limit(trim($_POST["subtitle"] ?? ""), 150);
        $link_url = content_limit(trim($_POST["link_url"] ?? ""), 255);
        $sort_order = (int) ($_POST["sort_order"] ?? 0);
        $status =
            ($_POST["status"] ?? "active") === "inactive"
                ? "inactive"
                : "active";
        $show_content = isset($_POST["show_content"]) ? 1 : 0;
        $image = str_replace("../", "", $_POST["old_image"] ?? "");

        if (!empty($_FILES["image"]["name"])) {
            $upload = upload_image($_FILES["image"], "uploads");
            if ($upload["success"]) {
                $image = $upload["filename"];
            } else {
                $error = $upload["error"];
            }
        }

        if (!$error && !$image) {
            $error = "A banner image is required.";
        }
        if (!$error) {
            if (!empty($_POST["id"])) {
                db_query(
                    "UPDATE banners SET title = ?, subtitle = ?, link_url = ?, sort_order = ?, image = ?, show_content = ?, status = ? WHERE id = ?",
                    [
                        $title,
                        $subtitle,
                        $link_url,
                        $sort_order,
                        $image,
                        $show_content,
                        $status,
                        (int) $_POST["id"],
                    ]
                );
                $message = "Banner updated.";
            } else {
                db_query(
                    "INSERT INTO banners (title, subtitle, image, link_url, sort_order, show_content, status) VALUES (?, ?, ?, ?, ?, ?, ?)",
                    [
                        $title,
                        $subtitle,
                        $image,
                        $link_url,
                        $sort_order,
                        $show_content,
                        $status,
                    ]
                );
                $message = "Banner added.";
            }
        }
    }
}

$banners = db_get_all("SELECT * FROM banners ORDER BY sort_order ASC, id ASC");
$edit = isset($_GET["edit"])
    ? db_get_row("SELECT * FROM banners WHERE id = ?", [(int) $_GET["edit"]])
    : null;
?>
<div class="max-w-6xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5"><div><h1 class="text-2xl font-bold">Banner slider</h1><p class="text-sm text-slate-500">Use the visibility control to show an image-only banner or an image with its text and buttons.</p></div><a href="?action=add" class="btn-accent px-5 py-2 text-sm">+ Add banner</a></div>
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

    <?php if (
        (isset($_GET["action"]) && $_GET["action"] === "add") ||
        $edit
    ): ?>
        <form method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl border space-y-4 max-w-2xl mb-8">
            <input type="hidden" name="save_banner" value="1">
            <?php if (
                $edit
            ): ?><input type="hidden" name="id" value="<?= (int) $edit[
    "id"
] ?>"><input type="hidden" name="old_image" value="<?= e(
    $edit["image"]
) ?>"><?php endif; ?>
            <div><label class="block text-xs font-semibold mb-1">Label / eyebrow</label><input name="title" maxlength="70" value="<?= e(
                $edit["title"] ?? ""
            ) ?>" class="w-full border px-3 py-2 rounded-xl"><p class="content-manager__hint">Maximum 70 characters.</p></div>
            <div><label class="block text-xs font-semibold mb-1">Banner headline</label><textarea name="subtitle" maxlength="150" rows="2" class="w-full border px-3 py-2 rounded-xl"><?= e(
                $edit["subtitle"] ?? ""
            ) ?></textarea><p class="content-manager__hint">Maximum 150 characters; keep it concise for mobile.</p></div>
            <div><label class="block text-xs font-semibold mb-1">Optional link URL</label><input name="link_url" maxlength="255" value="<?= e(
                $edit["link_url"] ?? ""
            ) ?>" class="w-full border px-3 py-2 rounded-xl" placeholder="courses.php"></div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4"><div><label class="block text-xs font-semibold mb-1">Sort order</label><input type="number" name="sort_order" value="<?= (int) ($edit[
                "sort_order"
            ] ??
                0) ?>" class="w-full border px-3 py-2 rounded-xl"></div><div><label class="block text-xs font-semibold mb-1">Status</label><select name="status" class="w-full border px-3 py-2 rounded-xl"><option value="active" <?= ($edit[
    "status"
] ??
    "active") ===
"active"
    ? "selected"
    : "" ?>>Active</option><option value="inactive" <?= ($edit["status"] ??
    "") ===
"inactive"
    ? "selected"
    : "" ?>>Hidden</option></select></div><label class="flex items-end gap-2 pb-2 text-sm font-semibold"><input type="checkbox" name="show_content" value="1" <?= !isset(
    $edit["show_content"]
) || (int) ($edit["show_content"] ?? 1) === 1
    ? "checked"
    : "" ?> class="w-4 h-4"> Show banner text</label></div>
            <div><label class="block text-xs font-semibold mb-1">Banner image</label><?php if (
                !empty($edit["image"])
            ): ?><img src="../<?= e(
    $edit["image"]
) ?>" class="content-manager__preview" alt="Current banner preview"><?php endif; ?><input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif" class="mt-2"><p class="content-manager__hint">Landscape image recommended; JPG, PNG, WEBP or GIF, max 5 MB.</p></div>
            <div class="flex gap-2"><button type="submit" class="btn-primary px-7 py-2 text-sm">Save banner</button><a href="banners.php" class="px-5 py-2 text-sm border rounded-xl">Cancel</a></div>
        </form>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border overflow-x-auto"><table class="admin-table w-full text-sm"><thead><tr><th>Image</th><th>Text</th><th>Display</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead><tbody>
        <?php foreach ($banners as $banner): ?><tr><td><img src="../<?= e(
    $banner["image"]
) ?>" class="h-12 w-20 object-cover rounded border" alt=""></td><td><strong><?= e(
    $banner["title"]
) ?></strong><br><span class="text-xs text-slate-500"><?= e(
    $banner["subtitle"]
) ?></span></td><td><?= !isset($banner["show_content"]) ||
(int) $banner["show_content"]
    ? "Image + text"
    : "Image only" ?></td><td><?= (int) $banner[
    "sort_order"
] ?></td><td><?= get_status_badge(
    $banner["status"]
) ?></td><td><div class="flex gap-2"><a href="?edit=<?= (int) $banner[
    "id"
] ?>" class="text-xs px-3 py-1 bg-blue-100 text-blue-700 rounded">Edit</a><form method="POST" onsubmit="return confirm('Delete this banner?')"><input type="hidden" name="delete" value="<?= (int) $banner[
    "id"
] ?>"><button class="text-xs px-3 py-1 bg-red-100 text-red-700 rounded">Delete</button></form></div></td></tr><?php endforeach; ?>
    </tbody></table></div>
</div>
<?php require_once __DIR__ . "/includes/admin_footer.php"; ?>
