(() => {
  'use strict';

  const checklist = [
    'OPUS_REF_BOOK Chrome robot checklist',
    '- Extension loaded unpacked from tools/chrome_extension/opus_refbook_robot',
    '- Page opened at http://127.0.0.1/OPUS_REF_BOOK/ or http://localhost/OPUS_REF_BOOK/',
    '- Badge visible at bottom right',
    '- Badge status is OK',
    '- Header/search/theme/language/sidebar/content visible'
  ].join('\n');

  const status = document.getElementById('status');
  const button = document.getElementById('copy-checklist');

  button.addEventListener('click', async () => {
    try {
      await navigator.clipboard.writeText(checklist);
      status.textContent = 'Checklist copiée.';
    } catch (error) {
      status.textContent = checklist;
    }
  });
})();
