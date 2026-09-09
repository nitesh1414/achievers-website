-- =====================================================
-- ACHIEVERS ACADEMY - HERO BANNERS SEEDER (5 Slides)
-- Run this after schema.sql + main seed_data.sql
-- Or import directly in phpMyAdmin / MySQL
-- =====================================================

USE achievers_cms;

-- Clear old banners (optional - comment out if you want to keep existing)
-- DELETE FROM banners;

-- Insert 5 beautiful banners for the hero slider
INSERT INTO banners (title, subtitle, image, link_url, sort_order, status) VALUES 
('Train Like a Champion', 
 'Under International Coach Pankaj Kunde — Nagpur\'s most decorated gymnastics academy', 
 'assets/images/hero-main.jpg', 
 '/courses.php', 
 1, 'active'),

('World-Class Facility', 
 'FIG-standard apparatus • Sprung floors • Olympic-grade safety', 
 'assets/images/hero-facility.jpg', 
 '/about.php', 
 2, 'active'),

('Enroll for 2026 Season', 
 'Limited slots available. Start with a FREE TRIAL today!', 
 'assets/images/hero-enroll.jpg', 
 '/admissions.php', 
 3, 'active'),

('Join Our Champions', 
 'Build strength, discipline & confidence. Ages 5–18 welcome', 
 'assets/images/hero-main.jpg', 
 '/achievements.php', 
 4, 'active'),

('Free Trial This Week', 
 'Experience world-class coaching. Book your slot now', 
 'assets/images/hero-facility.jpg', 
 '/admissions.php', 
 5, 'active');

SELECT '✅ 5 Hero Banners added successfully!' AS message;
SELECT COUNT(*) AS total_banners FROM banners;