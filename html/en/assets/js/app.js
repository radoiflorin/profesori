(() => {
  const closeSidebar = () => document.body.classList.remove('sidebar-open');
  const toggleSidebar = () => document.body.classList.toggle('sidebar-open');

  document.addEventListener('click', (event) => {
    const toggle = event.target.closest('[data-sidebar-toggle]');
    if (toggle) {
      toggleSidebar();
      return;
    }

    if (event.target.closest('.sidebar-overlay')) {
      closeSidebar();
    }
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      closeSidebar();
    }
  });

  const exportTableToCsv = (table, filename) => {
    if (!table) return;
    const rows = Array.from(table.querySelectorAll('tr'));
    const csv = rows
      .map((row) =>
        Array.from(row.querySelectorAll('th, td'))
          .map((cell) => {
            const text = cell.textContent.trim().replace(/\s+/g, ' ');
            const escaped = text.replace(/"/g, '""');
            return `"${escaped}"`;
          })
          .join(',')
      )
      .join('\n');

    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = filename || 'export.csv';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
  };

  document.addEventListener('click', (event) => {
    const exportButton = event.target.closest('[data-export]');
    if (!exportButton) return;

    const type = exportButton.dataset.export;
    if (type === 'pdf') {
      window.print();
      return;
    }

    if (type === 'csv') {
      const targetId = exportButton.dataset.exportTarget;
      const table = targetId ? document.getElementById(targetId) : null;
      exportTableToCsv(table, exportButton.dataset.exportFilename);
    }
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth >= 992) {
      closeSidebar();
    }
  });

  const initDynamicUI = () => {
    const setupCalendarLinks = () => {
      const cells = document.querySelectorAll('.calendar-cell[data-date]');
      if (!cells.length) return;

      const navigate = (cell) => {
        const count = Number.parseInt(cell.dataset.events || '0', 10);
        const date = cell.dataset.date || '';
        let target = 'calendar-add.html';
        if (count === 1) {
          target = `calendar-event-detail.html?date=${encodeURIComponent(date)}`;
        } else if (count > 1) {
          target = `calendar-event-list.html?date=${encodeURIComponent(date)}`;
        }
        window.location.href = target;
      };

      cells.forEach((cell) => {
        if (!cell.classList.contains('is-clickable')) {
          cell.classList.add('is-clickable');
        }
        cell.addEventListener('click', () => navigate(cell));
        cell.addEventListener('keydown', (event) => {
          if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            navigate(cell);
          }
        });
      });
    };

    const setupTopbarMenus = () => {
      const menus = document.querySelectorAll('[data-menu-toggle]');
      if (!menus.length) return;

      const closeAll = () => {
        document.querySelectorAll('.topbar-menu.open').forEach((menu) => {
          menu.classList.remove('open');
        });
      };

      menus.forEach((button) => {
        button.addEventListener('click', (event) => {
          event.stopPropagation();
          const wrapper = button.closest('.topbar-menu');
          if (!wrapper) return;
          const isOpen = wrapper.classList.contains('open');
          closeAll();
          if (!isOpen) {
            wrapper.classList.add('open');
          }
        });
      });

      document.addEventListener('click', (event) => {
        if (!event.target.closest('.topbar-menu')) {
          closeAll();
        }
      });
    };

    const setupLangToggle = () => {
      const toggles = document.querySelectorAll('[data-lang-toggle]');
      if (!toggles.length) return;

      const rawPath = window.location.pathname.replace(/\\/g, '/');
      const isEnglish = rawPath.includes('/en/');
      let targetPath = rawPath;

      if (isEnglish) {
        targetPath = rawPath.replace('/en/', '/');
      } else if (rawPath.includes('/pages/')) {
        targetPath = rawPath.replace('/pages/', '/en/pages/');
      } else {
        targetPath = rawPath.replace(/\/([^\/]*$)/, '/en/$1');
      }

      toggles.forEach((toggle) => {
        if (toggle.tagName === 'A') {
          toggle.href = targetPath;
        }
        toggle.textContent = isEnglish ? 'RO' : 'EN';
        toggle.setAttribute('aria-label', isEnglish ? 'Switch to Romanian' : 'Switch to English');
      });
    };

    const targets = document.querySelectorAll('.topbar-user, .topbar-row');
    targets.forEach((group) => {
      if (group.querySelector('[data-sidebar-toggle]')) return;
      const button = document.createElement('button');
      button.type = 'button';
      button.className = 'btn btn-light btn-icon d-lg-none';
      button.setAttribute('data-sidebar-toggle', '');
      button.setAttribute('aria-label', 'Open menu');
      button.innerHTML = '<i class="bi bi-list"></i>';
      group.prepend(button);
    });

    document.querySelectorAll('.inline-search input').forEach((input) => {
      if (!input.getAttribute('aria-label')) {
        input.setAttribute('aria-label', input.getAttribute('placeholder') || 'Search');
      }
    });

    setupCalendarLinks();
    setupTopbarMenus();
    setupLangToggle();

    const bursierToggle = document.getElementById('bursier');
    const bursaType = document.getElementById('bursa-type');
    if (bursierToggle && bursaType) {
      const syncBursa = () => {
        bursaType.disabled = !bursierToggle.checked;
      };
      syncBursa();
      bursierToggle.addEventListener('change', syncBursa);
    }

    const revealTargets = document.querySelectorAll('.app-card, .stat-card, .chart-card, .calendar-cell');
    revealTargets.forEach((target, index) => {
      if (target.classList.contains('reveal')) return;
      target.classList.add('reveal');
      target.style.setProperty('--reveal-delay', `${index * 60}ms`);
    });
  };

  window.addEventListener('includes:loaded', initDynamicUI);

  window.addEventListener('load', () => {
    initDynamicUI();
    window.requestAnimationFrame(() => {
      document.body.classList.add('is-loaded');
    });
  });
})();
