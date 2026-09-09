<?php
/**
 * One-click Banner Seeder
 * Visit this file in your browser to instantly add 5 beautiful hero banners.
 * 
 * URL example: http://localhost:8080/sql/seed_banners.php
 * 
 * DELETE THIS FILE AFTER USE for security.
 */

require_once __DIR__ . '/../includes/db.php';

echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Seed Banners</title>';
echo '<style>body{font-family:system-ui;padding:40px;max-width:700px;margin:0 auto;line-height:1.6} .success{background:#ecfdf5;padding:20px;border-radius:12px;border:1px solid #10b981}</style>';
echo '</head><body>';

echo '<h1>🎯 Seed Hero Banners</h1>';

$banners = [
    ['Train Like a Champion', 'Under International Coach Pankaj Kunde — Nagpur\'s most decorated gymnastics academy', 'assets/images/hero-main.jpg', '/courses.php', 1],
    ['World-Class Facility', 'FIG-standard apparatus • Sprung floors • Olympic-grade safety', 'assets/images/hero-facility.jpg', '/about.php', 2],
    ['Enroll for 2026 Season', 'Limited slots available. Start with a FREE TRIAL today!', 'assets/images/hero-enroll.jpg', '/admissions.php', 3],
    ['Join Our Champions', 'Build strength, discipline & confidence. Ages 5–18 welcome', 'assets/images/hero-main.jpg', '/achievements.php', 4],
    ['Free Trial This Week', 'Experience world-class coaching. Book your slot now', 'assets/images/hero-facility.jpg', '/admissions.php', 5],
];

$added = 0;
$existing = 0;

foreach ($banners as $b) {
    $check = db_get_row("SELECT id FROM banners WHERE title = ?", [$b[0]]);
    if ($check) {
        $existing++;
        continue;
    }
    
    db_query("INSERT INTO banners (title, subtitle, image, link_url, sort_order, status) VALUES (?, ?, ?, ?, ?, 'active')", $b);
    $added++;
}

echo '<div class="success">';
echo "<h2>✅ Done!</h2>";
echo "<p><strong>Added:</strong> $added new banners</p>";
echo "<p><strong>Already existed:</strong> $existing</p>";
echo "<p><strong>Total banners now:</strong> " . (db_get_row("SELECT COUNT(*) as c FROM banners")['c'] ?? 0) . "</p>";
echo '</div>';

echo '<h3>Next Steps:</h3>';
echo '<ol>';
echo '<li>Go to <a href="admin/banners">Admin → Banners</a> to view / edit them</li>';
echo '<li>Visit your <a href="">Homepage</a> to see the stunning full-screen hero slider!</li>';
echo '<li><strong>Delete this file</strong> (sql/seed_banners.php) for security</li>';
echo '</ol>';

echo '<p><a href="admin/banners" style="background:#0f172a;color:white;padding:10px 18px;border-radius:8px;text-decoration:none;display:inline-block">→ Open Admin Banners</a></p>';
echo '</body></html>';
?>