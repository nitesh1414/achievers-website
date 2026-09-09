<?php
require_once __DIR__ . '/includes/header.php';

$mentor = db_get_all("SELECT * FROM mentors WHERE status='active' ORDER BY experience_years DESC");
?>
<div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10 w-full max-w-[1400px] mx-auto px-6 md:px-10 w-full max-w-[1400px] mx-auto px-6 md:px-8 w-full px-6 md:px-8 max-w-[1400px] mx-auto w-full max-w-full py-10">
    <h1 class="text-4xl font-bold mb-2">Our Expert Mentor</h1>
    <p class="max-w-xl mb-8 text-slate-600">Led by International Coach Pankaj Kunde, our team of certified coaches ensures every student reaches their full potential.</p>
    
    <div class="grid md:grid-cols-3 gap-6">
        <?php foreach ($mentor as $f): ?>
        <div class="bg-white border rounded-3xl overflow-hidden">
            <img src="<?= htmlspecialchars($f['photo'] ?: 'assets/images/mentor-pankaj.jpg') ?>" class="w-full h-64 object-cover">
            <div class="p-6">
                <div class="font-bold text-xl"><?= htmlspecialchars($f['name']) ?></div>
                <div class="font-semibold text-amber-600"><?= htmlspecialchars($f['designation']) ?></div>
                
                <div class="mt-4 text-sm">
                    <?= nl2br(htmlspecialchars($f['bio'])) ?>
                </div>
                
                <div class="mt-4">
                    <div class="text-xs font-bold tracking-wider">SPECIALTIES</div>
                    <div class="text-sm mt-1"><?= htmlspecialchars($f['specialties']) ?></div>
                </div>
                
                <div class="mt-4 text-xs font-semibold"><?= $f['experience_years'] ?>+ years experience</div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>