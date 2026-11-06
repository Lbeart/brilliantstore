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
      if (icon) {
        const prefix = icon.dataset.themePrefix || 'fa';
        if (prefix === 'text') {
          icon.textContent = selected === 'dark' ? '☼' : '☾';
        } else {
          icon.className = prefix + ' ' + prefix + '-' + (selected === 'dark' ? 'sun' : 'moon');
        }
      }
      const text = button.querySelector('[data-theme-label]');
      if (text) text.textContent = selected === 'dark' ? 'Tema e çelët' : 'Tema e errët';
    });
  }

  document.addEventListener('click', event => {
    const button = event.target.closest('[data-theme-toggle]');
    if (!button) return;
    applyTheme(root.dataset.adminTheme === 'dark' ? 'light' : 'dark');
  });

  if (!location.pathname.startsWith('/admin') && document.body && !document.querySelector('[data-theme-toggle]')) {
    const toggle = document.createElement('button');
    toggle.type = 'button';
    toggle.className = 'global-theme-toggle';
    toggle.setAttribute('data-theme-toggle', '');
    toggle.setAttribute('aria-label', 'Kalo në temën e çelët');
    toggle.innerHTML = '<span aria-hidden="true" data-theme-icon data-theme-prefix="text">☼</span><span data-theme-label>Tema e çelët</span>';
    const nav = document.querySelector('.navbar-custom .navbar-nav, .navbar .navbar-nav');
    if (nav) {
      const item = document.createElement('li');
      item.className = 'nav-item theme-toggle-nav-item';
      item.appendChild(toggle);
      nav.appendChild(item);
    } else {
      document.body.appendChild(toggle);
    }
  }

  let savedTheme = 'dark';
  try { savedTheme = localStorage.getItem(storageKey) || 'dark'; } catch (_) {}
  applyTheme(root.dataset.adminTheme || savedTheme);
})();
