<?php
/**
 * Editable copy used by the Page Content screen.
 *
 * Each field defines the maximum space available in its template. Values are
 * stored in the existing settings table and are always escaped at render time.
 */
return [
    "mission_vision" => [
        "label" => "Mission & Vision",
        "description" => "Shown on both the Home and About pages.",
        "fields" => [
            [
                "key" => "mission_label",
                "label" => "Mission eyebrow",
                "type" => "text",
                "max" => 35,
                "default" => "OUR MISSION",
            ],
            [
                "key" => "mission_vision_section_title",
                "label" => "Mission and vision section title",
                "type" => "text",
                "max" => 100,
                "default" => "The purpose behind every practice",
            ],
            [
                "key" => "mission_title",
                "label" => "Mission title",
                "type" => "text",
                "max" => 100,
                "default" => "Building champions in body, mind and character",
            ],
            [
                "key" => "mission_content",
                "label" => "Mission description",
                "type" => "textarea",
                "max" => 420,
                "rows" => 4,
                "default" =>
                    "We give every child the opportunity to discover their inner champion through safe, structured and world-class gymnastics training.",
            ],
            [
                "key" => "mission_image",
                "label" => "Mission image",
                "type" => "image",
                "default" => "assets/images/hero-main.jpg",
            ],
            [
                "key" => "mission_image_alt",
                "label" => "Mission image alternative text",
                "type" => "text",
                "max" => 110,
                "default" => "Young gymnast training with a coach",
            ],
            [
                "key" => "vision_label",
                "label" => "Vision eyebrow",
                "type" => "text",
                "max" => 35,
                "default" => "OUR VISION",
            ],
            [
                "key" => "vision_title",
                "label" => "Vision title",
                "type" => "text",
                "max" => 100,
                "default" => "A confident generation that rises higher",
            ],
            [
                "key" => "vision_content",
                "label" => "Vision description",
                "type" => "textarea",
                "max" => 420,
                "rows" => 4,
                "default" =>
                    "To be the most trusted gymnastics academy in central India, developing disciplined, resilient athletes and thoughtful leaders for life.",
            ],
            [
                "key" => "vision_image",
                "label" => "Vision image",
                "type" => "image",
                "default" => "assets/images/hero-facility.jpg",
            ],
            [
                "key" => "vision_image_alt",
                "label" => "Vision image alternative text",
                "type" => "text",
                "max" => 110,
                "default" => "Gymnast performing in the academy",
            ],
        ],
    ],
    "home" => [
        "label" => "Home Page",
        "description" =>
            "Home page headings, value cards and call to action. Hero slides are managed separately in Banners.",
        "fields" => [
            [
                "key" => "hero_default_text",
                "label" => "Fallback hero description",
                "type" => "textarea",
                "max" => 180,
                "rows" => 2,
                "default" =>
                    "A confident, disciplined future starts with safe, world-class gymnastics training.",
            ],
            [
                "key" => "home_competitions_label",
                "label" => "Competition ticker label",
                "type" => "text",
                "max" => 25,
                "default" => "COMPETITIONS",
            ],
            [
                "key" => "home_why_label",
                "label" => "Why section eyebrow",
                "type" => "text",
                "max" => 35,
                "default" => "WHY ACHIEVERS?",
            ],
            [
                "key" => "home_why_title",
                "label" => "Why section title",
                "type" => "text",
                "max" => 80,
                "default" => "Built to build champions",
            ],
            [
                "key" => "home_why_1_icon",
                "label" => "Value 1 icon",
                "type" => "text",
                "max" => 12,
                "default" => "🥇",
            ],
            [
                "key" => "home_why_1_title",
                "label" => "Value 1 title",
                "type" => "text",
                "max" => 45,
                "default" => "International coaching",
            ],
            [
                "key" => "home_why_1_text",
                "label" => "Value 1 description",
                "type" => "textarea",
                "max" => 180,
                "rows" => 2,
                "default" =>
                    "FIG-informed coaching that meets every athlete at their level.",
            ],
            [
                "key" => "home_why_2_icon",
                "label" => "Value 2 icon",
                "type" => "text",
                "max" => 12,
                "default" => "🏆",
            ],
            [
                "key" => "home_why_2_title",
                "label" => "Value 2 title",
                "type" => "text",
                "max" => 45,
                "default" => "Proven results",
            ],
            [
                "key" => "home_why_2_text",
                "label" => "Value 2 description",
                "type" => "textarea",
                "max" => 180,
                "rows" => 2,
                "default" =>
                    "A pathway built on strong fundamentals, confidence and competitive excellence.",
            ],
            [
                "key" => "home_why_3_icon",
                "label" => "Value 3 icon",
                "type" => "text",
                "max" => 12,
                "default" => "🛡️",
            ],
            [
                "key" => "home_why_3_title",
                "label" => "Value 3 title",
                "type" => "text",
                "max" => 45,
                "default" => "Safe and supportive",
            ],
            [
                "key" => "home_why_3_text",
                "label" => "Value 3 description",
                "type" => "textarea",
                "max" => 180,
                "rows" => 2,
                "default" =>
                    "A positive, professionally equipped environment where every child belongs.",
            ],
            [
                "key" => "home_programs_label",
                "label" => "Programs eyebrow",
                "type" => "text",
                "max" => 35,
                "default" => "PROGRAMS",
            ],
            [
                "key" => "home_programs_title",
                "label" => "Programs title",
                "type" => "text",
                "max" => 80,
                "default" => "Our training programs",
            ],
            [
                "key" => "home_achievers_label",
                "label" => "Achievers eyebrow",
                "type" => "text",
                "max" => 45,
                "default" => "CHAMPIONS MADE HERE",
            ],
            [
                "key" => "home_achievers_title",
                "label" => "Achievers title",
                "type" => "text",
                "max" => 80,
                "default" => "Our star achievers",
            ],
            [
                "key" => "home_cta_title",
                "label" => "CTA title",
                "type" => "text",
                "max" => 90,
                "default" => "Ready to begin your champion story?",
            ],
            [
                "key" => "home_cta_text",
                "label" => "CTA description",
                "type" => "textarea",
                "max" => 180,
                "rows" => 2,
                "default" =>
                    "Book a free trial session this week. Limited spots available.",
            ],
            [
                "key" => "home_cta_button",
                "label" => "CTA button",
                "type" => "text",
                "max" => 35,
                "default" => "Book free trial",
            ],
        ],
    ],
    "about" => [
        "label" => "About Page",
        "description" =>
            "About page introduction, philosophy and call to action.",
        "fields" => [
            [
                "key" => "about_label",
                "label" => "Page eyebrow",
                "type" => "text",
                "max" => 35,
                "default" => "EST. 2007",
            ],
            [
                "key" => "about_title",
                "label" => "Page title",
                "type" => "text",
                "max" => 80,
                "default" => "About Achievers Gymnastics Academy",
            ],
            [
                "key" => "about_intro",
                "label" => "Introduction",
                "type" => "textarea",
                "max" => 220,
                "rows" => 3,
                "default" =>
                    "Nagpur's most decorated gymnastics academy. Where every child discovers their inner champion.",
            ],
            [
                "key" => "about_philosophy_title",
                "label" => "Philosophy title",
                "type" => "text",
                "max" => 60,
                "default" => "Our philosophy",
            ],
            [
                "key" => "about_philosophy_text",
                "label" => "Philosophy description",
                "type" => "textarea",
                "max" => 650,
                "rows" => 5,
                "default" =>
                    "We believe gymnastics is more than a sport. It is a powerful vehicle for building discipline, confidence, resilience and physical excellence. Every child who walks through our doors is treated as a future champion, regardless of their starting point.",
            ],
            [
                "key" => "about_cta_label",
                "label" => "CTA eyebrow",
                "type" => "text",
                "max" => 35,
                "default" => "START YOUR JOURNEY",
            ],
            [
                "key" => "about_cta_title",
                "label" => "CTA title",
                "type" => "text",
                "max" => 90,
                "default" => "One free trial session can change everything.",
            ],
            [
                "key" => "about_cta_button",
                "label" => "CTA button",
                "type" => "text",
                "max" => 35,
                "default" => "Book your free trial",
            ],
        ],
    ],
    "courses" => [
        "label" => "Courses Page",
        "description" =>
            "Courses page headings and apparatus section copy. Courses, disciplines and apparatus are managed in their own screens.",
        "fields" => [
            [
                "key" => "courses_label",
                "label" => "Page eyebrow",
                "type" => "text",
                "max" => 35,
                "default" => "PROGRAMS",
            ],
            [
                "key" => "courses_title",
                "label" => "Page title",
                "type" => "text",
                "max" => 80,
                "default" => "Our training programs",
            ],
            [
                "key" => "courses_intro",
                "label" => "Introduction",
                "type" => "textarea",
                "max" => 220,
                "rows" => 3,
                "default" =>
                    "From beginner foundations to elite competition preparation. Choose the perfect path for your child.",
            ],
            [
                "key" => "courses_apparatus_label",
                "label" => "Apparatus eyebrow",
                "type" => "text",
                "max" => 45,
                "default" => "GYMNASTICS DISCIPLINES",
            ],
            [
                "key" => "courses_apparatus_title",
                "label" => "Apparatus title",
                "type" => "text",
                "max" => 100,
                "default" => "Apparatus, organised by discipline and gender",
            ],
            [
                "key" => "courses_apparatus_intro",
                "label" => "Apparatus description",
                "type" => "textarea",
                "max" => 260,
                "rows" => 3,
                "default" =>
                    "Explore the equipment used in our artistic gymnastics pathways.",
            ],
        ],
    ],
    "achievements" => [
        "label" => "Achievements Page",
        "description" =>
            "Achievement page headings. Champion profiles and competitions are managed in their modules.",
        "fields" => [
            [
                "key" => "achievements_label",
                "label" => "Page eyebrow",
                "type" => "text",
                "max" => 35,
                "default" => "CHAMPIONS",
            ],
            [
                "key" => "achievements_title",
                "label" => "Page title",
                "type" => "text",
                "max" => 80,
                "default" => "Our achievers and results",
            ],
            [
                "key" => "achievements_intro",
                "label" => "Introduction",
                "type" => "textarea",
                "max" => 220,
                "rows" => 3,
                "default" =>
                    "Proudly showcasing the success of our athletes across national and international platforms.",
            ],
            [
                "key" => "achievements_medalists_title",
                "label" => "Medalists title",
                "type" => "text",
                "max" => 55,
                "default" => "Recent medalists",
            ],
            [
                "key" => "achievements_competitions_title",
                "label" => "Competitions title",
                "type" => "text",
                "max" => 55,
                "default" => "Competitions and events",
            ],
        ],
    ],
    "mentors" => [
        "label" => "Mentors Page",
        "description" =>
            "Mentor page headings. Team profiles and photos are managed in Mentors.",
        "fields" => [
            [
                "key" => "mentors_title",
                "label" => "Page title",
                "type" => "text",
                "max" => 70,
                "default" => "Our expert mentors",
            ],
            [
                "key" => "mentors_intro",
                "label" => "Introduction",
                "type" => "textarea",
                "max" => 240,
                "rows" => 3,
                "default" =>
                    "Led by an experienced coaching team, we help every student reach their full potential.",
            ],
        ],
    ],
    "gallery" => [
        "label" => "Gallery Page",
        "description" =>
            "Gallery heading. Images, titles, categories and descriptions are managed in Gallery.",
        "fields" => [
            [
                "key" => "gallery_title",
                "label" => "Page title",
                "type" => "text",
                "max" => 60,
                "default" => "Gallery",
            ],
            [
                "key" => "gallery_intro",
                "label" => "Introduction",
                "type" => "textarea",
                "max" => 200,
                "rows" => 3,
                "default" =>
                    "Moments from our training sessions, competitions and events.",
            ],
            [
                "key" => "gallery_empty_text",
                "label" => "Empty gallery message",
                "type" => "text",
                "max" => 120,
                "default" => "No images in this category yet.",
            ],
        ],
    ],
    "competitions" => [
        "label" => "Competitions Page",
        "description" =>
            "Competition list heading. Events, content and images are managed in Competitions.",
        "fields" => [
            [
                "key" => "competitions_label",
                "label" => "Page eyebrow",
                "type" => "text",
                "max" => 35,
                "default" => "OPPORTUNITIES",
            ],
            [
                "key" => "competitions_title",
                "label" => "Page title",
                "type" => "text",
                "max" => 60,
                "default" => "Competitions",
            ],
            [
                "key" => "competitions_intro",
                "label" => "Introduction",
                "type" => "textarea",
                "max" => 190,
                "rows" => 3,
                "default" =>
                    "Upcoming and past events our gymnasts participate in.",
            ],
            [
                "key" => "competitions_empty_title",
                "label" => "Empty state title",
                "type" => "text",
                "max" => 90,
                "default" => "No competitions listed right now.",
            ],
            [
                "key" => "competitions_empty_text",
                "label" => "Empty state description",
                "type" => "text",
                "max" => 120,
                "default" => "Check back soon for upcoming events.",
            ],
        ],
    ],
    "admissions" => [
        "label" => "Admissions Page",
        "description" =>
            "Admissions page copy. Contact details are managed in Website Settings.",
        "fields" => [
            [
                "key" => "admissions_label",
                "label" => "Page eyebrow",
                "type" => "text",
                "max" => 35,
                "default" => "ENROLLMENT",
            ],
            [
                "key" => "admissions_title",
                "label" => "Page title",
                "type" => "text",
                "max" => 70,
                "default" => "Start your journey",
            ],
            [
                "key" => "admissions_intro",
                "label" => "Introduction",
                "type" => "textarea",
                "max" => 200,
                "rows" => 3,
                "default" =>
                    "Book a free trial class or enquire about our programs today.",
            ],
            [
                "key" => "admissions_trial_title",
                "label" => "Trial information title",
                "type" => "text",
                "max" => 55,
                "default" => "Free trial class",
            ],
            [
                "key" => "admissions_trial_text",
                "label" => "Trial information description",
                "type" => "textarea",
                "max" => 180,
                "rows" => 2,
                "default" =>
                    "One complimentary 60-minute session. Limited slots are available every week.",
            ],
        ],
    ],
    "contact" => [
        "label" => "Contact Page",
        "description" =>
            "Contact page headings and messaging. Contact information and social links are managed in Website Settings / Social Media.",
        "fields" => [
            [
                "key" => "contact_label",
                "label" => "Page eyebrow",
                "type" => "text",
                "max" => 35,
                "default" => "GET IN TOUCH",
            ],
            [
                "key" => "contact_title",
                "label" => "Page title",
                "type" => "text",
                "max" => 80,
                "default" => "Contact Achievers Academy",
            ],
            [
                "key" => "contact_intro",
                "label" => "Introduction",
                "type" => "textarea",
                "max" => 220,
                "rows" => 3,
                "default" =>
                    "We're here to answer your questions and help you get started on your gymnastics journey.",
            ],
            [
                "key" => "contact_form_title",
                "label" => "Form title",
                "type" => "text",
                "max" => 75,
                "default" => "Send us a quick message",
            ],
            [
                "key" => "contact_form_text",
                "label" => "Form description",
                "type" => "text",
                "max" => 120,
                "default" => "We'll get back to you within a few hours.",
            ],
            [
                "key" => "contact_cta_label",
                "label" => "CTA button",
                "type" => "text",
                "max" => 45,
                "default" => "Book a free trial class",
            ],
        ],
    ],
    "why_us" => [
        "label" => "Why Us Page",
        "description" => "Why Us page cards and call to action.",
        "fields" => [
            [
                "key" => "why_us_title",
                "label" => "Page title",
                "type" => "text",
                "max" => 80,
                "default" => "Why parents choose Achievers",
            ],
            [
                "key" => "why_us_1_title",
                "label" => "Card 1 title",
                "type" => "text",
                "max" => 55,
                "default" => "Proven track record",
            ],
            [
                "key" => "why_us_1_text",
                "label" => "Card 1 description",
                "type" => "textarea",
                "max" => 180,
                "rows" => 3,
                "default" =>
                    "Strong foundations, consistent coaching and a history of proud performances.",
            ],
            [
                "key" => "why_us_2_title",
                "label" => "Card 2 title",
                "type" => "text",
                "max" => 55,
                "default" => "International coaching",
            ],
            [
                "key" => "why_us_2_text",
                "label" => "Card 2 description",
                "type" => "textarea",
                "max" => 180,
                "rows" => 3,
                "default" =>
                    "Professional coaching standards that help athletes progress safely and confidently.",
            ],
            [
                "key" => "why_us_3_title",
                "label" => "Card 3 title",
                "type" => "text",
                "max" => 55,
                "default" => "A safe, equipped facility",
            ],
            [
                "key" => "why_us_3_text",
                "label" => "Card 3 description",
                "type" => "textarea",
                "max" => 180,
                "rows" => 3,
                "default" =>
                    "Thoughtful equipment, structured sessions and a culture that puts children first.",
            ],
            [
                "key" => "why_us_cta_label",
                "label" => "CTA button",
                "type" => "text",
                "max" => 55,
                "default" => "Start your free trial today",
            ],
        ],
    ],
    "competition_detail" => [
        "label" => "Competition Detail Page",
        "description" =>
            "Shared labels used on each competition detail page. Event-specific content and images are managed in Competitions.",
        "fields" => [
            [
                "key" => "competition_back_label",
                "label" => "Back link label",
                "type" => "text",
                "max" => 45,
                "default" => "Back to competitions",
            ],
            [
                "key" => "competition_about_label",
                "label" => "About section label",
                "type" => "text",
                "max" => 45,
                "default" => "About the event",
            ],
            [
                "key" => "competition_apply_label",
                "label" => "Participation section label",
                "type" => "text",
                "max" => 55,
                "default" => "How to apply / participate",
            ],
            [
                "key" => "competition_results_label",
                "label" => "Results section label",
                "type" => "text",
                "max" => 35,
                "default" => "Results",
            ],
            [
                "key" => "competition_contact_button",
                "label" => "Contact button",
                "type" => "text",
                "max" => 50,
                "default" => "Contact for more information",
            ],
        ],
    ],
    "notices" => [
        "label" => "Notices Page",
        "description" =>
            "Notices page heading. Notices and downloadable files are managed in Notices.",
        "fields" => [
            [
                "key" => "notices_title",
                "label" => "Page title",
                "type" => "text",
                "max" => 70,
                "default" => "Notices and downloads",
            ],
            [
                "key" => "notices_intro",
                "label" => "Introduction",
                "type" => "textarea",
                "max" => 190,
                "rows" => 3,
                "default" =>
                    "Latest announcements, schedules and important documents.",
            ],
            [
                "key" => "notices_empty_text",
                "label" => "Empty state message",
                "type" => "text",
                "max" => 100,
                "default" => "No published notices yet.",
            ],
        ],
    ],
    "not_found" => [
        "label" => "404 Page",
        "description" => "Not found page text.",
        "fields" => [
            [
                "key" => "not_found_title",
                "label" => "Page title",
                "type" => "text",
                "max" => 55,
                "default" => "Page not found",
            ],
            [
                "key" => "not_found_text",
                "label" => "Description",
                "type" => "textarea",
                "max" => 190,
                "rows" => 3,
                "default" =>
                    "Oops! The page you're looking for doesn't exist or has been moved.",
            ],
        ],
    ],
    "global" => [
        "label" => "Global Content",
        "description" => "Shared header, footer and WhatsApp button content.",
        "fields" => [
            [
                "key" => "footer_description",
                "label" => "Footer description",
                "type" => "textarea",
                "max" => 180,
                "rows" => 3,
                "default" =>
                    "Nagpur's gymnastics academy for disciplined, confident and resilient athletes.",
            ],
            [
                "key" => "footer_copyright",
                "label" => "Footer copyright organisation",
                "type" => "text",
                "max" => 80,
                "default" => "Achievers Gymnastics Academy",
            ],
            [
                "key" => "footer_developer_name",
                "label" => "Footer developer label",
                "type" => "text",
                "max" => 70,
                "default" => "Right Serve Infotech System Pvt. Ltd.",
            ],
            [
                "key" => "footer_developer_url",
                "label" => "Footer developer URL",
                "type" => "url",
                "max" => 255,
                "default" => "https://rightserveinfotechsystem.com/",
            ],
            [
                "key" => "whatsapp_message",
                "label" => "Pre-filled WhatsApp message",
                "type" => "text",
                "max" => 160,
                "default" => "Hi Achievers Academy, I would like to know more.",
            ],
            [
                "key" => "whatsapp_float_label",
                "label" => "Floating WhatsApp accessible label",
                "type" => "text",
                "max" => 80,
                "default" => "Chat with Achievers Academy on WhatsApp",
            ],
        ],
    ],
];
