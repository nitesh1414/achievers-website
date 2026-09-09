<?php
require_once __DIR__ . '/includes/header.php';

$notices = db_get_all("SELECT * FROM notices WHERE status='published' ORDER BY publish_date DESC");
?>
<div class="tail-container py-10">
    <h1 class="text-4xl font-bold mb-2">Notices &amp; Downloads</h1>
    <p class="mb-7">Latest announcements, schedules and important documents.</p>
    
    <?php if (empty($notices)): ?>
        <div class="text-center py-10 text-slate-500">No published notices yet.</div>
    <?php else: ?>
        <div class="space-y-4">
            <?php foreach ($notices as $n): ?>
            <div class="bg-white border p-6 rounded-2xl">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-bold text-xl"><?= htmlspecialchars($n['title']) ?></div>
                        <div class="text-xs text-slate-500"><?= date('d F Y', strtotime($n['publish_date'])) ?></div>
                    </div>
                    <?php if ($n['file_path']): ?>
                        <a href="<?= htmlspecialchars($n['file_path']) ?>" target="_blank" class="text-xs px-4 py-1 bg-amber-600 text-white rounded-full font-semibold">Download PDF</a>
                    <?php endif; ?>
                </div>
                <div class="mt-4 text-sm text-slate-600"><?= nl2br(htmlspecialchars($n['content'])) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>