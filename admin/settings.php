<?php
require_once __DIR__ . '/includes/admin_header.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'setting_') === 0) {
            $real_key = substr($key, 8);
            
            // IMPORTANT: Google Maps embed must be saved RAW (no sanitize/htmlspecialchars)
            // because it contains <iframe> HTML that needs to render as-is.
            if ($real_key === 'google_map_embed') {
                $save_value = trim($value);
            } else {
                $save_value = sanitize($value);
            }
            
            db_query("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?", [$real_key, $save_value, $save_value]);
        }
    }
    
    // Handle logo upload
    if (!empty($_FILES['logo']['name'])) {
        $upload = upload_image($_FILES['logo'], 'uploads');
        if ($upload['success']) {
            db_query("INSERT INTO settings (setting_key, setting_value) VALUES ('logo', ?) ON DUPLICATE KEY UPDATE setting_value = ?", [$upload['filename'], $upload['filename']]);
        }
    }
    
    $msg = "Settings updated successfully!";
}

$settings = [];
$rows = db_get_all("SELECT * FROM settings");
foreach ($rows as $row) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>
<div class="max-w-3xl">
    <h2 class="text-2xl font-bold mb-1">Website Settings</h2>
    <p class="text-sm text-slate-500 mb-6">Update contact, social, SEO and branding info.</p>
    
    <?php if ($msg): ?><div class="mb-4 px-4 py-2 rounded bg-emerald-100 text-emerald-700"><?= $msg ?></div><?php endif; ?>
    
    <form method="POST" enctype="multipart/form-data" class="bg-white border p-6 rounded-2xl space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="text-xs font-semibold">Site Name</label>
                <input type="text" name="setting_site_name" value="<?= htmlspecialchars($settings['site_name'] ?? 'Achievers Gymnastics Academy') ?>" class="w-full border px-3 py-2 rounded-xl">
            </div>
            <div>
                <label class="text-xs font-semibold">Tagline</label>
                <input type="text" name="setting_tagline" value="<?= htmlspecialchars($settings['tagline'] ?? '') ?>" class="w-full border px-3 py-2 rounded-xl">
            </div>
            
            <div>
                <label class="text-xs font-semibold">Phone Number</label>
                <input type="text" name="setting_phone" value="<?= htmlspecialchars($settings['phone'] ?? '') ?>" class="w-full border px-3 py-2 rounded-xl">
            </div>
            <div>
                <label class="text-xs font-semibold">WhatsApp Number</label>
                <input type="text" name="setting_whatsapp" value="<?= htmlspecialchars($settings['whatsapp'] ?? '') ?>" class="w-full border px-3 py-2 rounded-xl">
            </div>
            
            <div>
                <label class="text-xs font-semibold">Email</label>
                <input type="email" name="setting_email" value="<?= htmlspecialchars($settings['email'] ?? '') ?>" class="w-full border px-3 py-2 rounded-xl">
            </div>
            <div>
                <label class="text-xs font-semibold">Address</label>
                <input type="text" name="setting_address" value="<?= htmlspecialchars($settings['address'] ?? '') ?>" class="w-full border px-3 py-2 rounded-xl">
            </div>
        </div>
        
        <div>
            <label class="text-xs font-semibold">Social Links</label>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-1">
                <input type="url" name="setting_instagram" value="<?= htmlspecialchars($settings['instagram'] ?? '') ?>" placeholder="Instagram URL" class="border px-3 py-2 rounded-xl">
                <input type="url" name="setting_facebook" value="<?= htmlspecialchars($settings['facebook'] ?? '') ?>" placeholder="Facebook URL" class="border px-3 py-2 rounded-xl">
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="text-xs font-semibold">Logo (upload new)</label>
                <input type="file" name="logo" accept="image/*" class="w-full">
                <?php if (!empty($settings['logo'])): ?>
                    <div class="mt-1"><img src="<?= htmlspecialchars($settings['logo']) ?>" class="h-8"></div>
                <?php endif; ?>
            </div>
            
            <div>
                <label class="text-xs font-semibold">SEO Meta Title</label>
                <input type="text" name="setting_meta_title" value="<?= htmlspecialchars($settings['meta_title'] ?? '') ?>" class="w-full border px-3 py-2 rounded-xl">
            </div>
        </div>
        
        <div>
            <label class="text-xs font-semibold">Meta Description</label>
            <textarea name="setting_meta_description" rows="2" class="w-full border px-3 py-2 rounded-xl"><?= htmlspecialchars($settings['meta_description'] ?? '') ?></textarea>
        </div>
        
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="text-xs font-semibold">Founded Year</label>
                <input type="text" name="setting_founded_year" value="<?= htmlspecialchars($settings['founded_year'] ?? '2007') ?>" class="w-full border px-3 py-2 rounded-xl">
            </div>
            <div>
                <label class="text-xs font-semibold">Medals Won</label>
                <input type="text" name="setting_medals_won" value="<?= htmlspecialchars($settings['medals_won'] ?? '250+') ?>" class="w-full border px-3 py-2 rounded-xl">
            </div>
            <div>
                <label class="text-xs font-semibold">Active Students</label>
                <input type="text" name="setting_active_students" value="<?= htmlspecialchars($settings['active_students'] ?? '400+') ?>" class="w-full border px-3 py-2 rounded-xl">
            </div>
        </div>

        <!-- Google Maps Location -->
        <div class="pt-2">
            <label class="text-xs font-semibold">Google Maps Embed (paste full iframe code or src URL)</label>
            <textarea name="setting_google_map_embed" rows="3" class="w-full border px-3 py-2 rounded-xl text-sm font-mono" placeholder="Paste &lt;iframe&gt; code from Google Maps here..."><?= htmlspecialchars($settings['google_map_embed'] ?? '') ?></textarea>
            <p class="text-[10px] text-slate-500 mt-1">Go to Google Maps → Share → Embed a map → Copy the full &lt;iframe&gt; HTML and paste above.</p>
        </div>
        
        <button type="submit" class="btn-primary px-7 py-2.5">Save All Settings</button>
    </form>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>