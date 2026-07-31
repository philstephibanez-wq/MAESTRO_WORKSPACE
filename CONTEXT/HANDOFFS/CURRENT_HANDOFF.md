# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-31

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R46C2_SESSION_IDENTITY_ACL_NORMALIZATION_2026-07-31.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Base exacte

- OPUS GitHub : `9572f4fa264e21205cd3e4a81f2d19db5a4cc0c6` — `opus_p117w_r46c1_profiler_score_iframe`.
- R46A1 validé et poussé.
- R46B1 présent sur `master`.
- R46C1 appliqué et poussé.
- Site témoin : `fullstack-test`; ne jamais le corriger directement.

## Preuve et échec R46C1

- `iframe.ow-profiler-frame` est réellement présente.
- La route OPUS same-origin est réellement appelée.
- La route répond `OPUS_ACL_DENIED` pour une session affichée `admin`.
- R46C1 n'est pas accepté fonctionnellement.

## Cause active

`OwasysAuthSession::user()` retourne sans normalisation l'identité courante `owasys_sso_identity`. L'UI tolère `profile`, tandis que l'ACL ne consomme que `roles`. Le moteur ACL et ses grants ne doivent pas être contournés.

## Livraison active

`opus_p117w_r46c2_session_identity_acl_normalization.zip`  
SHA-256 : `003c8d4d830fa64f1f136b1b86c045188052e9250c99b76daf198d8e2727fde5`

R46C2 contient uniquement le fichier complet `sites/owasys-front/application/default/models/AuthSession.php`. Il normalise et valide toutes les identités de session à la frontière, migre `profile` seulement lorsque `roles` est absent et refuse les rôles explicitement invalides.

## État à ne pas falsifier

- archive et structure vérifiées ;
- PHP/Composer indisponibles dans l'environnement de construction ;
- lint, tests ACL et recette HTTP/DOM owner requis ;
- R46C2 non accepté tant que l'iframe ne rend pas le SCORE pour admin/developer et ne refuse pas viewer/session absente ;
- barre compacte complète et douze rubriques R46C encore incomplètes.

## Autorité

```text
Assistant : MAESTRO_WORKSPACE + ZIP différentiel
Owner : application, validation, commit et push OPUS/OWASYS
```

NO ACL BYPASS.  
NO EVENT, NO CLAIM.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
