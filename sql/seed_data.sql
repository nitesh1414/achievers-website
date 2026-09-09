-- Achievers Gymnastics Academy CMS initial content
USE achievers_cms;

-- Default login: admin / admin123. Change it immediately on a production site.
INSERT INTO admins (username, password, email, full_name) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@achieversacademy.com', 'Admin User');

INSERT INTO course_categories (name, slug, description, icon, status) VALUES
('Beginner Programs', 'beginner-programs', 'Foundation level gymnastics for ages 5 to 8.', 'child', 'active'),
('Intermediate Training', 'intermediate-training', 'Skill development for ages 8 to 12.', 'school', 'active'),
('Elite Competitive', 'elite-competitive', 'Advanced preparation for competitive athletes.', 'trophy', 'active'),
('Specialized Camps', 'specialized-camps', 'Holiday and summer intensive programs.', 'calendar', 'active');

INSERT INTO disciplines (name, slug, description, image, sort_order, status) VALUES
('Gymnastics', 'gymnastics', 'Artistic gymnastics pathways built around confidence, technique and safe progressions.', 'assets/images/hero-facility.jpg', 1, 'active');

INSERT INTO courses (category_id, discipline_id, title, slug, description, syllabus, duration, thumbnail, status) VALUES
(1, 1, 'Little Champions (Ages 5–7)', 'little-champions', 'An introductory program focused on movement confidence, balance, coordination and basic tumbling.', 'Floor basics\nBalance beam introduction\nVault and trampoline fundamentals\nMini routines and games', '8 weeks · 2 classes/week', 'assets/images/course-little.jpg', 'active'),
(2, 1, 'Rising Stars (Ages 8–11)', 'rising-stars', 'Build strength, flexibility and apparatus skills in a structured progression pathway.', 'Core tumbling progressions\nBeam and bars basics\nVault technique\nStrength and conditioning', '12 weeks', 'assets/images/course-rising.jpg', 'active'),
(3, 1, 'National Prep Squad', 'national-prep-squad', 'Focused development for athletes preparing for state and national competition.', 'Advanced routines\nHigh-level apparatus work\nCompetition simulation\nMental training', 'Ongoing', 'assets/images/course-national.jpg', 'active'),
(1, 1, 'Free Trial Class', 'free-trial', 'A complimentary assessment and fun gymnastics session to find the right pathway.', 'Assessment\nGymnastics fundamentals\nCoach guidance', 'One 60-minute class', 'assets/images/course-little.jpg', 'active');

-- Women's Artistic Gymnastics (WAG) apparatus and Men's Artistic Gymnastics (MAG) apparatus.
INSERT INTO apparatus (discipline_id, name, gender, description, sort_order, status) VALUES
(1, 'Vault', 'Women', 'WAG apparatus', 1, 'active'),
(1, 'Uneven Bars', 'Women', 'WAG apparatus', 2, 'active'),
(1, 'Balance Beam', 'Women', 'WAG apparatus', 3, 'active'),
(1, 'Floor Exercise', 'Women', 'WAG apparatus', 4, 'active'),
(1, 'Floor Exercise', 'Men', 'MAG apparatus', 1, 'active'),
(1, 'Pommel Horse', 'Men', 'MAG apparatus', 2, 'active'),
(1, 'Still Rings', 'Men', 'MAG apparatus', 3, 'active'),
(1, 'Vault', 'Men', 'MAG apparatus', 4, 'active'),
(1, 'Parallel Bars', 'Men', 'MAG apparatus', 5, 'active'),
(1, 'Horizontal Bar', 'Men', 'MAG apparatus', 6, 'active');

INSERT INTO banners (title, subtitle, image, link_url, show_content, sort_order, status) VALUES
('Nagpur’s gymnastics academy', 'Train like a champion', 'assets/images/hero-main.jpg', 'courses.php', 1, 1, 'active'),
('World-class facility', 'A safer way to reach higher', 'assets/images/hero-facility.jpg', 'about.php', 1, 2, 'active'),
('Enrollment open', 'Start with a free trial class', 'assets/images/hero-enroll.jpg', 'admissions.php', 1, 3, 'active');

INSERT INTO mentors (name, designation, bio, photo, specialties, experience_years, status) VALUES
('Pankaj Kunde', 'Founder and International Head Coach', 'Experienced coach focused on safe, structured development from fundamentals to performance.', 'assets/images/mentor-pankaj.jpg', 'Artistic Gymnastics, Floor, Vault, Beam', 18, 'active'),
('Neha Rao', 'Senior Coach — Beam and Floor', 'A former national-level gymnast specialising in women’s artistic gymnastics and flexibility training.', 'assets/images/mentor-neha.jpg', 'Balance Beam, Floor Exercise, Flexibility', 9, 'active'),
('Rahul Deshpande', 'Assistant Coach — Strength and Vault', 'A certified strength and conditioning coach with a deep understanding of gymnastics foundations.', 'assets/images/mentor-rahul.jpg', 'Vault, Strength Training, Tumbling', 6, 'active');

INSERT INTO social_links (platform, url, icon, is_active, sort_order) VALUES
('Facebook', 'https://facebook.com/achieversgymnasticacademy', 'facebook', 1, 1),
('Instagram', 'https://www.instagram.com/achieversgymnasticacademy/', 'instagram', 1, 2),
('LinkedIn', 'https://linkedin.com/company/achievers-gymnastics', 'linkedin', 1, 3),
('WhatsApp', 'https://wa.me/919096594552', 'whatsapp', 1, 4),
('YouTube', 'https://youtube.com/', 'youtube', 1, 5);

INSERT INTO testimonials (name, role, quote, rating, photo, status) VALUES
('Mrs. Priya Sharma', 'Parent of Aarav', 'The coaching has helped my son become more disciplined, confident and excited about each new skill.', 5, NULL, 'active'),
('Mr. Rajesh Deshmukh', 'Parent of Riya', 'The personal attention and structured guidance give us complete confidence in our child’s progress.', 5, NULL, 'active'),
('Anaya Joshi', 'Gymnast', 'Achievers gave me the confidence to work hard, enjoy the process and believe in what I can achieve.', 5, NULL, 'active');

INSERT INTO settings (setting_key, setting_value) VALUES
('site_name', 'Achievers Gymnastics Academy'),
('tagline', 'Train like a champion'),
('phone', '+91 90965 94552'),
('whatsapp', '919096594552'),
('email', 'info@achieversacademy.com'),
('address', 'Plot No. 45, Wardhaman Nagar, Nagpur - 440008'),
('logo', 'assets/images/logo-big.png'),
('meta_title', 'Achievers Gymnastics Academy | Gymnastics Coaching in Nagpur'),
('meta_description', 'Achievers Gymnastics Academy offers safe, structured gymnastics coaching in Nagpur.'),
('meta_keywords', 'gymnastics academy nagpur, gymnastics coaching, gymnastics classes'),
('active_students', '400+'),
('medals_won', '250+'),
('years_experience', '18+'),
('competitions_count', '35+'),
('footer_description', 'Nagpur’s gymnastics academy for disciplined, confident and resilient athletes.'),
('footer_copyright', 'Achievers Gymnastics Academy'),
('footer_developer_name', 'Right Serve Infotech System Pvt. Ltd.'),
('footer_developer_url', 'https://rightserveinfotechsystem.com/'),
('whatsapp_message', 'Hi Achievers Academy, I would like to know more.'),
('whatsapp_float_label', 'Chat with Achievers Academy on WhatsApp'),
('mission_label', 'OUR MISSION'),
('mission_vision_section_title', 'The purpose behind every practice'),
('mission_title', 'Building champions in body, mind and character'),
('mission_content', 'We give every child the opportunity to discover their inner champion through safe, structured and world-class gymnastics training.'),
('mission_image', 'assets/images/hero-main.jpg'),
('mission_image_alt', 'Young gymnast training with a coach'),
('vision_label', 'OUR VISION'),
('vision_title', 'A confident generation that rises higher'),
('vision_content', 'To be the most trusted gymnastics academy in central India, developing disciplined, resilient athletes and thoughtful leaders for life.'),
('vision_image', 'assets/images/hero-facility.jpg'),
('vision_image_alt', 'Gymnast performing in the academy'),
('home_competitions_label', 'COMPETITIONS'),
('home_why_label', 'WHY ACHIEVERS?'),
('home_why_title', 'Built to build champions'),
('home_why_1_icon', '🥇'),
('home_why_1_title', 'International coaching'),
('home_why_1_text', 'FIG-informed coaching that meets every athlete at their level.'),
('home_why_2_icon', '🏆'),
('home_why_2_title', 'Proven results'),
('home_why_2_text', 'A pathway built on strong fundamentals, confidence and competitive excellence.'),
('home_why_3_icon', '🛡️'),
('home_why_3_title', 'Safe and supportive'),
('home_why_3_text', 'A positive, professionally equipped environment where every child belongs.'),
('home_programs_label', 'PROGRAMS'),
('home_programs_title', 'Our training programs'),
('home_achievers_label', 'CHAMPIONS MADE HERE'),
('home_achievers_title', 'Our star achievers'),
('home_cta_title', 'Ready to begin your champion story?'),
('home_cta_text', 'Book a free trial session this week. Limited spots available.'),
('home_cta_button', 'Book free trial'),
('about_label', 'EST. 2007'),
('about_title', 'About Achievers Gymnastics Academy'),
('about_intro', 'Nagpur’s most decorated gymnastics academy. Where every child discovers their inner champion.'),
('about_philosophy_title', 'Our philosophy'),
('about_philosophy_text', 'We believe gymnastics is more than a sport. It is a powerful vehicle for building discipline, confidence, resilience and physical excellence. Every child who walks through our doors is treated as a future champion, regardless of their starting point.'),
('about_cta_label', 'START YOUR JOURNEY'),
('about_cta_title', 'One free trial session can change everything.'),
('about_cta_button', 'Book your free trial'),
('courses_label', 'PROGRAMS'),
('courses_title', 'Our training programs'),
('courses_intro', 'From beginner foundations to elite competition preparation. Choose the perfect path for your child.'),
('courses_apparatus_label', 'GYMNASTICS DISCIPLINES'),
('courses_apparatus_title', 'Apparatus, organised by discipline and gender'),
('courses_apparatus_intro', 'Explore the equipment used in our artistic gymnastics pathways.')
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value);
