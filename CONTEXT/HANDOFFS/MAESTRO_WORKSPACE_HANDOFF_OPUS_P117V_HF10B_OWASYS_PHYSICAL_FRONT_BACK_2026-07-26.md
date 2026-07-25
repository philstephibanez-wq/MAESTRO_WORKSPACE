# MAESTRO_WORKSPACE HANDOFF — OPUS P117V HF10B OWASYS PHYSICAL FRONT/BACK

Date : 2026-07-26  
Statut : livrable produit ; installation et validation owner en attente

## Base exacte

```text
Repository : philstephibanez-wq/OPUS
Branch     : master
HEAD       : 21650601d7025706d4f7008ec0d0028d8cbe9c9d
Local      : H:\OPUS
```

HF10A est committé sur cette base mais rejeté fonctionnellement.

## Preuve owner

```text
runtime_mode : front
route        : /fr-FR/applications
error_code   : OPUS_RCP_CLIENT_TOKEN_NOT_CONFIGURED
REST émis    : non
log backend  : impossible dans cet état
```

## Livrable actif

```text
ZIP     : opus_p117v_hf10b_owasys_physical_front_back_runtime_bootstrap.zip
SHA-256 : 20803dd76b72bbed4704655e782fbf29cd79d7e2f01652a2ef0a6faa46f588ef
FILES   : 19
BASE    : 21650601d7025706d4f7008ec0d0028d8cbe9c9d
```

HF10A n'est plus le livrable actif.

## Structure après migration

```text
sites/owasys/application/shared
sites/owasys/application/shared/i18n/default
sites/owasys/application/shared/i18n/modules
sites/owasys/application/front/default
sites/owasys/application/front/modules
sites/owasys/application/back/modules
sites/owasys/application/back/api
```

Le frontend ne charge aucune classe API. Le backend ne charge aucun contrôleur, template ou renderer frontend.

## Démarrage contractuel

Terminal back :

```text
cd /d H:\OPUS
composer opus:serve-site -- owasys --mode=back --host=127.0.0.1 --port=8792
```

Terminal front :

```text
cd /d H:\OPUS
composer opus:serve-site -- owasys --mode=front --host=127.0.0.1 --port=8000
```

Aucune variable ou génération manuelle de secret.

Le premier processus crée sous verrou le store runtime ignoré par Git :

```text
sites/owasys/var/runtime/rcp-secrets.json
```

Le second processus lit le même store. La paire token/HMAC est transmise uniquement à l'environnement des processus PHP.

## Diagnostics attendus

Immédiatement après le lancement back :

```text
sites/owasys/var/logs/rcp-backend.log
message = process.starting
runtime_mode = back
```

Immédiatement après le lancement front :

```text
sites/owasys/var/logs/owasys-frontend.log
message = process.starting
runtime_mode = front
```

Après ouverture de `/fr-FR/applications`, le journal backend doit recevoir la requête RCP puis les événements Composer/FSM.

## Installation

```text
tar -xf opus_p117v_hf10b_owasys_physical_front_back_runtime_bootstrap.zip -C H:\OPUS
call sites\owasys\tools\cmd\MIGRATE_OWASYS_LAYOUT_HF10B.cmd
composer dump-autoload -o
php sites\owasys\tools\smoke\smoke_p117v_hf10b_owasys_physical_split.php
```

Résultat smoke attendu :

```text
P117V_HF10B_OWASYS_PHYSICAL_SPLIT_SMOKE_OK
```

## Nettoyage

Aucun ancien chemin ne doit être supprimé avant validation :

- des deux logs de démarrage ;
- de `/fr-FR/applications` ;
- de `/fr-FR/applications/new` ;
- d'une exécution REST -> Composer ;
- des traces Profiler front/back.

Après validation, fournir un bloc CMD de nettoyage fondé sur les chemins réellement devenus inactifs. Préserver `sites/owasys_old`, `var/logs`, `var/profiler`, `var/registry` et `var/runtime`.

## Validation effectuée hors owner runtime

```text
lint PHP                       : OK
JSON                           : OK
ZIP réouvert et relinté        : OK
secret store répété            : OK
logs front/back de démarrage   : OK
migration simulée              : OK
smoke structure                : OK
```

## Prochaine séquence

1. appliquer le ZIP ;
2. exécuter la migration ;
3. transmettre le résultat du smoke ;
4. lancer back puis front par Composer ;
5. transmettre les deux lignes `process.starting` ;
6. tester Applications et Creation ;
7. vérifier le flux REST/Composer ;
8. fournir ensuite le nettoyage des anciens chemins ;
9. gate P117M ;
10. commit/push owner après acceptation.
