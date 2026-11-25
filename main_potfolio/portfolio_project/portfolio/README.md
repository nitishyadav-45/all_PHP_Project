# Premium Professional Portfolio Website

A complete, responsive, and modern portfolio website built with PHP, MySQL, Bootstrap 5, and JavaScript.

## Features
- **Premium Design:** Glassmorphism effects, smooth animations, and modern UI/UX.
- **Dynamic Content:** Fully manageable through a secure Admin Panel.
- **Sections:** Hero, About, Skills, Services, Projects, Experience, Education, Certificates, Testimonials, and Contact.
- **Admin Panel:** Secure login, dashboard statistics, and full CRUD operations for all sections.
- **Fully Responsive:** Optimized for mobile, tablet, and desktop screens.
- **Performance:** Fast loading, SEO-friendly, and clean code.

## Tech Stack
- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5, AOS (Animations), Swiper (Slider), Typed.js, Particles.js.
- **Backend:** PHP (PDO for database interactions).
- **Database:** MySQL.

## Installation Guide

### Prerequisites
- XAMPP, WAMP, or any local server with PHP and MySQL support.

### Steps
1. **Extract the Project:**
   - Copy the `portfolio` folder to your server's root directory (e.g., `C:/xampp/htdocs/`).

2. **Setup Database:**
   - Open PHPMyAdmin (`http://localhost/phpmyadmin/`).
   - Create a new database named `portfolio_db`.
   - Import the `database/portfolio_db.sql` file into the newly created database.

3. **Configure Database Connection:**
   - Open `includes/config.php`.
   - Update `DB_HOST`, `DB_USER`, `DB_PASS`, and `DB_NAME` if they differ from the default (root with no password).
   - Update `SITE_URL` to match your local setup.

4. **Access the Website:**
   - Frontend: `http://localhost/portfolio/`
   - Admin Panel: `http://localhost/portfolio/admin/`

5. **Admin Credentials:**
   - **Username:** `admin`
   - **Password:** `admin123`

## Folder Structure
```
portfolio/
├── index.php
├── contact-submit.php
├── resume-download.php
├── includes/ (Core PHP files)
├── admin/ (Admin Panel modules)
├── assets/ (CSS, JS, Images, Resume)
└── database/ (SQL file)
```

## Security Features
- Password Hashing (BCRYPT)
- Prepared Statements (PDO)
- Session-based Authentication
- Input Sanitization
- XSS Prevention
```
