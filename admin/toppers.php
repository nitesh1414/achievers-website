<?php
require_once __DIR__ . "/includes/admin_header.php";

$msg = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["delete"])) {
        db_query("DELETE FROM toppers WHERE id=?", [intval($_POST["delete"])]);
        $msg = "Topper record deleted.";
    } elseif (isset($_POST["save"])) {
        $name = content_limit(trim($_POST["name"] ?? ""), 100);
        $rank = content_limit(trim($_POST["rank"] ?? ""), 50);
        $year = intval($_POST["year"]);
        $achievement = content_limit(trim($_POST["achievement"] ?? ""), 600);
        $course = content_limit(trim($_POST["course"] ?? ""), 150);
        $status = $_POST["status"];

        $photo = $_POST["old_photo"] ?? "";
        if (!empty($_FILES["photo"]["name"])) {
            $upload = upload_image($_FILES["photo"], "uploads");
            if ($upload["success"]) {
                $photo = $upload["filename"];
            }
        }

        if (!empty($_POST["id"])) {
            db_query(
                "UPDATE toppers SET name=?, rank=?, year=?, achievement=?, photo=?, course=?, status=? WHERE id=?",
                [
                    $name,
                    $rank,
                    $year,
                    $achievement,
                    $photo,
                    $course,
                    $status,
                    intval($_POST["id"]),
                ]
            );
            $msg = "Topper updated.";
        } else {
            db_query(
                "INSERT INTO toppers (name, rank, year, achievement, photo, course, status) VALUES (?,?,?,?,?,?,?)",
                [$name, $rank, $year, $achievement, $photo, $course, $status]
            );
            $msg = "Topper added.";
        }
    }
}

$toppers = db_get_all("SELECT * FROM toppers ORDER BY year DESC");
$edit = isset($_GET["edit"])
    ? db_get_row("SELECT * FROM toppers WHERE id=?", [intval($_GET["edit"])])
    : null;
?>
<div>
    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold">Toppers / Achievers Manager</h2>
        <a href="?action=add" class="btn-accent px-5 py-2 text-sm">+ Add Topper</a>
    </div>
    
    <?php if (
        $msg
    ): ?><div class="mb-4 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-xl"><?= $msg ?></div><?php endif; ?>
    
    <?php if (isset($_GET["action"]) || $edit): ?>
    <div class="max-w-lg bg-white p-5 border rounded-2xl mb-8">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="save" value="1">
            <?php if ($edit): ?><input type="hidden" name="id" value="<?= $edit[
    "id"
] ?>"><input type="hidden" name="old_photo" value="<?= htmlspecialchars(
    $edit["photo"]
) ?>"><?php endif; ?>
            
            <div class="space-y-4">
                <div><label class="block text-xs font-semibold">Student Name</label><input name="name" maxlength="100" value="<?= e(
                    $edit["name"] ?? ""
                ) ?>" class="w-full border px-3 py-2 rounded-xl" required></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-xs font-semibold">Rank / Medal</label><input name="rank" maxlength="50" value="<?= e(
                        $edit["rank"] ?? ""
                    ) ?>" class="w-full border px-3 py-2 rounded-xl"></div>
                    <div><label class="block text-xs font-semibold">Year</label><input type="number" name="year" value="<?= $edit[
                        "year"
                    ] ??
                        date(
                            "Y"
                        ) ?>" class="w-full border px-3 py-2 rounded-xl"></div>
                </div>
                <div><label class="block text-xs font-semibold">Achievement</label><textarea name="achievement" maxlength="600" rows="3" class="w-full border px-3 py-2 rounded-xl"><?= e(
                    $edit["achievement"] ?? ""
                ) ?></textarea></div>
                <div><label class="block text-xs font-semibold">Program / Course</label><input name="course" maxlength="150" value="<?= e(
                    $edit["course"] ?? ""
                ) ?>" class="w-full border px-3 py-2 rounded-xl"></div>
                
                <div>
                    <label class="text-xs font-semibold">Photo</label>
                    <?php if ($edit && $edit["photo"]): ?><img src="../<?= e(
    $edit["photo"]
) ?>" class="h-14 rounded mb-1"><br><?php endif; ?>
                    <input type="file" name="photo" accept="image/*">
                </div>
                
                <div>
                    <label class="text-xs font-semibold">Status</label>
                    <select name="status" class="w-full border px-3 py-2 rounded-xl">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary px-6 py-2">Save Topper</button>
            </div>
        </form>
    </div>
    <?php endif; ?>
    
    <div class="bg-white rounded-2xl border overflow-hidden">
        <table class="admin-table w-full text-sm">
            <thead><tr><th>Photo</th><th>Name</th><th>Rank &amp; Year</th><th>Achievement</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                <?php foreach ($toppers as $t): ?>
                <tr>
                    <td><img src="../<?= e(
                        $t["photo"] ?: "assets/images/topper-aarav.jpg"
                    ) ?>" class="w-10 h-10 object-cover rounded"></td>
                    <td class="font-semibold"><?= htmlspecialchars(
                        $t["name"]
                    ) ?></td>
                    <td><?= htmlspecialchars($t["rank"]) ?> (<?= $t[
     "year"
 ] ?>)</td>
                    <td class="text-xs"><?= htmlspecialchars(
                        $t["achievement"]
                    ) ?></td>
                    <td><?= get_status_badge($t["status"]) ?></td>
                    <td>
                        <a href="?edit=<?= $t[
                            "id"
                        ] ?>" class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded">Edit</a>
                        <form method="POST" onsubmit="return confirm('Delete this achiever?')" class="inline">
                            <input type="hidden" name="delete" value="<?= $t[
                                "id"
                            ] ?>">
                            <button class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . "/includes/admin_footer.php"; ?>
