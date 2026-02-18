(() => {
  const root = document.documentElement;

  const applyTheme = (value) => {
    if (!value) return;
    root.dataset.theme = value;
  };

  const saved = localStorage.getItem('theme');
  if (saved) {
    applyTheme(saved);
  }

  const bindThemeSelect = () => {
    const themeSelect = document.querySelector('#theme-select');
    if (!themeSelect || themeSelect.dataset.bound === 'true') return;
    themeSelect.dataset.bound = 'true';

    const current = localStorage.getItem('theme');
    if (current) {
      themeSelect.value = current;
    }

    themeSelect.addEventListener('change', (event) => {
      const value = event.target.value;
      applyTheme(value);
      localStorage.setItem('theme', value);
    });
  };

  window.addEventListener('includes:loaded', bindThemeSelect);
  bindThemeSelect();
})();
