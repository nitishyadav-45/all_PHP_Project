
CREATE DATABASE IF NOT EXISTS `portfolio_db`;
USE `portfolio_db`;

-- Table for User/Admin Information
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `title` VARCHAR(255),
    `description` TEXT,
    `profile_image` VARCHAR(255),
    `about_image` VARCHAR(255),
    `about_content_short` TEXT,
    `about_content_long` TEXT,
    `projects_done` INT DEFAULT 0,
    `happy_clients` INT DEFAULT 0,
    `years_experience` INT DEFAULT 0,
    `location` VARCHAR(255),
    `phone` VARCHAR(50),
    `working_hours` VARCHAR(255),
    `facebook_link` VARCHAR(255),
    `twitter_link` VARCHAR(255),
    `instagram_link` VARCHAR(255),
    `linkedin_link` VARCHAR(255),
    `github_link` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Services
CREATE TABLE IF NOT EXISTS `services` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `icon_class` VARCHAR(255),
    `description` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Skills
CREATE TABLE IF NOT EXISTS `skills` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `percentage` INT NOT NULL CHECK (`percentage` >= 0 AND `percentage` <= 100),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Project Categories
CREATE TABLE IF NOT EXISTS `project_categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL UNIQUE,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Projects
CREATE TABLE IF NOT EXISTS `projects` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `image` VARCHAR(255),
    `live_link` VARCHAR(255),
    `github_link` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`category_id`) REFERENCES `project_categories`(`id`) ON DELETE SET NULL
);

-- Table for Testimonials
CREATE TABLE IF NOT EXISTS `testimonials` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `client_name` VARCHAR(255) NOT NULL,
    `client_title` VARCHAR(255),
    `client_image` VARCHAR(255),
    `rating` INT NOT NULL CHECK (`rating` >= 1 AND `rating` <= 5),
    `quote` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Contact Messages
CREATE TABLE IF NOT EXISTS `contact_messages` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `subject` VARCHAR(255),
    `message` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for Newsletter Subscribers
CREATE TABLE IF NOT EXISTS `subscribers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `subscribed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
