(() => {
  const containers = document.querySelectorAll('[data-include]');
  if (!containers.length) return;

  const base = document.body.dataset.base || '';
  const page = document.body.dataset.page || '';
  const sidebarMeta = {
    title: document.body.dataset.sidebarTitle,
    body: document.body.dataset.sidebarBody,
    badgeText: document.body.dataset.sidebarBadgeText,
    badgeClass: document.body.dataset.sidebarBadgeClass,
    badgeIcon: document.body.dataset.sidebarBadgeIcon,
  };
  const topbarMeta = {
    title: document.body.dataset.topbarTitle,
    subtitle: document.body.dataset.topbarSubtitle,
    search: document.body.dataset.topbarSearch,
    cta: document.body.dataset.topbarCta,
    ctaClass: document.body.dataset.topbarCtaClass,
    ctaHref: document.body.dataset.topbarCtaHref,
    avatar: document.body.dataset.topbarAvatar,
  };
  const footerMeta = {
    text: document.body.dataset.footerText,
  };

  const applySidebarMeta = (root) => {
    if (sidebarMeta.title) {
      const target = root.querySelector('[data-sidebar-title]');
      if (target) target.textContent = sidebarMeta.title;
    }

    if (sidebarMeta.body) {
      const target = root.querySelector('[data-sidebar-body]');
      if (target) target.textContent = sidebarMeta.body;
    }

    if (sidebarMeta.badgeText) {
      const target = root.querySelector('[data-sidebar-badge-text]');
      if (target) target.textContent = sidebarMeta.badgeText;
    }

    if (sidebarMeta.badgeClass) {
      const badge = root.querySelector('[data-sidebar-badge]');
      if (badge) badge.className = `badge-soft ${sidebarMeta.badgeClass}`;
    }

    if (sidebarMeta.badgeIcon) {
      const icon = root.querySelector('[data-sidebar-badge-icon]');
      if (icon) icon.className = `bi ${sidebarMeta.badgeIcon}`;
    }
  };

  const applyNavState = (root) => {
    if (!page) return;
    const link = root.querySelector(`[data-page="${page}"]`);
    if (link) {
      link.classList.add('active');
      link.setAttribute('aria-current', 'page');
    }
  };

  const applyTopbarMeta = (root) => {
    if (topbarMeta.title) {
      const target = root.querySelector('[data-topbar-title]');
      if (target) target.textContent = topbarMeta.title;
    }

    if (topbarMeta.subtitle) {
      const target = root.querySelector('[data-topbar-subtitle]');
      if (target) target.textContent = topbarMeta.subtitle;
    }

    if (topbarMeta.search) {
      const target = root.querySelector('[data-topbar-search]');
      if (target) {
        target.setAttribute('placeholder', topbarMeta.search);
        target.setAttribute('aria-label', topbarMeta.search);
      }
    }

    if (topbarMeta.cta) {
      const target = root.querySelector('[data-topbar-cta]');
      if (target) target.textContent = topbarMeta.cta;
    }

    if (topbarMeta.ctaClass) {
      const target = root.querySelector('[data-topbar-cta]');
      if (target) target.className = topbarMeta.ctaClass;
    }

    if (topbarMeta.ctaHref) {
      const target = root.querySelector('[data-topbar-cta]');
      if (target) target.setAttribute('href', topbarMeta.ctaHref);
    }

    if (topbarMeta.avatar) {
      const target = root.querySelector('[data-topbar-avatar]');
      if (target) target.textContent = topbarMeta.avatar;
    }
  };

  const applyFooterMeta = (root) => {
    if (footerMeta.text) {
      const target = root.querySelector('[data-footer-text]');
      if (target) target.textContent = footerMeta.text;
    }
  };

  containers.forEach((container) => {
    const url = container.dataset.include;
    if (!url) return;

    fetch(url)
      .then((response) => {
        if (!response.ok) throw new Error('Include failed');
        return response.text();
      })
      .then((html) => {
        container.innerHTML = html;
        container.querySelectorAll('[data-href]').forEach((link) => {
          link.setAttribute('href', `${base}${link.dataset.href}`);
        });
        applyNavState(container);
        applySidebarMeta(container);
        applyTopbarMeta(container);
        applyFooterMeta(container);
        window.dispatchEvent(new Event('includes:loaded'));
      })
      .catch(() => {});
  });
})();
