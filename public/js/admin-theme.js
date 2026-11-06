(function () {
  const storageKey = 'brillant-admin-theme';
  const root = document.documentElement;
  const validThemes = ['dark', 'light'];

  function applyTheme(theme) {
    const selected = validThemes.includes(theme) ? theme : 'dark';
    root.dataset.adminTheme = selected;
    try { localStorage.setItem(storageKey, selected); } catch (_) {}

    document.querySelectorAll('[data-theme-toggle]').forEach(button => {
      const nextTheme = selected === 'dark' ? 'light' : 'dark';
      const label = nextTheme === 'light' ? 'Kalo në temën e çelët' : 'Kalo në temën e errët';
      button.setAttribute('aria-label', label);
      button.setAttribute('title', label);
      button.setAttribute('aria-pressed', selected === 'dark' ? 'true' : 'false');
      const icon = button.querySelector('[data-theme-icon]');
      if (icon) icon.className = selected === 'dark' ? 'fa fa-sun' : 'fa fa-moon';
      const text = button.querySelector('[data-theme-label]');
      if (text) text.textContent = selected === 'dark' ? 'Tema e çelët' : 'Tema e errët';
    });
  }

  document.addEventListener('click', event => {
    const button = event.target.closest('[data-theme-toggle]');
    if (!button) return;
    applyTheme(root.dataset.adminTheme === 'dark' ? 'light' : 'dark');
  });

  applyTheme(root.dataset.adminTheme || 'dark');
})();
