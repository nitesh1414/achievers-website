<?php
require_once __DIR__ . "/includes/header.php";
$toppers = db_get_all(
    "SELECT * FROM toppers WHERE status = 'active' ORDER BY year DESC, id DESC"
);
$competitions = db_get_all(
    "SELECT * FROM competitions WHERE status = 'active' ORDER BY event_date DESC"
);
?>
<section class="page-shell"><div class="tail-container">
    <header class="page-header"><span class="section-kicker"><?= e(
        content_value("achievements_label", "CHAMPIONS")
    ) ?></span><h1><?= e(
    content_value("achievements_title", "Our achievers and results")
) ?></h1><p><?= e(
    content_value(
        "achievements_intro",
        "Proudly showcasing the success of our athletes across national and international platforms."
    )
) ?></p></header>
    <div class="section-heading"><span>ATHLETE HIGHLIGHTS</span><h2><?= e(
        content_value("achievements_medalists_title", "Recent medalists")
    ) ?></h2></div>
    <?php if ($toppers): ?><div class="data-grid mb-14"><?php foreach (
    $toppers
    as $topper
): ?><article class="achievement-card"><img src="<?= e(
    $topper["photo"] ?: "assets/images/topper-aarav.jpg"
) ?>" alt="<?= e(
    $topper["name"]
) ?>" loading="lazy"><div class="achievement-card__body"><h2><?= e(
    $topper["name"]
) ?></h2><p><strong><?= e($topper["rank"]) ?> · <?= e(
     $topper["year"]
 ) ?></strong><br><?= e($topper["achievement"]) ?></p><p><?= e(
    $topper["course"]
) ?></p></div></article><?php endforeach; ?></div><?php else: ?><div class="empty-state">Our achievers will be featured here soon.</div><?php endif; ?>
    <div class="section-heading"><span>ON THE FLOOR</span><h2><?= e(
        content_value(
            "achievements_competitions_title",
            "Competitions and events"
        )
    ) ?></h2></div>
    <div class="space-y-4"><?php foreach (
        $competitions
        as $competition
    ): ?><article class="bg-white border rounded-2xl p-6 flex flex-col md:flex-row gap-5"><div class="md:w-3/12"><span class="section-kicker"><?= $competition[
    "type"
] === "future"
    ? "UPCOMING"
    : "COMPLETED" ?></span><h3 class="font-bold text-lg mt-1"><?= e(
    $competition["title"]
) ?></h3><p class="text-sm text-slate-500"><?= e(
    date("d M Y", strtotime($competition["event_date"]))
) ?> · <?= e(
     $competition["location"]
 ) ?></p></div><div class="flex-1 text-sm text-slate-700">
    <?= nl2br(e($competition["description"])) ?>
    <?php if ($competition["type"] === "future" && $competition["how_to_apply"]): ?>
        <div class="mt-3"><strong>How to participate</strong><br><?= nl2br(e($competition["how_to_apply"])) ?></div>
    <?php endif; ?>
    <?php if ($competition["results"]): ?>
        <div class="mt-3 bg-slate-100 p-3 text-xs rounded"><strong>Results:</strong> <?= nl2br(e($competition["results"])) ?></div>
    <?php endif; ?>
</div></article><?php endforeach; ?></div>
</div></section>
<?php require_once __DIR__ . "/includes/footer.php"; ?>
