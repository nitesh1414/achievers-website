<?php
/** Shared testimonial carousel. $testimonials is provided by the host page. */
$testimonial_section_id = $testimonial_section_id ?? "testimonials-carousel"; ?>
<section class="testimonials-section" aria-labelledby="<?= e(
    $testimonial_section_id
) ?>-title">
    <div class="tail-container">
        <div class="testimonials-section__heading">
            <div>
                <span class="section-kicker section-kicker--light">PARENTS &amp; ATHLETES SAY</span>
                <h2 id="<?= e(
                    $testimonial_section_id
                ) ?>-title">Loved by champions</h2>
            </div>
            <div class="testimonials-section__trust"><i class="fa-solid fa-star" aria-hidden="true"></i> Trusted by academy families</div>
        </div>

        <div id="<?= e(
            $testimonial_section_id
        ) ?>" class="carousel-container testimonial-carousel">
            <div class="carousel-track">
                <?php if (!empty($testimonials)): ?>
                    <?php foreach ($testimonials as $testimonial): ?>
                        <?php
                        $initial = strtoupper(
                            substr(trim($testimonial["name"]), 0, 1)
                        );
                        $rating = max(1, min(5, (int) $testimonial["rating"]));
                        ?>
                        <article class="carousel-item testimonial-card" tabindex="0">
                            <div class="testimonial-card__quote-mark" aria-hidden="true">“</div>
                            <div class="testimonial-card__rating" aria-label="<?= $rating ?> out of 5 stars">
                                <?php for ($star = 1; $star <= 5; $star++): ?>
                                    <i class="fa-<?= $star <= $rating
                                        ? "solid"
                                        : "regular" ?> fa-star" aria-hidden="true"></i>
                                <?php endfor; ?>
                            </div>
                            <blockquote><?= e(
                                $testimonial["quote"]
                            ) ?></blockquote>
                            <footer class="testimonial-card__person">
                                <?php if (!empty($testimonial["photo"])): ?>
                                    <img src="<?= e(
                                        $testimonial["photo"]
                                    ) ?>" alt="<?= e(
    $testimonial["name"]
) ?>" loading="lazy">
                                <?php else: ?>
                                    <span class="testimonial-card__avatar" aria-hidden="true"><?= e(
                                        $initial
                                    ) ?></span>
                                <?php endif; ?>
                                <div>
                                    <cite><?= e($testimonial["name"]) ?></cite>
                                    <?php if (
                                        !empty($testimonial["role"])
                                    ): ?><span><?= e(
    $testimonial["role"]
) ?></span><?php endif; ?>
                                </div>
                            </footer>
                        </article>
                    <?php endforeach; ?>
                <?php else: ?>
                    <article class="carousel-item testimonial-card testimonial-card--empty">
                        <div class="testimonial-card__quote-mark" aria-hidden="true">“</div>
                        <h3>Share your experience</h3>
                        <p>Be the first to share your Achievers Academy story.</p>
                    </article>
                <?php endif; ?>
            </div>
            <div class="carousel-controls testimonial-carousel__controls">
                <button type="button" class="carousel-btn carousel-prev" aria-label="Show previous testimonial"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i></button>
                <div class="carousel-dots" aria-label="Testimonial carousel navigation"></div>
                <button type="button" class="carousel-btn carousel-next" aria-label="Show next testimonial"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>
</section>
