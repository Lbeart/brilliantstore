(function () {
  const menu = document.getElementById('storefrontMainMenu');
  const toggle = document.querySelector('.storefront-site-header .menu-toggle');
  const header = document.querySelector('.storefront-site-header');
  if (!menu || !toggle || !header) return;

  const openLabel = toggle.dataset.openLabel || 'Hap menynë';
  const closeLabel = toggle.dataset.closeLabel || 'Mbyll menynë';

  function setOpen(open) {
    menu.classList.toggle('open', open);
    document.body.classList.toggle('storefront-menu-open', open);
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    toggle.setAttribute('aria-label', open ? closeLabel : openLabel);
    toggle.innerHTML = '<i class="bi ' + (open ? 'bi-x-lg' : 'bi-list') + '" aria-hidden="true"></i>';
  }

  toggle.dataset.openLabel = openLabel;
  toggle.dataset.closeLabel = closeLabel;
  toggle.addEventListener('click', event => {
    event.preventDefault();
    event.stopPropagation();
    setOpen(toggle.getAttribute('aria-expanded') !== 'true');
  });

  menu.addEventListener('click', event => {
    if (event.target.closest('a')) setOpen(false);
  });

  document.addEventListener('click', event => {
    if (toggle.getAttribute('aria-expanded') === 'true' && !header.contains(event.target)) setOpen(false);
  });

  document.addEventListener('keydown', event => {
    if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
      setOpen(false);
      toggle.focus();
    }
  });

  const desktop = window.matchMedia('(min-width: 901px)');
  desktop.addEventListener?.('change', event => { if (event.matches) setOpen(false); });
})();
