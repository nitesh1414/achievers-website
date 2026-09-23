<?php
require_once __DIR__ . "/includes/admin_header.php";

$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["delete"])) {
        db_query("DELETE FROM team_members WHERE id = ?", [(int) $_POST["delete"]]);
        $message = "Team member deleted.";
    } elseif (isset($_POST["save_team_member"])) {
        $name = content_limit(trim($_POST["name"] ?? ""), 100);
        $designation = content_limit(trim($_POST["designation"] ?? ""), 150);
        $bio = content_limit(trim($_POST["bio"] ?? ""), 1000);
        $specialties = content_limit(trim($_POST["specialties"] ?? ""), 255);
        $experience_years = max(0, (int) ($_POST["experience_years"] ?? 0));
        $status =
            ($_POST["status"] ?? "active") === "inactive"
                ? "inactive"
                : "active";
        $photo = str_replace(
            ["../", "..\\"],
            "",
            $_POST["old_photo"] ?? ""
        );

        if (!$name) {
            $error = "A team member name is required.";
        }

        if (!$error && !empty($_FILES["photo"]["name"])) {
            $upload = upload_image($_FILES["photo"], "uploads");
            if ($upload["success"]) {
                $photo = $upload["filename"];
            } else {
                $error = $upload["error"];
            }
        }

        if (!$error && !empty($_POST["id"])) {
            db_query(
                "UPDATE team_members SET name = ?, designation = ?, bio = ?, photo = ?, specialties = ?, experience_years = ?, status = ? WHERE id = ?",
                [
                    $name,
                    $designation,
                    $bio,
                    $photo,
                    $specialties,
                    $experience_years,
                    $status,
                    (int) $_POST["id"],
                ]
            );
            $message = "Team member updated.";
        } elseif (!$error) {
            db_query(
                "INSERT INTO team_members (name, designation, bio, photo, specialties, experience_years, status) VALUES (?, ?, ?, ?, ?, ?, ?)",
                [
                    $name,
                    $designation,
                    $bio,
                    $photo,
                    $specialties,
                    $experience_years,
                    $status,
                ]
            );
            $message = "Team member added.";
        }
    }
}

$team_members = db_get_all("SELECT * FROM team_members ORDER BY id DESC");
$edit = isset($_GET["edit"])
    ? db_get_row(
        "SELECT * FROM team_members WHERE id = ?",
        [(int) $_GET["edit"]]
    )
    : null;
?>
<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-5">
        <div>
            <h1 class="text-2xl font-bold">Our Team</h1>
            <p class="text-sm text-slate-500">Add the people who support your athletes, families and academy operations.</p>
        </div>
        <a href="?action=add" class="btn-accent px-5 py-2 text-sm">+ Add team member</a>
    </div>

    <?php if ($message): ?>
        <div class="mb-4 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-xl text-sm"><?= e(
            $message
        ) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="mb-4 px-4 py-2 bg-red-100 text-red-700 rounded-xl text-sm"><?= e(
            $error
        ) ?></div>
    <?php endif; ?>

    <?php if (isset($_GET["action"]) || $edit): ?>
        <div class="max-w-2xl bg-white p-6 border rounded-2xl mb-8">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="save_team_member" value="1">
                <?php if ($edit): ?>
                    <input type="hidden" name="id" value="<?= (int) $edit["id"] ?>">
                    <input type="hidden" name="old_photo" value="<?= e(
                        public_asset_path($edit["photo"])
                    ) ?>">
                <?php endif; ?>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold">Full name</label>
                        <input name="name" maxlength="100" value="<?= e(
                            $edit["name"] ?? ""
                        ) ?>" class="w-full border px-3 py-2 rounded-xl" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold">Role / designation</label>
                        <input name="designation" maxlength="150" value="<?= e(
                            $edit["designation"] ?? ""
                        ) ?>" class="w-full border px-3 py-2 rounded-xl" placeholder="Operations Manager, Physiotherapist or Coach">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold">Short bio</label>
                        <textarea name="bio" maxlength="1000" rows="5" class="w-full border px-3 py-2 rounded-xl"><?= e(
                            $edit["bio"] ?? ""
                        ) ?></textarea>
                        <p class="content-manager__hint">Maximum 1,000 characters.</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold">Areas of support / specialties</label>
                        <input name="specialties" maxlength="255" value="<?= e(
                            $edit["specialties"] ?? ""
                        ) ?>" class="w-full border px-3 py-2 rounded-xl" placeholder="Athlete care, administration, strength training">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold">Years of experience</label>
                            <input type="number" min="0" name="experience_years" value="<?= (int) (
                                $edit["experience_years"] ?? 0
                            ) ?>" class="w-full border px-3 py-2 rounded-xl">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold">Status</label>
                            <select name="status" class="w-full border px-3 py-2 rounded-xl">
                                <option value="active" <?= ($edit["status"] ?? "active") ===
                                "active"
                                    ? "selected"
                                    : "" ?>>Active</option>
                                <option value="inactive" <?= ($edit["status"] ?? "") ===
                                "inactive"
                                    ? "selected"
                                    : "" ?>>Hidden</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold">Profile photo</label>
                        <?php if ($edit && !empty($edit["photo"])): ?>
                            <img src="../<?= e(
                                public_asset_path($edit["photo"])
                            ) ?>" class="h-16 w-24 object-contain bg-slate-100 mb-2 rounded" alt="Current profile photo">
                        <?php endif; ?>
                        <input type="file" name="photo" accept="image/jpeg,image/png,image/webp,image/gif" class="text-sm">
                        <p class="content-manager__hint">Upload exactly 900 × 1200 px (3:4 portrait) so the public team card displays without an unexpected crop. JPG, PNG, WEBP or GIF; maximum 5 MB.</p>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button class="btn-primary px-7 py-2 text-sm">Save team member</button>
                        <a href="team.php" class="px-5 py-2 text-sm border border-slate-300 rounded-xl">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl overflow-x-auto border">
        <table class="admin-table w-full text-sm">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name &amp; role</th>
                    <th>Areas of support</th>
                    <th>Experience</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$team_members): ?>
                    <tr><td colspan="6" class="text-center text-slate-500">No team members have been added yet.</td></tr>
                <?php endif; ?>
                <?php foreach ($team_members as $member): ?>
                    <tr>
                        <td>
                            <?php if (!empty($member["photo"])): ?>
                                <img src="../<?= e(
                                    public_asset_path($member["photo"])
                                ) ?>" class="w-11 h-11 object-contain bg-slate-100 rounded" alt="<?= e(
    $member["name"]
) ?>">
                            <?php else: ?>
                                <span class="inline-flex w-11 h-11 items-center justify-center rounded bg-slate-100 text-slate-500"><i class="fa-solid fa-users" aria-hidden="true"></i></span>
                            <?php endif; ?>
                        </td>
                        <td><strong><?= e($member["name"]) ?></strong><br><span class="text-xs text-slate-500"><?= e(
                            $member["designation"]
                        ) ?></span></td>
                        <td class="text-xs"><?= e($member["specialties"]) ?></td>
                        <td><?= (int) $member["experience_years"] ?> yrs</td>
                        <td><?= get_status_badge($member["status"]) ?></td>
                        <td>
                            <a href="?edit=<?= (int) $member[
                                "id"
                            ] ?>" class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded">Edit</a>
                            <form method="POST" onsubmit="return confirm('Delete this team member?')" class="inline">
                                <input type="hidden" name="delete" value="<?= (int) $member[
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
