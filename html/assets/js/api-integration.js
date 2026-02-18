/**
 * API Integration Module for Admin Scoala
 * Handles all communication with Laravel API backend
 */

const ApiIntegration = (() => {
  const API_BASE = 'http://localhost:8000/api';

  // Generic API methods
  const request = async (method, endpoint, data = null) => {
    try {
      const options = {
        method,
        headers: { 'Content-Type': 'application/json' },
      };
      if (data) options.body = JSON.stringify(data);

      const response = await fetch(`${API_BASE}${endpoint}`, options);
      if (!response.ok) {
        throw new Error(`API Error ${response.status}: ${response.statusText}`);
      }
      return response.status === 204 ? null : await response.json();
    } catch (error) {
      console.error(`API Error (${method} ${endpoint}):`, error);
      return null;
    }
  };

  // Teachers API
  const teachers = {
    async getAll() {
      return await request('GET', '/teachers');
    },
    async getById(id) {
      return await request('GET', `/teachers/${id}`);
    },
    async create(data) {
      return await request('POST', '/teachers', data);
    },
    async update(id, data) {
      return await request('PUT', `/teachers/${id}`, data);
    },
    async delete(id) {
      return await request('DELETE', `/teachers/${id}`);
    }
  };

  // Timetables API
  const timetables = {
    async getAll() {
      return await request('GET', '/timetables');
    },
    async getById(id) {
      return await request('GET', `/timetables/${id}`);
    },
    async create(data) {
      return await request('POST', '/timetables', data);
    },
    async update(id, data) {
      return await request('PUT', `/timetables/${id}`, data);
    },
    async delete(id) {
      return await request('DELETE', `/timetables/${id}`);
    },
    async getByTeacher(teacherId) {
      const allTimetables = await this.getAll();
      return allTimetables ? allTimetables.filter(t => t.teacher_id === teacherId) : [];
    }
  };

  // Teacher Profiles API
  const profiles = {
    async get(teacherId) {
      return await request('GET', `/teachers/${teacherId}/profile`);
    },
    async save(teacherId, data) {
      return await request('POST', `/teachers/${teacherId}/profile`, data);
    },
    async update(teacherId, data) {
      return await request('PUT', `/teachers/${teacherId}/profile`, data);
    },
    async delete(teacherId) {
      return await request('DELETE', `/teachers/${teacherId}/profile`);
    }
  };

  // DOM Population helpers
  const dom = {
    populateTeachersTable(selector, teachers) {
      const table = document.querySelector(selector);
      if (!table || !teachers || !Array.isArray(teachers)) return;

      const tbody = table.querySelector('tbody');
      if (!tbody) return;

      tbody.innerHTML = teachers.map(teacher => `
        <tr>
          <td>
            <strong>${teacher.name}</strong>
            <div class="text-muted">${teacher.role || 'N/A'}</div>
          </td>
          <td>${teacher.subject || 'N/A'}</td>
          <td><a href="pages/teacher-detail.html?id=${teacher.id}">Vezi clase</a></td>
          <td>${teacher.phone || 'N/A'}</td>
          <td class="text-end">
            <div class="table-actions">
              <a class="btn btn-sm btn-outline-info" href="pages/teacher-profile.html?id=${teacher.id}">Profil</a>
              <a class="btn btn-sm btn-outline-secondary" href="pages/teacher-edit.html?id=${teacher.id}">Editeaza</a>
              <button class="btn btn-sm btn-outline-danger" onclick="ApiIntegration.deleteTeacher(${teacher.id})">Sterge</button>
            </div>
          </td>
        </tr>
      `).join('');
    },

    populateTimetableTable(selector, timetables) {
      const table = document.querySelector(selector);
      if (!table || !timetables || !Array.isArray(timetables)) return;

      const tbody = table.querySelector('tbody');
      if (!tbody) return;

      // Group by day for display
      const days = ['Luni', 'Marti', 'Miercuri', 'Joi', 'Vineri'];
      const timeSlots = {};

      timetables.forEach(tt => {
        const key = `${tt.start_time}-${tt.end_time}`;
        if (!timeSlots[key]) {
          timeSlots[key] = { start_time: tt.start_time, end_time: tt.end_time, days: {} };
        }
        timeSlots[key].days[tt.day] = tt;
      });

      tbody.innerHTML = Object.entries(timeSlots).map(([key, slot]) => {
        const daysHtml = days.map(day => {
          const tt = slot.days[day];
          if (!tt) return '<td>Liber</td>';
          return `<td>
            ${tt.subject || 'N/A'}<br>
            <div class="text-muted small">${tt.teacher?.name || 'N/A'}</div>
          </td>`;
        }).join('');

        return `<tr>
          <td>${slot.start_time} - ${slot.end_time}</td>
          ${daysHtml}
        </tr>`;
      }).join('');
    },

    fillTeacherSelect(selector) {
      const select = document.querySelector(selector);
      if (!select) return;

      teachers.getAll().then(teachersList => {
        if (!teachersList) return;
        select.innerHTML = '<option value="">-- Selecteaza profesor --</option>' +
          teachersList.map(t => `<option value="${t.id}">${t.name}</option>`).join('');
      });
    }
  };

  // Utility: Delete teacher with confirmation
  const deleteTeacher = (id) => {
    if (!confirm('Esti sigur ca vrei sa stergi acest profesor?')) return;
    teachers.delete(id).then(() => {
      alert('Profesor sters cu succes!');
      location.reload();
    });
  };

  // Public API
  return {
    API_BASE,
    teachers,
    timetables,
    profiles,
    dom,
    deleteTeacher,
    request
  };
})();

// Expose globally for use in HTML
window.ApiIntegration = ApiIntegration;
