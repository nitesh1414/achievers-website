<?php
require_once __DIR__ . "/includes/header.php";

$success = false;
$error = "";
$selected_course_id = (int) ($_GET["course"] ?? 0);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = content_limit(trim($_POST["name"] ?? ""), 100);
    $phone = content_limit(trim($_POST["phone"] ?? ""), 20);
    $email = content_limit(trim($_POST["email"] ?? ""), 100);
    $course_id = (int) ($_POST["course_id"] ?? 0);
    $message = content_limit(trim($_POST["message"] ?? ""), 1500);
    $selected_course_id = $course_id;
    if ($name && $phone) {
        db_query(
            "INSERT INTO inquiries (name, phone, email, course_id, message, status) VALUES (?, ?, ?, ?, ?, 'Pending')",
            [$name, $phone, $email ?: null, $course_id ?: null, $message]
        );
        $success = true;
    } else {
        $error = "Please fill in your name and phone number.";
    }
}
$courses = db_get_all(
    "SELECT id, title FROM courses WHERE status = 'active' ORDER BY title ASC"
);
?>
<section class="page-shell"><div class="tail-container max-w-5xl">
    <header class="page-header"><span class="section-kicker"><?= e(
        content_value("admissions_label", "ENROLLMENT")
    ) ?></span><h1><?= e(
    content_value("admissions_title", "Start your journey")
) ?></h1><p><?= e(
    content_value(
        "admissions_intro",
        "Book a free trial class or enquire about our programs today."
    )
) ?></p></header>
    <?php if (
        $success
    ): ?><div class="bg-emerald-100 border border-emerald-200 p-6 rounded-2xl mb-8"><h2 class="font-bold text-emerald-800 text-lg">Thank you. Your enquiry has been received.</h2><p class="mt-1 text-sm text-emerald-900">Our team will contact you shortly. You can also message us on WhatsApp.</p><?php if (
    $whatsapp
): ?><a href="https://wa.me/<?= e(
    $whatsapp
) ?>" target="_blank" rel="noopener noreferrer" class="mt-4 btn-accent">Chat on WhatsApp</a><?php endif; ?></div><?php endif; ?>
    <div class="grid md:grid-cols-5 gap-8"><div class="md:col-span-3 bg-white border rounded-3xl p-6"><h2 class="font-bold mb-4">Enquiry / admission form</h2><?php if (
        $error
    ): ?><div class="mb-4 bg-red-100 text-red-700 text-sm p-3 rounded-xl"><?= e(
    $error
) ?></div><?php endif; ?><form method="POST" class="space-y-4"><div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="text-xs font-semibold block mb-1">Full name *</label><input type="text" name="name" required maxlength="100" class="w-full px-4 py-2.5 border border-slate-300 rounded-2xl"></div><div><label class="text-xs font-semibold block mb-1">Phone number *</label><input type="tel" name="phone" required maxlength="20" class="w-full px-4 py-2.5 border border-slate-300 rounded-2xl"></div></div><div><label class="text-xs font-semibold block mb-1">Email (optional)</label><input type="email" name="email" maxlength="100" class="w-full px-4 py-2.5 border border-slate-300 rounded-2xl"></div><div><label class="text-xs font-semibold block mb-1">Interested program</label><select name="course_id" class="w-full px-4 py-2.5 border border-slate-300 rounded-2xl"><option value="">Select a program (optional)</option><?php foreach (
    $courses
    as $course
): ?><option value="<?= (int) $course["id"] ?>" <?= $selected_course_id ===
(int) $course["id"]
    ? "selected"
    : "" ?>><?= e(
    $course["title"]
) ?></option><?php endforeach; ?></select></div><div><label class="text-xs font-semibold block mb-1">Message / questions</label><textarea name="message" rows="4" maxlength="1500" class="w-full px-4 py-2.5 border border-slate-300 rounded-2xl" placeholder="Tell us about your child or any specific requirements..."></textarea></div><button type="submit" class="btn-primary w-full py-3.5">Submit enquiry</button><p class="text-center text-xs text-slate-400">We will contact you within 24 hours.</p></form></div>
    <aside class="md:col-span-2"><div class="bg-slate-900 text-white p-6 rounded-3xl"><h2 class="font-semibold mb-3 text-white">Contact details</h2><div class="text-sm space-y-3"><div><strong>Phone</strong><br><?= e(
        get_setting("phone")
    ) ?></div><div><strong>WhatsApp</strong><br><?php if (
    $whatsapp
): ?><a href="https://wa.me/<?= e(
    $whatsapp
) ?>" class="underline">Chat now</a><?php endif; ?></div><div><strong>Email</strong><br><?= e(
    get_setting("email")
) ?></div><div><strong>Address</strong><br><?= e(
    get_setting("address")
) ?></div></div><div class="mt-6 pt-6 border-t border-white/30 text-sm"><h3 class="font-semibold text-white"><?= e(
    content_value("admissions_trial_title", "Free trial class")
) ?></h3><p class="text-xs mt-1 text-slate-200"><?= e(
    content_value(
        "admissions_trial_text",
        "One complimentary 60-minute session. Limited slots are available every week."
    )
) ?></p></div></div></aside></div>
</div></section>
<?php require_once __DIR__ . "/includes/footer.php"; ?>
