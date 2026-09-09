<?php
require_once __DIR__ . "/includes/admin_header.php";

$message = "";
$errors = [];
$limits = [
    "site_name" => 100,
    "tagline" => 160,
    "phone" => 30,
    "whatsapp" => 20,
    "email" => 120,
    "address" => 255,
    "instagram" => 255,
    "facebook" => 255,
    "linkedin" => 255,
    "youtube" => 255,
    "meta_title" => 70,
    "meta_description" => 160,
    "meta_keywords" => 255,
    "founded_year" => 10,
    "medals_won" => 20,
    "active_students" => 20,
    "years_experience" => 20,
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach ($_POST as $key => $value) {
        if (strpos($key, "setting_") !== 0) {
            continue;
        }
        $real_key = substr($key, 8);
        $save_value =
            $real_key === "google_map_embed"
                ? trim($value)
                : content_limit(trim($value), $limits[$real_key] ?? 1000);
        if (
            in_array(
                $real_key,
                ["instagram", "facebook", "linkedin", "youtube"],
                true
            ) &&
            $save_value &&
            !filter_var($save_value, FILTER_VALIDATE_URL)
        ) {
            $errors[] = ucfirst($real_key) . " must be a valid full URL.";
            continue;
        }
        if ($real_key === "whatsapp") {
            $save_value = whatsapp_number($save_value);
        }
        db_query(
            "INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)",
            [$real_key, $save_value]
        );
    }

    if (!empty($_FILES["logo"]["name"])) {
        $upload = upload_image($_FILES["logo"], "uploads");
        if ($upload["success"]) {
            db_query(
                "INSERT INTO settings (setting_key, setting_value) VALUES ('logo', ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)",
                [$upload["filename"]]
            );
        } else {
            $errors[] = $upload["error"];
        }
    }
    $message = $errors
        ? "Settings saved with the errors shown below."
        : "Settings updated successfully.";
}

$settings = [];
foreach (
    db_get_all("SELECT setting_key, setting_value FROM settings")
    as $row
) {
    $settings[$row["setting_key"]] = $row["setting_value"];
}
?>
<div class="max-w-4xl">
    <div class="mb-6"><h1 class="text-2xl font-bold">Website settings</h1><p class="text-sm text-slate-500">Manage contact information, branding, SEO, WhatsApp and legacy social links. For the social icons shown on the website, use <a href="social.php" class="text-amber-700 font-semibold">Social Media</a>.</p></div>
    <?php if ($message): ?><div class="mb-4 px-4 py-3 rounded-xl <?= $errors
    ? "bg-amber-100 text-amber-800"
    : "bg-emerald-100 text-emerald-700" ?> text-sm"><?= e(
     $message
 ) ?></div><?php endif; ?>
    <?php if (
        $errors
    ): ?><ul class="mb-4 px-5 py-3 rounded-xl bg-red-50 text-red-700 text-sm list-disc list-inside"><?php foreach (
    $errors
    as $error
): ?><li><?= e($error) ?></li><?php endforeach; ?></ul><?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="bg-white border p-6 rounded-2xl space-y-7">
        <section><h2 class="font-bold text-lg mb-4">Brand and contact details</h2><div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div><label class="text-xs font-semibold">Site name</label><input type="text" name="setting_site_name" maxlength="100" value="<?= e(
                $settings["site_name"] ?? "Achievers Gymnastics Academy"
            ) ?>" class="w-full border px-3 py-2 rounded-xl"></div>
            <div><label class="text-xs font-semibold">Tagline</label><input type="text" name="setting_tagline" maxlength="160" value="<?= e(
                $settings["tagline"] ?? ""
            ) ?>" class="w-full border px-3 py-2 rounded-xl"></div>
            <div><label class="text-xs font-semibold">Phone number</label><input type="text" name="setting_phone" maxlength="30" value="<?= e(
                $settings["phone"] ?? ""
            ) ?>" class="w-full border px-3 py-2 rounded-xl"></div>
            <div><label class="text-xs font-semibold">WhatsApp number</label><input type="text" name="setting_whatsapp" maxlength="20" value="<?= e(
                $settings["whatsapp"] ?? ""
            ) ?>" class="w-full border px-3 py-2 rounded-xl"><p class="content-manager__hint">Digits only are saved for the WhatsApp button.</p></div>
            <div><label class="text-xs font-semibold">Email</label><input type="email" name="setting_email" maxlength="120" value="<?= e(
                $settings["email"] ?? ""
            ) ?>" class="w-full border px-3 py-2 rounded-xl"></div>
            <div><label class="text-xs font-semibold">Address</label><input type="text" name="setting_address" maxlength="255" value="<?= e(
                $settings["address"] ?? ""
            ) ?>" class="w-full border px-3 py-2 rounded-xl"></div>
        </div></section>

        <section class="border-t pt-6"><h2 class="font-bold text-lg mb-4">Social links</h2><p class="content-manager__hint mb-3">The Social Media screen controls active icons and their order. These fields provide backwards-compatible URLs and a quick reference.</p><div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <input type="url" name="setting_instagram" maxlength="255" value="<?= e(
                $settings["instagram"] ?? ""
            ) ?>" placeholder="Instagram URL" class="border px-3 py-2 rounded-xl">
            <input type="url" name="setting_facebook" maxlength="255" value="<?= e(
                $settings["facebook"] ?? ""
            ) ?>" placeholder="Facebook URL" class="border px-3 py-2 rounded-xl">
            <input type="url" name="setting_linkedin" maxlength="255" value="<?= e(
                $settings["linkedin"] ?? ""
            ) ?>" placeholder="LinkedIn URL" class="border px-3 py-2 rounded-xl">
            <input type="url" name="setting_youtube" maxlength="255" value="<?= e(
                $settings["youtube"] ?? ""
            ) ?>" placeholder="YouTube URL" class="border px-3 py-2 rounded-xl">
        </div></section>

        <section class="border-t pt-6"><h2 class="font-bold text-lg mb-4">Brand image and SEO</h2><div class="grid grid-cols-1 md:grid-cols-2 gap-5"><div><label class="text-xs font-semibold">Logo (upload new)</label><input type="file" name="logo" accept="image/jpeg,image/png,image/webp,image/gif" class="w-full"><?php if (
            !empty($settings["logo"])
        ): ?><img src="../<?= e(
    $settings["logo"]
) ?>" class="content-manager__preview" alt="Current site logo"><?php endif; ?></div><div><label class="text-xs font-semibold">SEO meta title</label><input type="text" name="setting_meta_title" maxlength="70" value="<?= e(
    $settings["meta_title"] ?? ""
) ?>" class="w-full border px-3 py-2 rounded-xl"><p class="content-manager__hint">Recommended maximum 60–70 characters.</p></div></div><div class="mt-4"><label class="text-xs font-semibold">Meta description</label><textarea name="setting_meta_description" maxlength="160" rows="2" class="w-full border px-3 py-2 rounded-xl"><?= e(
    $settings["meta_description"] ?? ""
) ?></textarea><p class="content-manager__hint">Recommended maximum 160 characters.</p></div><div class="mt-4"><label class="text-xs font-semibold">SEO keywords</label><input type="text" name="setting_meta_keywords" maxlength="255" value="<?= e(
    $settings["meta_keywords"] ?? ""
) ?>" class="w-full border px-3 py-2 rounded-xl"></div></section>

        <section class="border-t pt-6"><h2 class="font-bold text-lg mb-4">Academy statistics</h2><div class="grid grid-cols-1 sm:grid-cols-3 gap-4"><div><label class="text-xs font-semibold">Founded year</label><input type="text" name="setting_founded_year" maxlength="10" value="<?= e(
            $settings["founded_year"] ?? "2007"
        ) ?>" class="w-full border px-3 py-2 rounded-xl"></div><div><label class="text-xs font-semibold">Medals won</label><input type="text" name="setting_medals_won" maxlength="20" value="<?= e(
    $settings["medals_won"] ?? "250+"
) ?>" class="w-full border px-3 py-2 rounded-xl"></div><div><label class="text-xs font-semibold">Active students / families</label><input type="text" name="setting_active_students" maxlength="20" value="<?= e(
    $settings["active_students"] ?? "400+"
) ?>" class="w-full border px-3 py-2 rounded-xl"></div></div></section>

        <section class="border-t pt-6"><label class="text-xs font-semibold">Google Maps embed</label><textarea name="setting_google_map_embed" rows="3" class="w-full border px-3 py-2 rounded-xl text-sm font-mono" placeholder="Paste the Google Maps iframe code or its src URL"><?= e(
            $settings["google_map_embed"] ?? ""
        ) ?></textarea><p class="content-manager__hint">Google Maps → Share → Embed a map. Only paste an iframe from Google or its HTTPS source URL.</p></section>
        <button type="submit" class="btn-primary px-7 py-2.5">Save settings</button>
    </form>
</div>
<?php require_once __DIR__ . "/includes/admin_footer.php"; ?>
