<?php
$footer_phone = get_setting("phone", "+91 90965 94552");
$footer_email = get_setting("email", "info@achieversgymnastics.com");
$footer_address = get_setting("address", "Wardhaman Nagar, Nagpur");
$footer_whatsapp = whatsapp_number(get_setting("whatsapp", "919096594552"));
$footer_social_links = get_social_links();
$footer_whatsapp_message = rawurlencode(
    content_value(
        "whatsapp_message",
        "Hi Achievers Academy, I would like to know more."
    )
);
?>
</main>
<footer class="site-footer">
    <div class="tail-container">
        <div class="site-footer__grid">
            <div class="site-footer__brand">
                <a href="./" class="site-footer__logo" aria-label="<?= e(
                    get_setting("site_name", "Achievers Gymnastics Academy")
                ) ?> home">
                    <img src="<?= e(
                        get_setting("logo", "assets/images/logo-big.png")
                    ) ?>" alt="<?= e(
    get_setting("site_name", "Achievers Gymnastics Academy")
) ?>">
                    <span><?= e(
                        get_setting("site_name", "Achievers Gymnastics Academy")
                    ) ?></span>
                </a>
                <p><?= e(
                    content_value(
                        "footer_description",
                        "Nagpur's gymnastics academy for disciplined, confident and resilient athletes."
                    )
                ) ?></p>
                <?php if ($footer_social_links): ?>
                    <div class="footer-socials" aria-label="Social media links">
                        <?php foreach ($footer_social_links as $social): ?>
                            <a href="<?= e(
                                $social["url"]
                            ) ?>" target="_blank" rel="noopener noreferrer" title="<?= e(
    $social["platform"]
) ?>" aria-label="<?= e($social["platform"]) ?>">
                                <i class="<?= e(
                                    social_icon_family(
                                        $social["icon"] ?? "",
                                        $social["platform"]
                                    ) .
                                        " " .
                                        social_icon_class(
                                            $social["icon"] ?? "",
                                            $social["platform"]
                                        )
                                ) ?>" aria-hidden="true"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div>
                <h2>Explore</h2>
                <nav class="footer-links" aria-label="Explore">
                    <a href="about.php">About us</a>
                    <a href="courses.php">Training programs</a>
                    <a href="mentor.php">Our mentors</a>
                    <a href="team.php">Our team</a>
                    <a href="achievements.php">Achievements</a>
                    <a href="competitions.php">Competitions</a>
                    <a href="notices.php">Notices</a>
                </nav>
            </div>
            <div>
                <h2>Join us</h2>
                <nav class="footer-links" aria-label="Join us">
                    <a href="admissions.php">Admissions</a>
                    <a href="admissions.php">Book a free trial</a>
                    <a href="gallery.php">Gallery</a>
                    <a href="contact.php">Contact</a>
                </nav>
            </div>
            <div>
                <h2>Contact</h2>
                <address class="footer-contact">
                    <span><i class="fa-solid fa-location-dot" aria-hidden="true"></i> <?= e(
                        $footer_address
                    ) ?></span>
                    <a href="tel:<?= e(
                        $footer_phone
                    ) ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i> <?= e(
    $footer_phone
) ?></a>
                    <a href="mailto:<?= e(
                        $footer_email
                    ) ?>"><i class="fa-solid fa-envelope" aria-hidden="true"></i> <?= e(
    $footer_email
) ?></a>
                </address>
                <?php if ($footer_whatsapp): ?>
                    <a href="https://wa.me/<?= e(
                        $footer_whatsapp
                    ) ?>?text=<?= e(
    $footer_whatsapp_message
) ?>" target="_blank" rel="noopener noreferrer" class="footer-whatsapp">
                        <i class="fa-brands fa-whatsapp" aria-hidden="true"></i> Chat on WhatsApp
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="site-footer__bottom">
            <div>&copy; <?= date("Y") ?> <?= e(
     content_value("footer_copyright", "Achievers Gymnastics Academy")
 ) ?>. All rights reserved.</div>
            <?php if (content_value("footer_developer_url", "")): ?>
                <div>Designed and developed by <a href="<?= e(
                    content_value("footer_developer_url", "#")
                ) ?>" target="_blank" rel="noopener noreferrer"><?= e(
    content_value(
        "footer_developer_name",
        "Right Serve Infotech System Pvt. Ltd."
    )
) ?></a></div>
            <?php endif; ?>
        </div>
    </div>
</footer>
<script src="assets/js/site.js?v=20260909"></script>
</body>
</html>
