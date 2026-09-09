<?php
require_once __DIR__ . '/includes/admin_header.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_social'])) {
        $platform = sanitize($_POST['platform']);
        $url = sanitize($_POST['url']);
        $icon = sanitize($_POST['icon']);
        $sort_order = intval($_POST['sort_order']);
        $is_active = isset($_POST['is_active']) ? 1 : 0;

        if (!empty($_POST['id'])) {
            db_query("UPDATE social_links SET platform=?, url=?, icon=?, sort_order=?, is_active=? WHERE id=?", 
                [$platform, $url, $icon, $sort_order, $is_active, intval($_POST['id'])]);
            $msg = "Social link updated.";
        } else {
            db_query("INSERT INTO social_links (platform, url, icon, sort_order, is_active) VALUES (?,?,?,?,?)", 
                [$platform, $url, $icon, $sort_order, $is_active]);
            $msg = "Social link added.";
        }
    }
    if (isset($_POST['delete'])) {
        db_query("DELETE FROM social_links WHERE id=?", [intval($_POST['delete'])]);
        $msg = "Social link deleted.";
    }
}

$socials = db_get_all("SELECT * FROM social_links ORDER BY sort_order ASC");
$edit = null;
if (isset($_GET['edit'])) {
    $edit = db_get_row("SELECT * FROM social_links WHERE id=?", [intval($_GET['edit'])]);
}
?>
<div class="max-w-4xl">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Social Media Management</h2>
        <a href="?action=add" class="btn-accent px-5 py-2 text-sm">+ Add New Link</a>
    </div>

    <?php if ($msg): ?>
        <div class="mb-4 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-xl text-sm"><?= $msg ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['action']) && $_GET['action'] === 'add' || $edit): ?>
        <div class="bg-white p-6 rounded-2xl border mb-8 max-w-lg">
            <form method="POST" class="space-y-4">
                <?php if ($edit): ?>
                    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
                <?php endif; ?>
                <input type="hidden" name="save_social" value="1">

                <div>
                    <label class="text-xs font-semibold">Platform</label>
                    <input name="platform" value="<?= htmlspecialchars($edit['platform'] ?? '') ?>" class="w-full border px-3 py-2 rounded-xl" required>
                </div>
                <div>
                    <label class="text-xs font-semibold">URL</label>
                    <input name="url" value="<?= htmlspecialchars($edit['url'] ?? '') ?>" class="w-full border px-3 py-2 rounded-xl" required placeholder="https://...">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-semibold">Icon (name)</label>
                        <input name="icon" value="<?= htmlspecialchars($edit['icon'] ?? 'instagram') ?>" class="w-full border px-3 py-2 rounded-xl" placeholder="instagram">
                        <div class="text-[10px] text-slate-500 mt-1">instagram, whatsapp, facebook, linkedin, etc.</div>
                    </div>
                    <div>
                        <label class="text-xs font-semibold">Sort Order</label>
                        <input type="number" name="sort_order" value="<?= $edit['sort_order'] ?? 0 ?>" class="w-full border px-3 py-2 rounded-xl">
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" <?= ($edit['is_active'] ?? 1) ? 'checked' : '' ?> class="w-4 h-4">
                    <label class="text-sm">Active</label>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="btn-primary px-6 py-2 text-sm">Save</button>
                    <a href="social.php" class="px-5 py-2 text-sm">Cancel</a>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl border overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b bg-slate-50">
                    <th class="p-3 text-left">Platform</th>
                    <th class="p-3 text-left">URL</th>
                    <th class="p-3">Icon</th>
                    <th class="p-3">Order</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($socials as $s): ?>
                <tr class="border-b last:border-none">
                    <td class="p-3 font-medium"><?= htmlspecialchars($s['platform']) ?></td>
                    <td class="p-3 text-xs text-slate-600 truncate max-w-[280px]"><?= htmlspecialchars($s['url']) ?></td>
                    <td class="p-3 text-center">
                        <?php 
                        $icon = strtolower($s['icon'] ?? 'instagram');
                        if ($icon === 'instagram' || $icon === 'ig') {
                            echo '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline mx-auto" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.849.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.76 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm6.406 1.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>';
                        } elseif ($icon === 'whatsapp' || $icon === 'wa') {
                            echo '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline mx-auto" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.198-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.372-.025-.521-.075-.149-.67-.161-1.297-.161-.627 0-1.052.298-1.297.446-.149.149-.347.446-.446.744-.099.298-.05.595.149.793.347.446.744 1.044 1.44 1.74.696.696 1.294 1.093 1.74 1.44.198.198.446.347.744.149.298-.149.446-.298.595-.446.149-.149.298-.298.446-.446.149-.149.347-.05.52.05.174.099.943.446 1.093.595.149.149.248.298.347.446.099.149.248.298.298.446.05.149.099.298.149.446.05.149.05.298.05.446zM12 2C6.477 2 2 6.477 2 12c0 1.89.553 3.657 1.508 5.139L2 22l4.861-1.508A9.955 9.955 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"/></svg>';
                        } elseif ($icon === 'facebook' || $icon === 'fb') {
                            echo '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline mx-auto" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>';
                        } elseif ($icon === 'linkedin' || $icon === 'in') {
                            echo '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline mx-auto" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.064 0-1.14.92-2.064 2.063-2.064 1.14 0 2.064.925 2.064 2.064 0 1.139-.925 2.064-2.064 2.064zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>';
                        } else {
                            echo '<span class="text-lg">🔗</span>';
                        }
                        ?>
                    </td>
                    <td class="p-3 text-center"><?= $s['sort_order'] ?></td>
                    <td class="p-3 text-center">
                        <?= $s['is_active'] ? '<span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded text-xs">Active</span>' : '<span class="px-2 py-0.5 bg-gray-200 rounded text-xs">Hidden</span>' ?>
                    </td>
                    <td class="p-3">
                        <div class="flex gap-2">
                            <a href="?edit=<?= $s['id'] ?>" class="text-xs px-3 py-1 bg-blue-100 text-blue-700 rounded">Edit</a>
                            <form method="POST" onsubmit="return confirm('Delete this social link?')">
                                <input type="hidden" name="delete" value="<?= $s['id'] ?>">
                                <button class="text-xs px-3 py-1 bg-red-100 text-red-700 rounded">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once __DIR__ . '/includes/admin_footer.php'; ?>