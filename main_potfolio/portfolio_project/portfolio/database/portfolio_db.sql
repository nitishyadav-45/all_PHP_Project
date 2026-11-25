-- Database: portfolio_db
CREATE DATABASE IF NOT EXISTS main_portfolio_db;
USE main_portfolio_db;

-- Table for admin users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for personal profile
CREATE TABLE IF NOT EXISTS profile (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    title VARCHAR(255),
    about_me TEXT,
    profile_image VARCHAR(255),
    resume_file VARCHAR(255),
    email VARCHAR(100),
    phone VARCHAR(20),
    address TEXT,
    facebook VARCHAR(255),
    twitter VARCHAR(255),
    instagram VARCHAR(255),
    linkedin VARCHAR(255),
    github VARCHAR(255)
);

-- Table for skills
CREATE TABLE IF NOT EXISTS skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    skill_name VARCHAR(100),
    percentage INT,
    skill_category VARCHAR(50) -- e.g., Frontend, Backend, Tools
);

-- Table for services
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    service_name VARCHAR(100),
    description TEXT,
    icon VARCHAR(50) -- FontAwesome class
);

-- Table for projects
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    description TEXT,
    image VARCHAR(255),
    category VARCHAR(50),
    link VARCHAR(255),
    github_link VARCHAR(255)
);

-- Table for experience
CREATE TABLE IF NOT EXISTS experiences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company VARCHAR(100),
    position VARCHAR(100),
    start_date DATE,
    end_date DATE,
    is_current BOOLEAN DEFAULT 0,
    description TEXT
);

-- Table for education
CREATE TABLE IF NOT EXISTS education (
    id INT AUTO_INCREMENT PRIMARY KEY,
    institution VARCHAR(100),
    degree VARCHAR(100),
    start_date DATE,
    end_date DATE,
    description TEXT
);

-- Table for certificates
CREATE TABLE IF NOT EXISTS certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    issuer VARCHAR(100),
    date_issued DATE,
    image VARCHAR(255)
);

-- Table for testimonials
CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(100),
    client_title VARCHAR(100),
    feedback TEXT,
    client_image VARCHAR(255)
);

-- Table for contact messages
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    subject VARCHAR(255),
    message TEXT,
    is_read BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for general settings
CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    site_title VARCHAR(100),
    site_description TEXT,
    site_keywords TEXT,
    favicon VARCHAR(255),
    footer_text VARCHAR(255)
);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, password, full_name, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin User', 'admin@example.com');

-- Insert default profile data
INSERT INTO profile (name, title, about_me) VALUES 
('John Doe', 'Full Stack Developer', 'I am a passionate developer with expertise in PHP, MySQL, and modern frontend technologies.');
