<?php
require_once __DIR__ . "/includes/header.php";

$banners = db_get_all(
    "SELECT * FROM banners WHERE status = 'active' ORDER BY sort_order ASC"
);
$courses = db_get_all(
    "SELECT c.*, cat.name AS category_name FROM courses c LEFT JOIN course_categories cat ON c.category_id = cat.id WHERE c.status = 'active' ORDER BY c.id DESC LIMIT 8"
);
$toppers = db_get_all(
    "SELECT * FROM toppers WHERE status = 'active' ORDER BY year DESC, id DESC LIMIT 8"
);
$testimonials = db_get_all(
    "SELECT * FROM testimonials WHERE status = 'active' ORDER BY created_at DESC LIMIT 8"
);
$marquee_competitions = db_get_all(
    "SELECT id, title, event_date FROM competitions WHERE status = 'active' AND type = 'future' ORDER BY event_date ASC"
);
$stats = [
    "students" => get_setting("active_students", "400+"),
    "medals" => get_setting("medals_won", "250+"),
    "years" => get_setting("years_experience", "18"),
];
?>

<section class="hero-slider" aria-label="Featured academy highlights">
    <?php if (!empty($banners)): ?>
        <?php foreach ($banners as $index => $banner): ?>
            <?php
            $show_content =
                !array_key_exists("show_content", $banner) ||
                (int) $banner["show_content"] === 1;
            $banner_link = !empty($banner["link_url"])
                ? $banner["link_url"]
                : "admissions.php";
            ?>
            <article class="hero-slide <?= $index === 0
                ? "active"
                : "" ?> <?= !$show_content
     ? "hero-slide--image-only"
     : "" ?>" aria-hidden="<?= $index === 0 ? "false" : "true" ?>">
                <img class="hero-slide__image" src="<?= e(
                    $banner["image"] ?: "assets/images/hero-main.jpg"
                ) ?>" alt="" <?= $index === 0
    ? 'fetchpriority="high"'
    : 'loading="lazy"' ?>>
                <?php if ($show_content): ?>
                    <div class="hero-content">
                        <div class="tail-container">
                            <div class="hero-copy">
                                <?php if (
                                    !empty($banner["title"])
                                ): ?><span class="hero-badge"><?= e(
    $banner["title"]
) ?></span><?php endif; ?>
                                <h1 class="hero-title"><?= e(
                                    $banner["subtitle"] ?:
                                    "Train like a champion"
                                ) ?></h1>
                                <p class="hero-text"><?= e(
                                    $banner["description"] ??
                                        content_value(
                                            "hero_default_text",
                                            "A confident, disciplined future starts with safe, world-class gymnastics training."
                                        )
                                ) ?></p>
                                <div class="hero-actions">
<a href="<?= e(
    $banner_link
) ?>" class="btn-accent">Explore <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                                    <a href="achievements.php" class="btn-primary">View achievements</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <article class="hero-slide active" aria-hidden="false">
            <img class="hero-slide__image" src="assets/images/hero-main.jpg" alt="Gymnast in training" fetchpriority="high">
            <div class="hero-content">
                <div class="tail-container">
                    <div class="hero-copy">
                        <span class="hero-badge">Gymnastics academy</span>
                        <h1 class="hero-title">Train like a champion</h1>
                        <p class="hero-text">Build strength, discipline and a podium-ready future with Achievers Academy.</p>
                        <div class="hero-actions"><a href="admissions.php" class="btn-accent">Enroll now <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a></div>
                    </div>
                </div>
            </div>
        </article>
    <?php endif; ?>

    <?php if (count($banners) > 1): ?>
        <button type="button" class="slider-arrow prev" aria-label="Previous banner"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i></button>
        <button type="button" class="slider-arrow next" aria-label="Next banner"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i></button>
        <div class="slider-nav" aria-label="Banner carousel navigation"></div>
    <?php endif; ?>
</section>

<?php if ($marquee_competitions): ?>
    <section class="competition-ticker" aria-label="Upcoming competitions">
        <div class="tail-container competition-ticker__inner">
            <span class="competition-ticker__label"><?= e(
                content_value("home_competitions_label", "COMPETITIONS")
            ) ?></span>
            <div class="marquee-wrap">
                <div class="marquee">
                    <?php foreach (
                        array_merge(
                            $marquee_competitions,
                            $marquee_competitions
                        )
                        as $competition
                    ): ?>
                        <a href="competition.php?id=<?= (int) $competition["id"] ?>">
                            <?= e($competition["title"]) ?>
                            <?php if ($competition["event_date"]): ?>
                                <time datetime="<?= e($competition["event_date"]) ?>">• <?= e(date("d M Y", strtotime($competition["event_date"]))) ?></time>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<section class="trust-bar" aria-label="Academy highlights">
    <div class="tail-container trust-bar__inner">
        <div class="trust-bar__list"><span><i class="fa-solid fa-trophy" aria-hidden="true"></i> National champions</span><span>International coaching</span><span>FIG-standard facility</span></div>
        <div class="trust-bar__stats"><span><strong><?= e(
            $stats["medals"]
        ) ?></strong> medals</span><span><strong><?= e(
    $stats["years"]
) ?></strong> years</span><span><strong><?= e(
    $stats["students"]
) ?></strong> families</span></div>
    </div>
</section>

<section class="home-values">
    <div class="tail-container">
        <div class="section-heading section-heading--center">
            <span><?= e(
                content_value("home_why_label", "WHY ACHIEVERS?")
            ) ?></span>
            <h2><?= e(
                content_value("home_why_title", "Built to build champions")
            ) ?></h2>
        </div>
        <div class="value-grid">
            <?php for ($value_index = 1; $value_index <= 3; $value_index++): ?>
                <article class="value-card">
                    <div class="value-card__icon" aria-hidden="true"><?= e(
                        content_value("home_why_{$value_index}_icon", "★")
                    ) ?></div>
                    <h3><?= e(
                        content_value(
                            "home_why_{$value_index}_title",
                            "Achievers Academy"
                        )
                    ) ?></h3>
                    <p><?= e(
                        content_value(
                            "home_why_{$value_index}_text",
                            "A supportive path for every gymnast."
                        )
                    ) ?></p>
                </article>
            <?php endfor; ?>
        </div>
    </div>
</section>

<?php
$mission_vision_id = "home-mission-vision";
require __DIR__ . "/includes/mission-vision.php";
?>

<section class="content-section content-section--warm">
    <div class="tail-container">
        <div class="section-heading">
            <span><?= e(
                content_value("home_programs_label", "PROGRAMS")
            ) ?></span>
            <h2><?= e(
                content_value("home_programs_title", "Our training programs")
            ) ?></h2>
        </div>
        <div id="programs-carousel" class="carousel-container">
            <div class="carousel-track">
                <?php if ($courses): ?>
                    <?php foreach ($courses as $course): ?>
                        <a href="courses.php#<?= e(
                            $course["slug"]
                        ) ?>" class="carousel-item modern-card program-card">
                            <div class="program-card__image"><img src="<?= e(
                                $course["thumbnail"] ?:
                                "assets/images/course-little.jpg"
                            ) ?>" alt="<?= e(
    $course["title"]
) ?>" loading="lazy"><span class="program-card__tag"><?= e(
    $course["category_name"] ?: "Program"
) ?></span></div>
                            <div class="program-card__body"><h3><?= e(
                                $course["title"]
                            ) ?></h3><p><?= e(
    content_limit($course["description"], 110)
) ?></p><div class="program-card__footer"><span><?= e(
    $course["duration"]
) ?></span><strong>Explore <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></strong></div></div>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="carousel-item modern-card program-card"><div class="program-card__body"><h3>Programs coming soon</h3><p>Contact our team to find the right gymnastics pathway for your child.</p></div></div>
                <?php endif; ?>
            </div>
            <div class="carousel-controls"><button type="button" class="carousel-btn carousel-prev" aria-label="Previous program"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button><div class="carousel-dots" aria-label="Programs carousel navigation"></div><button type="button" class="carousel-btn carousel-next" aria-label="Next program"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button></div>
        </div>
    </div>
</section>

<section class="content-section content-section--soft">
    <div class="tail-container">
        <div class="section-heading"><span><?= e(
            content_value("home_achievers_label", "CHAMPIONS MADE HERE")
        ) ?></span><h2><?= e(
    content_value("home_achievers_title", "Our star achievers")
) ?></h2></div>
        <div id="achievers-carousel" class="carousel-container">
            <div class="carousel-track">
                <?php if ($toppers): ?>
                    <?php foreach ($toppers as $topper): ?>
                        <article class="carousel-item modern-card achiever-card">
                            <div class="achiever-card__image"><img src="<?= e(
                                $topper["photo"] ?:
                                "assets/images/topper-aarav.jpg"
                            ) ?>" alt="<?= e(
    $topper["name"]
) ?>" loading="lazy"><div class="achiever-card__label"><strong><?= e(
    $topper["name"]
) ?></strong><span><?= e($topper["rank"]) ?> · <?= e(
     $topper["year"]
 ) ?></span></div></div>
                            <div class="achiever-card__body"><p><?= e(
                                content_limit($topper["achievement"], 125)
                            ) ?></p></div>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="carousel-item modern-card achiever-card"><div class="achiever-card__body"><h3>Our champions are training hard</h3><p>Check back soon to meet our newest achievers.</p></div></div>
                <?php endif; ?>
            </div>
            <div class="carousel-controls"><button type="button" class="carousel-btn carousel-prev" aria-label="Previous achiever"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button><div class="carousel-dots" aria-label="Achievers carousel navigation"></div><button type="button" class="carousel-btn carousel-next" aria-label="Next achiever"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button></div>
        </div>
    </div>
</section>

<?php
$testimonial_section_id = "home-testimonials-carousel";
require __DIR__ . "/includes/testimonials-section.php";
?>

<section class="home-cta">
    <div class="tail-container home-cta__inner">
        <div><h2><?= e(
            content_value(
                "home_cta_title",
                "Ready to begin your champion story?"
            )
        ) ?></h2><p><?= e(
    content_value(
        "home_cta_text",
        "Book a free trial session this week. Limited spots available."
    )
) ?></p></div>
        <div class="home-cta__actions"><a href="admissions.php" class="btn-accent"><?= e(
            content_value("home_cta_button", "Book free trial")
        ) ?></a><a href="tel:<?= e(
    $phone
) ?>" class="home-cta__phone"><i class="fa-solid fa-phone" aria-hidden="true"></i> <?= e(
    $phone
) ?></a></div>
    </div>
</section>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
