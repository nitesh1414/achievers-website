<?php
require_once __DIR__ . "/includes/header.php"; ?>
<section class="page-shell"><div class="tail-container text-center"><div class="max-w-xl mx-auto"><div class="text-7xl mb-4" aria-hidden="true">🤸</div><span class="section-kicker">404 ERROR</span><h1 class="text-5xl font-bold mt-2"><?= e(
    content_value("not_found_title", "Page not found")
) ?></h1><p class="mt-3 text-lg text-slate-600"><?= e(
    content_value(
        "not_found_text",
        "Oops! The page you're looking for doesn't exist or has been moved."
    )
) ?></p><div class="mt-8 flex flex-wrap justify-center gap-3"><a href="./" class="btn-primary">Back to homepage</a><a href="admissions.php" class="btn-accent">Enroll now</a></div><div class="mt-8 text-sm text-slate-500">Need help? <a href="contact.php" class="underline">Contact us</a> or call <?= e(
    get_setting("phone")
) ?></div></div></div></section>
<?php require_once __DIR__ . "/includes/footer.php"; ?>
