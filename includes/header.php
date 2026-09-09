<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$site_name = get_setting('site_name', 'Achievers Gymnastics Academy');
$phone = get_setting('phone', '+91 90965 94552');
$whatsapp = get_setting('whatsapp', '919096594552');
$instagram = get_setting('instagram', 'https://www.instagram.com/achieversgymnasticacademy/');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= get_setting('meta_title', 'Achievers Gymnastics Academy | Best Gymnastics in Nagpur') ?></title>
    <meta name="description" content="<?= get_setting('meta_description', 'Nagpur\'s #1 gymnastics academy under Coach Pankaj Kunde. 250+ medals. FIG-standard facility.') ?>">
    <meta name="keywords" content="<?= get_setting('meta_keywords', 'gymnastics nagpur, gymnastics academy') ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/logo-big.png">
    <link rel="shortcut icon" href="assets/images/logo-big.png">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=20260803">

</head>

<body class="bg-slate-50 text-slate-800">
    <!-- Top Bar -->
    <div class="top-bar bg-slate-900 text-white text-sm py-2.5">
        <div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10 flex flex-wrap justify-between items-center gap-x-4 text-xs">
            <div class="flex items-center gap-x-4 flex-wrap">
                <span class="flex items-center gap-x-1.5"><span class="text-amber-400">📍</span> <?= get_setting('address', 'Wardhaman Nagar, Nagpur') ?></span>
                <a href="tel:<?= $phone ?>" class="hover:text-amber-300 transition-colors"><?= $phone ?></a>
            </div>
            <div class="flex items-center gap-x-4 text-xs">
                <a href="https://wa.me/<?= $whatsapp ?>?text=Hi%20Achievers%20Academy" target="_blank"
                    class="hover:text-emerald-400 flex items-center gap-x-1.5" aria-label="WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                    <span>WhatsApp</span>
                </a>
                <a href="<?= $instagram ?>" target="_blank"
                    class="hover:text-amber-300 transition-colors flex items-center gap-x-1.5" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                    <span>Instagram</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Modern Navbar -->
    <nav class="navbar text-white shadow-lg">
        <div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10 w-full max-w-[1400px] mx-auto px-6 md:px-8">
            <div class="flex justify-between items-center">
                <!-- Logo (COLOR + BIG) -->
                <a href="./" class="flex items-center group">
                    <img src="assets/images/logo-big.png"
                        alt="<?= htmlspecialchars($site_name) ?>"
                        class="navbar-logo h-[100px] w-auto object-contain">
                    <div class="text-logo">
                        <?= $site_name ?>
                    </div>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center gap-x-8 text-sm font-medium">
                    <a href="./" class="nav-link">Home</a>
                    <a href="about.php" class="nav-link">About</a>
                    <a href="courses.php" class="nav-link">Courses</a>
                    <a href="achievements.php" class="nav-link">Achievements</a>
                    <a href="mentor.php" class="nav-link">Mentor</a>
                    <a href="admissions.php" class="nav-link">Admissions</a>
                    <a href="gallery.php" class="nav-link">Gallery</a>
                    <a href="contact.php" class="nav-link">Contact</a>
                </div>

                <div class="flex items-center gap-x-3">
                    <!-- Enroll Button -->
                    <a href="admissions"
                        class="hidden md:inline-flex btn-accent px-6 py-2.5 text-sm font-semibold rounded-full shadow-sm hover:shadow-md transition-all">
                        Enroll Now
                    </a>

                    <!-- Mobile Menu Button -->
                    <button onclick="toggleMobileMenu()"
                        class="lg:hidden w-11 h-11 flex items-center justify-center text-white hover:bg-white/10 rounded-xl transition-colors"
                        aria-label="Toggle menu">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.25" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden border-t border-slate-800 bg-slate-900">
            <div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10 py-5 flex flex-col gap-y-1 text-sm">
                <a href="./" class="nav-link py-3 px-1">Home</a>
                <a href="about.php" class="nav-link py-3 px-1">About Us</a>
                <a href="courses.php" class="nav-link py-3 px-1">Our Programs</a>
                <a href="achievements.php" class="nav-link py-3 px-1">Achievements</a>
                <a href="mentor.php" class="nav-link py-3 px-1">Our Mentor</a>
                <a href="admissions.php" class="nav-link py-3 px-1">Admissions</a>
                <a href="gallery.php" class="nav-link py-3 px-1">Gallery</a>
                <a href="contact.php" class="nav-link py-3 px-1">Contact</a>

                <div class="pt-3 mt-2 border-t border-slate-800">
                    <a href="admissions.php" class="btn-accent w-full text-center py-3 rounded-full block font-semibold">Enroll for Free Trial</a>
                </div>
            </div>
        </div>
    </nav>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('mobile-menu');
            const btn = e.target.closest('button');
            if (menu && !menu.contains(e.target) && !btn) {
                menu.classList.add('hidden');
            }
        });

        // Keyboard accessibility
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const menu = document.getElementById('mobile-menu');
                if (menu) menu.classList.add('hidden');
            }
        });
    </script>