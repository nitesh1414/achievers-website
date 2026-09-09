-- Achievers Academy CMS - Sample Seed Data
USE achievers_cms;

-- Default Admin (username: admin, password: admin123 - CHANGE IN PRODUCTION!)
INSERT INTO admins (username, password, email, full_name) VALUES 
('admin', '', 'admin@achieversacademy.com', 'Admin User');

-- Course Categories
INSERT INTO course_categories (name, slug, description, icon) VALUES 
('Beginner Programs', 'beginner-programs', 'Foundation level gymnastics for ages 5-8. Learn basics of tumbling, balance and coordination.', 'child'),
('Intermediate Training', 'intermediate-training', 'Skill development for ages 8-12. Introduction to apparatus and competitive routines.', 'school'),
('Elite Competitive', 'elite-competitive', 'Advanced training for national/international level athletes. FIG-standard coaching.', 'trophy'),
('Specialized Camps', 'specialized-camps', 'Intensive short-term programs: Holiday camps, Summer clinics, Competition prep.', 'calendar');

-- Courses
INSERT INTO courses (category_id, title, slug, description, syllabus, duration, fees, thumbnail, status) VALUES 
(1, 'Little Champions (Ages 5-7)', 'little-champions', 
'Introductory gymnastics program focused on fun, balance, coordination and basic tumbling.', 
'Week 1-2: Floor basics & body positions\nWeek 3-4: Balance beam intro\nWeek 5-6: Vault & trampoline fundamentals\nWeek 7-8: Mini routines & games', 
'8 weeks (2 classes/week)', 4500.00, 'assets/images/course-little.jpg', 'active'),

(2, 'Rising Stars (Ages 8-11)', 'rising-stars', 
'Builds strength, flexibility and apparatus skills. Perfect bridge to competitive team.', 
'Core tumbling progressions\nBeam & bars basics\nVault technique\nStrength & conditioning', 
'12 weeks', 6500.00, 'assets/images/course-rising.jpg', 'active'),

(3, 'National Prep Squad', 'national-prep-squad', 
'Intensive training for national and state level competitions. Personalized coaching plan.', 
'Advanced floor routines\nHigh-level apparatus work\nCompetition simulation\nMental training', 
'Ongoing (monthly)', 12500.00, 'assets/images/course-national.jpg', 'active'),

(1, 'Free Trial Class', 'free-trial', 
'One complimentary session to experience our world-class facility and coaching.', 
'Full assessment + fun gymnastics session', '1 class (60 mins)', 0.00, 'assets/images/course-trial.jpg', 'active');

-- Banners / Hero Slider (5 beautiful slides for full glory)
INSERT INTO banners (title, subtitle, image, link_url, sort_order, status) VALUES 
('Train Like a Champion', 'Under International Coach Pankaj Kunde — Nagpur\'s most decorated gymnastics academy', 'assets/images/hero-main.jpg', '/courses.php', 1, 'active'),
('World-Class Facility', 'FIG-standard apparatus • Sprung floors • Olympic-grade safety', 'assets/images/hero-facility.jpg', '/about.php', 2, 'active'),
('Enroll for 2026 Season', 'Limited slots available. Start with a FREE TRIAL today!', 'assets/images/hero-enroll.jpg', '/admissions.php', 3, 'active'),
('Join Our Champions', 'Build strength, discipline & confidence. Ages 5–18 welcome', 'assets/images/hero-main.jpg', '/achievements.php', 4, 'active'),
('Free Trial This Week', 'Experience world-class coaching. Book your slot now', 'assets/images/hero-facility.jpg', '/admissions.php', 5, 'active');

-- Inquiries / Leads (sample)
INSERT INTO inquiries (name, phone, email, course_id, message, status) VALUES 
('Aarav Sharma Parent', '9876543210', 'priya.sharma@email.com', 1, 'Interested in Little Champions for my son Aarav (6 yrs). When is the next batch?', 'Enrolled'),
('Riya Deshmukh', '9823456789', 'rajesh.deshmukh@email.com', 3, 'My daughter Riya wants to join the Elite program. Please call me.', 'Contacted'),
('Kabir Patil', '9012345678', NULL, 2, 'Looking for summer camp options for 10 year old.', 'Pending'),
('Anaya Joshi', '8765432109', 'anaya.joshi@email.com', NULL, 'Want to know about competition fees and schedule.', 'Pending'),
('Vihaan Kulkarni', '9988776655', NULL, 4, 'Please send details for Free Trial class next week.', 'Contacted');

-- Faculty
INSERT INTO faculty (name, designation, bio, photo, specialties, experience_years, status) VALUES 
('Pankaj Kunde', 'Founder & International Head Coach', 
'Trained under international standards. 18+ years experience coaching gymnasts to national and international medals. FIG certified.', 
'assets/images/faculty-pankaj.jpg', 'Artistic Gymnastics, Floor, Vault, Beam, Rings', 18, 'active'),

('Neha Rao', 'Senior Coach - Beam & Floor', 
'Former national level gymnast. Specializes in women\'s artistic gymnastics and flexibility training.', 
'assets/images/faculty-neha.jpg', 'Balance Beam, Floor Exercise, Flexibility', 9, 'active'),

('Rahul Deshpande', 'Assistant Coach - Strength & Vault', 
'Certified strength and conditioning coach with deep knowledge of gymnastics conditioning.', 
'assets/images/faculty-rahul.jpg', 'Vault, Strength Training, Tumbling', 6, 'active');

-- Competitions
INSERT INTO competitions (title, event_date, type, location, description, how_to_apply, results, image, status) VALUES 
('Maharashtra State Gymnastics Championship 2026', '2026-03-15', 'future', 'Pune, Maharashtra', 
'Annual state level championship. Open to all registered gymnasts from Maharashtra.', 
'Register via academy office or email by Feb 28, 2026. Age groups: U-10, U-12, U-15, Senior.', 
NULL, 'assets/images/comp-state.jpg', 'active'),

('Khelo India Youth Games Selection Trials', '2026-02-20', 'future', 'Nagpur', 
'National selection trials. Top performers qualify for Khelo India.', 
'Internal academy trials + submission of form to Coach Pankaj.', 
NULL, 'assets/images/comp-khelo.jpg', 'active'),

('National Gymnastics Championship 2025', '2025-12-05', 'past', 'New Delhi', 
'National level competition. Our athletes won 5 Gold, 3 Silver.', 
NULL, 'Aarav Sharma: Gold (Floor)\nRiya Deshmukh: Silver (Beam)\nKabir Patil: Gold (Vault)', 'assets/images/comp-national.jpg', 'active');

-- Gallery Items
INSERT INTO gallery (title, image, category, event_date, description, status) VALUES 
('National Gold - Aarav Sharma 2024', 'assets/images/gallery-aarav.jpg', 'Competition', '2024-11-15', 'Aarav winning National Floor Gold', 'active'),
('International Silver - Riya 2024', 'assets/images/gallery-riya.jpg', 'Competition', '2024-09-20', 'Riya on podium at Asian Junior', 'active'),
('Training Session - Beam', 'assets/images/gallery-beam.jpg', 'Training', '2025-01-10', 'Girls training on beam apparatus', 'active'),
('Facility Tour - FIG Apparatus', 'assets/images/gallery-facility.jpg', 'Facility', '2025-02-01', 'World-class sprung floor & foam pits', 'active'),
('Summer Camp 2025 Group Photo', 'assets/images/gallery-camp.jpg', 'Event', '2025-05-25', 'Group photo of summer campers', 'active'),
('State Championship Podium', 'assets/images/gallery-podium.jpg', 'Competition', '2024-08-12', 'Team podium at Maharashtra State', 'active');

-- Toppers / Achievers
INSERT INTO toppers (name, rank, year, achievement, photo, course, status) VALUES 
('Aarav Sharma', 'National Gold', 2024, 'National Gymnastics Championship - Floor Exercise', 'assets/images/topper-aarav.jpg', 'National Prep Squad', 'active'),
('Riya Deshmukh', 'Asian Silver', 2024, 'Asian Junior Gymnastics Championship - Beam', 'assets/images/topper-riya.jpg', 'Elite Competitive', 'active'),
('Anaya Joshi', 'SGFI Gold', 2023, 'SGFI National Games - All Around', 'assets/images/topper-anaya.jpg', 'Elite Competitive', 'active'),
('Vihaan Kulkarni', 'Khelo India Bronze', 2023, 'Khelo India Youth Games - Vault', 'assets/images/topper-vihaan.jpg', 'Rising Stars', 'active'),
('Kabir Patil', 'State Gold', 2024, 'Maharashtra State Championship - Rings', 'assets/images/topper-kabir.jpg', 'National Prep Squad', 'active');

-- Notices & Downloads
INSERT INTO notices (title, content, file_path, publish_date, status) VALUES 
('Summer Camp 2026 Registrations Open', 'Registrations are now open for our 4-week Summer Intensive Camp. Limited seats. Contact office.', 'assets/downloads/summer-camp-2026.pdf', '2026-01-15', 'published'),
('National Trials - Important Notice', 'Internal trials for Khelo India selection will be held on 15th Feb. All Elite students must attend.', NULL, '2026-01-20', 'published'),
('Fee Revision - 2026', 'Updated fee structure for new academic year effective from March 1. Please check your email.', 'assets/downloads/fee-structure-2026.pdf', '2026-02-01', 'published'),
('Holiday Schedule', 'Academy will remain closed on 26th Jan for Republic Day.', NULL, '2026-01-20', 'unpublished');

-- Website Settings
INSERT INTO settings (setting_key, setting_value) VALUES 
('site_name', 'Achievers Gymnastics Academy'),
('tagline', 'Train Like a Champion | Nagpur\'s #1 Gymnastics Academy'),
('phone', '+91 90965 94552'),
('whatsapp', '919096594552'),
('email', 'info@achieversacademy.com'),
('address', 'Plot No. 45, Wardhaman Nagar, Above Domino\'s, Nagpur - 440008, Maharashtra'),
('instagram', 'https://www.instagram.com/achieversgymnasticacademy/'),
('facebook', 'https://facebook.com/achieversgymnasticacademy'),
('youtube', ''),
('logo', 'assets/images/logo.png'),
('meta_title', 'Achievers Gymnastics Academy | Best Gymnastics Coaching in Nagpur'),
('meta_description', 'Nagpur\'s premier gymnastics academy under International Coach Pankaj Kunde. 250+ medals. FIG-standard facility. Enroll for free trial today!'),
('meta_keywords', 'gymnastics academy nagpur, gymnastics coaching, pankaj kunde, national champions, gymnastics classes nagpur'),
('founded_year', '2007'),
('medals_won', '250+'),
('active_students', '400+'),
('years_experience', '18');