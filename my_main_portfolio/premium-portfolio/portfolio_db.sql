-- Premium Portfolio Website Database Export
-- Import this file into MySQL, then visit /admin/login.php to create the first admin account.

CREATE DATABASE IF NOT EXISTS `my_portfolio_db`
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `my_portfolio_db`;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `site_views`;
DROP TABLE IF EXISTS `messages`;
DROP TABLE IF EXISTS `projects`;
DROP TABLE IF EXISTS `profile_settings`;
DROP TABLE IF EXISTS `admins`;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `admins` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(60) NOT NULL,
    `email` VARCHAR(160) NOT NULL,
    `display_name` VARCHAR(120) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `avatar_path` VARCHAR(255) DEFAULT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `last_login_at` DATETIME DEFAULT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `admins_username_unique` (`username`),
    UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `profile_settings` (
    `id` TINYINT UNSIGNED NOT NULL DEFAULT 1,
    `full_name` VARCHAR(120) NOT NULL,
    `headline` VARCHAR(160) NOT NULL,
    `tagline` VARCHAR(220) NOT NULL,
    `bio` TEXT NOT NULL,
    `email` VARCHAR(160) NOT NULL,
    `phone` VARCHAR(60) DEFAULT NULL,
    `location` VARCHAR(120) DEFAULT NULL,
    `website` VARCHAR(255) DEFAULT NULL,
    `cv_path` VARCHAR(255) DEFAULT NULL,
    `avatar_path` VARCHAR(255) DEFAULT NULL,
    `linkedin_url` VARCHAR(255) DEFAULT NULL,
    `github_url` VARCHAR(255) DEFAULT NULL,
    `x_url` VARCHAR(255) DEFAULT NULL,
    `instagram_url` VARCHAR(255) DEFAULT NULL,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `projects` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(180) NOT NULL,
    `slug` VARCHAR(220) NOT NULL,
    `category` VARCHAR(100) NOT NULL,
    `short_description` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `technologies` VARCHAR(255) DEFAULT NULL,
    `image_path` VARCHAR(255) DEFAULT NULL,
    `project_url` VARCHAR(255) DEFAULT NULL,
    `github_url` VARCHAR(255) DEFAULT NULL,
    `is_featured` TINYINT(1) NOT NULL DEFAULT 0,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `projects_slug_unique` (`slug`),
    KEY `projects_status_order_index` (`is_active`, `is_featured`, `sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `messages` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(120) NOT NULL,
    `email` VARCHAR(160) NOT NULL,
    `subject` VARCHAR(180) NOT NULL,
    `message` TEXT NOT NULL,
    `ip_address` VARCHAR(64) DEFAULT NULL,
    `user_agent` VARCHAR(255) DEFAULT NULL,
    `is_read` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `messages_read_created_index` (`is_read`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `site_views` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `ip_hash` CHAR(64) NOT NULL,
    `page` VARCHAR(120) NOT NULL DEFAULT 'home',
    `user_agent` VARCHAR(255) DEFAULT NULL,
    `viewed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `site_views_page_date_index` (`page`, `viewed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `profile_settings`
    (`id`, `full_name`, `headline`, `tagline`, `bio`, `email`, `phone`, `location`, `website`, `cv_path`, `avatar_path`, `linkedin_url`, `github_url`, `x_url`, `instagram_url`)
VALUES
    (1,
     'Alex Morgan',
     'Full-Stack Web Developer',
     'I build fast, elegant, and scalable digital experiences for ambitious teams.',
     'I am a full-stack web developer focused on polished user interfaces, secure PHP/MySQL backends, and dashboards that are pleasant to use every day. I care about performance, maintainability, accessibility, and the tiny interaction details that make a product feel premium.',
     'hello@example.com',
     '+1 555 0189',
     'Remote / Worldwide',
     'https://example.com',
     '',
     'assets/images/profile-portrait.png',
     'https://www.linkedin.com/',
     'https://github.com/',
     'https://x.com/',
     'https://www.instagram.com/');

INSERT INTO `projects`
    (`title`, `slug`, `category`, `short_description`, `description`, `technologies`, `image_path`, `project_url`, `github_url`, `is_featured`, `is_active`, `sort_order`)
VALUES
    ('SaaS Analytics Dashboard',
     'saas-analytics-dashboard',
     'Dashboard',
     'A responsive KPI dashboard with realtime-feeling cards, filters, and clean data visualization.',
     'Designed and developed a SaaS analytics dashboard focused on executive visibility, fast scanning, and repeat daily workflows. The project includes responsive layouts, authenticated admin screens, message handling, and a polished visual system.',
     'PHP, MySQL, Bootstrap, JavaScript',
     'assets/images/projects/project-1.png',
     'https://example.com',
     'https://github.com/',
     1,
     1,
     1),
    ('Luxury Ecommerce Store',
     'luxury-ecommerce-store',
     'Ecommerce',
     'A conversion-focused storefront concept with refined product cards and mobile-first browsing.',
     'Built a premium ecommerce interface with strong product hierarchy, smooth transitions, responsive product grids, and clear purchase paths. Backend-ready patterns make it easy to connect product and order data.',
     'HTML5, CSS3, Bootstrap, JavaScript',
     'assets/images/projects/project-2.png',
     'https://example.com',
     'https://github.com/',
     1,
     1,
     2),
    ('Agency Portfolio Platform',
     'agency-portfolio-platform',
     'Brand Website',
     'A polished agency website with animated sections, project storytelling, and a secure contact flow.',
     'Created a brand-forward website system for presenting services, case studies, and inbound leads. The contact form saves messages to MySQL and supports email notification through the hosting server mail configuration.',
     'PHP, MySQL, AOS, FontAwesome',
     'assets/images/projects/project-3.png',
     'https://example.com',
     'https://github.com/',
     0,
     1,
     3);

