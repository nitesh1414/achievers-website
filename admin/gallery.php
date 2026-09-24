<?php
require_once __DIR__ . "/includes/admin_header.php";

$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["delete"])) {
        db_query("DELETE FROM gallery WHERE id=?", [intval($_POST["delete"])]);
        $msg = "Gallery item deleted.";
    } elseif (isset($_POST["save"])) {
        $title = content_limit(trim($_POST["title"] ?? ""), 255);
        $category = content_limit(trim($_POST["category"] ?? ""), 100);
        $description = content_limit(trim($_POST["description"] ?? ""), 1000);
        $event_date = $_POST["event_date"];
        $status = $_POST["status"];

        $image = $_POST["old_image"] ?? "";
        if (!empty($_FILES["image"]["name"])) {
            $upload = upload_image($_FILES["image"], "uploads");
            if ($upload["success"]) {
                $image = $upload["filename"];
            }
        }

        $image = str_replace("../", "", $image);

        if (!empty($_POST["id"])) {
            db_query(
                "UPDATE gallery SET title=?, category=?, image=?, description=?, event_date=?, status=? WHERE id=?",
                [
                    $title,
                    $category,
                    $image,
                    $description,
                    $event_date,
                    $status,
                    intval($_POST["id"]),
                ]
            );
            $msg = "Gallery updated.";
        } else {
            db_query(
                "INSERT INTO gallery (title, image, category, description, event_date, status) VALUES (?,?,?,?,?,?)",
                [$title, $image, $category, $description, $event_date, $status]
            );
            $msg = "Gallery item added.";
        }
    }
}

$gallery = db_get_all("SELECT * FROM gallery ORDER BY created_at DESC");
$edit = isset($_GET["edit"])
    ? db_get_row("SELECT * FROM gallery WHERE id=?", [intval($_GET["edit"])])
    : null;
?>
<div>
    <div class="flex justify-between mb-5">
        <h2 class="text-2xl font-bold">Gallery Manager</h2>
        <a href="?action=add" class="btn-accent px-5 py-2 text-sm">+ Add New Image</a>
    </div>
    
    <?php if (
        $msg
    ): ?><div class="mb-4 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-xl"><?= $msg ?></div><?php endif; ?>
    
    <?php if (isset($_GET["action"]) || $edit): ?>
    <div class="max-w-lg mb-7 bg-white border p-5 rounded-2xl">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="save" value="1">
            <?php if ($edit): ?>
                <input type="hidden" name="id" value="<?= $edit["id"] ?>">
                <input type="hidden" name="old_image" value="<?= "../" .
                    htmlspecialchars($edit["image"]) ?>">
            <?php endif; ?>
            
            <div class="space-y-4">
                <div><label class="text-xs font-semibold">Title</label><input name="title" maxlength="255" value="<?= e(
                    $edit["title"] ?? ""
                ) ?>" class="w-full border px-3 py-2 rounded-xl" required></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="text-xs font-semibold">Category</label><input name="category" maxlength="100" value="<?= e(
                        $edit["category"] ?? "Competition"
                    ) ?>" class="w-full border px-3 py-2 rounded-xl"></div>
                    <div><label class="text-xs font-semibold">Event Date</label><input type="date" name="event_date" value="<?= $edit[
                        "event_date"
                    ] ??
                        date(
                            "Y-m-d"
                        ) ?>" class="w-full border px-3 py-2 rounded-xl"></div>
                </div>
                <div><label class="text-xs font-semibold">Description</label><textarea name="description" maxlength="1000" rows="4" class="w-full border px-3 py-2 rounded-xl"><?= e(
                    $edit["description"] ?? ""
                ) ?></textarea></div>
                
                <div>
                    <label class="text-xs font-semibold">Image</label>
                    <?php if ($edit && $edit["image"]): ?><img src="<?= "../" .
    htmlspecialchars(
        $edit["image"]
    ) ?>" class="h-16 rounded mb-1"><br><?php endif; ?>
                    <input type="file" name="image" accept="image/*" <?= !$edit
                        ? "required"
                        : "" ?>>
                    <p class="content-manager__hint">Upload exactly 1000 × 800 px (5:4) for the public gallery tile. JPG, PNG, WEBP or GIF; max 5 MB.</p>
                </div>
                
                <div>
                    <label class="text-xs font-semibold">Status</label>
                    <select name="status" class="w-full border px-3 py-2 rounded-xl">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <button class="btn-primary px-7 py-2">Save Image</button>
            </div>
        </form>
    </div>
    <?php endif; ?>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <?php foreach ($gallery as $g): ?>
        <div class="bg-white border rounded-2xl overflow-hidden">
            <img src="<?= "../" .
                htmlspecialchars(
                    $g["image"]
                ) ?>" class="w-full h-40 object-cover">
            <div class="p-3 text-sm">
                <div class="font-semibold"><?= htmlspecialchars(
                    $g["title"]
                ) ?></div>
                <div class="text-xs text-amber-600"><?= htmlspecialchars(
                    $g["category"]
                ) ?> • <?= $g["event_date"] ?></div>
                <div class="flex justify-between items-center mt-3">
                    <?= get_status_badge($g["status"]) ?>
                    <div class="text-xs flex gap-1">
                        <a href="?edit=<?= $g[
                            "id"
                        ] ?>" class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded">Edit</a>
                        <form method="POST" onsubmit="return confirm('Delete this gallery image?')">
                            <input type="hidden" name="delete" value="<?= $g[
                                "id"
                            ] ?>">
                            <button class="px-2 py-0.5 bg-red-100 text-red-700 rounded">Del</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php require_once __DIR__ . "/includes/admin_footer.php"; ?>
