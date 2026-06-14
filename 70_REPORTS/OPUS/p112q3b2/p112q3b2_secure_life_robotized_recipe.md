# P112Q3B2 â€” Opus Secure Life Robotized Recipe

- Generated at: `2026-06-14T00:32:20+00:00`
- Mail status: `EML_WRITTEN`
- Panther status: `SKIPPED`

| User | Lang | Method | Type | Route | Expected | Observed | Result |
|---|---:|---:|---|---|---|---|---|
| guest | FR | GET | navigation | `/opus-secure-life/fr/public` | ALLOWED | ALLOWED | OK |
| editor | ES | GET | navigation | `/opus-secure-life/es/editor` | ALLOWED | ALLOWED | OK |
| admin | EN | GET | navigation | `/opus-secure-life/en/admin` | ALLOWED | ALLOWED | OK |
| guest | FR | GET | navigation | `/opus-secure-life/en/admin` | DENIED | DENIED | OK |
| editor | ES | GET | navigation | `/opus-secure-life/en/admin` | DENIED | DENIED | OK |
| guest | FR | POST | form | `/opus-secure-life/fr/contact` | ALLOWED | ALLOWED | OK |
| editor | ES | POST | form | `/opus-secure-life/es/editor/form` | ALLOWED | ALLOWED | OK |
| admin | EN | POST | form | `/opus-secure-life/en/admin/settings` | ALLOWED | ALLOWED | OK |
| guest | FR | POST | form | `/opus-secure-life/en/admin/settings` | DENIED | DENIED | OK |
| editor | ES | POST | form | `/opus-secure-life/en/admin/settings` | DENIED | DENIED | OK |
| guest | FR | GET | form | `/opus-secure-life/fr/contact` | DENIED | DENIED | OK |
