(() => {
  'use strict';

  const badgeId = 'opus-live-tester-badge';
  const allowedHosts = new Set(['127.0.0.1', 'localhost']);

  if (!allowedHosts.has(window.location.hostname)) {
    return;
  }

  const existing = document.getElementById(badgeId);
  if (existing) {
    existing.remove();
  }

  const anchors = Array.from(document.querySelectorAll('a[href]'));
  const brokenAnchors = anchors.filter((anchor) => {
    const href = anchor.getAttribute('href') || '';
    if (href.trim() === '' || href.trim() === '#') {
      return true;
    }
    try {
      new URL(href, window.location.href);
      return false;
    } catch (error) {
      return true;
    }
  });

  const badge = document.createElement('aside');
  badge.id = badgeId;
  badge.setAttribute('role', 'status');
  badge.style.position = 'fixed';
  badge.style.right = '12px';
  badge.style.bottom = '12px';
  badge.style.zIndex = '2147483647';
  badge.style.maxWidth = '360px';
  badge.style.padding = '12px 14px';
  badge.style.borderRadius = '12px';
  badge.style.background = '#111827';
  badge.style.color = '#f9fafb';
  badge.style.fontFamily = 'Arial, sans-serif';
  badge.style.fontSize = '13px';
  badge.style.lineHeight = '1.35';
  badge.style.boxShadow = '0 10px 28px rgba(0, 0, 0, 0.35)';
  badge.style.border = brokenAnchors.length ? '2px solid #f97316' : '2px solid #22c55e';

  const status = brokenAnchors.length ? 'REVIEW' : 'OK';
  badge.innerHTML = [
    '<strong>OPUS LIVE TESTER</strong>',
    '<div>Status: ' + status + '</div>',
    '<div>URL: ' + window.location.pathname + '</div>',
    '<div>Links: ' + anchors.length + '</div>',
    '<div>Empty/invalid links: ' + brokenAnchors.length + '</div>'
  ].join('');

  document.documentElement.dataset.opusLiveTesterStatus = status;
  document.documentElement.dataset.opusLiveTesterLinks = String(anchors.length);
  document.documentElement.dataset.opusLiveTesterBrokenLinks = String(brokenAnchors.length);
  document.body.appendChild(badge);

  console.info('[OPUS Live Tester]', {
    status,
    href: window.location.href,
    links: anchors.length,
    emptyOrInvalidLinks: brokenAnchors.length
  });
})();
