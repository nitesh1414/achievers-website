<?php
require_once __DIR__ . '/includes/header.php';

$categories = ['All', 'Competition', 'Training', 'Facility', 'Event'];
$active_cat = $_GET['cat'] ?? 'All';

$sql = "SELECT * FROM gallery WHERE status='active'";
$params = [];
if ($active_cat !== 'All') {
    $sql .= " AND category = ?";
    $params[] = $active_cat;
}
$sql .= " ORDER BY created_at DESC";
$gallery = db_get_all($sql, $params);
?>
<div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10 w-full max-w-[1400px] mx-auto px-6 md:px-10 w-full max-w-[1400px] mx-auto px-6 md:px-8 w-full px-6 md:px-8 max-w-[1400px] mx-auto w-full max-w-full py-10">
    <div class="mb-7">
        <h1 class="text-4xl font-bold">Gallery</h1>
        <p class="text-slate-600">Moments from our training sessions, competitions and events.</p>
    </div>

    <div class="flex gap-2 mb-7 flex-wrap">
        <?php foreach ($categories as $cat): ?>
            <a href="?cat=<?= urlencode($cat) ?>" class="px-4 py-1 text-sm rounded-full <?= $active_cat === $cat ? 'bg-slate-900 text-white' : 'bg-white border' ?>"><?= $cat ?></a>
        <?php endforeach; ?>
    </div>

    <div class="gallery-grid" id="gallery-grid">
        <?php foreach ($gallery as $item): ?>
            <div class="gallery-item bg-white border rounded-2xl overflow-hidden cursor-pointer" onclick="openLightbox('<?= htmlspecialchars($item['image']) ?>', '<?= htmlspecialchars($item['title']) ?>', '<?= htmlspecialchars($item['category']) ?>', '<?= $item['event_date'] ?>')">

                <img src="<?= htmlspecialchars($item['image']) ?>" class="w-full h-64 object-cover" alt="<?= htmlspecialchars($item['title']) ?>">
                <div class="p-4">
                    <div class="font-semibold"><?= htmlspecialchars($item['title']) ?></div>
                    <div class="flex justify-between mt-1">
                        <span class="text-xs px-2 py-0.5 bg-amber-100 rounded text-amber-700"><?= htmlspecialchars($item['category']) ?></span>
                        <span class="text-xs text-slate-400"><?= $item['event_date'] ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Lightbox -->
    <<!-- Lightbox -->
        <div id="lightbox" class="hidden fixed inset-0 bg-black/90 z-50 items-center justify-center p-4" onclick="closeLightbox()">
            <div class="max-w-4xl w-full" onclick="event.stopPropagation()">
                <div class="flex justify-end mb-2">
                    <button onclick="closeLightbox()" class="text-white text-3xl leading-none cursor-pointer">&times;</button>
                </div>
                <img id="lightbox-img" class="w-full max-h-[75vh] object-contain rounded-xl" alt="Lightbox Preview">
                <div class="mt-4 text-white">
                    <div id="lightbox-title" class="text-xl font-semibold"></div>
                    <div id="lightbox-meta" class="text-sm text-white/70"></div>
                </div>
            </div>
        </div>

        <script>
            function openLightbox(image, title, category, date) {
                const lb = document.getElementById('lightbox');

                // Set image source (Verify if '../' is actually needed in your project layout)
                document.getElementById('lightbox-img').src = image;
                document.getElementById('lightbox-title').textContent = title || '';
                document.getElementById('lightbox-meta').textContent = (category && date) ? `${category} • ${date}` : '';

                lb.classList.remove('hidden');
                lb.classList.add('flex');
            }

            function closeLightbox() {
                const lb = document.getElementById('lightbox');
                lb.classList.remove('flex');
                lb.classList.add('hidden');
            }

            // Close on ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === "Escape") {
                    const lb = document.getElementById('lightbox');
                    if (!lb.classList.contains('hidden')) closeLightbox();
                }
            });
        </script>

        <?php if (empty($gallery)): ?>
            <div class="text-center py-16 text-slate-400">No images in this category yet.</div>
        <?php endif; ?>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>