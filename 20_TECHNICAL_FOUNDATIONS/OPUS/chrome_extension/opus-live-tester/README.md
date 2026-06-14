# OPUS Live Tester

Workspace-only Chrome extension used by the OPUS live recipe.

It is not part of the public OPUS product root. It is a development/testing helper stored under MAESTRO_WORKSPACE.

Current checks:

- injects a visible OPUS LIVE TESTER badge on localhost pages;
- counts page links;
- reports empty or invalid links;
- exposes results through `document.documentElement.dataset` and the browser console.

Supported local hosts:

- `http://127.0.0.1/*`
- `http://localhost/*`
