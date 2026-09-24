<?php
require_once __DIR__ . "/includes/header.php";

$team_members = db_get_all(
    "SELECT * FROM team_members WHERE status = 'active' ORDER BY experience_years DESC, id DESC"
);
?>
<section class="page-shell">
    <div class="tail-container">
        <header class="page-header">
            <span class="section-kicker"><?= e(
                content_value("team_label", "THE PEOPLE BEHIND ACHIEVERS")
            ) ?></span>
            <h1><?= e(content_value("team_title", "Our team")) ?></h1>
            <p><?= e(
                content_value(
                    "team_intro",
                    "Meet the dedicated people who create a safe, encouraging and focused experience for every gymnast."
                )
            ) ?></p>
        </header>

        <?php if ($team_members): ?>
            <div class="data-grid">
                <?php foreach ($team_members as $member): ?>
                    <?php $member_photo = public_asset_path($member["photo"]); ?>
                    <article class="profile-card team-card">
                        <?php if ($member_photo): ?>
                            <img src="<?= e($member_photo) ?>" alt="<?= e($member["name"]) ?>" loading="lazy">
                        <?php else: ?>
                            <div class="team-card__placeholder" aria-hidden="true"><i class="fa-solid fa-users"></i></div>
                        <?php endif; ?>
                        <div class="profile-card__body">
                            <h2><?= e($member["name"]) ?></h2>
                            <?php if (!empty($member["designation"])): ?>
                                <p class="team-card__designation"><?= e($member["designation"]) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($member["bio"])): ?>
                                <p><?= nl2br(e($member["bio"])) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($member["specialties"])): ?>
                                <p><strong>Areas of support</strong><br><?= e($member["specialties"]) ?></p>
                            <?php endif; ?>
                            <?php if ((int) $member["experience_years"] > 0): ?>
                                <p><strong><?= (int) $member["experience_years"] ?>+ years’ experience</strong></p>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fa-solid fa-users" aria-hidden="true"></i>
                <strong><?= e(content_value("team_empty_title", "Our team will be introduced here soon.")) ?></strong>
                <p><?= e(
                    content_value(
                        "team_empty_text",
                        "Please check back soon to meet the people who support every gymnast’s journey."
                    )
                ) ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php require_once __DIR__ . "/includes/footer.php"; ?>
