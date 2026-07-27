# OPUS P117W R13 — LIRE L’ADRESSE ET LE PORT DU SERVEUR DE DÉVELOPPEMENT DEPUIS LA CONFIGURATION

Date : 2026-07-27  
État : ZIP différentiel produit ; validation runtime owner requise

## Lire

Lire `README-FIRST.md` et appliquer tous les contrats MAESTRO/OPUS actifs.

## Conserver

Conserver uniquement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne partager aucun fichier. Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier runtime et aucune racine partagée.

## Cause

La commande `composer opus:dev-server` impose encore `--host` et `--port`, alors que l’adresse et le port de chaque environnement doivent appartenir à la configuration de l’application.

## Corriger génériquement OPUS

Modifier :

```text
Opus/Console/OpusConsoleApplication.php
Opus/Console/Service/SiteCommandService.php
```

Rendre les options suivantes facultatives :

```text
--host
--port
```

Lorsque ces options sont absentes, lire les variables locales désignées par :

```text
development_server.network.local.host_env
development_server.network.local.port_env
```

Résoudre leurs valeurs depuis :

```text
environments.sections.dev.variables
```

Conserver les options `--host` et `--port` comme surcharges explicites. Valider toute valeur configurée ou fournie avant ouvrir le serveur.

## Configurer les applications

Frontend :

```text
OPUS_DEV_SERVER_HOST = 127.0.0.1
OPUS_DEV_SERVER_PORT = 8000
```

Backend :

```text
OPUS_DEV_SERVER_HOST = 127.0.0.1
OPUS_DEV_SERVER_PORT = 8080
```

Conserver les coordonnées du peer dans la même section `dev`.

## Commandes canoniques

Frontend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-front
```

Backend :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-back
```

Surcharges explicites admises :

```text
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8000
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8080
```

## Livrer

```text
ZIP : opus_p117w_r13_dev_server_binding_from_site_config.zip
SHA-256 : a0ae3b511f68b80504fd5f7a31aa57da973bddbe7a58cfe9c5a51d6158c21983
Fichiers : 4
```

Inclure uniquement :

```text
Opus/Console/OpusConsoleApplication.php
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

## Valider avant livraison

```text
PHP lint OpusConsoleApplication           : OK
PHP lint SiteCommandService               : OK
JSON frontend                             : OK
JSON backend                              : OK
Résolution frontend depuis config         : 127.0.0.1:8000
Résolution backend depuis config          : 127.0.0.1:8080
Surcharge explicite                       : OK
Analyse du parsing sans options           : OK
Chemins interdits dans le ZIP             : 0
```

Marqueurs :

```text
P117W_R13_CONFIG_BINDING_OK
P117W_R13_CONSOLE_PARSE_OK
P117W_R13_ZIP_CLEAN_OK
```

Ne pas présenter cette validation isolée comme une validation runtime Windows owner.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
