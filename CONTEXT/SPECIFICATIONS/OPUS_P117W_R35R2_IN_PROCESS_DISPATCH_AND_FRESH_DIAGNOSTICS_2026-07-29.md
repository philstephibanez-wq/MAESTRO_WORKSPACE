# OPUS P117W R35-R2 — dispatch in-process et diagnostics de session propres

Date : 2026-07-29

## Statut

R35-R2 remplace R35-R1 avant application. Le prototype R35 d'un fichier reste invalidé.

## Dispatch Composer

R35-R2 conserve la restauration complète de R35-R1 : moteur OPUS in-process, interfaces, dispatch REST/Console, instrumentation et configuration `@in-process`.

## Remise à zéro à chaque relance

Chaque appel :

```text
composer opus:dev-server -- <application-id>
```

réinitialise avant le démarrage uniquement les deux fichiers diagnostics contractuels du site ciblé :

```text
sites/<application-id>/var/logs/<application-id>.log
sites/<application-id>/var/profiler/<application-id>.jsonl
```

Le chemin du log vient de `development_server.diagnostics.log` dans `config/site.json` et passe par la validation de chemin relatif OPUS. Le profiler respecte le contrat canonique d'un seul JSONL par application.

La réinitialisation utilise `File::writeAtomic(path, '')`. Elle précède `development_server.starting`, de sorte que la nouvelle session commence immédiatement par sa propre trace de démarrage. Aucun fichier d'une autre application n'est touché.

## Livraison

Archive : `opus_p117w_r35r2_in_process_dispatch_and_fresh_diagnostics.zip`

SHA-256 : `729f128344dc38b9aaa7a17b3bc80d7d881957322e0c76a87c9c42f746040316`

Fichiers complets : 8.

## Hors périmètre

Aucune modification de la FSM R34, de Source/SCORE, de l'I18n ou du sélecteur de langue.

## Gates

Après relance de chaque application :

- son log ne contient que la nouvelle session ;
- son profiler ne contient que la nouvelle session ;
- la première entrée est `development_server.starting` ;
- Source produit `script.succeeded` avec `execution_mode: in_process` ;
- aucun `command.succeeded` n'est produit pour `source.list` ou `source.read`.
