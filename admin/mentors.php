<?php
require_once __DIR__ . "/includes/admin_header.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["delete"])) {
        db_query("DELETE FROM mentors WHERE id=?", [intval($_POST["delete"])]);
        $msg = "Mentor deleted.";
    } elseif (isset($_POST["save"])) {
        $name = content_limit(trim($_POST["name"] ?? ""), 100);
        $designation = content_limit(trim($_POST["designation"] ?? ""), 150);
        $bio = content_limit(trim($_POST["bio"] ?? ""), 1000);
        $specialties = content_limit(trim($_POST["specialties"] ?? ""), 255);
        $experience = intval($_POST["experience_years"]);
        $status = $_POST["status"];

        $photo = $_POST["old_photo"] ?? "";
        if (!empty($_FILES["photo"]["name"])) {
            $upload = upload_image($_FILES["photo"], "uploads");
            if ($upload["success"]) {
                $photo = $upload["filename"];
            }
        }

        $photo = str_replace("../", "", $photo);

        if (!empty($_POST["id"])) {
            db_query(
                "UPDATE `mentors` SET name=?, designation=?, bio=?, photo=?, specialties=?, experience_years=?, status=? WHERE id=?",
                [
                    $name,
                    $designation,
                    $bio,
                    $photo,
                    $specialties,
                    $experience,
                    $status,
                    intval($_POST["id"]),
                ]
            );
            $msg = "Mentor updated.";
        } else {
            db_query(
                "INSERT INTO `mentors` (name, designation, bio, photo, specialties, experience_years, status) VALUES (?,?,?,?,?,?,?)",
                [
                    $name,
                    $designation,
                    $bio,
                    $photo,
                    $specialties,
                    $experience,
                    $status,
                ]
            );
            $msg = "Mentor added.";
        }
    }
}

$mentor = db_get_all("SELECT * FROM `mentors` ORDER BY id DESC");
$edit = isset($_GET["edit"])
    ? db_get_row("SELECT * FROM `mentors` WHERE id=?", [intval($_GET["edit"])])
    : null;
?>
<div>
    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold">Mentor Manager</h2>
        <a href="?action=add" class="btn-accent px-5 py-2 text-sm">+ Add Mentor</a>
    </div>

    <?php if (
        $msg
    ): ?><div class="mb-4 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-xl"><?= $msg ?></div><?php endif; ?>

    <?php if (isset($_GET["action"]) || $edit): ?>
        <div class="max-w-lg bg-white p-6 border rounded-2xl mb-8">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="save" value="1">
                <?php if ($edit): ?>
                    <input type="hidden" name="id" value="<?= $edit["id"] ?>">
                    <input type="hidden" name="old_photo" value="<?= e(
                        public_asset_path($edit["photo"])
                    ) ?>">
                <?php endif; ?>

                <div class="space-y-4">
                    <div><label class="block text-xs font-semibold">Full Name</label><input name="name" maxlength="100" value="<?= e(
                        $edit["name"] ?? ""
                    ) ?>" class="w-full border px-3 py-2 rounded-xl" required></div>
                    <div><label class="block text-xs font-semibold">Designation</label><input name="designation" maxlength="150" value="<?= e(
                        $edit["designation"] ?? ""
                    ) ?>" class="w-full border px-3 py-2 rounded-xl"></div>
                    <div><label class="block text-xs font-semibold">Bio</label><textarea name="bio" maxlength="1000" rows="5" class="w-full border px-3 py-2 rounded-xl"><?= e(
                        $edit["bio"] ?? ""
                    ) ?></textarea><p class="content-manager__hint">Maximum 1,000 characters.</p></div>
                    <div><label class="block text-xs font-semibold">Specialties</label><input name="specialties" maxlength="255" value="<?= e(
                        $edit["specialties"] ?? ""
                    ) ?>" class="w-full border px-3 py-2 rounded-xl"></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-xs font-semibold">Years Experience</label><input type="number" name="experience_years" value="<?= $edit[
                            "experience_years"
                        ] ??
                            0 ?>" class="w-full border px-3 py-2 rounded-xl"></div>
                        <div><label class="block text-xs font-semibold">Status</label>
                            <select name="status" class="w-full border px-3 py-2 rounded-xl">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold">Photo</label>
                        <?php if (
                            $edit &&
                            $edit["photo"]
                        ): ?><img src="../<?= e(
    public_asset_path($edit["photo"])
) ?>" class="h-16 w-24 object-contain bg-slate-100 mb-1 rounded"><br><?php endif; ?>
                        <input type="file" name="photo" accept="image/*">
                        <p class="content-manager__hint">Upload exactly 900 × 1200 px (3:4 portrait) so the public mentor card displays without an unexpected crop. JPG, PNG, WEBP or GIF; max 5 MB.</p>
                    </div>
                    <button class="btn-primary px-7 py-2 text-sm">Save Mentor</button>
                    <a href="mentor.php" class="ml-3">Cancel</a>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl overflow-hidden border">
        <table class="admin-table w-full text-sm">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name &amp; Role</th>
                    <th>Specialties</th>
                    <th>Exp</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mentor as $f): ?>
                    <tr>
                        <td><img src="../<?= e(
                            public_asset_path(
                                $f["photo"],
                                "assets/images/mentor-pankaj.jpg"
                            )
                        ) ?>" class="w-11 h-11 object-contain bg-slate-100 rounded"></td>
                        <td><strong><?= htmlspecialchars(
                            $f["name"]
                        ) ?></strong><br><span class="text-xs"><?= htmlspecialchars(
    $f["designation"]
) ?></span></td>
                        <td class="text-xs"><?= htmlspecialchars(
                            $f["specialties"]
                        ) ?></td>
                        <td><?= $f["experience_years"] ?> yrs</td>
                        <td><?= get_status_badge($f["status"]) ?></td>
                        <td>
                            <a href="?edit=<?= $f[
                                "id"
                            ] ?>" class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded">Edit</a>
                            <form method="POST" onsubmit="return confirm('Delete this mentor?')" class="inline">
                                <input type="hidden" name="delete" value="<?= $f[
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
