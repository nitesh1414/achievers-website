<?php
require_once __DIR__ . "/includes/header.php";

$category_rows = db_get_all(
    "SELECT DISTINCT category FROM gallery WHERE status = 'active' AND category IS NOT NULL AND category != '' ORDER BY category ASC"
);
$categories = array_merge(["All"], array_column($category_rows, "category"));
$active_category = $_GET["cat"] ?? "All";
if (!in_array($active_category, $categories, true)) {
    $active_category = "All";
}
$sql = "SELECT * FROM gallery WHERE status = 'active'";
$params = [];
if ($active_category !== "All") {
    $sql .= " AND category = ?";
    $params[] = $active_category;
}
$sql .= " ORDER BY created_at DESC";
$gallery = db_get_all($sql, $params);
?>
<section class="page-shell">
    <div class="tail-container">
        <header class="page-header"><span class="section-kicker">OUR MOMENTS</span><h1><?= e(
            content_value("gallery_title", "Gallery")
        ) ?></h1><p><?= e(
    content_value(
        "gallery_intro",
        "Moments from our training sessions, competitions and events."
    )
) ?></p></header>
        <nav class="filter-pills" aria-label="Gallery categories"><?php foreach (
            $categories
            as $category
        ): ?><a href="?cat=<?= urlencode($category) ?>" <?= $active_category ===
$category
    ? 'aria-current="page"'
    : "" ?>><?= e($category) ?></a><?php endforeach; ?></nav>

        <?php if ($gallery): ?>
            <div class="gallery-grid" data-gallery>
                <?php foreach ($gallery as $item): ?>
                    <button type="button" class="gallery-item" data-gallery-item data-image="<?= e(
                        $item["image"]
                    ) ?>" data-title="<?= e(
    $item["title"]
) ?>" data-meta="<?= e(
    trim(
        ($item["category"] ?: "") .
            ($item["event_date"] ? " · " . $item["event_date"] : "")
    )
) ?>">
                        <img src="<?= e($item["image"]) ?>" alt="<?= e(
    $item["title"]
) ?>" loading="lazy">
                        <span class="gallery-item__body"><span class="gallery-item__title"><?= e(
                            $item["title"]
                        ) ?></span><span class="gallery-item__meta"><span class="gallery-item__category"><?= e(
    $item["category"]
) ?></span><time datetime="<?= e($item["event_date"]) ?>"><?= e(
    $item["event_date"]
) ?></time></span></span>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state"><i class="fa-regular fa-images" aria-hidden="true"></i><?= e(
                content_value(
                    "gallery_empty_text",
                    "No images in this category yet."
                )
            ) ?></div>
        <?php endif; ?>
    </div>
</section>

<div class="lightbox" data-lightbox aria-hidden="true" role="dialog" aria-modal="true" aria-label="Gallery image preview">
    <div class="lightbox__dialog"><button type="button" class="lightbox__close" data-lightbox-close aria-label="Close image preview"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button><img src="" data-lightbox-image alt=""><div class="lightbox__caption"><strong data-lightbox-title></strong><span data-lightbox-meta></span></div></div>
</div>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
