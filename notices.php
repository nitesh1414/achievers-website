<?php
require_once __DIR__ . "/includes/header.php";
$notices = db_get_all(
    "SELECT * FROM notices WHERE status = 'published' ORDER BY publish_date DESC"
);
?>
<section class="page-shell"><div class="page-shell--narrow">
    <header class="page-header"><span class="section-kicker">KEEP INFORMED</span><h1><?= e(
        content_value("notices_title", "Notices and downloads")
    ) ?></h1><p><?= e(
    content_value(
        "notices_intro",
        "Latest announcements, schedules and important documents."
    )
) ?></p></header>
    <?php if (
        !$notices
    ): ?><div class="empty-state"><i class="fa-regular fa-bell" aria-hidden="true"></i><?= e(
    content_value("notices_empty_text", "No published notices yet.")
) ?></div><?php else: ?><div class="space-y-4"><?php foreach (
    $notices
    as $notice
): ?><article class="bg-white border rounded-2xl p-6"><div class="flex flex-col sm:flex-row gap-3 justify-between"><div><h2 class="font-bold text-xl"><?= e(
    $notice["title"]
) ?></h2><time class="text-xs text-slate-500" datetime="<?= e(
    $notice["publish_date"]
) ?>"><?= e(
    date("d F Y", strtotime($notice["publish_date"]))
) ?></time></div><?php if ($notice["file_path"]): ?><a href="<?= e(
    $notice["file_path"]
) ?>" target="_blank" rel="noopener noreferrer" class="btn-accent text-xs">Download file <i class="fa-solid fa-download" aria-hidden="true"></i></a><?php endif; ?></div><?php if (
    $notice["content"]
): ?><p class="mt-4 text-sm text-slate-600 whitespace-pre-line"><?= e(
    $notice["content"]
) ?></p><?php endif; ?></article><?php endforeach; ?></div><?php endif; ?>
</div></section>
<?php require_once __DIR__ . "/includes/footer.php"; ?>
