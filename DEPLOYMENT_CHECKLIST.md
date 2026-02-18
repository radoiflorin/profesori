# ⚡ Admin Scoala - Quick Deployment Checklist
**Shared Hosting (cPanel) - 30 Minute Setup**

---

## 📝 BEFORE YOU START
- [ ] Save cPanel login credentials (username/password)
- [ ] Note your FTP/SFTP host from cPanel (usually `ftp.yourdomain.com`)
- [ ] Download FileZilla or WinSCP
- [ ] Get MySQL credentials from cPanel (host, username, password)

---

## 🔧 LOCAL PREPARATION (5 min)

```bash
# 1. Optimize backend for upload
cd C:\xampp\htdocs\profesori\backend
composer install --optimize-autoloader --no-dev

# 2. Update frontend API URL
# Edit: html/assets/js/api-integration.js
# Change: const API_BASE = 'https://yourdomain.com/api';
```

---

## 📤 UPLOAD BACKEND (10 min)

**Via FTP/SFTP:**
1. Connect to: `ftp.yourdomain.com`
2. Navigate to: `/public_html/`
3. Create folder: `api`
4. Upload: `backend/` contents into `api/` (skip: `.env`, `.git`, `node_modules`)

**Via cPanel File Manager:**
1. Create `/public_html/api/` folder
2. Extract uploaded zip file there

---

## 🗄️ DATABASE SETUP (5 min)

**In cPanel:**
1. MySQL Databases
   - Create database: `cpaneluser_profesori`
2. MySQL Users
   - Create user: `cpaneluser_prof_user`
   - Generate strong password
3. Assign user to database with ALL privileges

**Edit `/public_html/api/.env` (via File Manager):**
```env
DB_HOST=localhost
DB_DATABASE=cpaneluser_profesori
DB_USERNAME=cpaneluser_prof_user
DB_PASSWORD=your-password-here
APP_URL=https://yourdomain.com/api
APP_ENV=production
APP_DEBUG=false
```

---

## 🚀 RUN MIGRATIONS (2 min)

**Option A: Via SSH Terminal (best)**
```bash
cd /home/yourusername/public_html/api
php artisan migrate --force
php artisan db:seed --force
```

**Option B: Via PHP Script**
1. Create file: `/public_html/api/public/migrate.php` (copy from guide)
2. Visit: `https://yourdomain.com/api/public/migrate.php?token=secret`
3. ⚠️ **Delete migrate.php after running!**

**Option C: Contact Hosting**
Ask support to run those 2 commands

---

## 📁 UPLOAD FRONTEND (5 min)

1. Via FTP: Upload `html/` contents to `/public_html/app/`
2. Verify: Can access `https://yourdomain.com/app/index.html`

---

## 🔐 SET PERMISSIONS (2 min)

**Via cPanel File Manager:**
- `/public_html/api/storage` → **755**
- `/public_html/api/bootstrap/cache` → **755**
- `/public_html/api/.env` → **600**
- `/public_html/api/artisan` → **755**
- Other files → **644**
- Other folders → **755**

---

## ✅ VERIFY DEPLOYMENT (3 min)

**Test these URLs:**

1. API working:
   ```
   https://yourdomain.com/api/teachers
   ```
   Should return: JSON array of teachers

2. Frontend loading:
   ```
   https://yourdomain.com/app/
   ```
   Should show: Admin Scoala Dashboard

3. Features working:
   - [ ] Teachers list displays
   - [ ] Can add new teacher
   - [ ] Dashboard loads
   - [ ] Statistics show charts
   - [ ] Can download certificate PDF
   - [ ] Can import Excel file
   - [ ] No red errors in F12 console

---

## 🎉 YOU'RE DONE!

Your application is live at:
- **Dashboard:** `https://yourdomain.com/app/`
- **API:** `https://yourdomain.com/api/`

---

## 🆘 QUICK FIXES

| Problem | Solution |
|---------|----------|
| 502 Bad Gateway | Check .htaccess in `/public_html/api/` |
| 404 on API | Verify database migrations ran |
| CORS errors | Check API_BASE URL in api-integration.js |
| Can't upload via FTP | Try SFTP instead or use cPanel File Manager |
| "Allowed memory exhausted" | Ask hosting to set PHP memory_limit to 256M |
| Missing teachers data | Run: `php artisan db:seed --force` |

---

**Estimated Time:** 30 minutes
**Difficulty:** ⭐⭐☆ (Intermediate)
**Support:** See SHARED_HOSTING_DEPLOYMENT.md for detailed guide
