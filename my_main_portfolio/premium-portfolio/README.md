# Premium Portfolio Website

Complete responsive portfolio website with PHP/MySQL backend, functional contact form, secure admin login, project CRUD, message management, profile settings, image uploads, and dark/light admin theme.

## Folder Structure

```text
premium-portfolio/
├── actions/
│   ├── contact_submit.php
│   ├── login.php
│   ├── logout.php
│   ├── message_delete.php
│   ├── password_update.php
│   ├── project_delete.php
│   ├── project_store.php
│   ├── project_update.php
│   └── settings_update.php
├── admin/
│   ├── dashboard.php
│   ├── login.php
│   ├── messages.php
│   ├── projects.php
│   └── settings.php
├── assets/
│   ├── css/
│   │   ├── admin.css
│   │   └── style.css
│   ├── images/
│   │   ├── profile-portrait.png
│   │   └── projects/
│   │       ├── project-1.png
│   │       ├── project-2.png
│   │       └── project-3.png
│   └── js/
│       ├── admin.js
│       └── main.js
├── config/
│   ├── app.php
│   └── db.php
├── includes/
│   ├── admin-auth.php
│   ├── admin-footer.php
│   ├── admin-header.php
│   ├── functions.php
│   ├── project-form-fields.php
│   ├── public-footer.php
│   └── public-header.php
├── uploads/
│   ├── cv/
│   └── projects/
├── .htaccess
├── download_cv.php
├── index.php
└── portfolio_db.sql
```

## Requirements

- PHP 8.1 or newer
- MySQL 5.7+/MariaDB 10.4+
- Apache/Nginx with write access to `uploads/`
- PHP extensions: PDO MySQL, fileinfo, mbstring recommended

## Setup

1. Copy the `premium-portfolio` folder into your local server or hosting public directory.
2. Create/import the database using `portfolio_db.sql`.
3. Update database credentials in `config/db.php`, or set environment variables:
   - `DB_HOST`
   - `DB_NAME`
   - `DB_USER`
   - `DB_PASS`
4. Set `CONTACT_NOTIFICATION_EMAIL` in `config/app.php` or as an environment variable.
5. Make sure `uploads/`, `uploads/projects/`, and `uploads/cv/` are writable by PHP.
6. Visit `/admin/login.php`. Because no admin is seeded by default, the first visit shows a secure setup form.
7. Create your admin account, then manage projects, messages, profile details, CV, and password from the dashboard.

## Mail Notes

The contact form always saves messages to MySQL. Email notification uses PHP `mail()`, so the hosting server must be configured for outbound mail. If `CONTACT_NOTIFICATION_EMAIL` remains `admin@example.com`, mail sending is skipped while database saving still works.

## Security Notes

- Admin passwords use PHP `password_hash()` and `password_verify()`.
- Admin mutations and contact submission use CSRF tokens.
- Uploads are MIME and extension validated.
- Uploaded files are stored with random filenames.
- The included `.htaccess` files disable directory listing and block PHP execution inside `uploads/` on Apache.

