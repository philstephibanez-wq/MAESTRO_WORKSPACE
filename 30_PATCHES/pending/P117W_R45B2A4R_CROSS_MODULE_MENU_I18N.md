# P117W R45B2A4R — Cross-module FSM menu I18n

State: INVALID ARTIFACT — SUPERSEDED BY R45B2A4S

## Root cause targeted

After R45B2A4M/R45B2A4N, `Menu = FSM` projects every FSM state into the principal menu. `OwasysScorePageRenderer::normalizeI18nViewData()` still translated every state label and every signal target label through the active page module runtime only.

On `/applications`, the active module is `registry`. The `creation` state uses `navigation.label = creation.title`; `creation.title` belongs to the `creation` module catalog, not `default + registry`. The same architectural defect applies to `login/auth.sign_in`, `account/auth.change_password`, and future cross-module state labels.

## Artifact failure

Artifact `opus_p117w_r45b2a4r_cross_module_menu_i18n.zip` with SHA-256 `4359ae62234abfa43f4429b49966a889ea94455882cdd75a59791cfea2c59bfe` is INVALID and MUST NOT be reapplied.

Owner execution proved a PHP parse error before any tracked write:

`PHP Parse error: Unclosed '(' on line 173 ... on line 348`

Audit of the delivered runner found the exact packaging defect: the second replacement nowdoc opened with `<<<'NEW'` was closed with `OLD,` instead of `NEW,`. This is a delivery-script syntax defect; no OPUS/OWASYS tracked source was modified by R45B2A4R.

## Supersession

R45B2A4S reissues the same architectural correction against OPUS HEAD `c5122e03b40f6f483e325e7f0192984dd089c093`, while accepting R45B2A4Q already applied but not committed.

R45B2A4S runner requirements:

- runner itself must pass `php -l` before ZIP creation;
- all nowdoc/heredoc open/close markers must be balanced;
- patched `ScorePageRenderer.php` must be linted before tracked write;
- A4Q constructor migration must prove 4/4 valid call sites;
- all FSM state labels must resolve through their own module runtime for every selectable locale;
- no duplication of module-local translations into `default`;
- `Menu = FSM`, signal routing, ACL, SCORE and NMI semantics remain unchanged.

The assistant does not commit or push OPUS/OWASYS.