# INCIDENT OPUS P117W — R45C3 / R45C4 DELIVERY INVALID

Date : 2026-08-09
Statut : BLOQUANT — anciens artefacts retirés

## Source de vérité relue

`README-FIRST.md` impose notamment :

- traiter la cause, jamais l'effet ;
- ne jamais pousser OPUS/OWASYS depuis l'assistant ;
- livrer OPUS/OWASYS sous forme de ZIP différentiel direct contenant uniquement les fichiers complets à leurs chemins finaux ;
- relire la source de vérité et la base exacte avant tout patch.

Le dépôt GitHub `philstephibanez-wq/OPUS` publie toujours :

```text
058984bfb0229bf5f27c74cd2b59c6614bf74b4e
opus_p117w_r45c2_dev_preview_runtime_fix
```

Le retour owner du 2026-08-09 montre en revanche un HEAD local :

```text
0e0e54857214144d6c98ebec85cf9eee007676a0
```

Ce commit n'est pas résolvable dans le dépôt GitHub au moment de la relecture. La source locale exacte n'est donc pas disponible à l'assistant.

## Non-conformités constatées

### R45C3

L'artefact précédent était construit autour d'un script d'application au lieu d'un ZIP différentiel direct contenant les fichiers complets à leurs chemins finaux.

La projection FSM visible a bien montré le nouvel ordre de navigation, mais la validation runtime end-to-end n'était pas terminée. R45C3 ne doit donc pas être considéré acquis.

### R45C4

L'artefact précédent est invalidé pour plusieurs raisons :

1. même format non conforme : script d'application dans le ZIP au lieu des fichiers complets à leurs chemins finaux ;
2. garde globale sur le HEAD `058984...` alors que le HEAD owner réel est `0e0e548...` ;
3. la base locale n'avait pas été relue avant livraison ;
4. le smoke était un fichier séparé alors que les commandes owner l'invoquaient depuis `Downloads` sans garantie de présence ;
5. la séquence de commandes ne bloquait pas explicitement les étapes suivantes après l'échec de l'application ;
6. la correction de transport REST proposée n'est pas acquise et doit être réévaluée à partir de la source live et du comportement réel des deux bastions.

R45C4 est retiré. Son ZIP, son script et son smoke ne doivent plus être utilisés.

## État runtime observé

Le front OWASYS renvoie HTTP 500 sur `/fr-FR/applications`.

Le retour précédent montrait un blocage dans :

```text
owasys-front
-> RegistryModel::synchronize()
-> Opus\Api\Rest\RestClient::request()
-> fopen()
```

avec dépassement du temps d'exécution PHP.

Cette pile doit être réanalysée sur la source live actuelle et avec l'état effectif de `owasys-back` avant toute nouvelle correction.

## Gate obligatoire avant prochain livrable

Application stricte de :

```text
NO SOURCE OF TRUTH, NO PATCH.
NO CONTRACT, NO PATCH.
NO BRICOLAGE DELIVERY.
```

Le prochain livrable OPUS/OWASYS est bloqué jusqu'à obtention de la source owner live correspondant au HEAD local `0e0e548...`, soit par publication owner du commit après décision explicite, soit par fourniture d'un snapshot exact des fichiers concernés.

Les fichiers minimaux à relire sont :

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

## Règle de livraison corrigée

Le prochain ZIP différentiel OPUS/OWASYS :

- ne contiendra aucun script `apply_*` ;
- ne contiendra aucun smoke, rapport, log ou temporaire ;
- contiendra uniquement les fichiers complets modifiés à leurs chemins finaux ;
- sera basé sur les fichiers live exacts relus ;
- sera accompagné séparément des commandes de validation owner ;
- ne sera déclaré acquis qu'après validation runtime front + back.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
