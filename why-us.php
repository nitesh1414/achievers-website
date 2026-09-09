<?php
require_once __DIR__ . "/includes/header.php";
$why_cards = [
    [
        "icon" => "fa-trophy",
        "title" => content_value("why_us_1_title", "Proven track record"),
        "text" => content_value(
            "why_us_1_text",
            "Strong foundations, consistent coaching and a history of proud performances."
        ),
    ],
    [
        "icon" => "fa-person-chalkboard",
        "title" => content_value("why_us_2_title", "International coaching"),
        "text" => content_value(
            "why_us_2_text",
            "Professional coaching standards that help athletes progress safely and confidently."
        ),
    ],
    [
        "icon" => "fa-shield-heart",
        "title" => content_value("why_us_3_title", "A safe, equipped facility"),
        "text" => content_value(
            "why_us_3_text",
            "Thoughtful equipment, structured sessions and a culture that puts children first."
        ),
    ],
];
?>
<section class="page-shell"><div class="tail-container">
    <header class="page-header text-center"><span class="section-kicker">WHY US</span><h1><?= e(
        content_value("why_us_title", "Why parents choose Achievers")
    ) ?></h1></header>
    <div class="value-grid max-w-6xl mx-auto"><?php foreach (
        $why_cards
        as $card
    ): ?><article class="value-card"><div class="value-card__icon"><i class="fa-solid <?= e(
    $card["icon"]
) ?>" aria-hidden="true"></i></div><h3><?= e($card["title"]) ?></h3><p><?= e(
    $card["text"]
) ?></p></article><?php endforeach; ?></div>
    <div class="text-center mt-12"><a href="admissions.php" class="btn-accent"><?= e(
        content_value("why_us_cta_label", "Start your free trial today")
    ) ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></div>
</div></section>
<?php require_once __DIR__ . "/includes/footer.php"; ?>
