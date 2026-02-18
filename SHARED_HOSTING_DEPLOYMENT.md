# 🚀 Admin Scoala - Shared Hosting Deployment Guide
**Deployment to cPanel/WHM Environment**
**Date:** 2026-02-18
**Status:** Production Ready

---

## 📋 PRE-DEPLOYMENT CHECKLIST

Before starting, ensure you have:
- [ ] FTP/SFTP client (FileZilla, WinSCP, or cPanel File Manager)
- [ ] Domain name registered and pointing to hosting
- [ ] cPanel access credentials
- [ ] Database name, username, password from hosting
- [ ] PHP 8.1+ support confirmed with hosting
- [ ] MySQL 8.0+ support confirmed with hosting
- [ ] Composer installed on hosting (or pre-built vendor folder)

---

## 🔑 HOSTING CONFIGURATION EXAMPLES

### Example: Shared Hosting with cPanel

**Typical Structure:**
```
public_html/
├── api/                    # Laravel backend (http://yourdomain.com/api)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/
│   ├── routes/
│   ├── .env               # ← Your configuration
│   └── ... (Laravel files)
├── app/                    # Frontend (http://yourdomain.com/app)
│   ├── index.html
│   ├── assets/
│   └── pages/
└── .htaccess             # Root redirect (optional)
```

---

## 📤 STEP 1: PREPARE BACKEND FOR UPLOAD

### 1.1 Clean up vendor folder (make smaller)

```bash
cd C:\xampp\htdocs\profesori\backend

# Remove development dependencies
composer install --optimize-autoloader --no-dev

# Remove test files to save space
del /s /q tests\
del /s /q .phpunit.result.cache
del node_modules (if exists)
```

**Vendor size reduction:** ~500MB → ~100MB

### 1.2 Verify .env is NOT included in upload

```bash
# Files to NEVER upload:
# - .env (contains database credentials!)
# - .env.local
# - .env.*.local
# - storage/ (except storage/logs)
# - bootstrap/cache/ (will be recreated)
```

### 1.3 Create .env template for upload

Create file: `backend/.env.production` (will be renamed to .env on server)

```env
APP_NAME=Laravel
APP_ENV=production
APP_KEY=base64:qt/ZHWuEekxodeahWnGkUglD/qo1y/UULe2valPpuzk=
APP_DEBUG=false
APP_URL=https://yourdomain.com/api

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=your-hosting-db-host
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=log
```

---

## 📁 STEP 2: UPLOAD BACKEND VIA FTP/SFTP

### 2.1 Connect to hosting via FTP

**Using FileZilla:**
1. Open FileZilla
2. File → Site Manager → New Site
3. Protocol: SFTP (or FTP if SFTP unavailable)
4. Host: `ftp.yourdomain.com` or from cPanel
5. Username: `cpanel_username`
6. Password: Your cPanel password
7. Connect

### 2.2 Upload backend files

```
Local:  C:\xampp\htdocs\profesori\backend\*
Remote: /public_html/api/
```

**Order of upload (in FileZilla):**
1. Upload `public/` folder first (small, PHP entry point)
2. Upload `config/`, `routes/`, `database/`, `app/` folders
3. Upload `bootstrap/` folder
4. Upload `vendor/` folder last (large, slow)
5. Upload `.env.production` as `.env`
6. Upload `artisan` script

**Files to SKIP:**
- `.env` (don't upload your local copy)
- `node_modules/`
- `.git/` (if present)
- `tests/` folder
- `storage/logs/` (hosting will create)

### 2.3 Set correct permissions via cPanel File Manager

After upload, use **cPanel File Manager**:

1. Login to cPanel → File Manager
2. Navigate to `/public_html/api/`
3. Select all files → Right-click → Change Permissions

**Set these permissions:**
- `/public_html/api/storage/` → **755** (writable)
- `/public_html/api/bootstrap/cache/` → **755** (writable)
- `/public_html/api/.env` → **600** (readable by PHP only)
- `/public_html/api/artisan` → **755** (executable)
- All other files → **644**
- All folders → **755**

Command via SSH (if available):
```bash
cd /home/yourusername/public_html/api
chmod 755 storage bootstrap/cache
chmod 600 .env
chmod 755 artisan
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
```

---

## 🗄️ STEP 3: DATABASE SETUP ON HOSTING

### 3.1 Create Database via cPanel

1. Login to cPanel
2. MySQL Databases
3. Create new database:
   - Name: `cpaneluser_profesori`
   - Click "Create Database"

### 3.2 Create Database User

1. Create new user:
   - Username: `cpaneluser_prof_user`
   - Password: Generate strong password (save it!)
   - Click "Create User"

### 3.3 Assign User to Database

1. Add user to database with **ALL** privileges
2. Click "Add"

### 3.4 Update .env on server

Edit `/public_html/api/.env` (via cPanel File Manager):

```env
DB_HOST=localhost              # Usually localhost on shared hosting
DB_DATABASE=cpaneluser_profesori
DB_USERNAME=cpaneluser_prof_user
DB_PASSWORD=your-strong-password
```

---

## 🔄 STEP 4: RUN MIGRATIONS & SEEDERS

### 4.1 Access Terminal (if available)

**Via cPanel Terminal:**
1. Login to cPanel
2. Terminal (if enabled by hosting)
3. Navigate: `cd /home/yourusername/public_html/api`

**If Terminal not available:** Ask hosting support to run these commands, OR use a PHP script:

### 4.2 Create migration runner script

Create file: `/public_html/api/public/migrate.php`

```php
<?php
// ⚠️ DELETE THIS FILE AFTER RUNNING MIGRATIONS!
// This is only for shared hosting without SSH access

// Check if you have permission
if ($_GET['token'] !== 'your-secret-token-here') {
    die('Unauthorized');
}

echo "<pre>";
echo "Starting migrations...\n";

// Set environment
putenv('APP_ENV=production');

// Load Laravel
require __DIR__ . '/../bootstrap/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';

// Run migrations
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$status = $kernel->call('migrate', ['--force' => true]);

echo "Migrations completed! Status: " . $status . "\n";

// Run seeders
echo "Running seeders...\n";
$status = $kernel->call('db:seed', ['--force' => true]);

echo "Seeders completed! Status: " . $status . "\n";
echo "</pre>";
echo "<p style='color:red;'><strong>⚠️ IMPORTANT: Delete migrate.php file immediately after this completes!</strong></p>";
```

**Run in browser:**
```
https://yourdomain.com/api/public/migrate.php?token=your-secret-token-here
```

**⚠️ SECURITY:** Delete `migrate.php` immediately after running!

### 4.3 Alternative: Request hosting support

Contact your hosting support:
> "I have a Laravel 11 application in /home/yourusername/public_html/api/
> Please run these commands:
> - cd /home/yourusername/public_html/api
> - php artisan migrate --force
> - php artisan db:seed --force"

---

## 🎨 STEP 5: UPLOAD FRONTEND

### 5.1 Update API base URL

Edit file: `html/assets/js/api-integration.js`

**Change line 7:**
```javascript
// FROM:
const API_BASE = 'http://localhost:8000/api';

// TO:
const API_BASE = 'https://yourdomain.com/api';
```

### 5.2 Upload frontend files

**Via FTP:**
```
Local:  C:\xampp\htdocs\profesori\html\*
Remote: /public_html/app/
```

**Upload structure:**
```
Local path → Remote path
html/index.html → /public_html/app/index.html
html/pages/* → /public_html/app/pages/*
html/assets/* → /public_html/app/assets/*
html/partials/* → /public_html/app/partials/*
```

---

## 🔗 STEP 6: CONFIGURE WEB SERVER ROUTING

### 6.1 Create .htaccess for backend

File: `/public_html/api/.htaccess`

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On

    # Redirect /api to /api/public (Laravel public directory)
    RewriteBase /api
    RewriteRule ^index\.html$ - [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule . /api/public/index.php [L]
</IfModule>
```

### 6.2 Create .htaccess for frontend

File: `/public_html/app/.htaccess`

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /app

    # Serve existing files/dirs as-is
    RewriteCond %{REQUEST_FILENAME} -f [OR]
    RewriteCond %{REQUEST_FILENAME} -d
    RewriteRule ^ - [L]

    # Rewrite to index.html for single-page app
    RewriteRule ^ index.html [QSA,L]
</IfModule>
```

### 6.3 Create root .htaccess (optional)

File: `/public_html/.htaccess`

```apache
# Redirect traffic to app folder
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_URI} !^/app/
    RewriteCond %{REQUEST_URI} !^/api/
    RewriteRule ^(.*)$ /app/$1 [L]
</IfModule>
```

---

## ✅ STEP 7: VERIFY DEPLOYMENT

### 7.1 Test Backend API

Open in browser (one at a time):
```
https://yourdomain.com/api/teachers
https://yourdomain.com/api/timetables
```

**Expected response:** JSON array of teachers/timetables (not HTML error)

### 7.2 Test Frontend

Open in browser:
```
https://yourdomain.com/app/
```

**Expected:** Dashboard loads, data populates from API

### 7.3 Test Features

1. **Teachers Page:** Can see list of teachers ✅
2. **Add Teacher:** Form submits successfully ✅
3. **Teacher Profile:** Profile form loads and saves ✅
4. **Statistics:** Charts render with data ✅
5. **Certificates:** Can generate and download PDF ✅
6. **Excel Import:** Can upload and import file ✅

### 7.4 Check Browser Console

Open Developer Tools (F12):
- Console tab: No red errors
- Network tab: API calls returning 200 status
- Look for CORS errors (would show red in console)

---

## 🔒 STEP 8: SECURITY HARDENING

### 8.1 Secure sensitive files

Via cPanel File Manager - set permissions:

| File/Folder | Permissions | Why |
|---|---|---|
| `.env` | 600 | Only PHP can read DB password |
| `storage/` | 755 | Writable for logs |
| `config/` | 644 | Not writable |
| `app/` | 644 | Not writable |
| `routes/` | 644 | Not writable |

### 8.2 Disable directory listing

Create `.htaccess` in `/public_html/`:

```apache
Options -Indexes
```

### 8.3 Hide PHP errors on production

In `/public_html/api/.env`:
```env
APP_DEBUG=false
```

### 8.4 HTTPS enforcement

Create `/public_html/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    # Force HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
</IfModule>
```

### 8.5 Enable HTTPS certificate

1. Login to cPanel
2. AutoSSL → Install SSL
3. Or buy from your hosting provider

---

## 🐛 TROUBLESHOOTING

### Issue: "502 Bad Gateway" on `/api/` endpoints

**Solution:**
- Check `.htaccess` syntax in `/public_html/api/`
- Verify Laravel is in `/public_html/api/public/` entry point
- Check file permissions on `storage/` folder

### Issue: "404 Not Found" on API calls

**Solution:**
- Verify database migrations ran: Check if tables exist in cPanel MySQL
- Test URL: `https://yourdomain.com/api/public/index.php` (should work)
- Check routing in `routes/web.php`

### Issue: CORS errors in browser console

**Solution:**
Add CORS headers to `/public_html/api/public/index.php`:

```php
// After $response = $kernel->handle($request);

$response->header('Access-Control-Allow-Origin', '*');
$response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
$response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
```

### Issue: Cannot upload files via FTP

**Solution:**
- Try SFTP instead of FTP
- Check if hosting supports SFTP
- Contact hosting support for correct credentials

### Issue: "Allowed memory exhausted" during migration

**Solution:**
Contact hosting support: "Please increase PHP memory_limit to 256M"

---

## 📊 DEPLOYMENT CHECKLIST

After deployment completes:

- [ ] Backend API responds to `/api/teachers` request
- [ ] Frontend loads at `/app/`
- [ ] Can view teachers list
- [ ] Can add new teacher
- [ ] Can access teacher profile
- [ ] Can view statistics
- [ ] Can generate certificate
- [ ] Can import Excel file
- [ ] No console errors in browser (F12)
- [ ] HTTPS certificate active
- [ ] `.env` file has correct DB credentials
- [ ] Database tables created and seeded
- [ ] File permissions set correctly
- [ ] Sensitive files protected

---

## 🔄 ONGOING MAINTENANCE

### Daily: Monitor

```
1. Check cPanel error logs
2. Check Laravel logs: /public_html/api/storage/logs/
3. Test key functions (add teacher, export CSV)
```

### Weekly: Backup

```
1. Backup database via cPanel MySQL
2. Backup files via FTP
```

### Monthly: Updates

```
1. Run composer update (if hosting allows)
2. Review server logs for errors
3. Update any security patches
```

---

## 📞 SUPPORT CONTACTS

**Hosting Support Issue Template:**

Subject: Laravel Application Deployment Support

Body:
```
I have a Laravel 11 API application that needs to be deployed.

Location: /home/yourusername/public_html/api/
Database: cpaneluser_profesori
User: cpaneluser_prof_user

Current issue: [describe issue]

Can you help with:
- [ ] Running Laravel migrations
- [ ] Setting PHP memory limit to 256M
- [ ] Creating MySQL database
- [ ] Other: ___________

Thank you,
[Your Name]
```

---

## ✨ DEPLOYMENT COMPLETE!

Your Admin Scoala application is now live at:

```
Frontend: https://yourdomain.com/app/
Backend API: https://yourdomain.com/api/
Admin Dashboard: https://yourdomain.com/app/index.html
```

**Next Steps:**
1. Test all features thoroughly
2. Share with administrators
3. Collect feedback
4. Schedule regular backups
5. Monitor performance

---

**Last Updated:** 2026-02-18
**Prepared by:** Claude Haiku 4.5
**Status:** ✅ Ready for Production
