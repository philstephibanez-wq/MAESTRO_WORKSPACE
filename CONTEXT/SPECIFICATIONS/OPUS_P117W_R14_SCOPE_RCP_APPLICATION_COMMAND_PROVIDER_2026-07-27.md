# OPUS P117W R14 — CIBLER LE PROVIDER COMPOSER DE L’APPLICATION RCP

Date : 2026-07-27  
État : ZIP différentiel produit ; validation runtime owner requise

## Lire

Lire `README-FIRST.md` et appliquer tous les contrats MAESTRO/OPUS actifs.

## Constater

La requête frontend atteint correctement le backend REST, puis le backend lance :

```text
owasys:registry-sync
```

Le processus Composer termine avec :

```text
OPUS_CONSOLE_COMMAND_FAILED
```

Deux registres actifs déclarent la même commande canonique :

```text
sites/owasys/config/composer.commands.json
sites/owasys-back/config/composer.commands.json
```

`ApplicationCommandDispatcher` découvre les deux providers et ne connaît pas l’application propriétaire de la requête RCP. Il rejette donc la commande comme ambiguë avant exécuter le provider backend.

## Corriger génériquement OPUS

Modifier :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
Opus/Rcp/Rest/RcpRestServer.php
sites/owasys-back/config/backend.rest.json
```

Déclarer dans la configuration REST :

```text
application_id = owasys-back
```

Propager cette valeur dans la requête Composer :

```text
OPUS_RCP_COMPOSER_COMMAND_REQUEST_V1.application_id
```

Faire filtrer les descriptors de providers par :

```text
command + application_id
```

Exiger `application_id` pour toute requête RCP Composer V1. Conserver le comportement ambigu pour une commande directe non ciblée lorsqu’elle existe dans plusieurs applications.

## Conserver

Conserver exclusivement le flux :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne charger aucun provider du site historique `sites/owasys` lors d’une requête ciblant `owasys-back`.

Ne supprimer aucun répertoire dans ce correctif.

## Livrer

```text
ZIP : opus_p117w_r14_scope_rcp_application_command_provider.zip
SHA-256 : 8e94705f4a8992a3188ff0c469436e3c458b888713709da877ec79c1e7d8f494
Fichiers : 3
Octets ZIP : 7614
```

Inclure uniquement :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
Opus/Rcp/Rest/RcpRestServer.php
sites/owasys-back/config/backend.rest.json
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier runtime, aucun secret et aucune racine partagée.

## Valider avant livraison

```text
PHP lint ApplicationCommandDispatcher : OK
PHP lint RcpRestServer                 : OK
JSON backend.rest                     : OK
Deux providers homonymes simulés      : OK
Sélection owasys-back par application : OK
Rejet RCP sans application_id         : OK
Ambiguïté directe non ciblée          : conservée
Chemins interdits dans le ZIP         : 0
```

Marqueur :

```text
P117W_R14_SCOPED_APPLICATION_COMMAND_OK
```

Ne pas présenter cette validation isolée comme une validation runtime Windows owner.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
