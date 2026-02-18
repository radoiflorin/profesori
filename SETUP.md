# Admin Scoala - Profesor Management System

## Setup & Testing Guide

### Prerequisites
- XAMPP cu PHP & MySQL
- Node.js (opțional, pentru development tools)
- Git

### Initial Setup

#### 1. Database Setup
```bash
cd backend
php artisan migrate
php artisan db:seed
```

#### 2. Start Laravel API Server
```bash
cd backend
php artisan serve
```
Server va rula pe: `http://localhost:8000`

#### 3. Open HTML Interface
Deschide în browser: `file:///c:/xampp/htdocs/profesori/html/index.html`

---

## 📋 Available Pages & Features

### Dashboard
**URL**: `html/index.html`
- Overview cu statistici: total profesori, orar, etc.
- Links către alte sectiuni

### 👨‍🏫 Professors Management

#### View All Professors
**URL**: `html/pages/teachers.html`
- **API**: `GET /api/teachers`
- Afiseaza tabel dinamic cu:
  - Nume profesor
  - Disciplina
  - Contact (telefon)
  - Actiuni: Detalii, Editeaza, Sterge

#### Add Professor
**URL**: `html/pages/teacher-add.html`
- **API**: `POST /api/teachers`
- Formular cu campuri:
  - Nume complet (required)
  - Rol (Coordonator/Titular/Asociat)
  - Telefon
  - Disciplina (required)
  - Note

#### Edit Professor
**URL**: `html/pages/teacher-add.html?id=<teacher_id>`
- **API**: `PUT /api/teachers/<id>`
- Incarca date existente in form
- Permite actualizare

### 📅 Schedule Management

#### View Schedule
**URL**: `html/pages/timetable.html`
- **API**: `GET /api/timetables` (with teacher data)
- Afiseaza tabel dinamic cu:
  - Ore (08:00-09:00, etc.)
  - Ziua (Luni-Vineri)
  - Profesor & Disciplina
  - Sala/Laborator

#### Add Schedule Entry
**URL**: `html/pages/timetable-add.html`
- **API**: `POST /api/timetables`
- Formular cu:
  - Profesor (dropdown, dinamic din DB)
  - Ziua saptamanii
  - Inceput/Sfarsit ora
  - Clasa & Sala

---

## 🔌 API Endpoints Reference

### Teachers
```
GET    /api/teachers              List all teachers
POST   /api/teachers              Create teacher
GET    /api/teachers/{id}         Get teacher by ID
PUT    /api/teachers/{id}         Update teacher
DELETE /api/teachers/{id}         Delete teacher
```

**Request Example (POST)**:
```json
{
  "name": "John Doe",
  "role": "Titular",
  "subject": "Matematica",
  "phone": "07xxxxx",
  "notes": "Optional notes"
}
```

### Timetables
```
GET    /api/timetables            List all schedule entries
POST   /api/timetables            Create schedule entry
GET    /api/timetables/{id}       Get entry by ID
PUT    /api/timetables/{id}       Update entry
DELETE /api/timetables/{id}       Delete entry
```

**Request Example (POST)**:
```json
{
  "teacher_id": 1,
  "day": "Luni",
  "start_time": "08:00",
  "end_time": "09:00",
  "class": "10A",
  "room": "Sala 12"
}
```

---

## 🧪 Testing with Browser Console

All pages have `window.ApiIntegration` exposed globally for testing:

```javascript
// Get all teachers
ApiIntegration.teachers.getAll().then(data => console.log(data))

// Get all timetables
ApiIntegration.timetables.getAll().then(data => console.log(data))

// Create teacher
ApiIntegration.teachers.create({
  name: 'Test Prof',
  role: 'Titular',
  subject: 'Fizica',
  phone: '07123456'
}).then(data => console.log(data))
```

---

## 📁 Project Structure

```
/html/
  ├── index.html                 Dashboard principal
  ├── pages/
  │   ├── teachers.html          View all professors
  │   ├── teacher-add.html       Add/Edit professor
  │   ├── timetable.html         View schedule
  │   └── timetable-add.html     Add schedule entry
  ├── assets/
  │   ├── js/
  │   │   ├── app.js             Main app logic & UI interactions
  │   │   ├── api-integration.js  API communication module
  │   │   └── theme.js           Theme switcher
  │   └── css/
  │       ├── app.css            Main styles
  │       └── themes/            Theme files

/backend/
  ├── app/
  │   ├── Http/Controllers/Api/
  │   │   ├── TeacherController.php
  │   │   └── TimetableController.php
  │   └── Models/
  │       ├── Teacher.php
  │       └── Timetable.php
  ├── database/
  │   ├── migrations/
  │   └── seeders/
  └── routes/
      └── web.php               API routes
```

---

## 🔧 Configuration

**API Base URL**: Configured in `html/assets/js/api-integration.js`
```javascript
const API_BASE = 'http://localhost:8000/api';
```

**Database**: `config/database.php` (backend)
```
Host: 127.0.0.1
Database: profesori
User: root
Password: (empty)
```

---

## 🚀 Next Steps

- [ ] Add authentication & user roles
- [ ] Implement statistics/reports for teachers
- [ ] Add certificate generation feature
- [ ] Integrate schedule conflict detection
- [ ] Add more disciplines to database
- [ ] Implement data export (PDF/Excel)
- [ ] Mobile responsive improvements
- [ ] Implement search & filtering

---

## 📝 Notes

- All HTML pages are currently static-served from `/html/` folder
- API is accessed via `http://localhost:8000/api` (Laravel built-in server)
- For production, use proper web server (Nginx/Apache)
- CORS may need configuration if deploying separately
- Data persists in MySQL database (profesori)

---

**Last Updated**: 2026-02-18
**Version**: 1.0 Beta
