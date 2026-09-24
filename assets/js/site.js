/* Achievers Academy public interactions */
(function () {
    'use strict';

    function toggleMobileMenu() {
        var menu = document.querySelector('[data-mobile-menu]');
        var button = document.querySelector('[data-menu-toggle]');
        if (!menu || !button) return;
        var isOpen = menu.classList.toggle('is-open');
        button.setAttribute('aria-expanded', String(isOpen));
        button.setAttribute('aria-label', isOpen ? 'Close navigation menu' : 'Open navigation menu');
        button.querySelector('i').className = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
    }

    function initMobileMenu() {
        var button = document.querySelector('[data-menu-toggle]');
        if (!button) return;
        button.addEventListener('click', toggleMobileMenu);
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                var menu = document.querySelector('[data-mobile-menu]');
                if (menu && menu.classList.contains('is-open')) toggleMobileMenu();
            }
        });
    }

    function initCarousel(container) {
        var track = container.querySelector('.carousel-track');
        var items = track ? Array.prototype.slice.call(track.children) : [];
        var previous = container.querySelector('.carousel-prev');
        var next = container.querySelector('.carousel-next');
        var dots = container.querySelector('.carousel-dots');
        if (!track || !items.length) return;

        var current = 0;
        var timer = null;
        var touchStart = 0;

        function visibleCount() {
            if (window.innerWidth >= 1024) return 4;
            if (window.innerWidth >= 768) return 3;
            if (window.innerWidth >= 640) return 2;
            return 1;
        }

        function maxIndex() {
            return Math.max(0, items.length - visibleCount());
        }

        function itemWidth() {
            var gap = parseFloat(window.getComputedStyle(track).gap) || 20;
            return items[0].getBoundingClientRect().width + gap;
        }

        function goTo(index, focus) {
            current = Math.max(0, Math.min(index, maxIndex()));
            track.style.transform = 'translateX(' + (-current * itemWidth()) + 'px)';
            if (dots) {
                Array.prototype.forEach.call(dots.children, function (dot, dotIndex) {
                    dot.classList.toggle('active', dotIndex === current);
                    dot.setAttribute('aria-current', dotIndex === current ? 'true' : 'false');
                });
            }
            if (focus && items[current]) items[current].focus({preventScroll: true});
        }

        function startAuto() {
            if (items.length <= visibleCount()) return;
            stopAuto();
            timer = window.setInterval(function () {
                goTo(current >= maxIndex() ? 0 : current + 1);
            }, 6000);
        }

        function stopAuto() {
            if (timer) window.clearInterval(timer);
            timer = null;
        }

        if (dots) {
            dots.innerHTML = '';
            for (var index = 0; index <= maxIndex(); index += 1) {
                (function (dotIndex) {
                    var dot = document.createElement('button');
                    dot.type = 'button';
                    dot.className = 'carousel-dot' + (dotIndex === 0 ? ' active' : '');
                    dot.setAttribute('aria-label', 'Show testimonial ' + (dotIndex + 1));
                    dot.addEventListener('click', function () {
                        goTo(dotIndex, true);
                        startAuto();
                    });
                    dots.appendChild(dot);
                }(index));
            }
        }

        if (previous) previous.addEventListener('click', function () {
            goTo(current - 1, true);
            startAuto();
        });
        if (next) next.addEventListener('click', function () {
            goTo(current + 1, true);
            startAuto();
        });

        track.addEventListener('touchstart', function (event) {
            touchStart = event.touches[0].clientX;
        }, {passive: true});
        track.addEventListener('touchend', function (event) {
            var difference = touchStart - event.changedTouches[0].clientX;
            if (Math.abs(difference) > 45) goTo(current + (difference > 0 ? 1 : -1));
            startAuto();
        }, {passive: true});

        container.addEventListener('mouseenter', stopAuto);
        container.addEventListener('mouseleave', startAuto);
        container.addEventListener('focusin', stopAuto);
        container.addEventListener('focusout', function () {
            window.setTimeout(function () {
                if (!container.contains(document.activeElement)) startAuto();
            }, 0);
        });
        window.addEventListener('resize', function () {
            if (current > maxIndex()) current = maxIndex();
            goTo(current);
        });

        goTo(0);
        startAuto();
    }

    function initHeroSlider() {
        var slider = document.querySelector('.hero-slider');
        if (!slider) return;
        var slides = Array.prototype.slice.call(slider.querySelectorAll('.hero-slide'));
        if (slides.length < 2) return;

        var current = 0;
        var timer = null;
        var nav = slider.querySelector('.slider-nav');
        var previous = slider.querySelector('.slider-arrow.prev');
        var next = slider.querySelector('.slider-arrow.next');
        var touchStart = 0;

        function show(index) {
            current = (index + slides.length) % slides.length;
            slides.forEach(function (slide, slideIndex) {
                var active = slideIndex === current;
                slide.classList.toggle('active', active);
                slide.setAttribute('aria-hidden', active ? 'false' : 'true');
            });
            if (nav) Array.prototype.forEach.call(nav.children, function (dot, dotIndex) {
                dot.classList.toggle('active', dotIndex === current);
                dot.setAttribute('aria-current', dotIndex === current ? 'true' : 'false');
            });
        }

        function startAuto() {
            stopAuto();
            timer = window.setInterval(function () { show(current + 1); }, 6000);
        }
        function stopAuto() {
            if (timer) window.clearInterval(timer);
            timer = null;
        }
        function move(change) {
            show(current + change);
            startAuto();
        }

        if (nav) {
            nav.innerHTML = '';
            slides.forEach(function (_, index) {
                var dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'slider-dot' + (index === 0 ? ' active' : '');
                dot.setAttribute('aria-label', 'Show banner ' + (index + 1));
                dot.addEventListener('click', function () { show(index); startAuto(); });
                nav.appendChild(dot);
            });
        }
        if (previous) previous.addEventListener('click', function () { move(-1); });
        if (next) next.addEventListener('click', function () { move(1); });

        slider.addEventListener('touchstart', function (event) { touchStart = event.touches[0].clientX; }, {passive: true});
        slider.addEventListener('touchend', function (event) {
            var difference = touchStart - event.changedTouches[0].clientX;
            if (Math.abs(difference) > 45) move(difference > 0 ? 1 : -1);
        }, {passive: true});
        slider.addEventListener('mouseenter', stopAuto);
        slider.addEventListener('mouseleave', startAuto);
        document.addEventListener('keydown', function (event) {
            if (document.activeElement && ['INPUT', 'TEXTAREA', 'SELECT'].indexOf(document.activeElement.tagName) !== -1) return;
            if (event.key === 'ArrowLeft') move(-1);
            if (event.key === 'ArrowRight') move(1);
        });
        show(0);
        startAuto();
    }

    function initGallery() {
        var gallery = document.querySelector('[data-gallery]');
        var modal = document.querySelector('[data-lightbox]');
        if (!gallery || !modal) return;
        var image = modal.querySelector('[data-lightbox-image]');
        var title = modal.querySelector('[data-lightbox-title]');
        var meta = modal.querySelector('[data-lightbox-meta]');
        var close = modal.querySelector('[data-lightbox-close]');

        function closeModal() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-open');
        }
        gallery.addEventListener('click', function (event) {
            var item = event.target.closest('[data-gallery-item]');
            if (!item) return;
            image.src = item.dataset.image;
            image.alt = item.dataset.title || 'Gallery image';
            title.textContent = item.dataset.title || '';
            meta.textContent = item.dataset.meta || '';
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('modal-open');
            close.focus();
        });
        close.addEventListener('click', closeModal);
        modal.addEventListener('click', function (event) {
            if (event.target === modal) closeModal();
        });
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initMobileMenu();
        Array.prototype.forEach.call(document.querySelectorAll('.carousel-container'), initCarousel);
        initHeroSlider();
        initGallery();
    });
}());
