<?php
require_once __DIR__ . "/db.php";
require_once __DIR__ . "/functions.php";

$site_name = get_setting("site_name", "Achievers Gymnastics Academy");
$phone = get_setting("phone", "+91 90965 94552");
$whatsapp = whatsapp_number(get_setting("whatsapp", "919096594552"));
$logo = get_setting("logo", "assets/images/logo-big.png");
$social_links = get_social_links();
$whatsapp_message = rawurlencode(
    content_value(
        "whatsapp_message",
        "Hi Achievers Academy, I would like to know more."
    )
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(
        get_setting(
            "meta_title",
            "Achievers Gymnastics Academy | Best Gymnastics in Nagpur"
        )
    ) ?></title>
    <meta name="description" content="<?= e(
        get_setting(
            "meta_description",
            "Nagpur's gymnastics academy for confident athletes."
        )
    ) ?>">
    <meta name="keywords" content="<?= e(
        get_setting("meta_keywords", "gymnastics nagpur, gymnastics academy")
    ) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= e($logo) ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css?v=20260909-compact-5">
</head>
<body class="bg-slate-50 text-slate-800">
    <a class="skip-link" href="#main-content">Skip to content</a>

    <div class="top-bar bg-slate-950 text-white">
        <div class="tail-container top-bar__inner">
            <div class="top-bar__details">
                <span><i class="fa-solid fa-location-dot" aria-hidden="true"></i> <?= e(
                    get_setting("address", "Wardhaman Nagar, Nagpur")
                ) ?></span>
                <a href="tel:<?= e(
                    $phone
                ) ?>"><i class="fa-solid fa-phone" aria-hidden="true"></i> <?= e(
    $phone
) ?></a>
            </div>
            <div class="top-bar__social" aria-label="Social media links">
                <?php foreach ($social_links as $social): ?>
                    <a href="<?= e(
                        $social["url"]
                    ) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= e(
    $social["platform"]
) ?>" title="<?= e($social["platform"]) ?>">
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
        </div>
    </div>

    <nav class="navbar text-white" aria-label="Primary navigation">
        <div class="tail-container navbar__inner">
            <a href="./" class="navbar__brand" aria-label="<?= e(
                $site_name
            ) ?> home">
                <img src="<?= e($logo) ?>" alt="<?= e(
    $site_name
) ?>" class="navbar-logo">
                <span class="text-logo"><?= e($site_name) ?></span>
            </a>

            <div class="navbar__links">
                <a href="./" class="nav-link">Home</a>
                <a href="about.php" class="nav-link">About</a>
                <a href="courses.php" class="nav-link">Courses</a>
                <a href="achievements.php" class="nav-link">Achievements</a>
                <a href="mentor.php" class="nav-link">Mentors</a>
                <a href="team.php" class="nav-link">Our Team</a>
                <a href="admissions.php" class="nav-link">Admissions</a>
                <a href="gallery.php" class="nav-link">Gallery</a>
                <a href="contact.php" class="nav-link">Contact</a>
            </div>

            <div class="navbar__actions">
                <a href="admissions.php" class="btn-accent navbar__cta">Enroll now</a>
                <button type="button" class="menu-toggle" data-menu-toggle aria-controls="mobile-menu" aria-expanded="false" aria-label="Open navigation menu">
                    <i class="fa-solid fa-bars" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="mobile-menu" data-mobile-menu>
            <div class="tail-container mobile-menu__links">
                <a href="./" class="nav-link">Home</a>
                <a href="about.php" class="nav-link">About us</a>
                <a href="courses.php" class="nav-link">Our programs</a>
                <a href="achievements.php" class="nav-link">Achievements</a>
                <a href="mentor.php" class="nav-link">Our mentors</a>
                <a href="team.php" class="nav-link">Our team</a>
                <a href="admissions.php" class="nav-link">Admissions</a>
                <a href="gallery.php" class="nav-link">Gallery</a>
                <a href="contact.php" class="nav-link">Contact</a>
                <a href="admissions.php" class="btn-accent mobile-menu__cta">Enroll for a free trial</a>
            </div>
        </div>
    </nav>

    <?php if ($whatsapp): ?>
        <a class="whatsapp-float" href="https://wa.me/<?= e(
            $whatsapp
        ) ?>?text=<?= e(
    $whatsapp_message
) ?>" target="_blank" rel="noopener noreferrer" aria-label="<?= e(
    content_value(
        "whatsapp_float_label",
        "Chat with Achievers Academy on WhatsApp"
    )
) ?>" title="Chat on WhatsApp">
            <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
            <span>WhatsApp</span>
        </a>
    <?php endif; ?>

    <main id="main-content">
