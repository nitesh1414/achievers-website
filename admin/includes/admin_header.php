<?php
require_once __DIR__ . "/../../includes/db.php";
require_once __DIR__ . "/../../includes/auth.php";
require_once __DIR__ . "/../../includes/functions.php";

require_login();

$admin_name = $_SESSION["admin_name"] ?? "Admin";
$current_page = basename($_SERVER["PHP_SELF"]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin • Achievers Academy CMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css?v=20260909-compact-5">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/images/logo-big.png">
    <link rel="shortcut icon" href="../assets/images/logo-big.png">

</head>

<body class="bg-slate-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-slate-900 text-slate-200 flex flex-col">
            <div class="px-6 py-6 flex items-center gap-x-3 border-b border-slate-700">
                <img src="../assets/images/logo-big.png" alt="Logo" class="h-8 w-auto object-contain">
                <div>
                    <div class="font-bold">Achievers CMS</div>
                    <div class="text-[10px] text-amber-300">Admin Panel</div>
                </div>
            </div>

            <nav class="flex-1 px-2 py-5 text-sm">
                <a href="index.php" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 <?= $current_page ===
                "index.php"
                    ? "bg-slate-800 text-white"
                    : "hover:bg-slate-800" ?>">
                    📊 <span>Dashboard</span>
                </a>
                <a href="../about.php" target="_blank" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 hover:bg-slate-800 text-xs opacity-75">
                    🌐 <span>View About Page</span>
                </a>

                <a href="banners.php" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 <?= $current_page ===
                "banners.php"
                    ? "bg-slate-800 text-white"
                    : "hover:bg-slate-800" ?>">
                    🖼️ <span>Banners</span>
                </a>

                <a href="content.php" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 <?= $current_page ===
                "content.php"
                    ? "bg-slate-800 text-white"
                    : "hover:bg-slate-800" ?>">
                    ✍️ <span>Page Content</span>
                </a>

                <a href="courses.php" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 <?= $current_page ===
                "courses.php"
                    ? "bg-slate-800 text-white"
                    : "hover:bg-slate-800" ?>">
                    📚 <span>Courses</span>
                </a>

                <a href="categories.php" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 <?= $current_page ===
                "categories.php"
                    ? "bg-slate-800 text-white"
                    : "hover:bg-slate-800" ?>">
                    🗂️ <span>Course Categories</span>
                </a>

                <a href="disciplines.php" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 <?= $current_page ===
                "disciplines.php"
                    ? "bg-slate-800 text-white"
                    : "hover:bg-slate-800" ?>">
                    🤸 <span>Disciplines &amp; Apparatus</span>
                </a>

                <a href="inquiries.php" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 <?= $current_page ===
                "inquiries.php"
                    ? "bg-slate-800 text-white"
                    : "hover:bg-slate-800" ?>">
                    📩 <span>Inquiries &amp; Leads</span>
                </a>

                <a href="mentors.php" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 <?= $current_page ===
                "mentors.php"
                    ? "bg-slate-800 text-white"
                    : "hover:bg-slate-800" ?>">
                    👨‍🏫 <span>Mentors</span>
                </a>

                <a href="team.php" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 <?= $current_page ===
                "team.php"
                    ? "bg-slate-800 text-white"
                    : "hover:bg-slate-800" ?>">
                    👥 <span>Our Team</span>
                </a>

                <a href="social.php" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 <?= $current_page ===
                "social.php"
                    ? "bg-slate-800 text-white"
                    : "hover:bg-slate-800" ?>">
                    📱 <span>Social Media</span>
                </a>

                <a href="competitions.php" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 <?= $current_page ===
                "competitions.php"
                    ? "bg-slate-800 text-white"
                    : "hover:bg-slate-800" ?>">
                    🏅 <span>Competitions</span>
                </a>

                <a href="gallery.php" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 <?= $current_page ===
                "gallery.php"
                    ? "bg-slate-800 text-white"
                    : "hover:bg-slate-800" ?>">
                    🖼️ <span>Gallery</span>
                </a>

                <a href="toppers.php" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 <?= $current_page ===
                "toppers.php"
                    ? "bg-slate-800 text-white"
                    : "hover:bg-slate-800" ?>">
                    🏆 <span>Toppers</span>
                </a>

                <a href="testimonials.php" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 <?= $current_page ===
                "testimonials.php"
                    ? "bg-slate-800 text-white"
                    : "hover:bg-slate-800" ?>">
                    💬 <span>Testimonials</span>
                </a>

                <a href="notices.php" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 <?= $current_page ===
                "notices.php"
                    ? "bg-slate-800 text-white"
                    : "hover:bg-slate-800" ?>">
                    📋 <span>Notices &amp; Downloads</span>
                </a>

                <a href="settings.php" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 <?= $current_page ===
                "settings.php"
                    ? "bg-slate-800 text-white"
                    : "hover:bg-slate-800" ?>">
                    ⚙️ <span>Website Settings</span>
                </a>

                <a href="users.php" class="flex px-4 py-[9px] items-center gap-x-3 rounded-xl mb-1 <?= $current_page ===
                "users.php"
                    ? "bg-slate-800 text-white"
                    : "hover:bg-slate-800" ?>">
                    👥 <span>Admin Users</span>
                </a>
            </nav>

            <div class="border-t border-slate-700 p-4 text-xs">
                <div class="text-slate-400">Logged in as</div>
                <div class="font-semibold text-white"><?= htmlspecialchars(
                    $admin_name
                ) ?></div>

                <a href="logout.php" class="block text-xs mt-3 text-red-400 hover:text-red-300">Logout →</a>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            <header class="bg-white border-b px-6 py-3 flex justify-between items-center">
                <div class="font-semibold text-lg text-slate-700"><?= ucfirst(
                    str_replace(".php", "", $current_page)
                ) ?> Management</div>
                <div class="flex items-center gap-3 text-sm">
                    <a href="../" target="_blank" class="text-slate-500 hover:text-slate-700">View Website →</a>
                    <div class="bg-slate-100 px-3 py-1 rounded-full text-xs">PDO Secured</div>
                </div>
            </header>

            <div class="p-6 flex-1">