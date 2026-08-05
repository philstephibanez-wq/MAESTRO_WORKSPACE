# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-05

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_SECURE_SOURCE_EDITOR_AND_GIT_WORKFLOW_2026-08-05.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E1_SOURCE_WORKSPACE_2026-08-05.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_E2A_SOURCE_REST_COMPOSER_2026-08-05.md`
7. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_E2A_SOURCE_REST_COMPOSER_2026-08-05.md`
8. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base exacte

OPUS `master` : `60f45aae8ee6f3a10096069076900a41c33d9a19`.

E1 est acquis et publié à cette base. Sa comparaison avec la base précédente contient exactement les trois fichiers annoncés.

## Livrable actif

```text
ZIP     : opus_p117w_e2a_source_rest_composer.zip
SHA-256 : cb6ff147974ef987cb416a106f28a6b4f13fabcb20a62d6e4b3f986c25ea7f13
FILES   : 7
BASE    : 60f45aae8ee6f3a10096069076900a41c33d9a19
STATUS  : livré, application, validation et push owner requis
```

Cible : frontière Sources E2A dans `owasys-back` et extensions génériques OPUS nécessaires au transport structuré REST/Composer.

Le contenu et le hash de version restent dans la requête Composer structurée et ne passent jamais dans `argv`.

Aucun fichier `owasys-front`, aucun site généré et aucune opération Git ne sont ciblés.
Le smoke owner est fourni séparément du ZIP.

## Suite après acquisition

E2B : éditeur Sources dans `owasys-front`, POST backend, preview distincte de write, ViewModel, SCORE, conflit explicite, maintien du fichier et de la locale dans l’URL et fallback sans JavaScript obligatoire.

E3 : Git contrôlé, séparé de l’enregistrement Source et sans push implicite.

NO ACL BYPASS.
NO CONTENT IN ARGV.
NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO FALLBACK SILENCIEUX.
NO LOCAL SITE FIX.
NO PUSH OPUS PAR L’ASSISTANT.
