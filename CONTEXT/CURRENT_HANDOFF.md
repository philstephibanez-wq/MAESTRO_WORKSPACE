# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-01

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R46B2_HTTP_ROOT_SPAN_2026-08-01.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Base exacte

- OPUS HEAD owner : `7e07e43c1aa148bd198918cb5d8051d06c428620` — R46C3.
- R46C3 validé par preuve HTTP/DOM et poussé.
- Site témoin : `fullstack-test`; ne jamais le corriger directement.

## État réel

- iframe same-origin, session OWASYS, ACL et SCORE Profiler validés ;
- trace GET visible : cinq événements, zéro span ;
- cause : absence de span HTTP racine dans le Singleton frontend ;
- les spans REST restent réservés aux appels REST réellement exécutés.

## Livraison active

`opus_p117w_r46b2_http_root_span.zip`  
SHA-256 : `f2435b8451d4ca64bb0353868445dcbc1464be2c1a256efde79337ffee5fb991`

## Action owner immédiate

1. Appliquer R46B2 sur OPUS HEAD `7e07e43c`.
2. Linter le fichier unique et régénérer l'autoload.
3. Recharger une page GET avec `?profiler=1`.
4. Accepter seulement si un span HTTP réel est affiché et si aucun span REST/Composer n'est inventé.
5. Commit/push OPUS uniquement après validation.

## État à ne pas falsifier

- archive et structure vérifiées ;
- `git diff --check` propre ;
- PHP/Composer indisponibles dans l'environnement de construction ;
- R46B2 non accepté tant que la recette owner n'est pas réussie ;
- aucune modification OPUS/OWASYS poussée par l'assistant.

NO EVENT, NO CLAIM.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
