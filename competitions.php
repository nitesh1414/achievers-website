<?php
require_once __DIR__ . '/includes/header.php';

$comps = db_get_all("SELECT * FROM competitions WHERE status = 'active' ORDER BY event_date DESC");
?>
<div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10 py-12">
    <div class="text-center mb-10">
        <span class="text-amber-600 font-bold text-xs tracking-[2px]">OPPORTUNITIES</span>
        <h1 class="text-4xl font-extrabold mt-2 tracking-tight">Competitions</h1>
        <p class="text-slate-600 mt-2">Upcoming and past events our gymnasts participate in.</p>
    </div>

    <?php if (empty($comps)): ?>
        <div class="text-center py-16 text-slate-500">
            <div class="text-5xl mb-4">🏅</div>
            <div class="font-semibold text-lg">No competitions listed right now.</div>
            <p class="mt-2">Check back soon for upcoming events.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($comps as $c): ?>
                <a href="competition.php?id=<?= $c['id'] ?>" class="group block bg-white border rounded-3xl overflow-hidden hover:shadow-xl transition">
                    <?php if (!empty($c['image'])): ?>
                        <img src="<?= htmlspecialchars($c['image']) ?>" class="w-full h-48 object-cover group-hover:scale-[1.03] transition" alt="<?= htmlspecialchars($c['title']) ?>">
                    <?php else: ?>
                        <div class="h-48 bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-6xl">🏅</div>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2.5 py-0.5 text-xs font-bold rounded-full <?= $c['type'] === 'future' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-700' ?>">
                                <?= ucfirst($c['type']) ?>
                            </span>
                            <?php if ($c['event_date']): ?>
                                <span class="text-xs text-slate-500"><?= date('d M Y', strtotime($c['event_date'])) ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <h3 class="font-bold text-xl leading-tight mb-2 group-hover:text-amber-600"><?= htmlspecialchars($c['title']) ?></h3>
                        
                        <?php if (!empty($c['location'])): ?>
                            <div class="text-sm text-slate-600 mb-3">📍 <?= htmlspecialchars($c['location']) ?></div>
                        <?php endif; ?>
                        
                        <div class="text-sm text-amber-600 font-medium">View details →</div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
