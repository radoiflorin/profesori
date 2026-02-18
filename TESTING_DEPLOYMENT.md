# Testing & Deployment Guide
**Admin Scoala - Teacher Management System**
**Version:** 1.0 Beta
**Status:** Ready for Production Testing

---

## 📋 PRE-DEPLOYMENT CHECKLIST

### Backend Setup ✓
- [ ] Database migrations run successfully
- [ ] Seeder data loaded
- [ ] Laravel API server starts without errors
- [ ] CORS configured (if needed)
- [ ] Environment variables correct (.env)

### Frontend Setup ✓
- [ ] All HTML pages load without 404
- [ ] API base URL configured correctly
- [ ] Theme switcher works (School/Corporate/Dark)
- [ ] Language toggle responsive
- [ ] All links in navigation functional

### API Endpoints ✓
- [ ] GET /api/teachers - returns all teachers
- [ ] POST /api/teachers - creates new teacher
- [ ] PUT /api/teachers/{id} - updates teacher
- [ ] DELETE /api/teachers/{id} - deletes teacher
- [ ] GET /api/timetables - returns all timetables
- [ ] POST /api/timetables - creates new timetable
- [ ] GET /api/teachers/{id}/profile - get profile
- [ ] POST /api/teachers/{id}/profile - create profile
- [ ] PUT /api/teachers/{id}/profile - update profile

---

## 🧪 TESTING SCENARIOS

### 1. Teacher Management
**URL:** `html/pages/teachers.html`

**Test Steps:**
1. [ ] Load page - should display list of 3 seed teachers
2. [ ] Click "Adauga profesor" → goes to `teacher-add.html`
3. [ ] Fill form with test data:
   - Nume: "Test Prof"
   - Rol: "Titular"
   - Disciplina: "Informatica"
   - Telefon: "0700000000"
4. [ ] Click "Salveaza" → should add to database
5. [ ] Refresh page → new teacher appears in list
6. [ ] Click "Editeaza" on test teacher → `teacher-edit.html?id=X`
7. [ ] Modify data and save → changes persist
8. [ ] Click "Sterge" → should confirm and delete
9. [ ] Verify teacher removed from list

**Expected:** All CRUD operations work smoothly

---

### 2. Teacher Profile
**URL:** `html/pages/teacher-profile.html?id=1`

**Test Steps:**
1. [ ] Load page - should fetch teacher data
2. [ ] Verify all fields populated correctly
3. [ ] Fill in profile fields:
   - CNP: "1850305123456"
   - Data Nasterii: "1985-03-05"
   - Disciplina Principala: "Matematica"
   - Ore/Saptamana: "18"
4. [ ] Click "Salveaza Profil" → success message
5. [ ] Refresh page → data persists
6. [ ] Click "Export PDF" → downloads PDF file
7. [ ] Verify PDF quality and formatting

**Expected:** Profile data saves and exports correctly

---

### 3. Schedule (Orar)
**URL:** `html/pages/timetable.html`

**Test Steps:**
1. [ ] Load page - should display 3 seed timetable entries
2. [ ] Click "Adauga ora" → goes to `timetable-add.html`
3. [ ] Fill form:
   - Profesor: select one
   - Ziua: "Luni"
   - Inceput: "10:00"
   - Sfarsit: "11:00"
   - Clasa: "10A"
   - Sala: "Sala 5"
4. [ ] Click "Salveaza" → success message
5. [ ] Refresh timetable page → new entry appears
6. [ ] Test time validation (end must be after start)
7. [ ] Verify dropdown populates correctly

**Expected:** Timetable CRUD functional

---

### 4. Statistics Dashboard
**URL:** `html/pages/stats.html`

**Test Steps:**
1. [ ] Load page - should show metric cards
2. [ ] Verify metrics:
   - Total Profesori: correct count
   - Discipline Unice: counted correctly
3. [ ] Check all 4 charts render:
   - [ ] Profesori pe Disciplina (Bar)
   - [ ] Distribuire pe Rol (Doughnut)
   - [ ] Ore de Predare (Bar)
   - [ ] Orar - Zile (Line)
4. [ ] Click "Refresh" → charts update
5. [ ] Check data table populated
6. [ ] Click "Export CSV" → downloads CSV file
7. [ ] Verify CSV opens correctly in Excel

**Expected:** All charts render, data accurate, export works

---

### 5. Certificate Generator
**URL:** `html/pages/certificate-generator.html`

**Test Steps:**
1. [ ] Load page - teacher dropdown populates
2. [ ] Select different document types:
   - [ ] Adeverinta Angajare
   - [ ] Certificat Experienta
   - [ ] Certificat Specializare
   - [ ] Certificat Ore Predate
3. [ ] Fill configuration:
   - Data Emiterii: today's date
   - Locul: "Bucuresti"
   - Scopul: "Pentru CNAS"
   - Semnator: "Director"
4. [ ] Click "Previzualizare" → preview updates
5. [ ] Click "Descarca PDF" → PDF downloads
6. [ ] Click "Tipareste" → print dialog appears
7. [ ] Verify PDF formatting and content

**Expected:** Certificates generate correctly, all formats work

---

### 6. Excel Import
**URL:** `html/pages/excel-import.html`

**Test Steps:**
1. [ ] Click "Descarca Template" → template.xlsx downloads
2. [ ] Open template in Excel
3. [ ] Add 3 test teachers with data:
   ```
   Nume | Disciplina | Rol | Telefon | CNP
   Prof Test 1 | Fizica | Titular | 0700000001 | 1850305000001
   Prof Test 2 | Chimie | Suplinitor | 0700000002 | 1850305000002
   Prof Test 3 | Biologie | Asociat | 0700000003 | 1850305000003
   ```
4. [ ] Save as .xlsx
5. [ ] Go back to import page
6. [ ] Select file → preview shows data
7. [ ] Click "Importa Date" → progress bar appears
8. [ ] Wait for completion → success message
9. [ ] Go to teachers.html → 3 new teachers appear
10. [ ] Go to teacher-profile.html?id=X → verify profile data

**Expected:** Import successful, all data persists

---

### 7. API Direct Testing
**Via Browser Console:**

```javascript
// Test teacher endpoints
ApiIntegration.teachers.getAll().then(data => console.log('Teachers:', data))
ApiIntegration.teachers.getById(1).then(data => console.log('Teacher 1:', data))

// Test create
ApiIntegration.teachers.create({
  name: 'API Test Prof',
  role: 'Titular',
  subject: 'Historia',
  phone: '0700000000'
}).then(data => console.log('Created:', data))

// Test timetables
ApiIntegration.timetables.getAll().then(data => console.log('Timetables:', data))

// Test profiles
ApiIntegration.request('GET', '/teachers/1/profile').then(data => console.log('Profile:', data))
```

**Expected:** All endpoints return data without errors

---

## 🚀 DEPLOYMENT STEPS

### Local Testing Environment (Current)
**Status:** ✅ Development

```bash
# 1. Start Laravel server
cd C:\xampp\htdocs\profesori\backend
php artisan serve

# 2. Open browser
http://localhost:8000
file:///c:/xampp/htdocs/profesori/html/index.html
```

### Production Deployment

#### Option A: Shared Hosting (cPanel/WHM)

1. **Upload Backend Files**
   ```bash
   # Via FTP/SFTP
   - Upload /backend/* to public_html/api/
   - Ensure .env is secure
   ```

2. **Configure .env**
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-domain.com/api

   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_DATABASE=profesori
   DB_USERNAME=db_user
   DB_PASSWORD=secure_password
   ```

3. **Run Migrations**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```

4. **Upload Frontend**
   ```bash
   # Upload /html/* to public_html/app/
   ```

5. **Update API Base URL**
   Edit: `html/assets/js/api-integration.js`
   ```javascript
   const API_BASE = 'https://your-domain.com/api';
   ```

#### Option B: VPS (Nginx/Apache)

1. **Clone Repository**
   ```bash
   cd /var/www
   git clone https://github.com/radoiflorin/profesori.git
   cd profesori
   ```

2. **Setup Backend**
   ```bash
   cd backend
   composer install --optimize-autoloader --no-dev
   cp .env.example .env
   php artisan key:generate
   php artisan migrate
   php artisan db:seed
   ```

3. **Configure Nginx**
   ```nginx
   server {
       listen 80;
       server_name your-domain.com;
       root /var/www/profesori/backend/public;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location ~ \.php$ {
           fastcgi_pass unix:/var/run/php-fpm.sock;
           fastcgi_index index.php;
           include fastcgi_params;
       }
   }
   ```

4. **Setup Frontend**
   ```bash
   # Configure web server to serve /html/ on separate path
   # Or embed in Laravel
   cp -r html/* backend/public/app/
   ```

#### Option C: Docker (Recommended)

```dockerfile
# Dockerfile
FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    mariadb-client \
    git \
    curl \
    && docker-php-ext-install pdo_mysql

COPY backend /app
WORKDIR /app

RUN composer install --no-dev
RUN chown -R www-data:www-data /app

CMD ["php-fpm"]
```

```docker-compose
version: '3.8'
services:
  app:
    build: .
    ports:
      - "9000:9000"
    volumes:
      - ./backend:/app
    environment:
      DB_HOST: db
      DB_DATABASE: profesori
      DB_USERNAME: root
      DB_PASSWORD: password

  db:
    image: mariadb:latest
    environment:
      MYSQL_ROOT_PASSWORD: password
      MYSQL_DATABASE: profesori
    ports:
      - "3306:3306"
    volumes:
      - db_data:/var/lib/mysql

volumes:
  db_data:
```

---

## ✅ POST-DEPLOYMENT VERIFICATION

After deployment, verify:

- [ ] All pages load without 404 errors
- [ ] API endpoints respond with correct data
- [ ] Database persists data between requests
- [ ] PDF exports work correctly
- [ ] Excel import functions properly
- [ ] Statistics display accurate data
- [ ] No console errors in browser
- [ ] CORS headers allow requests
- [ ] HTTPS configured (if needed)
- [ ] Backups automated

---

## 🔒 SECURITY CHECKLIST

- [ ] `.env` file not exposed publicly
- [ ] Database credentials secure
- [ ] SQL injection protection (Laravel Eloquent)
- [ ] XSS prevention (input validation)
- [ ] CSRF tokens enabled
- [ ] File upload size limits
- [ ] Rate limiting on API endpoints
- [ ] CORS properly configured
- [ ] HTTPS enforced
- [ ] Regular backups scheduled

---

## 🐛 TROUBLESHOOTING

### Issue: 404 on API endpoints
**Solution:** Check Laravel routing and API base URL

### Issue: CORS errors
**Solution:** Add to `config/cors.php` or middleware:
```php
Header::set('Access-Control-Allow-Origin', '*');
Header::set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
```

### Issue: Excel import fails
**Solution:** Verify file format is .xlsx, check column names

### Issue: PDF export empty
**Solution:** Ensure html2pdf.js library loaded, check element selectors

### Issue: Database connection error
**Solution:** Verify DB credentials in .env, check MySQL running

---

## 📞 SUPPORT

- **GitHub Issues:** https://github.com/radoiflorin/profesori/issues
- **Documentation:** See SETUP.md
- **Contact:** Admin

---

## 📝 VERSION HISTORY

| Version | Date | Status | Changes |
|---------|------|--------|---------|
| 1.0 | 2026-02-18 | Beta | Initial release with 4 features |

---

**Last Updated:** 2026-02-18
**Prepared by:** Claude Haiku 4.5
**Status:** Ready for Production Testing
