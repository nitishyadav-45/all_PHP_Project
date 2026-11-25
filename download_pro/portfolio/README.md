# Creative Portfolio Website - PHP + MySQL

A fully responsive and beautifully designed portfolio website built with HTML, CSS, Bootstrap, JavaScript, PHP, and MySQL.

## Features

- **Fully Responsive Design** - Works perfectly on all devices (desktop, tablet, mobile)
- **Modern UI/UX** - Beautiful gradient designs and smooth animations
- **Admin Panel** - Manage all portfolio content from a secure admin dashboard
- **Dynamic Content** - All content is stored in MySQL database
- **Contact Form** - Functional contact form with database storage
- **Newsletter Subscription** - Email subscription system
- **Portfolio Filtering** - Filter projects by category
- **Smooth Animations** - AOS (Animate On Scroll) library integration
- **SEO Friendly** - Optimized for search engines

## Project Structure

```
portfolio/
├── index.php                 # Main portfolio page
├── config.php               # Database configuration
├── contact_handler.php      # Contact form handler
├── subscribe.php            # Newsletter subscription handler
├── admin_login.php          # Admin login page
├── admin_logout.php         # Admin logout
├── admin/
│   ├── dashboard.php        # Admin dashboard
│   ├── profile.php          # Edit profile
│   ├── services.php         # Manage services
│   ├── skills.php           # Manage skills
│   ├── projects.php         # Manage projects
│   ├── testimonials.php     # Manage testimonials
│   └── messages.php         # View contact messages
├── database_schema.sql      # Database schema
└── README.md               # This file
```

## Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Composer (optional)

### Step 1: Set Up Database

1. Open phpMyAdmin or MySQL command line
2. Create a new database:
   ```sql
   CREATE DATABASE portfolio_db;
   ```
3. Import the database schema:
   ```sql
   mysql -u root -p portfolio_db < database_schema.sql
   ```

### Step 2: Configure Database Connection

Edit `config.php` and update the database credentials:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', 'your_password');
define('DB_NAME', 'portfolio_db');
```

### Step 3: Create Admin User

Run this SQL query to create an admin user:

```sql
INSERT INTO users (name, email, password, title, description) VALUES 
('John Doe', 'admin@example.com', '$2y$10$...hashed_password...', 'Web Developer', 'Creative Web Developer');

```

To generate a hashed password, use PHP:
```php
echo password_hash('your_password', PASSWORD_BCRYPT);
```

### Step 4: Upload Files

1. Upload all files to your web server (public_html or www folder)
2. Make sure the directory has proper permissions (755 for folders, 644 for files)

### Step 5: Access Your Portfolio

- **Frontend**: `http://localhost/portfolio/`
- **Admin Panel**: `http://localhost/portfolio/admin_login.php`

## Usage

### Admin Panel

1. Log in to the admin panel with your credentials
2. Edit your profile information
3. Add/edit services, skills, projects, and testimonials
4. View contact messages from visitors

### Adding Content

#### Services
- Go to Admin > Services
- Click "Add Service" to add a new service
- Fill in the service name and description

#### Skills
- Go to Admin > Skills
- Add skill name and proficiency percentage (0-100)

#### Projects
- Go to Admin > Projects
- Add project title, description, image, and links
- Assign to a category

#### Testimonials
- Go to Admin > Testimonials
- Add client name, title, quote, and rating

## Database Schema

### Users Table
Stores admin/profile information

### Services Table
Portfolio services

### Skills Table
Technical skills with proficiency levels

### Projects Table
Portfolio projects with categories

### Testimonials Table
Client testimonials and reviews

### Contact Messages Table
Messages from the contact form

### Subscribers Table
Newsletter subscribers

## Customization

### Change Colors

Edit the CSS variables in `index.php`:

```css
:root {
    --primary-color: #6c5ce7;
    --secondary-color: #a29bfe;
    --accent-color: #fd79a8;
    /* ... more colors ... */
}
```

### Update Contact Email

Edit `contact_handler.php` and update the email address:

```php
$to = "your-email@example.com";
```

### Change Site URL

Update `config.php`:

```php
define('SITE_URL', 'http://yourdomain.com/portfolio/');
```

## Security Features

- Password hashing with bcrypt
- SQL injection prevention with prepared statements
- Session-based authentication
- CSRF protection ready
- Input sanitization

## Performance Optimization

- Lazy loading for images
- CSS and JS minification ready
- Responsive images
- Optimized animations
- CDN-based libraries

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## Troubleshooting

### Database Connection Error
- Check database credentials in `config.php`
- Ensure MySQL server is running
- Verify database name is correct

### Admin Login Not Working
- Check if admin user exists in database
- Verify password is correctly hashed
- Clear browser cookies and try again

### Images Not Loading
- Check image paths in database
- Ensure image files are uploaded to correct directory
- Verify file permissions

## Support

For issues or questions, please refer to the documentation or contact support.

## License

This project is provided as-is for personal and commercial use.

## Credits

- Bootstrap 5 - Frontend framework
- AOS - Scroll animations
- Bootstrap Icons - Icon library
- Google Fonts - Typography

---

**Version**: 1.0.0  
**Last Updated**: 2024  
**Author**: Your Name
