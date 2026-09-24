<?php
require_once __DIR__ . "/includes/header.php";

$phone = get_setting("phone", "+91 90965 94552");
$whatsapp = get_setting("whatsapp", "919096594552");
$email = get_setting("email", "info@achieversacademy.com");
$address = get_setting(
    "address",
    "Plot No. 45, Wardhaman Nagar, Nagpur - 440008"
);
$map_embed = get_setting("google_map_embed", "");
$social_links = get_social_links();
?>

<section class="page-shell">
    <div class="tail-container">
    <!-- Page Header -->
    <header class="page-header text-center">
        <span class="section-kicker">
            <?= e(content_value("contact_label", "GET IN TOUCH")) ?>
        </span>
        <h1><?= e(
            content_value("contact_title", "Contact Achievers Academy")
        ) ?></h1>
        <p><?= e(
            content_value(
                "contact_intro",
                "We're here to answer your questions and help you get started on your gymnastics journey."
            )
        ) ?></p>
    </header>

    <div class="grid lg:grid-cols-12 gap-8">

        <!-- Contact Info -->
        <div class="lg:col-span-5">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <h3 class="font-bold text-xl mb-6 flex items-center gap-3">
                    <i class="fas fa-map-marker-alt text-amber-500"></i>
                    Our Location
                </h3>

                <div class="space-y-6">
                    <!-- Address -->
                    <div class="flex gap-4">
                        <div class="w-9 h-9 bg-slate-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-slate-700"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-sm text-slate-500">ADDRESS</div>
                            <div class="text-slate-800 leading-snug"><?= htmlspecialchars(
                                $address
                            ) ?></div>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="flex gap-4">
                        <div class="w-9 h-9 bg-emerald-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-emerald-600"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-sm text-slate-500">PHONE / CALL</div>
                            <a href="tel:<?= htmlspecialchars(
                                $phone
                            ) ?>" class="block text-lg font-medium hover:text-amber-600 transition-colors">
                                <?= htmlspecialchars($phone) ?>
                            </a>
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div class="flex gap-4">
                        <div class="w-9 h-9 bg-green-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-whatsapp text-green-600 text-lg"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-sm text-slate-500">WHATSAPP</div>
                            <a href="https://wa.me/<?= htmlspecialchars(
                                $whatsapp
                            ) ?>?text=Hi%20Achievers%20Academy" target="_blank"
                                class="inline-flex items-center gap-1.5 text-emerald-600 hover:text-emerald-700 font-medium">
                                <span>Chat on WhatsApp</span>
                                <i class="fas fa-external-link-alt text-xs"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex gap-4">
                        <div class="w-9 h-9 bg-blue-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-blue-600"></i>
                        </div>
                        <div>
                            <div class="font-semibold text-sm text-slate-500">EMAIL US</div>
                            <a href="mailto:<?= htmlspecialchars(
                                $email
                            ) ?>" class="block text-lg font-medium hover:text-blue-600 transition-colors">
                                <?= htmlspecialchars($email) ?>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <?php if ($social_links): ?>
                    <div class="mt-8 pt-6 border-t">
                        <div class="text-xs font-semibold tracking-wider text-slate-500 mb-3">FOLLOW US</div>
                        <div class="flex gap-3">
                            <?php foreach ($social_links as $social): ?>
                                <a href="<?= e(
                                    $social["url"]
                                ) ?>" target="_blank" rel="noopener noreferrer"
                                    class="w-10 h-10 flex items-center justify-center bg-slate-100 hover:bg-amber-100 text-slate-700 hover:text-slate-900 rounded-2xl transition-colors"
                                    aria-label="<?= e(
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
                                    ) ?> text-xl"></i>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Enquiry Form -->
        <div class="lg:col-span-7">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <h3 class="font-bold text-xl mb-1"><?= e(
                    content_value(
                        "contact_form_title",
                        "Send us a quick message"
                    )
                ) ?></h3>
                <p class="text-sm text-slate-500 mb-6"><?= e(
                    content_value(
                        "contact_form_text",
                        "We'll get back to you within a few hours."
                    )
                ) ?></p>

                <form method="POST" action="admissions" class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Your Name</label>
                            <input type="text" name="name" required
                                class="w-full border border-slate-300 px-4 py-3 rounded-2xl focus:border-amber-400 transition" placeholder="Full name">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Phone Number</label>
                            <input type="tel" name="phone" required
                                class="w-full border border-slate-300 px-4 py-3 rounded-2xl focus:border-amber-400 transition" placeholder="+91 98XXXXXXXX">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email Address (optional)</label>
                        <input type="email" name="email"
                            class="w-full border border-slate-300 px-4 py-3 rounded-2xl focus:border-amber-400 transition" placeholder="your@email.com">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Message</label>
                        <textarea name="message" rows="4" required
                            class="w-full border border-slate-300 px-4 py-3 rounded-2xl focus:border-amber-400 transition"
                            placeholder="I'm interested in the Little Champions program for my 6-year-old..."></textarea>
                    </div>

                    <button type="submit"
                        class="w-full btn-primary py-3.5 text-sm font-semibold tracking-wider rounded-2xl flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        <span>SEND MESSAGE</span>
                    </button>

                    <p class="text-center text-[10px] text-slate-400">Your message will be sent via our admissions form</p>
                </form>
            </div>
        </div>
    </div>

    <!-- Google Map -->
    <?php if (!empty($map_embed)): ?>
        <div class="mt-8">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-px bg-slate-300 flex-1"></div>
                <div class="uppercase tracking-[2px] text-xs font-semibold text-slate-400">Visit Us</div>
                <div class="w-8 h-px bg-slate-300 flex-1"></div>
            </div>

            <div class="rounded-3xl overflow-hidden border border-slate-200 shadow-sm">
                <div class="aspect-video w-full">
                    <?php
                    // === FINAL FIX: Render Google Map (never shows raw code) ===
                    $map_html = trim($map_embed ?? "");

                    if (!empty($map_html)) {
                        // Decode escaped content (handles previous saves)
                        $map_html = html_entity_decode(
                            $map_html,
                            ENT_QUOTES | ENT_HTML5
                        );
                        $map_html = htmlspecialchars_decode(
                            $map_html,
                            ENT_QUOTES | ENT_HTML5
                        );

                        // Strip any remaining escaped tags
                        $map_html = str_replace(
                            [
                                "&lt;iframe",
                                "&lt;/iframe&gt;",
                                "&amp;lt;",
                                "&amp;gt;",
                            ],
                            ["<iframe", "</iframe>", "<", ">"],
                            $map_html
                        );

                        // If user pasted only a URL instead of full iframe
                        if (
                            stripos($map_html, "<iframe") === false &&
                            (filter_var($map_html, FILTER_VALIDATE_URL) ||
                                stripos($map_html, "google") !== false)
                        ) {
                            $src = htmlspecialchars(
                                $map_html,
                                ENT_QUOTES,
                                "UTF-8"
                            );
                            echo '<iframe src="' .
                                $src .
                                '" class="map-embed-frame" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
                        } else {
                            // Output the iframe HTML directly — this is what makes the map appear
                            echo $map_html;
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="mt-3 text-center text-xs text-slate-500">
                <i class="fas fa-map-marked mr-1"></i>
                Interactive map powered by Google
            </div>
        </div>
    <?php else: ?>
        <div class="mt-8 bg-slate-100 border border-dashed border-slate-300 rounded-3xl p-8 text-center">
            <div class="text-slate-400 mb-1">
                <i class="fas fa-map fa-2x"></i>
            </div>
            <p class="text-sm text-slate-500">Google Map will appear here once configured in the admin panel.</p>
            <p class="text-[10px] mt-1 text-slate-400">Go to Admin → Website Settings → Google Maps Embed</p>
        </div>
    <?php endif; ?>

    <!-- Quick CTA -->
    <div class="mt-8 text-center">
        <a href="admissions.php"
            class="inline-flex items-center gap-x-3 px-8 py-3.5 bg-slate-900 hover:bg-black text-white rounded-full font-semibold text-sm transition-all">
            <span>Book a Free Trial Class</span>
            <i class="fas fa-arrow-right"></i>
        </a>
        <div class="text-xs text-slate-400 mt-3">No commitment • Ages 5-18 welcome</div>
    </div>
    </div>
</section>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
