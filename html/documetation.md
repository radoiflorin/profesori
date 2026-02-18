📘 School Admin Dashboard — Documentation
🧠 Project Overview

This project is a static HTML Admin Dashboard Template built with Bootstrap 5.
It is designed modularly to support multiple themes, with one initial theme for School Administration.

Bootstrap 5 is a modern CSS framework that simplifies creating responsive components, grids, and utilities.

📁 Project Structure
school-admin/
  index.html
  pages/
    students.html
    student-detail.html
    teachers.html
    classes.html
    timetable.html
    grades.html
    attendance.html
    messages.html
    calendar.html
    settings.html
    login.html
    404.html
  partials/              (optional includes)
    sidebar.html
    topbar.html
    footer.html
  assets/
    css/
      app.css             (basic styles)
      themes/
        theme-school.css
        theme-corporate.css
        theme-dark.css
    js/
      app.js
      theme.js            (theme switching)
    img/

🛠️ Core Principles
🧱 Base UI

Bootstrap 5 (CSS & JS) for responsive layout and components.

Consistent layout across all pages: sidebar + topbar + main content.

Modular pages grouped by function.

Support for multiple themes via CSS variables.

🎨 Multi-Theme Setup
🌈 Theme Tokens (CSS Variables)

Themes are defined using CSS variables in /assets/css/themes/*.css:

Example (theme-school.css):

:root[data-theme="school"] {
  --app-primary: #1d4ed8;
  --app-secondary: #0ea5e9;
  --app-bg: #f8fafc;
  --app-text: #0f172a;
}


In app.css, use:

body {
  background: var(--app-bg);
  color: var(--app-text);
}
.btn-primary {
  background: var(--app-primary);
  border-color: var(--app-primary);
}

🧭 Layout Structure

All pages share a common layout:

<body>
  <aside class="sidebar">…</aside>
  <main>
    <header class="topbar">…</header>
    <div class="container-fluid">Page Content</div>
    <footer>…</footer>
  </main>
</body>

📌 Pages & Their Role
📊 Dashboard (index.html)

Displays key metrics:

Total students

Total teachers

Total classes

Attendance rate (today)

Average grades

Include graphs and charts for trends (placeholders acceptable for initial static version).

👩‍🎓 Students (students.html)

List of all students in a table

Search & filter by class

Link to student detail page

Student Detail (student-detail.html):

Personal info

Attendance summary

Grades overview

👨‍🏫 Teachers (teachers.html)

List of teachers

Subjects taught

Contact info

🏫 Classes (classes.html)

List of classes (9A, 10B, etc.)

Assigned teachers

Number of students

📅 Timetable (timetable.html)

Weekly schedule

Responsive table or calendar view

📈 Grades (grades.html)

Class gradebook

Sorting by subject and student

📍 Attendance (attendance.html)

Absence list

Filters by date and class

💬 Messages (messages.html)

Internal communication manager

🗓️ Calendar (calendar.html)

Upcoming events and exams

Integration with full calendar UI

⚙️ Settings (settings.html)

Admin settings

Theme switch

User roles

🔐 Login & Errors

login.html — Login page

404.html — Page not found

🧠 Theme Management

theme.js (simple theme switch):

const themeSwitcher = document.querySelector('#theme-select');
themeSwitcher.addEventListener('change', () => {
  document.documentElement.dataset.theme = themeSwitcher.value;
  localStorage.setItem('theme', themeSwitcher.value);
});

window.onload = () => {
  const saved = localStorage.getItem('theme');
  if (saved) document.documentElement.dataset.theme = saved;
};

🧰 Useful Bootstrap Resources

Bootstrap Admin Templates for inspiration and components.

Some existing dashboard templates (e.g., AdminLTE) show how layouts and UI components are structured.

Free educational admin dashboards (like Kiaalap) can showcase educational-oriented pages.

📅 Next Steps

Create core layout (index.html, sidebar, topbar)

Build Dashboard page

Develop Students + Student Detail

Add other pages with table skeletons

Implement theme switching

Add charts (optional)

✅ Checklist (for Codex Implementation)

 Bootstrap 5 setup (CSS + JS)

 Core layout partials

 Pages directory

 Theme CSS files

 Theme switching script

 Responsive tables & forms

 Navigation links (sidebar)