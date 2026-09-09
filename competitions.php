<?php
require_once __DIR__ . "/includes/header.php";
$competitions = db_get_all(
    "SELECT * FROM competitions WHERE status = 'active' ORDER BY event_date DESC"
);
?>
<section class="page-shell"><div class="tail-container">
    <header class="page-header text-center"><span class="section-kicker"><?= e(
        content_value("competitions_label", "OPPORTUNITIES")
    ) ?></span><h1><?= e(
    content_value("competitions_title", "Competitions")
) ?></h1><p><?= e(
    content_value(
        "competitions_intro",
        "Upcoming and past events our gymnasts participate in."
    )
) ?></p></header>
    <?php if ($competitions): ?><div class="data-grid"><?php foreach (
    $competitions
    as $competition
): ?><a href="competition.php?id=<?= (int) $competition[
    "id"
] ?>" class="competition-card transition hover:shadow-xl"><img src="<?= e(
    $competition["image"] ?: "assets/images/hero-facility.jpg"
) ?>" alt="<?= e(
    $competition["title"]
) ?>" loading="lazy"><div class="competition-card__body"><span class="section-kicker"><?= e(
    $competition["type"]
) ?> · <?= e(
     date("d M Y", strtotime($competition["event_date"]))
 ) ?></span><h2><?= e(
    $competition["title"]
) ?></h2><p><i class="fa-solid fa-location-dot text-amber-600" aria-hidden="true"></i> <?= e(
    $competition["location"]
) ?></p><p class="text-amber-700 font-semibold">View details <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></p></div></a><?php endforeach; ?></div><?php else: ?><div class="empty-state"><i class="fa-solid fa-medal" aria-hidden="true"></i><strong><?= e(
    content_value(
        "competitions_empty_title",
        "No competitions listed right now."
    )
) ?></strong><p><?= e(
    content_value(
        "competitions_empty_text",
        "Check back soon for upcoming events."
    )
) ?></p></div><?php endif; ?>
</div></section>
<?php require_once __DIR__ . "/includes/footer.php"; ?>
