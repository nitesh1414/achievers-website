-- Achievers Academy corporate CMS upgrade — 2026-09-09
-- Back up the database, then run once:
-- mysql -u root -p achievers_cms < sql/upgrade_20260909_corporate_cms.sql

USE achievers_cms;

CREATE TABLE IF NOT EXISTS disciplines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description VARCHAR(500),
    image VARCHAR(255),
    sort_order INT DEFAULT 0,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

SET @has_show_content := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'banners' AND COLUMN_NAME = 'show_content');
SET @show_content_sql := IF(@has_show_content = 0, 'ALTER TABLE banners ADD COLUMN show_content TINYINT(1) NOT NULL DEFAULT 1 AFTER link_url', 'SELECT 1');
PREPARE show_content_stmt FROM @show_content_sql;
EXECUTE show_content_stmt;
DEALLOCATE PREPARE show_content_stmt;

SET @has_discipline_id := (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'courses' AND COLUMN_NAME = 'discipline_id');
SET @discipline_id_sql := IF(@has_discipline_id = 0, 'ALTER TABLE courses ADD COLUMN discipline_id INT NULL AFTER category_id', 'SELECT 1');
PREPARE discipline_id_stmt FROM @discipline_id_sql;
EXECUTE discipline_id_stmt;
DEALLOCATE PREPARE discipline_id_stmt;

CREATE TABLE IF NOT EXISTS apparatus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    discipline_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    gender ENUM('Women','Men','Mixed') NOT NULL DEFAULT 'Mixed',
    description VARCHAR(255),
    sort_order INT DEFAULT 0,
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_apparatus_discipline FOREIGN KEY (discipline_id) REFERENCES disciplines(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS mentors (
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

CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(150),
    quote VARCHAR(600) NOT NULL,
    rating TINYINT(1) DEFAULT 5,
    photo VARCHAR(255),
    status ENUM('active','inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add the course relation only if it was not created automatically by a newer schema.
SET @has_course_fk := (SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = DATABASE() AND TABLE_NAME = 'courses' AND CONSTRAINT_NAME = 'fk_courses_discipline');
SET @course_fk_sql := IF(@has_course_fk = 0, 'ALTER TABLE courses ADD CONSTRAINT fk_courses_discipline FOREIGN KEY (discipline_id) REFERENCES disciplines(id) ON DELETE SET NULL', 'SELECT 1');
PREPARE course_fk_stmt FROM @course_fk_sql;
EXECUTE course_fk_stmt;
DEALLOCATE PREPARE course_fk_stmt;

INSERT INTO disciplines (name, slug, description, image, sort_order, status)
SELECT 'Gymnastics', 'gymnastics', 'Artistic gymnastics pathways built around confidence, technique and safe progressions.', 'assets/images/hero-facility.jpg', 1, 'active'
WHERE NOT EXISTS (SELECT 1 FROM disciplines WHERE slug = 'gymnastics');

SET @gymnastics_id := (SELECT id FROM disciplines WHERE slug = 'gymnastics' LIMIT 1);
UPDATE courses SET discipline_id = @gymnastics_id WHERE discipline_id IS NULL;

INSERT INTO apparatus (discipline_id, name, gender, description, sort_order, status)
SELECT @gymnastics_id, item_name, item_gender, item_description, item_sort, 'active'
FROM (
    SELECT 'Vault' AS item_name, 'Women' AS item_gender, 'WAG apparatus' AS item_description, 1 AS item_sort UNION ALL
    SELECT 'Uneven Bars', 'Women', 'WAG apparatus', 2 UNION ALL
    SELECT 'Balance Beam', 'Women', 'WAG apparatus', 3 UNION ALL
    SELECT 'Floor Exercise', 'Women', 'WAG apparatus', 4 UNION ALL
    SELECT 'Floor Exercise', 'Men', 'MAG apparatus', 1 UNION ALL
    SELECT 'Pommel Horse', 'Men', 'MAG apparatus', 2 UNION ALL
    SELECT 'Still Rings', 'Men', 'MAG apparatus', 3 UNION ALL
    SELECT 'Vault', 'Men', 'MAG apparatus', 4 UNION ALL
    SELECT 'Parallel Bars', 'Men', 'MAG apparatus', 5 UNION ALL
    SELECT 'Horizontal Bar', 'Men', 'MAG apparatus', 6
) AS apparatus_seed
WHERE NOT EXISTS (
    SELECT 1 FROM apparatus existing_item
    WHERE existing_item.discipline_id = @gymnastics_id
      AND existing_item.name = apparatus_seed.item_name
      AND existing_item.gender = apparatus_seed.item_gender
);

INSERT INTO social_links (platform, url, icon, is_active, sort_order)
SELECT 'YouTube', 'https://youtube.com/', 'youtube', 1, 5
WHERE NOT EXISTS (SELECT 1 FROM social_links WHERE LOWER(icon) IN ('youtube', 'yt'));

INSERT INTO settings (setting_key, setting_value) VALUES
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
('footer_description', 'Nagpur’s gymnastics academy for disciplined, confident and resilient athletes.'),
('whatsapp_message', 'Hi Achievers Academy, I would like to know more.'),
('whatsapp_float_label', 'Chat with Achievers Academy on WhatsApp')
ON DUPLICATE KEY UPDATE setting_value = setting_value;

-- Remove the retired federation wording from the default CMS copy and seeded facility banner.
-- Existing custom copy is left unchanged unless it is exactly the retired default.
UPDATE settings
SET setting_value = 'Athlete-first coaching that meets every athlete at their level.'
WHERE setting_key = 'home_why_1_text'
  AND setting_value = CONCAT(CHAR(70,73,71), '-informed coaching that meets every athlete at their level.');

UPDATE banners
SET subtitle = REPLACE(subtitle, CONCAT(CHAR(70,73,71), '-standard'), 'Competition-ready')
WHERE INSTR(subtitle, CONCAT(CHAR(70,73,71), '-standard')) > 0;
