<?php
/**
 * One-click Banner Seeder
 * Visit this file in your browser to instantly add 5 beautiful hero banners.
 *
 * URL example: http://localhost:8080/sql/seed_banners.php
 *
 * DELETE THIS FILE AFTER USE for security.
 */

require_once __DIR__ . "/../includes/db.php";

echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Seed Banners</title><link rel="stylesheet" href="../assets/css/style.css"></head><body>';
echo '<main class="page-shell--narrow">';
echo "<h1>🎯 Seed Hero Banners</h1>";

$banners = [
    [
        "Train Like a Champion",
        'Under International Coach Pankaj Kunde — Nagpur\'s most decorated gymnastics academy',
        "assets/images/hero-main.jpg",
        "/courses.php",
        1,
    ],
    [
        "World-Class Facility",
        "Competition-ready apparatus • Sprung floors • Olympic-grade safety",
        "assets/images/hero-facility.jpg",
        "/about.php",
        2,
    ],
    [
        "Enroll for 2026 Season",
        "Limited slots available. Start with a FREE TRIAL today!",
        "assets/images/hero-enroll.jpg",
        "/admissions.php",
        3,
    ],
    [
        "Join Our Champions",
        "Build strength, discipline & confidence. Ages 5–18 welcome",
        "assets/images/hero-main.jpg",
        "/achievements.php",
        4,
    ],
    [
        "Free Trial This Week",
        "Experience world-class coaching. Book your slot now",
        "assets/images/hero-facility.jpg",
        "/admissions.php",
        5,
    ],
];

$added = 0;
$existing = 0;

foreach ($banners as $b) {
    $check = db_get_row("SELECT id FROM banners WHERE title = ?", [$b[0]]);
    if ($check) {
        $existing++;
        continue;
    }

    db_query(
        "INSERT INTO banners (title, subtitle, image, link_url, show_content, sort_order, status) VALUES (?, ?, ?, ?, 1, ?, 'active')",
        $b
    );
    $added++;
}

echo '<div class="bg-emerald-50 border border-emerald-200 p-5 rounded-2xl">';
echo "<h2>✅ Done!</h2>";
echo "<p><strong>Added:</strong> $added new banners</p>";
echo "<p><strong>Already existed:</strong> $existing</p>";
echo "<p><strong>Total banners now:</strong> " .
    (db_get_row("SELECT COUNT(*) as c FROM banners")["c"] ?? 0) .
    "</p>";
echo "</div>";

echo "<h3>Next Steps:</h3>";
echo "<ol>";
echo '<li>Go to <a href="admin/banners">Admin → Banners</a> to view / edit them</li>';
echo '<li>Visit your <a href="">Homepage</a> to see the stunning full-screen hero slider!</li>';
echo "<li><strong>Delete this file</strong> (sql/seed_banners.php) for security</li>";
echo "</ol>";

echo '<p><a href="../admin/banners.php" class="btn-primary">→ Open Admin Banners</a></p>';
echo "</main></body></html>";
?>
