# Professional PHP Portfolio with Admin Panel

This is a complete, stylish, and fully responsive portfolio website built with PHP and MySQL.

## Features
- **Dynamic Content:** All sections (Hero, About, Services, Skills, Projects, Experience, Education, Certificates) are managed via the Admin Panel.
- **Admin Panel:** Secure login to manage all website content and view contact messages.
- **Responsive Design:** Built with Bootstrap 5 to look great on all devices.
- **Animations:** Smooth scroll and AOS (Animate On Scroll) effects.
- **Contact Form:** Working contact form that saves messages to the database.
- **Resume Download:** Easy resume management.

## Setup Instructions
1. **Database Setup:**
   - Create a database named `portfolio` in your MySQL server (e.g., via phpMyAdmin).
   - Import the `database/portfolio.sql` file into your new database.
2. **Configuration:**
   - Open `includes/config.php`.
   - Update the database credentials (`DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`) to match your local environment.
3. **Admin Access:**
   - URL: `your-site-url/admin/`
   - Username: `admin`
   - Password: `admin123` (You can change this in the database or profile settings).
4. **Permissions:**
   - Ensure the `uploads/` directory and its subfolders are writable by the web server.

## Folder Structure
- `admin/`: Backend management files.
- `includes/`: Reusable PHP components and core logic.
- `assets/`: CSS, JS, and static images.
- `uploads/`: Dynamic user-uploaded files (profile pics, project images, etc.).
- `database/`: SQL schema file.

Enjoy your new professional portfolio!
