<?php
require_once __DIR__ . '/includes/header.php';
?>
<div class="tail-container py-20 text-center">
    <div class="max-w-md mx-auto">
        <div class="text-8xl mb-4">🤸</div>
        <h1 class="text-5xl font-bold">Page Not Found</h1>
        <p class="mt-3 text-lg text-slate-600">Oops! The page you're looking for doesn't exist or has been moved.</p>
        
        <div class="mt-8 flex justify-center gap-3">
            <a href="" class="btn-primary px-7 py-3">Back to Homepage</a>
            <a href="admissions" class="btn-accent px-7 py-3">Enroll Now</a>
        </div>
        
        <div class="mt-8 text-sm text-slate-400">
            Need help? <a href="contact" class="underline">Contact us</a> or call <?= get_setting('phone') ?>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>