# OPUS P117W R35-R1 — restauration complète du dispatch Composer in-process

Date : 2026-07-29

## Statut

R35-R1 remplace et invalide le prototype R35 limité à `backend.rest.json`. R31, R33 et R34 restent acquis. Les éléments de performance de R32 sont restaurés ensemble.

## Preuve issue de la session propre

Les quatre fichiers Logger/Profiler ont été remis à zéro avant la reproduction.

- `/fr-FR/build` sans appel métier : 55,955 ms côté front ;
- `source.list` : 3 315,726 ms dans l'exécuteur Composer, 3 337,950 ms REST total ;
- `source.read` : 3 026,394 ms dans l'exécuteur Composer, 3 050,675 ms REST total ;
- page Source avec liste et lecture : environ 6,5 s ;
- événements observés : `command.started` / `command.succeeded` ;
- champ `execution_mode: in_process` absent.

Ces traces prouvent que la session charge l'ancien exécuteur externe, pas seulement une mauvaise valeur de configuration.

## Cause

Le dispatch in-process introduit par R32 n'est plus présent dans le backend effectivement exécuté. Réparer uniquement `composer_command` serait incohérent : un moteur ancien ne sait pas interpréter contractuellement `@in-process`.

## Correction générique OPUS

Le différentiel restaure comme une unité :

- `ComposerCommandExecutor::execute()` avec branche explicite `@in-process` ;
- `ComposerScripts::runRest()` ;
- `OpusConsoleApplication::runRest()` ;
- résolution REST qui accepte uniquement le sentinel contractuel ;
- interfaces homonymes correspondantes ;
- `sites/owasys-back/config/backend.rest.json` avec `["@in-process"]` ;
- Logger et Profiler avec `execution_mode: in_process`.

Aucun fallback vers un sous-processus n'est autorisé lorsque le mode in-process est déclaré.

## Hors périmètre

- aucune modification FSM R34 ;
- aucune modification OWASYS Source ou SCORE ;
- aucune modification I18n ;
- aucune modification du sélecteur de langue.

Le sélecteur expose déjà les 24 langues officielles de l'Union européenne plus l'ukrainien ; les catalogues parents restent cachés et les variantes régionales peuvent être proposées.

## Livraison

Archive : `opus_p117w_r35r1_complete_in_process_composer_dispatch.zip`

SHA-256 : `7ecd35de62f0e94b10194aa3199a7e5f6b475cf157940753ef22c5be860def71`

Fichiers complets : 7.

## Gate runtime owner

Après application et redémarrage des deux applications, une lecture Source doit produire `script.succeeded` avec `execution_mode: in_process`. Tout événement `command.succeeded` pour `source.list` ou `source.read` invalide R35-R1.
