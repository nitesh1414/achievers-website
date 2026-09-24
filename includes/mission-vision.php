<?php
/** Shared Mission & Vision module for Home and About pages. */
$mission_vision_id = $mission_vision_id ?? "mission-vision"; ?>
<section class="mission-vision" aria-labelledby="<?= e(
    $mission_vision_id
) ?>-title">
    <div class="tail-container">
        <div class="section-heading section-heading--center">
            <span><?= e(
                content_value("mission_label", "OUR MISSION")
            ) ?> &amp; <?= e(
     content_value("vision_label", "OUR VISION")
 ) ?></span>
            <h2 id="<?= e($mission_vision_id) ?>-title"><?= e(
    content_value(
        "mission_vision_section_title",
        "The purpose behind every practice"
    )
) ?></h2>
        </div>

        <div class="mission-vision__grid">
            <article class="mission-card mission-card--mission">
                <div class="mission-card__image">
                    <img src="<?= e(
                        content_value(
                            "mission_image",
                            "assets/images/hero-main.jpg"
                        )
                    ) ?>" alt="<?= e(
    content_value("mission_image_alt", "Young gymnast training with a coach")
) ?>" loading="lazy">
                </div>
                <div class="mission-card__body">
                    <span class="mission-card__eyebrow"><i class="fa-solid fa-bullseye" aria-hidden="true"></i> <?= e(
                        content_value("mission_label", "OUR MISSION")
                    ) ?></span>
                    <h3><?= e(
                        content_value(
                            "mission_title",
                            "Building champions in body, mind and character"
                        )
                    ) ?></h3>
                    <p><?= e(
                        content_value(
                            "mission_content",
                            "We give every child the opportunity to discover their inner champion through safe, structured and world-class gymnastics training."
                        )
                    ) ?></p>
                </div>
            </article>

            <article class="mission-card mission-card--vision">
                <div class="mission-card__image">
                    <img src="<?= e(
                        content_value(
                            "vision_image",
                            "assets/images/hero-facility.jpg"
                        )
                    ) ?>" alt="<?= e(
    content_value("vision_image_alt", "Gymnast performing in the academy")
) ?>" loading="lazy">
                </div>
                <div class="mission-card__body">
                    <span class="mission-card__eyebrow"><i class="fa-solid fa-eye" aria-hidden="true"></i> <?= e(
                        content_value("vision_label", "OUR VISION")
                    ) ?></span>
                    <h3><?= e(
                        content_value(
                            "vision_title",
                            "A confident generation that rises higher"
                        )
                    ) ?></h3>
                    <p><?= e(
                        content_value(
                            "vision_content",
                            "To be the most trusted gymnastics academy in central India, developing disciplined, resilient athletes and thoughtful leaders for life."
                        )
                    ) ?></p>
                </div>
            </article>
        </div>
    </div>
</section>
