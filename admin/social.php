<?php
require_once __DIR__ . "/includes/admin_header.php";

$message = "";
$error = "";
$platforms = [
    "facebook" => "Facebook",
    "instagram" => "Instagram",
    "linkedin" => "LinkedIn",
    "whatsapp" => "WhatsApp",
    "youtube" => "YouTube",
    "x" => "X / Twitter",
    "telegram" => "Telegram",
    "pinterest" => "Pinterest",
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["delete"])) {
        db_query("DELETE FROM social_links WHERE id = ?", [
            (int) $_POST["delete"],
        ]);
        $message = "Social link deleted.";
    } elseif (isset($_POST["save_social"])) {
        $id = (int) ($_POST["id"] ?? 0);
        $icon = strtolower(trim($_POST["icon"] ?? ""));
        $platform = content_limit(trim($_POST["platform"] ?? ""), 50);
        $url = content_limit(trim($_POST["url"] ?? ""), 255);
        $sort_order = (int) ($_POST["sort_order"] ?? 0);
        $is_active = isset($_POST["is_active"]) ? 1 : 0;
        if (!$platform || !$url) {
            $error = "Platform and URL are required.";
        } elseif (!filter_var($url, FILTER_VALIDATE_URL)) {
            $error = "Please provide a valid full URL, including https://.";
        }
        if (!$error) {
            if ($id) {
                db_query(
                    "UPDATE social_links SET platform = ?, url = ?, icon = ?, sort_order = ?, is_active = ? WHERE id = ?",
                    [$platform, $url, $icon, $sort_order, $is_active, $id]
                );
                $message = "Social link updated.";
            } else {
                db_query(
                    "INSERT INTO social_links (platform, url, icon, sort_order, is_active) VALUES (?, ?, ?, ?, ?)",
                    [$platform, $url, $icon, $sort_order, $is_active]
                );
                $message = "Social link added.";
            }
        }
    }
}

$socials = db_get_all(
    "SELECT * FROM social_links ORDER BY sort_order ASC, id ASC"
);
$edit = isset($_GET["edit"])
    ? db_get_row("SELECT * FROM social_links WHERE id = ?", [
        (int) $_GET["edit"],
    ])
    : null;
?>
<div class="max-w-5xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-6"><div><h1 class="text-2xl font-bold">Social media</h1><p class="text-sm text-slate-500">These active links are automatically displayed in the header, footer and contact page. Manage the WhatsApp number in <a href="settings.php" class="font-semibold text-amber-700">Website Settings</a>.</p></div><a href="?action=add" class="btn-accent px-5 py-2 text-sm">+ Add social link</a></div>
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
        <form method="POST" class="bg-white p-6 rounded-2xl border mb-8 max-w-xl space-y-4"><input type="hidden" name="save_social" value="1"><?php if (
            $edit
        ): ?><input type="hidden" name="id" value="<?= (int) $edit[
    "id"
] ?>"><?php endif; ?>
            <div><label class="text-xs font-semibold">Platform</label><select name="icon" class="w-full border px-3 py-2 rounded-xl" onchange="this.form.elements.platform.value=this.options[this.selectedIndex].text"><option value="">Choose platform</option><?php foreach (
                $platforms
                as $key => $label
            ): ?><option value="<?= e($key) ?>" <?= ($edit["icon"] ?? "") ===
$key
    ? "selected"
    : "" ?>><?= e($label) ?></option><?php endforeach; ?></select></div>
            <div><label class="text-xs font-semibold">Platform label</label><input name="platform" maxlength="50" value="<?= e(
                $edit["platform"] ?? ""
            ) ?>" class="w-full border px-3 py-2 rounded-xl" required placeholder="Facebook"></div>
            <div><label class="text-xs font-semibold">URL</label><input type="url" name="url" maxlength="255" value="<?= e(
                $edit["url"] ?? ""
            ) ?>" class="w-full border px-3 py-2 rounded-xl" required placeholder="https://..."></div>
            <div class="grid grid-cols-2 gap-4"><div><label class="text-xs font-semibold">Sort order</label><input type="number" name="sort_order" value="<?= (int) ($edit[
                "sort_order"
            ] ??
                0) ?>" class="w-full border px-3 py-2 rounded-xl"></div><label class="flex items-end gap-2 pb-2 text-sm"><input type="checkbox" name="is_active" value="1" <?= (int) ($edit[
    "is_active"
] ?? 1)
    ? "checked"
    : "" ?> class="w-4 h-4"> Show on website</label></div>
            <div class="flex gap-3"><button type="submit" class="btn-primary px-6 py-2 text-sm">Save link</button><a href="social.php" class="px-5 py-2 text-sm border rounded-xl">Cancel</a></div>
        </form>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border overflow-x-auto"><table class="admin-table w-full text-sm"><thead><tr><th>Platform</th><th>URL</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead><tbody>
        <?php if (
            !$socials
        ): ?><tr><td colspan="5" class="p-7 text-center text-slate-500">No social links yet.</td></tr><?php endif; ?>
        <?php foreach (
            $socials
            as $social
        ): ?><tr><td class="font-medium"><i class="fa-brands <?= e(
    social_icon_class($social["icon"], $social["platform"])
) ?> mr-2" aria-hidden="true"></i><?= e(
     $social["platform"]
 ) ?></td><td class="text-xs text-slate-600 max-w-[320px] truncate"><a href="<?= e(
    $social["url"]
) ?>" target="_blank" rel="noopener noreferrer" class="hover:text-amber-700"><?= e(
    $social["url"]
) ?></a></td><td><?= (int) $social["sort_order"] ?></td><td><?= (int) $social[
    "is_active"
]
    ? '<span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded text-xs">Active</span>'
    : '<span class="px-2 py-0.5 bg-gray-200 rounded text-xs">Hidden</span>' ?></td><td><div class="flex gap-2"><a href="?edit=<?= (int) $social[
    "id"
] ?>" class="text-xs px-3 py-1 bg-blue-100 text-blue-700 rounded">Edit</a><form method="POST" onsubmit="return confirm('Delete this social link?')"><input type="hidden" name="delete" value="<?= (int) $social[
    "id"
] ?>"><button class="text-xs px-3 py-1 bg-red-100 text-red-700 rounded">Delete</button></form></div></td></tr><?php endforeach; ?>
    </tbody></table></div>
</div>
<?php require_once __DIR__ . "/includes/admin_footer.php"; ?>
