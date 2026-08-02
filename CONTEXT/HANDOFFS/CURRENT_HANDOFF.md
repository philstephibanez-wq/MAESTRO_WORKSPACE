# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-03

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Base exacte

- OPUS GitHub : `6bee0bde41fa1bfb7a933c5b667da40fdb2d47d7`.
- Commit owner : `opus_p117w_r46b5b_fsm_started_deduplication`.
- R46A1, R46B1, R46B2, R46B3, R46B4, R46B5, R46B5A, R46B5B, R46C1 et R46C3 sont poussés.
- La preuve runtime confirme la collecte FSM et sa déduplication.
- La capture suivante révèle `Database 0` et l'absence de marquage visuel de l'onglet actif.
- R46B6 est livré sous forme de ZIP différentiel ; validation owner requise.
- R46C2 rejeté et jamais intégré.
- Site témoin : `fullstack-test`; ne jamais le corriger directement.

## Cause R46B6

`/applications` exécute réellement `GET /api/v1/applications`, puis le backend exécute Composer et SQLite. Cependant :

1. `OwasysRegistryModel` construisait `RestClient` sans le Profiler frontend, donc aucun span REST n'était collecté ;
2. le backend persistait les mesures Composer/BDD sous le même `trace_id`, mais dans son stockage autonome ;
3. le Profiler frontend ne fusionnait pas ces enregistrements distribués ;
4. les onglets SCORE n'avaient aucun état actif visible.

R46B6 traite la cause sans accès BDD direct depuis le frontend :

```text
owasys-front → span REST → owasys-back → Composer → SQLite
             ← enregistrements Profiler V2 assainis, même trace_id
```

La télémétrie distante est demandée uniquement en environnement `dev/local/development`, ne contient ni SQL brut, ni paramètres, ni secret, et est rattachée causalement au span REST frontend. Le template SCORE marque l'onglet sélectionné sans JavaScript.

## Ordre de travail

1. Appliquer R46B6 sur OPUS `6bee0bde41fa1bfb7a933c5b667da40fdb2d47d7`.
2. Linter les huit fichiers PHP, exécuter les smokes OPUS/REST/Profiler/FSM et `git diff --check`.
3. Parcourir `/applications?profiler=1`.
4. Vérifier REST, Composer et Database non nuls sur la même trace.
5. Vérifier les spans BDD enfants de Composer, lui-même corrélé au span REST frontend.
6. Vérifier l'absence de SQL, paramètres et secrets.
7. Vérifier que l'onglet courant est visuellement actif.
8. Ne commit/push OPUS qu'après validation owner.

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
