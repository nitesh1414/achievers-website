# 🌟 Quick Add Banners for Hero Slider

You now have **5 beautiful high-quality hero images** ready:
- `hero-main.jpg`
- `hero-facility.jpg`
- `hero-enroll.jpg`

## Easiest Way (Recommended)

### Option 1 — One-Click Button in Admin (Fastest)
1. Go to your site admin: `http://your-site/admin/banners.php`
2. Click the big green button: **🌟 Seed 5 Sample Banners**
3. Done! Visit your homepage to see the full glory slider.

### Option 2 — Visit Browser Seeder
Visit this URL in your browser:
```
http://localhost:8080/sql/seed_banners.php
```
(or replace with your actual domain)

This will instantly insert 5 professional banners.

**⚠️ Delete `sql/seed_banners.php` after use.**

---

## Option 3 — Run SQL (phpMyAdmin / MySQL)

Copy and paste this into your database tool:

```sql
USE achievers_cms;

INSERT INTO banners (title, subtitle, image, link_url, sort_order, status) VALUES 
('Train Like a Champion', 
 'Under International Coach Pankaj Kunde — Nagpur\'s most decorated gymnastics academy', 
 'assets/images/hero-main.jpg', 
 '/courses.php', 1, 'active'),

('World-Class Facility', 
 'Competition-ready apparatus • Sprung floors • Olympic-grade safety',
 'assets/images/hero-facility.jpg', 
 '/about.php', 2, 'active'),

('Enroll for 2026 Season', 
 'Limited slots available. Start with a FREE TRIAL today!', 
 'assets/images/hero-enroll.jpg', 
 '/admissions.php', 3, 'active'),

('Join Our Champions', 
 'Build strength, discipline & confidence. Ages 5–18 welcome', 
 'assets/images/hero-main.jpg', 
 '/achievements.php', 4, 'active'),

('Free Trial This Week', 
 'Experience world-class coaching. Book your slot now', 
 'assets/images/hero-facility.jpg', 
 '/admissions.php', 5, 'active');
```

---

## What You Will See

After adding the banners, your homepage will show a **beautiful full-screen rotating hero slider** with:

- 5 stunning professional images
- Smooth auto-rotation (every ~5 seconds)
- Left / Right arrows
- Clickable dots
- Swipe support on mobile/tablet
- Dark elegant overlay + white text
- Call-to-action buttons

## Verify

1. Visit `/` (homepage)
2. You should see the slider at the very top
3. Wait a few seconds — it will automatically rotate through the 5 banners

Enjoy the full glory! 🚀

---

**Tip:** You can edit titles, subtitles, order, or images anytime from **Admin → Banners**.