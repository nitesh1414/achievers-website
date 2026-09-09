<?php
require_once __DIR__ . "/includes/header.php";

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

$comp = db_get_row(
    "SELECT * FROM competitions WHERE id = ? AND status = 'active'",
    [$id]
);

if (!$comp) {
    header("Location: competitions.php");
    exit();
}
?>
<div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10 py-12">
    <a href="competitions.php" class="text-sm text-amber-600 hover:underline mb-4 inline-block">← <?= e(
        content_value("competition_back_label", "Back to competitions")
    ) ?></a>

    <div class="bg-white border rounded-3xl overflow-hidden">
        <?php if (!empty($comp["image"])): ?>
            <img src="<?= htmlspecialchars(
                $comp["image"]
            ) ?>" class="w-full h-72 object-cover" alt="<?= htmlspecialchars(
    $comp["title"]
) ?>">
        <?php endif; ?>

        <div class="p-8 md:p-10">
            <div class="flex flex-wrap items-center gap-3 mb-3">
                <span class="px-3 py-1 rounded-full text-xs font-bold <?= $comp[
                    "type"
                ] === "future"
                    ? "bg-blue-100 text-blue-700"
                    : "bg-gray-100 text-gray-700" ?>">
                    <?= ucfirst($comp["type"]) ?>
                </span>
                <?php if ($comp["event_date"]): ?>
                    <span class="text-sm text-slate-500"><?= date(
                        "d M Y",
                        strtotime($comp["event_date"])
                    ) ?></span>
                <?php endif; ?>
            </div>

            <h1 class="text-4xl font-extrabold tracking-tight mb-2"><?= htmlspecialchars(
                $comp["title"]
            ) ?></h1>

            <?php if (!empty($comp["location"])): ?>
                <div class="text-lg text-slate-600 mb-6">📍 <?= htmlspecialchars(
                    $comp["location"]
                ) ?></div>
            <?php endif; ?>

            <?php if (!empty($comp["description"])): ?>
                <div class="prose max-w-none mb-8">
                    <h3 class="text-xl font-semibold mb-2"><?= e(
                        content_value(
                            "competition_about_label",
                            "About the event"
                        )
                    ) ?></h3>
                    <p class="text-slate-700"><?= nl2br(
                        htmlspecialchars($comp["description"])
                    ) ?></p>
                </div>
            <?php endif; ?>

            <?php if (
                $comp["type"] === "future" &&
                !empty($comp["how_to_apply"])
            ): ?>
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-6 mb-8">
                    <h3 class="font-semibold text-amber-800 mb-2"><?= e(
                        content_value(
                            "competition_apply_label",
                            "How to apply / participate"
                        )
                    ) ?></h3>
                    <div class="text-slate-700"><?= nl2br(
                        htmlspecialchars($comp["how_to_apply"])
                    ) ?></div>
                </div>
            <?php endif; ?>

            <?php if ($comp["type"] === "past" && !empty($comp["results"])): ?>
                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-6 mb-8">
                    <h3 class="font-semibold text-emerald-800 mb-2"><?= e(
                        content_value("competition_results_label", "Results")
                    ) ?></h3>
                    <div class="text-slate-700"><?= nl2br(
                        htmlspecialchars($comp["results"])
                    ) ?></div>
                </div>
            <?php endif; ?>

            <div class="mt-8 pt-6 border-t flex flex-wrap gap-3">
                <a href="competitions.php" class="btn-primary px-6 py-2.5 text-sm">Back to All Competitions</a>
                <a href="contact.php" class="btn-accent px-6 py-2.5 text-sm"><?= e(
                    content_value(
                        "competition_contact_button",
                        "Contact for more information"
                    )
                ) ?></a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
