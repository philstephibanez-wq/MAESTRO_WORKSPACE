(() => {
  'use strict';

  const ROBOT_ID = 'OPUS_REFBOOK_ROBOT';
  const selectors = [
    ['header', '.site-header'],
    ['brand', '.site-brand'],
    ['search', '.top-search'],
    ['theme', '.theme-switcher'],
    ['language', '.language-switcher'],
    ['sidebar', '.sidebar'],
    ['content', '.content']
  ];

  function evaluateContract() {
    const checks = selectors.map(([name, selector]) => ({
      name,
      selector,
      ok: Boolean(document.querySelector(selector))
    }));

    const failed = checks.filter((check) => !check.ok);
    const htmlLang = document.documentElement.getAttribute('lang') || '';
    const title = document.title || '';

    return {
      id: ROBOT_ID,
      ok: failed.length === 0,
      failed,
      checks,
      htmlLang,
      title,
      url: String(window.location.href)
    };
  }

  function installMeta(report) {
    let meta = document.querySelector('meta[name="opus-refbook-robot"]');
    if (!meta) {
      meta = document.createElement('meta');
      meta.setAttribute('name', 'opus-refbook-robot');
      document.head.appendChild(meta);
    }
    meta.setAttribute('content', report.ok ? 'OK' : 'FAILED');
    document.documentElement.dataset.opusRefbookRobot = report.ok ? 'ok' : 'failed';
  }

  function installBadge(report) {
    const old = document.getElementById('opus-refbook-robot-badge');
    if (old) {
      old.remove();
    }

    const badge = document.createElement('aside');
    badge.id = 'opus-refbook-robot-badge';
    badge.setAttribute('aria-live', 'polite');
    badge.style.cssText = [
      'position:fixed',
      'right:12px',
      'bottom:12px',
      'z-index:2147483647',
      'max-width:320px',
      'padding:10px 12px',
      'border-radius:12px',
      'font:12px/1.35 system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif',
      'box-shadow:0 12px 28px rgba(0,0,0,.24)',
      'border:1px solid rgba(255,255,255,.22)',
      report.ok ? 'background:#065f46;color:#ecfdf5' : 'background:#7f1d1d;color:#fef2f2'
    ].join(';');

    const failedText = report.failed.length === 0
      ? 'Header · Search · Theme · Lang · Sidebar · Content OK'
      : 'Missing: ' + report.failed.map((check) => check.name).join(', ');

    badge.innerHTML = ''
      + '<strong style="display:block;margin-bottom:4px">Opus RefBook Robot — ' + (report.ok ? 'OK' : 'FAILED') + '</strong>'
      + '<span>' + escapeHtml(failedText) + '</span>';

    document.body.appendChild(badge);
  }

  function escapeHtml(value) {
    return String(value)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  function run() {
    const report = evaluateContract();
    installMeta(report);
    installBadge(report);
    console.info(ROBOT_ID, report);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', run, { once: true });
  } else {
    run();
  }
})();
