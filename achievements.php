<?php
require_once __DIR__ . '/includes/header.php';

$toppers = db_get_all("SELECT * FROM toppers WHERE status='active' ORDER BY year DESC, id DESC");
$competitions = db_get_all("SELECT * FROM competitions WHERE status='active' ORDER BY event_date DESC");
?>
<div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10 w-full max-w-[1400px] mx-auto px-6 md:px-10 w-full max-w-[1400px] mx-auto px-6 md:px-8 w-full px-6 md:px-8 max-w-[1400px] mx-auto w-full max-w-full py-10">
    <div class="mb-10">
        <span class="px-3 py-1 text-xs bg-amber-100 text-amber-800 font-bold tracking-wider rounded">CHAMPIONS</span>
        <h1 class="text-4xl font-extrabold mt-1">Our Achievers &amp; Results</h1>
        <p class="max-w-md mt-1">Proudly showcasing the success of our athletes across national and international platforms.</p>
    </div>
    
    <!-- Toppers -->
    <h3 class="font-bold text-2xl mb-4">Recent Medalists</h3>
    <div class="grid md:grid-cols-4 gap-6 mb-14">
        <?php foreach ($toppers as $t): ?>
        <div class="bg-white border rounded-2xl overflow-hidden">
            <img src="<?= htmlspecialchars($t['photo'] ?: 'assets/images/topper-aarav.jpg') ?>" class="h-52 w-full object-cover" alt="<?= htmlspecialchars($t['name']) ?>">
            <div class="px-5 py-4">
                <div class="font-semibold text-lg"><?= htmlspecialchars($t['name']) ?></div>
                <div class="text-amber-600 font-semibold"><?= htmlspecialchars($t['rank']) ?> • <?= $t['year'] ?></div>
                <div class="text-sm mt-2 text-slate-600"><?= htmlspecialchars($t['achievement']) ?></div>
                <div class="mt-1 text-xs text-slate-400"><?= htmlspecialchars($t['course']) ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Competitions -->
    <div>
        <h3 class="font-bold text-2xl mb-5">Competitions &amp; Events</h3>
        <div class="space-y-3">
            <?php foreach ($competitions as $comp): ?>
            <div class="bg-white border p-5 rounded-2xl flex flex-col md:flex-row gap-5">
                <div class="md:w-3/12">
                    <div class="text-xs uppercase tracking-wider font-semibold text-amber-700"><?= $comp['type'] === 'future' ? 'UPCOMING' : 'COMPLETED' ?></div>
                    <div class="font-bold text-lg mt-1"><?= htmlspecialchars($comp['title']) ?></div>
                    <div class="text-sm text-slate-500"><?= date('d M Y', strtotime($comp['event_date'])) ?> • <?= htmlspecialchars($comp['location']) ?></div>
                </div>
                <div class="flex-1 text-sm">
                    <?= nl2br(htmlspecialchars($comp['description'])) ?>
                    
                    <?php if ($comp['type'] === 'future' && $comp['how_to_apply']): ?>
                        <div class="mt-3">
                            <strong>How to apply:</strong><br>
                            <span class="text-xs"><?= nl2br(htmlspecialchars($comp['how_to_apply'])) ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($comp['results']): ?>
                        <div class="mt-3 bg-slate-100 p-3 text-xs rounded">
                            <strong>Results:</strong> <?= nl2br(htmlspecialchars($comp['results'])) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>