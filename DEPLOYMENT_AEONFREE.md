# AeonFree Deployment Guide (Upload & Run)

## 1) Create Database
1. Open AeonFree Control Panel -> MySQL Databases.
2. Create database and user.
3. Open phpMyAdmin and import `sql/al_alameya.sql`.

## 2) Configure Environment
1. Edit `.env.php` with your MySQL host/db/user/password and domain URL.
2. Set a long random value for `security.csrf_key`.

## 3) Upload Files
1. Upload all project folders/files so `public_html/` content becomes your web root.
2. Ensure these folders are writable:
   - `public_html/uploads`
   - `cache`

## 4) Verify Rewrite
- Ensure `.htaccess` is present in web root (`public_html/.htaccess`).
- Visit `/about` and `/contact` to verify clean URLs.

## 5) Default Admin Login
- URL: `https://your-domain.aeonfree.com/admin/login.php`
- Email: `admin@alameya.local`
- Password: `Admin@12345`
- Change credentials immediately from `Manage Users`.

## 6) Hardening Checklist
- Replace default admin password.
- Use HTTPS in AeonFree settings.
- Disable debug and keep file permissions restrictive.
