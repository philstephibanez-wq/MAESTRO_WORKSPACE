# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-29

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R31_STANDARD_OPUS_REST_API_COMPOSER_EXCHANGE_2026-07-29.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R32_LOCALE_PRESERVATION_AND_FAST_COMPOSER_DISPATCH_2026-07-29.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R33_SOURCE_LOCALE_ROUTE_SCOPE_FIX_2026-07-29.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R33_SOURCE_LOCALE_ROUTE_SCOPE_FIX_2026-07-29.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base relue : 8b186cbaa0938cd4c89666eac46bf9f4221ba71a
R29 : présent sur master
R30 : invalidé, ne pas appliquer
R31 : API REST OPUS standard, à appliquer
R32 : conservation de locale et dispatch Composer in-process, à appliquer après R31
R33 : correctif obligatoire du TypeError Source après R32
```

## Contrat actif

```text
owasys-front
-> API REST OPUS sécurisée fondée sur des ressources
-> owasys-back
-> script Composer métier allow-listé
-> provider métier
-> résultat structuré
-> réponse HTTP
-> owasys-front
```

Interdire `/api/v1/executions` et les abstractions `Rcp*` dans la chaîne active. Appliquer GET, POST, PUT, PATCH et DELETE selon le CRUD.

R32 conserve la ressource Source pendant un changement de locale et supprime le redémarrage coûteux de `composer.phar` à chaque échange.

R33 corrige la régression de portée introduite dans R32 : `OwasysSourceController::render()` doit construire la route localisée depuis `$selectedPath`, disponible dans cette méthode, et non depuis `$sourcePath`, variable locale de `run()`.

## Incident owner et preuve

```text
Trace frontend : 66742282ed38c98e
Erreur : TypeError
Fichier : sites/owasys-front/application/source/controllers/SourceController.php
Ligne : 181
Backend source.list : succeeded
Mode Composer : in_process
Durée Composer observée : 238.401 ms
```

## Livrable actif

```text
ZIP : opus_p117w_r33_source_locale_route_scope_fix.zip
Base : R31 puis R32
SHA-256 : ea4dca1a3c71144122840741204e62c12b8843c7d50dd5fa870e80f9143a954e
Fichiers : 1
```

## Lancement

```text
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
