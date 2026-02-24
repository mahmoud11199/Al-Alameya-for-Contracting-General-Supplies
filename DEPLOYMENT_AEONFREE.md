# AeonFree Deployment Guide (Upload & Run)

## 1) Create Database
1. Open AeonFree Control Panel -> MySQL Databases.
2. Create database and user.
3. Open phpMyAdmin and import `sql/al_alameya.sql`.

## 2) Configure Environment
1. Edit `.env.php` with your MySQL host/db/user/password and domain URL.
2. Set a long random value for `security.csrf_key`.
3. Keep `app.debug` as `false` in production.

## 3) Upload Files
1. Upload all project folders/files so `public_html/` content becomes your web root.
2. Ensure these folders are writable:
   - `public_html/uploads`
   - `cache`
3. Confirm `public_html/uploads/.htaccess` is uploaded (prevents script execution).

## 4) Verify Rewrite + SEO
- Ensure `.htaccess` is present in web root (`public_html/.htaccess`).
- Visit `/about` and `/contact` to verify clean URLs.
- Update domain in:
  - `.env.php` (`app.url`)
  - `public_html/sitemap.xml`
  - `public_html/robots.txt`

## 5) Default Admin Login
- URL: `https://your-domain.aeonfree.com/admin/login.php`
- Email: `admin@alameya.local`
- Password: `Admin@12345`
- Change credentials immediately from `Manage Users`.

## 6) AeonFree Free-Plan Safe Settings (Already Applied)
- No Composer, no SSH, no cron dependency, no background workers.
- File cache only (small TTL), lightweight routing, and low query count pages.
- Upload validation and 1MB upload size limit to reduce storage/resource abuse.
- Security headers + static file browser caching in `.htaccess`.

## 7) Final Upload Checklist
- [ ] SQL imported successfully in phpMyAdmin.
- [ ] `.env.php` updated with real DB credentials.
- [ ] `csrf_key` replaced with strong random value.
- [ ] `public_html/.htaccess` uploaded and rewrite working.
- [ ] `public_html/uploads/.htaccess` uploaded and upload folder writable.
- [ ] `cache` folder writable.
- [ ] Admin login works and default password changed.
- [ ] `sitemap.xml` and `robots.txt` contain live domain.
- [ ] Contact form submits once every 30 seconds (rate limit works).
- [ ] Test on mobile and desktop.
