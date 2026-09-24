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
$admission_phone = get_setting("phone", "+91 90965 94552");
$admission_email = get_setting("email", "info@achieversacademy.com");
$admission_address = get_setting(
    "address",
    "Plot No. 45, Wardhaman Nagar, Nagpur - 440008"
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
    <aside class="md:col-span-2">
        <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
            <h2 class="font-bold text-xl mb-6 flex items-center gap-3">
                <i class="fas fa-map-marker-alt text-amber-500" aria-hidden="true"></i>
                Our Location
            </h2>

            <div class="space-y-6">
                <div class="flex gap-4">
                    <div class="w-9 h-9 bg-slate-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-map-marker-alt text-slate-700" aria-hidden="true"></i>
                    </div>
                    <div>
                        <div class="font-semibold text-sm text-slate-500">ADDRESS</div>
                        <div class="text-slate-800 leading-snug"><?= e(
                            $admission_address
                        ) ?></div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="w-9 h-9 bg-emerald-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-phone text-emerald-600" aria-hidden="true"></i>
                    </div>
                    <div>
                        <div class="font-semibold text-sm text-slate-500">PHONE / CALL</div>
                        <a href="tel:<?= e(
                            $admission_phone
                        ) ?>" class="block text-lg font-medium hover:text-amber-600 transition-colors">
                            <?= e($admission_phone) ?>
                        </a>
                    </div>
                </div>

                <?php if ($whatsapp): ?>
                    <div class="flex gap-4">
                        <div class="w-9 h-9 bg-green-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-whatsapp text-green-600 text-lg" aria-hidden="true"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-sm text-slate-500">WHATSAPP</div>
                            <a href="https://wa.me/<?= e(
                                $whatsapp
                            ) ?>?text=<?= e(
    $whatsapp_message
) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-emerald-600 hover:text-emerald-700 font-medium">
                                <span>Chat on WhatsApp</span>
                                <i class="fas fa-external-link-alt text-xs" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="flex gap-4">
                    <div class="w-9 h-9 bg-blue-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-envelope text-blue-600" aria-hidden="true"></i>
                    </div>
                    <div>
                        <div class="font-semibold text-sm text-slate-500">EMAIL US</div>
                        <a href="mailto:<?= e(
                            $admission_email
                        ) ?>" class="block text-lg font-medium hover:text-blue-600 transition-colors">
                            <?= e($admission_email) ?>
                        </a>
                    </div>
                </div>
            </div>

            <?php if ($social_links): ?>
                <div class="mt-8 pt-6 border-t">
                    <div class="text-xs font-semibold tracking-wider text-slate-500 mb-3">FOLLOW US</div>
                    <div class="flex gap-3">
                        <?php foreach ($social_links as $social): ?>
                            <a href="<?= e(
                                $social["url"]
                            ) ?>" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center bg-slate-100 hover:bg-amber-100 text-slate-700 hover:text-slate-900 rounded-2xl transition-colors" aria-label="<?= e(
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
                                ) ?> text-xl" aria-hidden="true"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="mt-8 pt-6 border-t">
                <h3 class="font-semibold text-slate-900"><?= e(
                    content_value("admissions_trial_title", "Free trial class")
                ) ?></h3>
                <p class="text-xs mt-1 text-slate-600"><?= e(
                    content_value(
                        "admissions_trial_text",
                        "One complimentary 60-minute session. Limited slots are available every week."
                    )
                ) ?></p>
            </div>
        </div>
    </aside></div>
</div></section>
<?php require_once __DIR__ . "/includes/footer.php"; ?>
