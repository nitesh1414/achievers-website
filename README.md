# Achievers Gymnastics Academy CMS

A responsive Core PHP + MySQL website and content management system for Achievers Gymnastics Academy, Nagpur.

## Corporate website update

The current build includes:

- **Brighter, image-led hero slider** with an admin checkbox to show or hide banner text.
- A shared **Mission & Vision** module on both Home and About pages, including admin-managed copy and images.
- Modern, high-contrast, keyboard and touch-friendly **testimonials carousel**.
- Course cards with **no fees shown** anywhere in the public site or Courses manager.
- **Disciplines & Apparatus** management, seeded with Gymnastics plus gender-wise WAG and MAG apparatus lists.
- **Page Content** management with template-safe character limits for shared and page-level copy.
- Dynamic social media links (Facebook, Instagram, LinkedIn, WhatsApp, YouTube and more) managed in the admin panel.
- A fixed WhatsApp button on every public page, positioned at 20% from the top on the right.
- Global CSS and JavaScript assets; no inline or per-page CSS.

## Installation

### New installation

```bash
mysql -u root -p < sql/schema.sql
mysql -u root -p achievers_cms < sql/seed_data.sql
```

Or use the single fresh-install file (it **drops and recreates** the database):

```bash
mysql -u root -p < sql/combined_schema_seed.sql
```

Configure MySQL credentials in `includes/db.php` before serving the site. The default development login is `admin` / `admin123`; change it immediately on a production system.

### Existing installation upgrade

Back up the `achievers_cms` database, then run:

```bash
mysql -u root -p achievers_cms < sql/upgrade_20260909_corporate_cms.sql
```

This adds banner content visibility, disciplines and apparatus without deleting existing course records.

## Content workflow

| Need to update | Admin screen |
| --- | --- |
| Shared copy, page headings, Mission & Vision images/text | **Page Content** |
| Hero image, headline, position, text visibility | **Banners** |
| Program title, description, syllabus, duration, image | **Courses** |
| Course group labels | **Course Categories** |
| Gymnastics disciplines and gender-wise apparatus | **Disciplines & Apparatus** |
| Parent/athlete reviews and photos | **Testimonials** |
| Facebook, Instagram, LinkedIn, WhatsApp, YouTube and other social links | **Social Media** |
| WhatsApp number, logo, address, SEO and map | **Website Settings** |

Gallery, mentors, team members, achievers, competitions and notices are managed through their matching admin modules. All Page Content fields include a character limit appropriate to the template, protecting the layout on smaller screens.

## Project layout

```text
admin/                  Admin CMS modules
assets/css/style.css    Global design system
assets/js/site.js       Shared public interactions
includes/               Database, shared UI and CMS helpers
sql/                    Fresh schema, seed data and upgrade script
uploads/                Admin-uploaded files
```

## Local routing

The site is designed to be served from the repository root with PHP and MySQL available. Clean URL rewrites are available in `.htaccess`, while all canonical links use their `.php` filenames for predictable local use.
