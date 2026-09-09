<?php
require_once __DIR__ . '/includes/header.php';

// Get active banners for hero slider
$banners = db_get_all("SELECT * FROM banners WHERE status = 'active' ORDER BY sort_order ASC");

// Get featured courses
$courses = db_get_all("SELECT c.*, cat.name as category_name FROM courses c LEFT JOIN course_categories cat ON c.category_id = cat.id WHERE c.status = 'active' LIMIT 8");

// Get recent toppers
$toppers = db_get_all("SELECT * FROM toppers WHERE status='active' ORDER BY year DESC LIMIT 6");

// Get stats
$stats = [
    'students' => get_setting('active_students', '400+'),
    'medals' => get_setting('medals_won', '250+'),
    'years' => get_setting('years_experience', '18'),
    'competitions' => '35+'
];

// Testimonials come ONLY from database (managed in admin panel)
$testimonials = db_get_all("SELECT * FROM testimonials WHERE status = 'active' ORDER BY created_at DESC LIMIT 6");
?>

<!-- ===================== HERO SLIDER ===================== -->
<div class="hero-slider">
    <?php if (!empty($banners)): ?>
        <?php foreach ($banners as $index => $banner): ?>
            <div class="hero-slide <?= $index === 0 ? 'active' : '' ?>"
                style="background-image: url('<?= htmlspecialchars($banner['image'] ?: 'assets/images/hero-main.jpg') ?>');">
                <div class="hero-content flex items-center min-h-[100dvh]">
                    <div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10 pt-12 pb-20">
                        <div class="max-w-3xl">
                            <?php if (!empty($banner['title'])): ?>
                                <div class="inline-block hero-badge px-4 py-1.5 rounded-full text-xs font-bold tracking-wider mb-4 bg-amber-400 text-slate-900">
                                    <?= htmlspecialchars($banner['title']) ?>
                                </div>
                            <?php else: ?>
                                <div class="inline-block hero-badge px-4 py-1.5 rounded-full text-xs font-bold tracking-wider mb-4">NAGPUR'S #1 GYMNASTICS ACADEMY</div>
                            <?php endif; ?>

                            <h1 class="text-5xl sm:text-6xl md:text-7xl font-extrabold leading-[1.05] tracking-tighter mb-4 text-white">
                                <?= !empty($banner['subtitle']) ? htmlspecialchars($banner['subtitle']) : 'TRAIN LIKE A<br>CHAMPION' ?>
                            </h1>

                            <?php if (!empty($banner['description'])): ?>
                                <p class="text-xl md:text-2xl text-slate-100 max-w-xl mb-8"><?= htmlspecialchars($banner['description']) ?></p>
                            <?php else: ?>
                                <p class="text-xl text-slate-200 max-w-lg mb-8">
                                    Under International Coach Pankaj Kunde — Nagpur's most decorated gymnastics academy.
                                </p>
                            <?php endif; ?>

                            <div class="flex flex-wrap gap-3">
                                <a href="admissions.php" class="btn-accent px-8 py-4 text-base rounded-full shadow-lg">Enroll Now — Free Trial</a>
                                <a href="achievements.php" class="btn-primary px-7 py-4 text-base border border-white/30 hover:bg-white/10 rounded-full">View Achievements</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <!-- Fallback static hero -->
        <div class="hero-slide active" style="background-image: url('assets/images/hero-main.jpg');">
            <div class="hero-content flex items-center min-h-[100dvh]">
                <div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10 pt-12 pb-20">
                    <div class="max-w-3xl">
                        <div class="inline-block hero-badge px-4 py-1.5 rounded-full text-xs font-bold tracking-wider mb-4">NAGPUR'S #1 GYMNASTICS ACADEMY</div>
                        <h1 class="text-5xl sm:text-6xl md:text-7xl font-extrabold leading-[1.05] tracking-tighter mb-4 text-white">TRAIN LIKE A<br>CHAMPION</h1>
                        <p class="text-xl text-slate-200 max-w-lg mb-8">Under International Coach Pankaj Kunde — Build strength, discipline and a podium-ready future.</p>
                        <div class="flex flex-wrap gap-3">
                            <a href="admissions.php" class="btn-accent px-8 py-4 text-base rounded-full">Enroll Now - Free Trial</a>
                            <a href="achievements.php" class="btn-primary px-7 py-4 text-base border border-white/30 rounded-full">View Achievements</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Slider Controls -->
    <?php if (count($banners) > 1): ?>
        <button class="slider-arrow prev">←</button>
        <button class="slider-arrow next">→</button>
        <div class="slider-nav"></div>
    <?php endif; ?>
</div>

<!-- COMPETITIONS MARQUEE (after hero - only if competitions exist) -->
<?php
$marqueeComps = db_get_all("SELECT id, title, type, event_date FROM competitions WHERE status = 'active' AND type = 'future' ORDER BY event_date ASC");
if (!empty($marqueeComps)): ?>
    <div class="bg-slate-900 text-white py-2.5 text-sm border-t border-b border-slate-700">
        <div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10">
            <div class="flex items-center gap-4">
                <span class="font-bold text-amber-400 text-xs tracking-widest whitespace-nowrap">COMPETITIONS</span>
                <div class="overflow-hidden flex-1">
                    <div class="marquee flex gap-x-8 whitespace-nowrap" style="width: 100%;">
                        <?php foreach ($marqueeComps as $c): ?>
                            <a href="competition.php?id=<?= $c['id'] ?>" class="hover:text-amber-300 transition flex items-center gap-x-2">
                                <span class="font-medium"><?= htmlspecialchars($c['title']) ?></span>
                                <?php if ($c['event_date']): ?>
                                    <span class="text-amber-400 text-xs">• <?= date("d M", strtotime($c['event_date'])) ?></span>
                                <?php endif; ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .marquee {
            display: inline-flex;
            animation: marquee 30s linear infinite;
        }

        .marquee:hover {
            animation-play-state: paused;
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-90%);
            }
        }
    </style>
<?php endif; ?>

<!-- TRUST BAR -->
<div class="section-gradient-1 border-b">
    <div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10 py-5 flex flex-wrap justify-center md:justify-between items-center gap-x-8 gap-y-2 text-xs font-semibold text-slate-500">
        <div class="flex flex-wrap items-center gap-x-6 gap-y-1">
            <div class="flex items-center gap-2"><span class="text-amber-500">🏆</span> NATIONAL CHAMPIONS</div>
            <div>INTERNATIONAL COACHING</div>
            <div>FIG-STANDARD FACILITY</div>
        </div>
        <div class="flex items-center gap-5 text-xs">
            <div><span class="text-amber-500 font-bold"><?= $stats['medals'] ?></span> Medals</div>
            <div><span class="text-amber-500 font-bold"><?= $stats['years'] ?></span> Years</div>
            <div><span class="text-amber-500 font-bold"><?= $stats['students'] ?></span> Families</div>
        </div>
    </div>
</div>

<!-- WHY CHOOSE (modern grid) -->
<div class="section-gradient-3 tail-container py-16">
    <div class="text-center mb-10">
        <span class="text-amber-600 font-bold text-xs tracking-[2px]">WHY ACHIEVERS?</span>
        <h2 class="text-4xl font-extrabold mt-2 tracking-tight">Built to Build Champions</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <div class="modern-card p-7 bg-white rounded-3xl">
            <div class="text-4xl mb-4">🥇</div>
            <h4 class="font-bold text-xl">International Coach</h4>
            <p class="mt-2 text-sm text-slate-600">Coach Pankaj Kunde — 18+ years international experience. FIG certified.</p>
        </div>
        <div class="modern-card p-7 bg-white rounded-3xl">
            <div class="text-4xl mb-4">🏆</div>
            <h4 class="font-bold text-xl">Proven Results</h4>
            <p class="mt-2 text-sm text-slate-600">250+ medals across National, State &amp; International competitions.</p>
        </div>
        <div class="modern-card p-7 bg-white rounded-3xl">
            <div class="text-4xl mb-4">🏋️</div>
            <h4 class="font-bold text-xl">World-Class Facility</h4>
            <p class="mt-2 text-sm text-slate-600">FIG-standard apparatus, sprung floors, foam pits &amp; Olympic-grade safety.</p>
        </div>
                                    
        <div class="modern-card p-7 bg-white rounded-3xl">
            <div class="text-4xl mb-4">🥇</div>
            <h4 class="font-bold text-xl">Personalised Pathway</h4>
            <p class="mt-2 text-sm text-slate-600">Every student gets a structured progression plan from beginner to elite competitor.</p>
        </div>
        <div class="modern-card p-7 bg-white rounded-3xl">
            <div class="text-4xl mb-4">🏆</div>
            <h4 class="font-bold text-xl">Safe & Supportive</h4>
            <p class="mt-2 text-sm text-slate-600">Small group sizes, certified coaches, and a culture that builds confidence — not just skills.</p>
        </div>
        <div class="modern-card p-7 bg-white rounded-3xl">
            <div class="text-4xl mb-4">🏋️</div>
            <h4 class="font-bold text-xl">Champion Mindset</h4>
            <p class="mt-2 text-sm text-slate-600">We train athletes who win — and humans who lead. Discipline, focus, and resilience for life.</p>
        </div>
    </div>
</div>

<!-- ===================== OUR TRAINING PROGRAMS (CAROUSEL) ===================== -->
<div class="section-gradient-2 py-14">
    <div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="uppercase tracking-[2px] text-xs font-bold text-amber-600">PROGRAMS</span>
                <h2 class="text-4xl font-extrabold tracking-tight">Our Training Programs</h2>
            </div>
            <a href="courses.php" class="hidden md:inline text-sm font-semibold hover:text-amber-600 flex items-center gap-1">Browse all →</a>
        </div>

        <div id="programs-carousel" class="carousel-container">
            <div class="carousel-track">
                <?php if (!empty($courses)): ?>
                    <?php foreach ($courses as $course): ?>
                        <div class="carousel-item">
                            <a href="courses.php#<?= htmlspecialchars($course['slug']) ?>" class="modern-card block bg-white border rounded-3xl overflow-hidden h-full">
                                <div class="h-48 bg-slate-200 relative">
                                    <img src="<?= htmlspecialchars($course['thumbnail'] ?: 'assets/images/course-little.jpg') ?>"
                                        class="w-full h-full object-cover" alt="<?= htmlspecialchars($course['title']) ?>">
                                    <div class="absolute top-3 right-3 bg-white px-3 py-0.5 text-xs font-bold rounded shadow">
                                        <?= htmlspecialchars($course['category_name'] ?? 'Program') ?>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h4 class="font-bold text-xl leading-tight"><?= htmlspecialchars($course['title']) ?></h4>
                                    <p class="text-sm text-slate-600 mt-2 line-clamp-2"><?= htmlspecialchars(substr($course['description'], 0, 90)) ?>...</p>

                                    <div class="flex justify-between items-center mt-5">
                                        <div>
                                            <span class="font-extrabold text-xl"><?= format_currency($course['fees']) ?></span>
                                            <span class="text-xs text-slate-500"> / <?= htmlspecialchars($course['duration']) ?></span>
                                        </div>
                                        <span class="text-xs font-semibold text-amber-600">Learn more →</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="carousel-item">
                        <div class="modern-card p-8 bg-white border rounded-3xl text-center text-slate-400">
                            <div class="text-4xl mb-3">📚</div>
                            <div class="font-semibold">No training programs yet</div>
                            <p class="text-sm mt-1">Check back soon or contact us to learn more.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Carousel controls -->
            <div class="carousel-controls px-1">
                <button class="carousel-btn carousel-prev">←</button>
                <div class="carousel-dots"></div>
                <button class="carousel-btn carousel-next">→</button>
            </div>
        </div>

        <div class="md:hidden text-center mt-4">
            <a href="courses" class="text-sm font-semibold">View all programs →</a>
        </div>
    </div>
</div>

<!-- ===================== OUR STAR ACHIEVERS (CAROUSEL) ===================== -->
<div class="section-gradient-3 tail-container py-16">
    <div class="flex items-end justify-between mb-8">
        <div>
            <span class="uppercase text-amber-600 font-bold tracking-[2px] text-xs">CHAMPIONS MADE HERE</span>
            <h2 class="text-4xl font-extrabold tracking-tight">Our Star Achievers</h2>
        </div>
        <a href="achievements.php" class="hidden md:inline text-sm font-semibold hover:text-amber-600">View all →</a>
    </div>

    <div id="achievers-carousel" class="carousel-container">
        <div class="carousel-track">
            <?php if (!empty($toppers)): ?>
                <?php foreach ($toppers as $topper): ?>
                    <div class="carousel-item">
                        <div class="modern-card bg-white border rounded-3xl overflow-hidden h-full">
                            <div class="relative">
                                <img src="<?= htmlspecialchars($topper['photo'] ?: 'assets/images/topper-aarav.jpg') ?>"
                                    class="w-full h-56 object-cover" alt="<?= htmlspecialchars($topper['name']) ?>">
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent h-20"></div>
                                <div class="absolute bottom-3 left-3 text-white">
                                    <div class="font-semibold text-lg"><?= htmlspecialchars($topper['name']) ?></div>
                                    <div class="text-amber-400 text-xs font-bold"><?= htmlspecialchars($topper['rank']) ?> • <?= $topper['year'] ?></div>
                                </div>
                            </div>
                            <div class="p-5">
                                <p class="text-sm text-slate-600"><?= htmlspecialchars($topper['achievement']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="carousel-item">
                    <div class="modern-card p-8 bg-white border rounded-3xl text-center text-slate-400">
                        <div class="text-4xl mb-3">🏆</div>
                        <div class="font-semibold">No achievers yet</div>
                        <p class="text-sm mt-1">Our champions are training hard. Check back soon!</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="carousel-controls px-1">
            <button class="carousel-btn carousel-prev">←</button>
            <div class="carousel-dots"></div>
            <button class="carousel-btn carousel-next">→</button>
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

<!-- FINAL CTA -->
<div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10 py-14">
    <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-3xl px-8 py-10 md:py-12 text-white flex flex-col lg:flex-row items-center justify-between gap-6">
        <div class="max-w-md">
            <h3 class="text-3xl font-extrabold tracking-tight">Ready to begin your champion story?</h3>
            <p class="text-slate-300 mt-2">Book a free trial session this week. Limited spots available.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="admissions.php" class="btn-accent px-9 py-3.5 rounded-full text-base font-semibold">Book Free Trial</a>
            <a href="tel:<?= $phone ?>" class="px-7 py-3.5 border border-white/30 hover:bg-white/10 rounded-full text-base">Call <?= $phone ?></a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>