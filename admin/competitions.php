<?php
require_once __DIR__ . "/includes/admin_header.php";

$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["delete"])) {
        db_query("DELETE FROM competitions WHERE id=?", [
            intval($_POST["delete"]),
        ]);
        $msg = "Competition deleted.";
    } elseif (isset($_POST["save"])) {
        $title = content_limit(trim($_POST["title"] ?? ""), 255);
        $event_date = $_POST["event_date"];
        $type = $_POST["type"];
        $location = content_limit(trim($_POST["location"] ?? ""), 150);
        $description = content_limit(trim($_POST["description"] ?? ""), 1500);
        $how_to_apply = content_limit(trim($_POST["how_to_apply"] ?? ""), 1500);
        $results = content_limit(trim($_POST["results"] ?? ""), 1500);
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
                "UPDATE competitions SET title=?, event_date=?, type=?, location=?, description=?, how_to_apply=?, results=?, image=?, status=? WHERE id=?",
                [
                    $title,
                    $event_date,
                    $type,
                    $location,
                    $description,
                    $how_to_apply,
                    $results,
                    $image,
                    $status,
                    intval($_POST["id"]),
                ]
            );
            $msg = "Competition updated.";
        } else {
            db_query(
                "INSERT INTO competitions (title, event_date, type, location, description, how_to_apply, results, image, status) VALUES (?,?,?,?,?,?,?,?,?)",
                [
                    $title,
                    $event_date,
                    $type,
                    $location,
                    $description,
                    $how_to_apply,
                    $results,
                    $image,
                    $status,
                ]
            );
            $msg = "Competition added.";
        }
    }
}

$comps = db_get_all("SELECT * FROM competitions ORDER BY event_date DESC");
$edit = isset($_GET["edit"])
    ? db_get_row("SELECT * FROM competitions WHERE id=?", [
        intval($_GET["edit"]),
    ])
    : null;
?>
<div>
    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold">Competitions Manager</h2>
        <a href="?action=add" class="btn-accent px-5 py-2 text-sm">+ Add Competition</a>
    </div>
    
    <?php if (
        $msg
    ): ?><div class="mb-4 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-xl"><?= $msg ?></div><?php endif; ?>
    
    <?php if (isset($_GET["action"]) || $edit): ?>
    <div class="max-w-xl bg-white p-5 rounded-2xl border mb-8">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="save" value="1">
            <?php if ($edit): ?><input type="hidden" name="id" value="<?= $edit[
    "id"
] ?>"><input type="hidden" name="old_image" value="<?= "../" .
    htmlspecialchars($edit["image"]) ?>"><?php endif; ?>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2"><label class="block text-xs font-semibold">Title</label><input name="title" value="<?= htmlspecialchars(
                    $edit["title"] ?? ""
                ) ?>" class="w-full border px-3 py-2 rounded-xl" required></div>
                
                <div><label class="block text-xs font-semibold">Event Date</label><input type="date" name="event_date" value="<?= $edit[
                    "event_date"
                ] ??
                    date(
                        "Y-m-d"
                    ) ?>" class="w-full border px-3 py-2 rounded-xl" required></div>
                <div><label class="block text-xs font-semibold">Type</label>
                    <select name="type" class="w-full border px-3 py-2 rounded-xl">
                        <option value="future">Future</option>
                        <option value="past">Past</option>
                    </select>
                </div>
                
                <div><label class="block text-xs font-semibold">Location</label><input name="location" value="<?= htmlspecialchars(
                    $edit["location"] ?? ""
                ) ?>" class="w-full border px-3 py-2 rounded-xl"></div>
                <div><label class="block text-xs font-semibold">Status</label>
                    <select name="status" class="w-full border px-3 py-2 rounded-xl">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-4"><label class="block text-xs font-semibold">Description</label><textarea name="description" class="w-full border px-3 py-2 rounded-xl"><?= htmlspecialchars(
                $edit["description"] ?? ""
            ) ?></textarea></div>
            <div class="mt-4"><label class="block text-xs font-semibold">How to Apply (for future events)</label><textarea name="how_to_apply" class="w-full border px-3 py-2 rounded-xl"><?= htmlspecialchars(
                $edit["how_to_apply"] ?? ""
            ) ?></textarea></div>
            <div class="mt-4"><label class="block text-xs font-semibold">Results (for past events)</label><textarea name="results" class="w-full border px-3 py-2 rounded-xl"><?= htmlspecialchars(
                $edit["results"] ?? ""
            ) ?></textarea></div>
            
            <div class="mt-4">
                <label class="block text-xs font-semibold">Image</label>
                <?php if ($edit && $edit["image"]): ?><img src="<?= "../" .
    $edit["image"] ?>" class="h-16 mb-1 rounded"><br><?php endif; ?>
                <input type="file" name="image" accept="image/*">
            </div>
            
            <button class="mt-4 btn-primary px-7 py-2 text-sm">Save Competition</button>
        </form>
    </div>
    <?php endif; ?>
    
    <div class="bg-white border rounded-2xl overflow-hidden">
        <table class="admin-table w-full text-sm">
            <thead><tr><th>Title</th><th>Date</th><th>Type</th><th>Location</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($comps as $c): ?>
                <tr>
                    <td class="font-semibold"><?= htmlspecialchars(
                        $c["title"]
                    ) ?></td>
                    <td><?= $c["event_date"] ?></td>
                    <td><span class="text-xs px-2 py-0.5 rounded <?= $c[
                        "type"
                    ] === "future"
                        ? "bg-blue-100 text-blue-700"
                        : "bg-gray-100" ?>"><?= ucfirst(
    $c["type"]
) ?></span></td>
                    <td><?= htmlspecialchars($c["location"]) ?></td>
                    <td><?= get_status_badge($c["status"]) ?></td>
                    <td>
                        <a href="?edit=<?= $c[
                            "id"
                        ] ?>" class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded">Edit</a>
                        <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this competition?')">
                            <input type="hidden" name="delete" value="<?= $c[
                                "id"
                            ] ?>">
                            <button class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded">Del</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . "/includes/admin_footer.php"; ?>
