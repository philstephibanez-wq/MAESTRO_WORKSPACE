# HANDOFF — OPUS P117W R45D2A10 LOGIN PRG PROFILER CORRELATION

Date : 2026-08-10

## Base canonique

OPUS master = `6dbc92bd48e03ba84325f6d68c304c76f73026e1`

## État acquis

- message utilisateur après échec login : acquis ;
- I18n du message : acquis ;
- Profiler intégré/repliable : acquis ;
- détail technique `OPUS_SSO_LOCAL_PASSWORD_INVALID` : acquis dans la trace POST ;
- défaut courant : après PRG, l'iframe montre la trace GET et `Security / ACL / SSO = 0`.

## Livrable R45D2A10

`opus_p117w_r45d2a10_login_prg_profiler_correlation.zip`

SHA-256 : `45f27e30c6342bee90359281b7ef4d60c71b2f20dcbd6394ab5c7d4c401819d2`

Base : `6dbc92bd48e03ba84325f6d68c304c76f73026e1`

Fichier : `tools/r45d2a10_apply_login_prg_profiler_correlation.php`

## Effet attendu

Après un mauvais mot de passe :

1. le POST enregistre `security.sso.authentication.failed` dans sa trace réelle ;
2. le flash conserve `trace_id` + état d'erreur utilisateur ;
3. réponse 303 vers le login ;
4. le GET affiche `Identifiant ou mot de passe incorrect.` ;
5. l'iframe Profiler pointe sur la trace du POST corrélé ;
6. `Security / ACL / SSO` affiche l'événement réel et son `error_code` ;
7. le flash et son `trace_id` sont consommés.

NO SITE-SPECIFIC PATCH.
NO ACL/SSO RELAXATION.
NO SYNTHETIC PROFILER EVENT.
NO PUSH OPUS BY ASSISTANT.
