<?php
require_once __DIR__ . "/includes/header.php";

$mentors = db_get_all(
    "SELECT * FROM mentors WHERE status = 'active' ORDER BY experience_years DESC, id DESC"
);
?>
<section class="page-shell">
    <div class="tail-container">
        <header class="page-header">
            <span class="section-kicker">EXPERT GUIDANCE</span>
            <h1><?= e(content_value("mentors_title", "Our expert mentors")) ?></h1>
            <p><?= e(
                content_value(
                    "mentors_intro",
                    "Led by an experienced coaching team, we help every student reach their full potential."
                )
            ) ?></p>
        </header>

        <?php if ($mentors): ?>
            <div class="data-grid">
                <?php foreach ($mentors as $mentor): ?>
                    <?php
                    $mentor_photo = public_asset_path(
                        $mentor["photo"],
                        "assets/images/mentor-pankaj.jpg"
                    );
                    ?>
                    <article class="profile-card mentor-card">
                        <img src="<?= e($mentor_photo) ?>" alt="<?= e(
                            $mentor["name"]
                        ) ?>" loading="lazy">
                        <div class="profile-card__body">
                            <h2><?= e($mentor["name"]) ?></h2>
                            <?php if (!empty($mentor["designation"])): ?>
                                <p class="mentor-card__designation"><?= e(
                                    $mentor["designation"]
                                ) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($mentor["bio"])): ?>
                                <p><?= nl2br(e($mentor["bio"])) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($mentor["specialties"])): ?>
                                <p><strong>Specialties</strong><br><?= e(
                                    $mentor["specialties"]
                                ) ?></p>
                            <?php endif; ?>
                            <?php if ((int) $mentor["experience_years"] > 0): ?>
                                <p><strong><?= (int) $mentor[
                                    "experience_years"
                                ] ?>+ years’ experience</strong></p>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">Our coaching team will be introduced here soon.</div>
        <?php endif; ?>
    </div>
</section>
<?php require_once __DIR__ . "/includes/footer.php"; ?>
