# R8B7B handoff

Baseline OPUS: `3b69781797e254f7e955c018c51002801f22fec7`.

Native differential ZIP: `R8B7B.zip`.

Changed files: `sites/owasys-front/config/site.json`, `sites/owasys-front/application/default/services/LocaleRegistry.php`, and 38 exact regional catalogs under `sites/owasys-front/application/default/local/`, including new `en-EN.json`.

Acceptance gate: clean expected baseline, apply ZIP, PHP lint LocaleRegistry, parse all configured regional JSON catalogs, `git diff --check`, then runtime check locale selector and Application menu label.

R8B7A is superseded and must not be applied.
