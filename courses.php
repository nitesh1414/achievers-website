<?php
require_once __DIR__ . "/includes/header.php";

$categories = db_get_all(
    "SELECT * FROM course_categories WHERE status = 'active' ORDER BY name ASC"
);
$search = trim($_GET["search"] ?? "");
$where = "WHERE c.status = 'active'";
$params = [];
if ($search !== "") {
    $where .= " AND (c.title LIKE ? OR c.description LIKE ? OR d.name LIKE ?)";
    $params = ["%{$search}%", "%{$search}%", "%{$search}%"];
}
$all_courses = db_get_all(
    "SELECT c.*, cat.name AS cat_name, d.name AS discipline_name FROM courses c LEFT JOIN course_categories cat ON c.category_id = cat.id LEFT JOIN disciplines d ON c.discipline_id = d.id {$where} ORDER BY c.id DESC",
    $params
);
$disciplines = db_get_all(
    "SELECT * FROM disciplines WHERE status = 'active' ORDER BY sort_order ASC, name ASC"
);
$apparatus = db_get_all(
    "SELECT a.*, d.name AS discipline_name FROM apparatus a INNER JOIN disciplines d ON a.discipline_id = d.id WHERE a.status = 'active' AND d.status = 'active' ORDER BY d.sort_order ASC, a.gender ASC, a.sort_order ASC, a.name ASC"
);
$apparatus_by_discipline = [];
foreach ($apparatus as $item) {
    $apparatus_by_discipline[$item["discipline_id"]][$item["gender"]][] = $item;
}
?>
<section class="page-shell">
    <div class="tail-container">
        <header class="page-header page-header--split">
            <div><span class="section-kicker"><?= e(
                content_value("courses_label", "PROGRAMS")
            ) ?></span><h1><?= e(
    content_value("courses_title", "Our training programs")
) ?></h1><p><?= e(
    content_value(
        "courses_intro",
        "From beginner foundations to elite competition preparation. Choose the perfect path for your child."
    )
) ?></p></div>
            <a href="admissions.php" class="btn-accent">Start a free trial <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
        </header>

        <?php if (
            $categories
        ): ?><nav class="filter-pills" aria-label="Course categories"><?php foreach (
    $categories
    as $category
): ?><a href="#<?= e($category["slug"]) ?>"><?= e(
    $category["name"]
) ?></a><?php endforeach; ?></nav><?php endif; ?>

        <?php if ($all_courses): ?>
            <div class="course-grid">
                <?php foreach ($all_courses as $course): ?>
                    <article id="<?= e($course["slug"]) ?>" class="course-card">
                        <div class="course-card__image"><img src="<?= e(
                            $course["thumbnail"] ?:
                            "assets/images/course-little.jpg"
                        ) ?>" alt="<?= e(
    $course["title"]
) ?>" loading="lazy"></div>
                        <div class="course-card__body">
                            <span class="course-card__category"><?= e(
                                $course["discipline_name"] ?:
                                $course["cat_name"] ?:
                                "Program"
                            ) ?></span>
                            <h2><?= e($course["title"]) ?></h2>
                            <p><?= e($course["description"]) ?></p>
                            <div class="course-card__footer"><span class="course-card__duration"><i class="fa-regular fa-clock" aria-hidden="true"></i> <?= e(
                                $course["duration"]
                            ) ?></span><a href="admissions.php?course=<?= (int) $course[
    "id"
] ?>" class="btn-primary">Enquire now</a></div>
                            <?php if (
                                !empty($course["syllabus"])
                            ): ?><details><summary>View program details</summary><div><?= nl2br(
    e($course["syllabus"])
) ?></div></details><?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state"><i class="fa-solid fa-dumbbell" aria-hidden="true"></i><strong>Programs are being updated.</strong><p>Contact us to find the right gymnastics pathway for your child.</p></div>
        <?php endif; ?>
    </div>
</section>

<?php if ($disciplines): ?>
<section class="apparatus-section">
    <div class="tail-container">
        <div class="section-heading section-heading--center"><span><?= e(
            content_value("courses_apparatus_label", "GYMNASTICS DISCIPLINES")
        ) ?></span><h2><?= e(
    content_value(
        "courses_apparatus_title",
        "Apparatus, organised by discipline and gender"
    )
) ?></h2><p><?= e(
    content_value(
        "courses_apparatus_intro",
        "Explore the equipment used in our artistic gymnastics pathways."
    )
) ?></p></div>
        <div class="discipline-grid">
            <?php foreach ($disciplines as $discipline): ?>
                <article class="discipline-card">
                    <?php if (
                        !empty($discipline["image"])
                    ): ?><div class="discipline-card__image"><img src="<?= e(
    $discipline["image"]
) ?>" alt="<?= e($discipline["name"]) ?>" loading="lazy"></div><?php endif; ?>
                    <div class="discipline-card__body"><h3><?= e(
                        $discipline["name"]
                    ) ?></h3><?php if ($discipline["description"]): ?><p><?= e(
    $discipline["description"]
) ?></p><?php endif; ?>
                        <?php if (
                            !empty($apparatus_by_discipline[$discipline["id"]])
                        ): ?>
                            <div class="apparatus-groups">
                                <?php foreach ($apparatus_by_discipline[$discipline["id"]] as $gender => $gender_apparatus): ?>
                                    <?php
                                    $apparatus_heading = $gender === "Women"
                                        ? "Women's Artistic Gymnastics (WAG)"
                                        : ($gender === "Men" ? "Men's Artistic Gymnastics (MAG)" : $gender);
                                    ?>
                                    <div class="apparatus-group">
                                        <h4><?= e($apparatus_heading) ?></h4>
                                        <ul class="apparatus-list">
                                            <?php foreach ($gender_apparatus as $apparatus_item): ?>
                                                <li title="<?= e($apparatus_item["description"]) ?>"><?= e($apparatus_item["name"]) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
