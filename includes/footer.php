<?php
$phone = get_setting('phone', '+91 90965 94552');
$email = get_setting('email', 'info@achieversgymnastics.com');
$address = get_setting('address', 'Wardhaman Nagar, Nagpur');
?>
<footer class="bg-slate-900 text-slate-300 pt-16 pb-8 mt-16">
    <div class="tail-container w-full max-w-[1400px] mx-auto px-6 md:px-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-x-8 gap-y-10">

            <!-- Brand -->
            <div class="lg:col-span-2">
                <div class="flex items-center gap-x-3 mb-4">
                    <img src="assets/images/logo-big.png" alt="Achievers Academy" class="h-[80px] w-auto">
                    <span class="text-white text-2xl font-extrabold tracking-tight"><?= get_setting('site_name', 'Achievers Gymnastics Academy') ?></span>
                </div>
                <p class="text-sm max-w-sm text-slate-400">Nagpur's #1 gymnastics academy. Building champions since 2007.</p>

                <div class="flex gap-3 text-xl">
                    <?php if ($ig = get_setting('instagram')): ?>
                        <a href="<?= htmlspecialchars($ig) ?>" target="_blank" class="hover:text-white transition-colors" title="Instagram" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    <?php endif; ?>

                    <?php if ($wa = get_setting('whatsapp')): ?>
                        <a href="https://wa.me/<?= htmlspecialchars($wa) ?>" target="_blank" class="hover:text-white transition-colors" title="WhatsApp" aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    <?php endif; ?>

                    <?php if ($fb = get_setting('facebook')): ?>
                        <a href="<?= htmlspecialchars($fb) ?>" target="_blank" class="hover:text-white transition-colors" title="Facebook" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    <?php endif; ?>

                    <?php if ($li = get_setting('linkedin')): ?>
                        <a href="<?= htmlspecialchars($li) ?>" target="_blank" class="hover:text-white transition-colors" title="LinkedIn" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    <?php endif; ?>
                </div>

            </div>

            <div>
                <h5 class="font-bold text-white mb-4 text-sm tracking-widest">QUICK LINKS</h5>
                <div class="space-y-1.5 text-sm">
                    <a href="about.php" class="block hover:text-white">About Us</a>
                    <a href="courses.php" class="block hover:text-white">Training Programs</a>
                    <a href="mentor.php" class="block hover:text-white">Our Coaches</a>
                    <a href="achievements.php" class="block hover:text-white">Achievements</a>
                    <a href="competitions.php" class="block hover:text-white">Competitions</a>
                    <a href="notices.php" class="block hover:text-white">Notices</a>
                </div>
            </div>
            <div>
                <h5 class="font-bold text-white mb-4 text-sm tracking-widest">JOIN US</h5>
                <div class="space-y-1.5 text-sm">
                    <a href="admissions.php" class="block hover:text-white">Admissions</a>
                    <a href="admissions.php" class="block hover:text-white">Book Free Trial</a>
                    <a href="gallery.php" class="block hover:text-white">Gallery</a>
                    <a href="contact.php" class="block hover:text-white">Contact</a>
                </div>
            </div>

            <div>
                <h5 class="font-bold text-white mb-4 text-sm tracking-widest">CONTACT</h5>
                <div class="space-y-2 text-sm">
                    <div class="flex gap-2 items-start">
                        <span class="mt-0.5">📍</span>
                        <span><?= $address ?></span>
                    </div>
                    <a href="tel:<?= $phone ?>" class="block hover:text-white"><?= $phone ?></a>
                    <a href="mailto:<?= $email ?>" class="block hover:text-white"><?= $email ?></a>

                    <div class="pt-2">
                        <a href="https://wa.me/<?= get_setting('whatsapp', '919096594552') ?>?text=Hi%20Achievers" target="_blank"
                            class="inline-flex items-center gap-2 text-sm px-4 py-1.5 bg-emerald-700 hover:bg-emerald-600 text-white rounded-full text-xs font-semibold">
                            <i class="fab fa-whatsapp"></i> Chat on WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-800 mt-14 pt-8 text-xs flex flex-col md:flex-row gap-y-1 justify-between text-slate-500">
            <div>&copy; <?= date('Y') ?> Achievers Gymnastics Academy. All rights reserved.</div>
            <div class="flex gap-x-4">
                Design &amp; Developed by  <a href="https://rightserveinfotechsystem.com/" class="hover:text-white">Right Serve Infotech System Pvt. Ltd</a>
                
                <span>Train </span><span class="hidden md:inline">•</span> Compete <span class="hidden md:inline">•</span> Achieve 
            </div>
        </div>
    </div>
</footer>

<!-- Responsive + Carousel JS -->
<script>
    // Global carousel function - robust implementation
    function initCarousel(containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;

        const track = container.querySelector('.carousel-track');
        const items = track ? Array.from(track.children) : [];
        const prevBtn = container.querySelector('.carousel-prev');
        const nextBtn = container.querySelector('.carousel-next');
        const dotsContainer = container.querySelector('.carousel-dots');

        if (!track || items.length === 0) return;

        let currentIndex = 0;
        let itemWidth = 0;

        function getVisibleCount() {
            const w = window.innerWidth;
            if (w >= 1280) return 4;
            if (w >= 1024) return 4;
            if (w >= 768) return 3;
            if (w >= 640) return 2;
            return 1;
        }

        function recalcItemWidth() {
            if (items.length > 0) {
                // Use actual rendered width + gap
                const style = window.getComputedStyle(track);
                const gap = parseFloat(style.gap) || 20;
                itemWidth = items[0].getBoundingClientRect().width + gap;
            }
        }

        function updateCarousel() {
            recalcItemWidth();
            const translateX = -currentIndex * itemWidth;
            track.style.transform = `translateX(${translateX}px)`;

            // Update dots
            if (dotsContainer) {
                const dots = dotsContainer.children;
                for (let i = 0; i < dots.length; i++) {
                    dots[i].classList.toggle('active', i === currentIndex);
                }
            }
        }

        function goTo(index) {
            const visible = getVisibleCount();
            const maxIndex = Math.max(0, items.length - visible);
            currentIndex = Math.max(0, Math.min(index, maxIndex));
            updateCarousel();
        }

        // Buttons
        if (prevBtn) prevBtn.onclick = (e) => {
            e.preventDefault();
            goTo(currentIndex - 1);
        };
        if (nextBtn) nextBtn.onclick = (e) => {
            e.preventDefault();
            goTo(currentIndex + 1);
        };

        // Dots
        if (dotsContainer) {
            dotsContainer.innerHTML = '';
            for (let i = 0; i < items.length; i++) {
                const dot = document.createElement('div');
                dot.className = 'carousel-dot' + (i === 0 ? ' active' : '');
                dot.onclick = () => goTo(i);
                dotsContainer.appendChild(dot);
            }
        }

        // Touch swipe
        let startX = 0;
        let isDragging = false;

        track.addEventListener('touchstart', e => {
            startX = e.touches[0].clientX;
            isDragging = true;
        }, {
            passive: true
        });

        track.addEventListener('touchend', e => {
            if (!isDragging) return;
            isDragging = false;
            const endX = e.changedTouches[0].clientX;
            const diff = startX - endX;
            if (diff > 50) goTo(currentIndex + 1);
            if (diff < -50) goTo(currentIndex - 1);
        });

        // Mouse drag for desktop
        let mouseDown = false;
        let mouseStartX = 0;
        track.addEventListener('mousedown', e => {
            mouseDown = true;
            mouseStartX = e.clientX;
            track.style.cursor = 'grabbing';
        });
        document.addEventListener('mouseup', e => {
            if (!mouseDown) return;
            mouseDown = false;
            track.style.cursor = '';
            const diff = mouseStartX - e.clientX;
            if (diff > 60) goTo(currentIndex + 1);
            if (diff < -60) goTo(currentIndex - 1);
        });
        track.addEventListener('mouseleave', () => {
            mouseDown = false;
            track.style.cursor = '';
        });

        // Responsive update
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                recalcItemWidth();
                const visible = getVisibleCount();
                const maxIndex = Math.max(0, items.length - visible);
                if (currentIndex > maxIndex) currentIndex = maxIndex;
                updateCarousel();
            }, 150);
        });

        // Auto advance every 5.5s (pause on hover)
        let interval = null;

        function startAuto() {
            if (interval) clearInterval(interval);
            interval = setInterval(() => {
                const visible = getVisibleCount();
                const maxIndex = Math.max(0, items.length - visible);
                let next = currentIndex + 1;
                if (next > maxIndex) next = 0;
                currentIndex = next;
                updateCarousel();
            }, 5500);
        }

        function stopAuto() {
            if (interval) {
                clearInterval(interval);
                interval = null;
            }
        }

        container.addEventListener('mouseenter', stopAuto);
        container.addEventListener('mouseleave', startAuto);

        // Initial setup - robust for images / flex
        function forceInit() {
            recalcItemWidth();
            const visible = getVisibleCount();
            const maxIndex = Math.max(0, items.length - visible);
            if (currentIndex > maxIndex) currentIndex = maxIndex;
            updateCarousel();
            if (!interval) startAuto();
        }

        setTimeout(forceInit, 80);
        setTimeout(forceInit, 380);
        setTimeout(forceInit, 850);

        // Force after full load + images
        window.addEventListener('load', forceInit);

        // Extra safety: re-calc after fonts/images settle
        setTimeout(forceInit, 1600);
    }

    // Hero Slider (multi-slide from DB banners)
    function initHeroSlider() {
        const slider = document.querySelector('.hero-slider');
        if (!slider) return;

        const slides = slider.querySelectorAll('.hero-slide');
        if (slides.length <= 1) return;

        let current = 0;

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });

            // Update dots
            const dots = slider.querySelectorAll('.slider-dot');
            dots.forEach((dot, i) => dot.classList.toggle('active', i === index));
        }

        // Dots
        const dotsContainer = slider.querySelector('.slider-nav');
        if (dotsContainer) {
            dotsContainer.innerHTML = '';
            slides.forEach((_, i) => {
                const dot = document.createElement('div');
                dot.className = 'slider-dot' + (i === 0 ? ' active' : '');
                dot.onclick = () => {
                    current = i;
                    showSlide(current);
                    resetAuto();
                };
                dotsContainer.appendChild(dot);
            });
        }

        // Arrows
        const prev = slider.querySelector('.slider-arrow.prev');
        const next = slider.querySelector('.slider-arrow.next');

        if (prev) prev.onclick = () => {
            current = (current - 1 + slides.length) % slides.length;
            showSlide(current);
            resetAuto();
        };

        if (next) next.onclick = () => {
            current = (current + 1) % slides.length;
            showSlide(current);
            resetAuto();
        };

        // Auto rotate
        let autoInterval;

        function startAuto() {
            autoInterval = setInterval(() => {
                current = (current + 1) % slides.length;
                showSlide(current);
            }, 5200);
        }

        function resetAuto() {
            clearInterval(autoInterval);
            startAuto();
        }

        // Keyboard + touch support
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') {
                current = (current + 1) % slides.length;
                showSlide(current);
                resetAuto();
            }
            if (e.key === 'ArrowLeft') {
                current = (current - 1 + slides.length) % slides.length;
                showSlide(current);
                resetAuto();
            }
        });

        let touchStartX = 0;
        slider.addEventListener('touchstart', e => touchStartX = e.touches[0].clientX);
        slider.addEventListener('touchend', e => {
            const diff = e.changedTouches[0].clientX - touchStartX;
            if (diff < -60) {
                current = (current + 1) % slides.length;
                showSlide(current);
                resetAuto();
            }
            if (diff > 60) {
                current = (current - 1 + slides.length) % slides.length;
                showSlide(current);
                resetAuto();
            }
        });

        // Start
        showSlide(0);
        startAuto();

        // Pause on hover (desktop)
        slider.addEventListener('mouseenter', () => clearInterval(autoInterval));
        slider.addEventListener('mouseleave', startAuto);
    }

    // Initialize everything on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all carousels
        const carousels = document.querySelectorAll('.carousel-container');
        carousels.forEach((c, index) => {
            if (!c.id) c.id = 'carousel-' + index;
            initCarousel(c.id);
        });

        // Initialize hero slider
        initHeroSlider();

        // Add touch-friendly classes for tablets
        if ('ontouchstart' in window) {
            document.documentElement.classList.add('touch-device');
        }
    });
</script>
</body>

</html>