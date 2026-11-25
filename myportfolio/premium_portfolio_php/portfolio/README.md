# Premium Portfolio Website

A dynamic, secure, and responsive portfolio website built with PHP, MySQL, and Bootstrap 5.

## Features
- **Glassmorphism UI**: Modern, vibrant, and colorful design.
- **Dynamic Content**: Projects and skills managed via a secure admin dashboard.
- **Security**: 
  - PDO Prepared Statements (SQL Injection protection).
  - CSRF Token Validation.
  - Input Sanitization & Output Escaping (XSS protection).
  - Password Hashing with `password_hash()`.
- **Responsive**: Fully optimized for mobile, tablet, and desktop.
- **Admin Panel**: Secure CRUD dashboard for content management.

## Setup Instructions
1. **Database**:
   - Create a MySQL database named `portfolio_db`.
   - Import the `sql/database.sql` file into your database.
2. **Configuration**:
   - Open `includes/config.php`.
   - Update `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASS` with your database credentials.
3. **Deployment**:
   - Upload the project files to your web server (Apache/Nginx with PHP 7.4+).
4. **Admin Access**:
   - URL: `yourdomain.com/login.php`
   - Default Username: `admin`
   - Default Password: `admin123`
   - *Note: Please change the password in the database or admin panel after first login.*

## File Structure
- `index.php`: Main frontend.
- `login.php`: Admin login page.
- `admin.php`: Admin dashboard.
- `includes/`: Core configuration and reusable components.
- `assets/`: CSS, JS, and images.
- `sql/`: Database schema.
