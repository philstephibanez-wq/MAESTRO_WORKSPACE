# P112Q2J4 — ASAP real Mailpit live recipe

## Contrat

Cette étape corrige la recette visible ASAP pour remplacer le faux mail local par un vrai test Mailpit.

## Mailpit réel

La recette exige Mailpit réel :

- SMTP 127.0.0.1:1025
- API 127.0.0.1:8025
- endpoint API attendu : `/api/v1/messages`

Un mail est envoyé par SMTP vers Mailpit, puis recherché par l'API HTTP Mailpit.

## Marqueurs vérifiés

- `ASAP_MAILPIT_AVAILABLE_OK`
- `ASAP_MAIL_SEND_OK`
- `ASAP_MAIL_RECEIVED_OK`
- `ASAP_MAIL_CONTENT_OK`
- `ASAP_MAILPIT_RECEIVED_OK`
- `ASAP_REAL_MAILPIT_SMTP_OK`

## Dashboard vivant

Le dashboard visible continue à afficher :

- acteur courant
- action courante
- timeline
- transcript HTTP
- Mailpit réel
- LSTSAR
- event stream

Le panneau mail doit montrer un envoi SMTP réel et une réception vérifiée par l'API Mailpit.

## Échec explicite

Si Mailpit n'est pas lancé ou pas accessible, la recette échoue clairement avec :

- `ASAP_MAILPIT_HTTP_API_UNAVAILABLE`
- `ASAP_MAILPIT_SMTP_UNAVAILABLE`
- `ASAP_MAIL_NOT_RECEIVED_FAIL`
- `ASAP_MAILPIT_CONTENT_MISSING`

## Anti-régression

Cette recette est inscrite dans le manifest global via `real_mailpit_life_recipe`.

Aucun OK mail ne doit être validé par simple JSON local.
