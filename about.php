<?php
require_once __DIR__ . "/includes/header.php";

$testimonials = db_get_all(
    "SELECT * FROM testimonials WHERE status = 'active' ORDER BY created_at DESC LIMIT 8"
);
$toppers = db_get_all(
    "SELECT * FROM toppers WHERE status = 'active' ORDER BY year DESC, id DESC LIMIT 3"
);
$about_stats = [
    ["value" => get_setting("medals_won", "250+"), "label" => "Medals won"],
    [
        "value" => get_setting("active_students", "400+"),
        "label" => "Families served",
    ],
    [
        "value" => get_setting("years_experience", "18+"),
        "label" => "Years of coaching",
    ],
    [
        "value" => get_setting("competitions_count", "35+"),
        "label" => "Competitions",
    ],
];
?>
<section class="page-shell">
    <div class="tail-container">
        <header class="page-header page-header--split">
            <div><span class="section-kicker"><?= e(
                content_value("about_label", "EST. 2007")
            ) ?></span><h1><?= e(
    content_value("about_title", "About Achievers Gymnastics Academy")
) ?></h1><p><?= e(
    content_value(
        "about_intro",
        "Nagpur's most decorated gymnastics academy. Where every child discovers their inner champion."
    )
) ?></p></div>
            <a href="admissions.php" class="btn-accent">Start a free trial <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
        </header>
    </div>
</section>

<?php
$mission_vision_id = "about-mission-vision";
require __DIR__ . "/includes/mission-vision.php";
?>

<section class="about-philosophy">
    <div class="tail-container">
        <div class="section-heading"><span>HOW WE COACH</span><h2><?= e(
            content_value("about_philosophy_title", "Our philosophy")
        ) ?></h2></div>
        <p class="about-philosophy__body"><?= e(
            content_value(
                "about_philosophy_text",
                "We believe gymnastics is more than a sport. It is a powerful vehicle for building discipline, confidence, resilience and physical excellence. Every child who walks through our doors is treated as a future champion, regardless of their starting point."
            )
        ) ?></p>
        <div class="about-stats">
            <?php foreach (
                $about_stats
                as $stat
            ): ?><div class="about-stat"><strong><?= e(
    $stat["value"]
) ?></strong><span><?= e($stat["label"]) ?></span></div><?php endforeach; ?>
        </div>
    </div>
</section>

<?php
$testimonial_section_id = "about-testimonials-carousel";
require __DIR__ . "/includes/testimonials-section.php";
?>

<?php if ($toppers): ?>
<section class="content-section content-section--soft">
    <div class="tail-container">
        <div class="section-heading"><span>RESULTS WITH PURPOSE</span><h2>Our champions speak</h2></div>
        <div class="data-grid">
            <?php foreach ($toppers as $topper): ?>
                <article class="achievement-card"><img src="<?= e(
                    $topper["photo"] ?: "assets/images/topper-aarav.jpg"
                ) ?>" alt="<?= e(
    $topper["name"]
) ?>" loading="lazy"><div class="achievement-card__body"><h2><?= e(
    $topper["name"]
) ?></h2><p><strong><?= e($topper["rank"]) ?> (<?= e(
     $topper["year"]
 ) ?>)</strong><br><?= e($topper["achievement"]) ?></p></div></article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="home-cta">
    <div class="tail-container home-cta__inner">
        <div><span class="section-kicker section-kicker--light"><?= e(
            content_value("about_cta_label", "START YOUR JOURNEY")
        ) ?></span><h2><?= e(
    content_value(
        "about_cta_title",
        "One free trial session can change everything."
    )
) ?></h2></div>
        <div class="home-cta__actions"><a href="admissions.php" class="btn-accent"><?= e(
            content_value("about_cta_button", "Book your free trial")
        ) ?></a></div>
    </div>
</section>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
