# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-31

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R46C3_CENTRALIZED_SESSION_RUNTIME_2026-07-31.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Base exacte

- OPUS GitHub : `9572f4fa264e21205cd3e4a81f2d19db5a4cc0c6` — `opus_p117w_r46c1_profiler_score_iframe`.
- R46A1 validé et poussé.
- R46B1 présent sur `master`.
- R46C1 appliqué et poussé.
- Site témoin : `fullstack-test`; ne jamais le corriger directement.

## État réel

- l'iframe et sa route same-origin sont prouvées ;
- la recette R46C1 échoue par `OPUS_ACL_DENIED` ;
- R46C2 modifie localement `AuthSession.php`, mais sa recette a échoué et il ne doit pas être committé/poussé ;
- la cause démontrée est l'ouverture non centralisée de la session : la route Profiler appelait `session_start()` sans le nom OWASYS configuré.

## Livraison active

`opus_p117w_r46c3_centralized_session_runtime.zip`  
SHA-256 : `18cf5d05f1f46347e7506ff809216a3f81af8d4fdb0a981a20ff360d46b89c67`

R46C3 centralise l'ouverture de session dans `OwasysSessionRuntime`, injecté depuis le Singleton dans la route Profiler et les trois contrôleurs. Il ne modifie ni ACL ni identité.

## Action owner immédiate

1. Retirer uniquement la modification locale R46C2 de `AuthSession.php` pour revenir au HEAD R46C1.
2. Extraire R46C3.
3. Linter les sept fichiers et régénérer l'autoload.
4. Recharger `?profiler=1` sans supprimer la session.
5. Accepter seulement si l'iframe répond 200 et rend le SCORE Profiler ; puis commit/push OPUS.

## État à ne pas falsifier

- archive et structure vérifiées ;
- `git diff --check` propre ;
- PHP/Composer indisponibles dans l'environnement de construction ;
- R46C3 non accepté tant que la recette HTTP/DOM owner n'est pas réussie ;
- aucune modification OPUS/OWASYS poussée par l'assistant.

## Autorité

```text
Assistant : MAESTRO_WORKSPACE + ZIP différentiel
Owner : retrait R46C2, application R46C3, validation, commit et push OPUS/OWASYS
```

NO ACL BYPASS.  
NO EVENT, NO CLAIM.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
