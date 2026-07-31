# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-31

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R46C1_PROFILER_SCORE_IFRAME_2026-07-31.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Base exacte

- OPUS GitHub : `ecdd12c` — `opus_p117w_r46b1_profiler_rest_collector`.
- R46A1 validé et poussé.
- R46B1 présent sur `master`.
- R46C1 livré, non encore appliqué ni validé owner.
- Site témoin : `fullstack-test`; ne jamais le corriger directement.

## Livraison active

`opus_p117w_r46c1_profiler_score_iframe.zip`  
SHA-256 : `339db6148b5a8202fcd5c1c0127fa3e2fe6f9b925ed9e047fe8f345034828098`

R46C1 consolide l'ancien Web Profiler OPUS avec le stockage JSONL V2, sert la route same-origin protégée, rend le SCORE générique et l'affiche dans l'iframe de l'`aside` OWASYS.

## État à ne pas falsifier

- Le ZIP est construit et vérifié structurellement.
- PHP/Composer ne sont pas disponibles dans l'environnement de construction.
- L'iframe n'est pas déclarée acquise tant que l'owner n'a pas appliqué le ZIP, exécuté les contrôles et fourni la preuve HTTP/DOM.
- La barre compacte complète et les douze rubriques contractuelles restent des incréments ultérieurs de R46C.

## Invariants

- OPUS sert la représentation Profiler ; OWASYS n'héberge que l'`aside` et l'iframe.
- SCORE uniquement ; aucun HTML produit par PHP.
- `profiler:view` deny-by-default et environnement de développement obligatoire.
- `frame-ancestors 'self'` et same-origin.
- Aucun événement absent ne doit être affirmé.
- Aucun partage de fichiers front/back.
- Aucun JavaScript dans `owasys-back`.

NO EVENT, NO CLAIM.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
