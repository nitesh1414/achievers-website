-- ============================================================
-- ACHIEVERS GYMNASTICS ACADEMY - COMPLETE DATABASE
-- Single file: Schema + All Seed Data + Banners
-- Run: mysql -u root -p < combined_schema_seed.sql
-- ============================================================

DROP DATABASE IF EXISTS achievers_cms;
CREATE DATABASE achievers_cms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE achievers_cms;

-- ============================================
-- TABLES
-- ============================================

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    full_name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE banners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255),
    image VARCHAR(255) NOT NULL,
    link_url VARCHAR(255),
    sort_order INT DEFAULT 0,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE course_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    icon VARCHAR(100),
    status ENUM('active','inactive') DEFAULT 'active'
);

CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    description TEXT,
    syllabus TEXT,
    duration VARCHAR(100),
    fees DECIMAL(10,2),
    thumbnail VARCHAR(255),
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES course_categories(id) ON DELETE SET NULL
);

CREATE TABLE inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    course_id INT NULL,
    message TEXT,
    status ENUM('Pending','Contacted','Enrolled','Closed') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL
);

-- Mentors (was Faculty)
CREATE TABLE faculty (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    designation VARCHAR(150),
    bio TEXT,
    photo VARCHAR(255),
    specialties VARCHAR(255),
    experience_years INT DEFAULT 0,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE competitions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    event_date DATE,
    type ENUM('future','past') DEFAULT 'future',
    location VARCHAR(150),
    description TEXT,
    how_to_apply TEXT,
    results TEXT,
    image VARCHAR(255),
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    event_date DATE,
    description TEXT,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE toppers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    rank VARCHAR(50),
    year YEAR,
    achievement TEXT,
    photo VARCHAR(255),
    course VARCHAR(150),
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE notices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    file_path VARCHAR(255),
    publish_date DATE,
    status ENUM('published','unpublished') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Social Media Management
CREATE TABLE social_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    platform VARCHAR(50) NOT NULL,
    url VARCHAR(255) NOT NULL,
    icon VARCHAR(50),
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0
);

-- ============================================
-- SEED DATA
-- ============================================

-- Admin
INSERT INTO admins (username, password, email, full_name) VALUES 
('admin', '', 'admin@achieversacademy.com', 'Admin User');

-- Course Categories
INSERT INTO course_categories (name, slug, description, icon) VALUES 
('Beginner Programs', 'beginner-programs', 'Foundation level gymnastics for ages 5-8.', 'child'),
('Intermediate Training', 'intermediate-training', 'Skill development for ages 8-12.', 'school'),
('Elite Competitive', 'elite-competitive', 'Advanced training for national level.', 'trophy'),
('Specialized Camps', 'specialized-camps', 'Holiday and summer intensive programs.', 'calendar');

-- Courses
INSERT INTO courses (category_id, title, slug, description, syllabus, duration, fees, thumbnail, status) VALUES 
(1, 'Little Champions (Ages 5-7)', 'little-champions', 'Introductory gymnastics program focused on fun, balance and coordination.', 'Floor basics, Balance beam, Vault fundamentals', '8 weeks', 4500.00, 'assets/images/course-little.jpg', 'active'),
(2, 'Rising Stars (Ages 8-11)', 'rising-stars', 'Builds strength, flexibility and apparatus skills.', 'Core tumbling, Beam & bars, Strength & conditioning', '12 weeks', 6500.00, 'assets/images/course-rising.jpg', 'active'),
(3, 'National Prep Squad', 'national-prep-squad', 'Intensive training for national and state competitions.', 'Advanced routines, Competition simulation, Mental training', 'Ongoing', 12500.00, 'assets/images/course-national.jpg', 'active'),
(1, 'Free Trial Class', 'free-trial', 'One complimentary session to experience our facility.', 'Full assessment + fun session', '1 class', 0.00, 'assets/images/course-trial.jpg', 'active');

-- 5 Beautiful Banners
INSERT INTO banners (title, subtitle, image, link_url, sort_order, status) VALUES 
('Train Like a Champion', 'Under International Coach Pankaj Kunde — Nagpur\'s most decorated gymnastics academy', 'assets/images/hero-main.jpg', 'courses', 1, 'active'),
('World-Class Facility', 'FIG-standard apparatus • Sprung floors • Olympic-grade safety', 'assets/images/hero-facility.jpg', 'about', 2, 'active'),
('Enroll for 2026 Season', 'Limited slots available. Start with a FREE TRIAL today!', 'assets/images/hero-enroll.jpg', 'admissions', 3, 'active'),
('Join Our Champions', 'Build strength, discipline & confidence. Ages 5–18 welcome', 'assets/images/hero-main.jpg', 'achievements', 4, 'active'),
('Free Trial This Week', 'Experience world-class coaching. Book your slot now', 'assets/images/hero-facility.jpg', 'admissions', 5, 'active');

-- Mentors (formerly Faculty)
INSERT INTO faculty (name, designation, bio, photo, specialties, experience_years, status) VALUES 
('Pankaj Kunde', 'Founder & International Head Coach', 'Trained under international standards. 18+ years experience coaching gymnasts to national and international medals. FIG certified.', 'assets/images/faculty-pankaj.jpg', 'Artistic Gymnastics, Floor, Vault, Beam', 18, 'active'),
('Neha Rao', 'Senior Coach - Beam & Floor', 'Former national level gymnast. Specializes in women\'s artistic gymnastics and flexibility training.', 'assets/images/faculty-neha.jpg', 'Balance Beam, Floor Exercise, Flexibility', 9, 'active'),
('Rahul Deshpande', 'Assistant Coach - Strength & Vault', 'Certified strength and conditioning coach with deep knowledge of gymnastics conditioning.', 'assets/images/faculty-rahul.jpg', 'Vault, Strength Training, Tumbling', 6, 'active');

-- Inquiries
INSERT INTO inquiries (name, phone, email, course_id, message, status) VALUES 
('Aarav Sharma Parent', '9876543210', 'priya.sharma@email.com', 1, 'Interested in Little Champions for my son Aarav (6 yrs).', 'Enrolled'),
('Riya Deshmukh', '9823456789', 'rajesh.deshmukh@email.com', 3, 'My daughter wants to join the Elite program.', 'Contacted');

-- Social Media
INSERT INTO social_links (platform, url, icon, is_active, sort_order) VALUES 
('Instagram', 'https://www.instagram.com/achieversgymnasticacademy/', 'instagram', 1, 1),
('WhatsApp', 'https://wa.me/919096594552', 'whatsapp', 1, 2),
('Facebook', 'https://facebook.com/achieversgymnasticacademy', 'facebook', 1, 3),
('LinkedIn', 'https://linkedin.com/company/achievers-gymnastics', 'linkedin', 1, 4);

-- Settings
INSERT INTO settings (setting_key, setting_value) VALUES 
('site_name', 'Achievers Gymnastics Academy'),
('tagline', 'Train Like a Champion | Nagpur\'s #1 Gymnastics Academy'),
('phone', '+91 90965 94552'),
('whatsapp', '919096594552'),
('email', 'info@achieversacademy.com'),
('address', 'Plot No. 45, Wardhaman Nagar, Nagpur - 440008'),
('instagram', 'https://www.instagram.com/achieversgymnasticacademy/'),
('facebook', 'https://facebook.com/achieversgymnasticacademy'),
('linkedin', 'https://linkedin.com/company/achievers-gymnastics'),
('meta_title', 'Achievers Gymnastics Academy | Best Gymnastics in Nagpur'),
('meta_description', 'Nagpur\'s #1 gymnastics academy under Coach Pankaj Kunde. 250+ medals. FIG-standard facility.'),
('active_students', '400+'),
('medals_won', '250+'),
('years_experience', '18');

-- Toppers & other data (abbreviated for brevity)
INSERT INTO toppers (name, rank, year, achievement, photo, course, status) VALUES 
('Aarav Sharma', 'National Gold', 2024, 'National Gymnastics Championship - Floor', 'assets/images/topper-aarav.jpg', 'National Prep Squad', 'active'),
('Riya Deshmukh', 'Asian Silver', 2024, 'Asian Junior - Beam', 'assets/images/topper-riya.jpg', 'Elite Competitive', 'active');

INSERT INTO gallery (title, image, category, event_date, status) VALUES 
('National Gold - Aarav 2024', 'assets/images/gallery-aarav.jpg', 'Competition', '2024-11-15', 'active'),
('Facility - FIG Apparatus', 'assets/images/gallery-facility.jpg', 'Facility', '2025-02-01', 'active');

-- ============================================
-- INDEXES
-- ============================================
CREATE INDEX idx_inquiries_status ON inquiries(status);
CREATE INDEX idx_courses_slug ON courses(slug);
CREATE INDEX idx_banners_sort ON banners(sort_order);