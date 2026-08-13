# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-13

## Lecture obligatoire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A23_LOCALIZED_PUBLIC_ROUTES_2026-08-13.md`
5. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A23_LOCALIZED_PUBLIC_ROUTES_2026-08-13.md`

## Base OPUS publiée

`2e17008ad0cf23e70195ee2c0f6c947ecb5333be` — `opus_p117w_r45d2a22d_account_canonical_route_alias`.

Les gates navigateur précédents sont acquis.

## Gate actif

R45D2A23 — routes publiques localisées avec accents.

Le frontend conserve des routes internes stables. `Opus\Http\LocalizedRouteResolver` traduit les chemins publics dans les deux sens.

Exemples français :

- `/fr-FR/sécurité`
- `/fr-FR/compte/mot-de-passe`
- `/fr-FR/sources-de-données`
- `/fr-FR/sources-et-git/...`
- `/fr-FR/construction-et-validation`

Le catalogue couvre les 25 langues de base. Les variantes régionales héritent de la langue de base. Les accents sont conservés. Les chemins de ressources restent opaques. La localisation concerne uniquement le frontend.

## Livrable actif

`opus_p117w_r45d2a23_localized_public_routes.zip`

SHA-256 : `f1b6cd0ef27512e425dcfda61254f253559b4b606d0b69ed1a7951687eda3e99`.
