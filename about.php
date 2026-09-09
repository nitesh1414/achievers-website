<?php
require_once __DIR__ . '/includes/header.php';

// Get some toppers as "testimonials" + static rich ones
$toppers = db_get_all("SELECT * FROM toppers WHERE status='active' ORDER BY year DESC LIMIT 3");

// Additional testimonials (static but high-quality and relevant)

// Testimonials come ONLY from database (managed in admin panel)
$testimonials = db_get_all("SELECT * FROM testimonials WHERE status = 'active' ORDER BY created_at DESC LIMIT 6");
?>



<div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10 w-full max-w-[1400px] mx-auto px-6 md:px-10 w-full max-w-[1400px] mx-auto px-6 md:px-8 w-full px-6 md:px-8 max-w-[1400px] mx-auto w-full max-w-full py-10">
    <div class="flex flex-col md:flex-row md:items-end gap-4 mb-9">
        <div>
            <span class="text-xs font-bold tracking-[1.5px] text-amber-600">EST. 2007</span>
            <h1 class="text-4xl font-bold">About Achievers
                Gymnastics Academy</h1>
            <p class="mt-1 max-w-xl">Nagpur's most decorated gymnastics academy. Where every child discovers their inner champion.</p>
        </div>
        <div class="md:ml-auto">
            <a href="admissions" class="btn-accent px-7 py-2.5">Start Free Trial</a>
        </div>
    </div>

    <!-- Mission -->
    <div class="mx-auto bg-white border p-9 rounded-3xl mb-12">
        <div class="flex flex-col md:flex-row gap-8 items-center">
            <div class="flex-1">
                <div class="font-bold text-amber-600">OUR MISSION</div>
                <h2 class="text-3xl font-bold mt-1">Building Champions in Body, Mind &amp; Character</h2>
                <p class="mt-4 text-slate-600">We were founded with a single mission: to give every child the opportunity to discover their inner champion through world-class gymnastics training.</p>
            </div>
            <div class="flex-1">
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 rounded-2xl">
                        <div class="font-extrabold text-4xl">250+</div>
                        <div class="text-sm font-semibold">Medals Won</div>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl">
                        <div class="font-extrabold text-4xl">400+</div>
                        <div class="text-sm font-semibold">Families Served</div>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl">
                        <div class="font-extrabold text-4xl">18+</div>
                        <div class="text-sm font-semibold">Years of Coaching</div>
                    </div>
                    <div class="p-4 bg-slate-50 rounded-2xl">
                        <div class="font-extrabold text-4xl">35+</div>
                        <div class="text-sm font-semibold">Competitions</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Philosophy -->
    <div class="mx-auto mb-14">
        <h3 class="text-center text-3xl font-bold mb-6">Our Philosophy</h3>
        <div class="prose max-w-none text-lg text-slate-700">
            <p>We believe gymnastics is more than a sport — it is a powerful vehicle for building discipline, confidence, resilience, and physical excellence. Every child who walks through our doors is treated as a future champion, regardless of their starting point.</p>

            <div class="my-7 grid md:grid-cols-3 gap-5 not-prose">
                <div class="bg-white p-5 border rounded-2xl">
                    <div class="text-xl mb-1">🥇</div>
                    <strong>International Standards</strong>
                    <p class="text-sm mt-1 text-slate-600">FIG-standard apparatus and coaching methods.</p>
                </div>
                <div class="bg-white p-5 border rounded-2xl">
                    <div class="text-xl mb-1">🧠</div>
                    <strong>Mind + Body</strong>
                    <p class="text-sm mt-1 text-slate-600">We develop athletes who win — and humans who lead.</p>
                </div>
                <div class="bg-white p-5 border rounded-2xl">
                    <div class="text-xl mb-1">❤️</div>
                    <strong>Safe &amp; Supportive</strong>
                    <p class="text-sm mt-1 text-slate-600">Small groups, certified coaches, and a culture of care.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- ===================== LOVED BY CHAMPIONS (TESTIMONIAL CAROUSEL) ===================== -->
    <div class="section-gradient-5 text-white py-16">
        <div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10">
            <div class="text-center mb-9">
                <span class="uppercase text-amber-300 text-xs tracking-[2px] font-bold">PARENTS &amp; ATHLETES SAY</span>
                <h2 class="text-4xl font-extrabold mt-1 tracking-tight">Loved by Champions</h2>
            </div>

            <div id="testimonials-carousel" class="carousel-container">
                <div class="carousel-track">
                    <?php if (!empty($testimonials)): ?>
                        <?php foreach ($testimonials as $t): ?>
                            <div class="carousel-item">
                                <div class="modern-card bg-slate-800 border border-slate-700 rounded-3xl p-7 h-full flex flex-col">
                                    <div class="flex text-amber-400 text-xl mb-4">
                                        <?php for ($i = 0; $i < $t['rating']; $i++) echo '★'; ?>
                                    </div>
                                    <blockquote class="italic text-[15px] leading-relaxed flex-1">"<?= htmlspecialchars($t['quote']) ?>"</blockquote>
                                    <div class="mt-6 pt-5 border-t border-slate-600">
                                        <div class="font-semibold"><?= htmlspecialchars($t['name']) ?></div>
                                        <div class="text-xs text-slate-400"><?= htmlspecialchars($t['role']) ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="carousel-item">
                            <div class="modern-card bg-slate-800 border border-slate-700 rounded-3xl p-7 h-full flex flex-col text-center text-slate-400">
                                <div class="text-4xl mb-3">💬</div>
                                <div class="font-semibold text-white">No testimonials yet</div>
                                <p class="text-sm mt-1">Be the first to share your experience with us!</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="carousel-controls px-1 mt-3">
                    <button class="carousel-btn carousel-prev">←</button>
                    <div class="carousel-dots"></div>
                    <button class="carousel-btn carousel-next">→</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Topper Highlights -->
    <div class="mx-auto mt-12">
        <h3 class="text-xl font-bold mb-6 text-center">Our Champions Speak</h3>
        <div class="grid md:grid-cols-6 gap-5">
            <?php foreach ($toppers as $topper): ?>
                <div class="bg-white border rounded-2xl overflow-hidden">
                    <img src="<?= htmlspecialchars($topper['photo'] ?: 'assets/images/topper-aarav.jpg') ?>" class="h-60 w-full object-cover" alt="<?= htmlspecialchars($topper['name']) ?>">
                    <div class="p-5">
                        <div class="font-bold"><?= htmlspecialchars($topper['name']) ?></div>
                        <div class="text-amber-600 font-semibold text-sm"><?= htmlspecialchars($topper['rank']) ?> (<?= $topper['year'] ?>)</div>
                        <div class="text-sm mt-3"><?= htmlspecialchars($topper['achievement']) ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- CTA -->
    <div class="mt-16 text-center">
        <div class="bg-slate-900 text-white rounded-3xl px-8 py-9 inline-block max-w-2xl">
            <div class="text-amber-400 font-bold text-sm">START YOUR JOURNEY</div>
            <h3 class="font-bold text-3xl mt-1">One free trial session can change everything.</h3>
            <div class="mt-5">
                <a href="admissions" class="btn-accent px-9 py-3 inline-block text-base">Book Your Free Trial</a>
            </div>
        </div>
    </div>

</div>








<?php require_once __DIR__ . '/includes/footer.php'; ?>