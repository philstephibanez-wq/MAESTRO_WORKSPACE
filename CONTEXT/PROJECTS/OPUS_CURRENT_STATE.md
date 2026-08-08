# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-09.

## Dépôt publié

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD GitHub : 058984bfb0229bf5f27c74cd2b59c6614bf74b4e
Commit : opus_p117w_r45c2_dev_preview_runtime_fix
Dernier état acquis publié : R45C2
```

## État owner local non publié

Le retour owner indique :

```text
HEAD local : 0e0e54857214144d6c98ebec85cf9eee007676a0
```

Ce commit n'est pas résolvable dans GitHub. Sa source exacte n'est donc pas disponible à l'assistant.

## R45C3

Statut : NON ACQUIS.

La projection OWASYS visible montre bien :

```text
Applications
-> Sources de données
-> Structure
-> Sécurité
-> Workflows
-> Sources et Git
-> Construction et validation
```

Mais la validation runtime complète a échoué sur la navigation vers `Applications`. R45C3 ne peut donc pas être déclaré acquis.

Son format de livraison précédent était en outre non conforme à `README-FIRST.md` : script d'application au lieu d'un ZIP différentiel direct contenant les fichiers complets à leurs chemins finaux.

## R45C4

Statut : RETIRÉ / INVALIDÉ.

Le script précédent a échoué immédiatement :

```text
R45C4_BASE_MISMATCH
EXPECTED=058984bfb0229bf5f27c74cd2b59c6614bf74b4e
ACTUAL=0e0e54857214144d6c98ebec85cf9eee007676a0
```

Le smoke séparé n'était pas présent au chemin invoqué par les commandes owner.

Le ZIP R45C4 précédent ne doit plus être utilisé.

## Incident runtime actuel

URL :

```text
http://127.0.0.1:8000/fr-FR/applications
```

Résultat owner : HTTP 500.

Pile précédente disponible :

```text
owasys-front
-> RegistryModel::synchronize()
-> Opus\Api\Rest\RestClient::request()
-> fopen()
-> Maximum execution time exceeded
```

La cause doit être réétablie à partir de la source live owner actuelle et de l'état réel de `owasys-back`.

## Gate actif

```text
NO SOURCE OF TRUTH, NO PATCH.
NO CONTRACT, NO PATCH.
NO BRICOLAGE DELIVERY.
```

Le prochain patch OPUS/OWASYS est bloqué jusqu'à lecture de la source correspondant au HEAD owner local.

## Source minimale requise

```text
Opus/Api/Rest/RestClient.php
Opus/Api/Rest/RestClientInterface.php
sites/owasys-front/config/rest-api.json
sites/owasys-front/config/site.json
sites/owasys-front/config/fsm.json
sites/owasys-front/application/creation/controllers/CreationController.php
sites/owasys-front/application/registry/models/RegistryModel.php
sites/owasys-front/application/default/controllers/RuntimeController.php
sites/owasys-back/config/site.json
```

## Prochain livrable

Le prochain ZIP différentiel OPUS/OWASYS devra :

- contenir uniquement les fichiers complets modifiés à leurs chemins finaux ;
- ne contenir aucun script `apply_*`, smoke, rapport, log ou temporaire ;
- être basé sur les fichiers live exacts ;
- conserver les interfaces homonymes et les quatre marqueurs pour toute classe OPUS touchée ;
- respecter REST sécurisé, Logger/Profiler, FSM, ACL et séparation front/back ;
- être validé end-to-end avec `owasys-back` et `owasys-front`.

## Suite gouvernée

1. acquérir la source owner live ;
2. diagnostiquer le 500 sur cette source ;
3. livrer le correctif direct conforme ;
4. valider R45C3 ou l'annuler selon les faits ;
5. reprendre R45D uniquement après acquisition stable.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO AUTO-START CROSS-APPLICATION.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
