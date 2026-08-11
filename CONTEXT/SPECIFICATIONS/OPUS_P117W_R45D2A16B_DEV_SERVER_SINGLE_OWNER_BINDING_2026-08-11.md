# OPUS P117W R45D2A16B — Dev-server single-owner binding

Date : 2026-08-11

## Constat owner

Après R45D2A16, OWASYS-front répondait correctement sur `127.0.0.1:8000`, tandis que `127.0.0.1:8080` présentait deux processus simultanément en `LISTENING`. La connexion TCP vers le backend était acceptée mais aucune réponse HTTP n'était émise avant timeout. Les logs applicatifs ne contenaient aucun `request.received`, seulement `development_server.starting`.

## Cause

`SiteCommandService::devServer()` écrit le diagnostic `development_server.starting` puis lance `php -S` via `proc_open()`, mais le chemin commun de démarrage explicite ne refuse pas préalablement un host/port déjà occupé. L'auto-port dispose d'une sonde, mais le binding explicite foreground/background peut atteindre le lancement avec un endpoint déjà détenu.

## Correction contractuelle

Après résolution finale de `host` et `port`, mais avant :

- RAZ des diagnostics ;
- `development_server.starting` ;
- `proc_open()` ;

OPUS doit appeler la sonde canonique `developmentPortOpen(host, port)` et refuser un endpoint déjà occupé avec :

`OPUS_DEV_SERVER_PORT_ALREADY_IN_USE:<host>:<port>`

Le contrôle s'applique au chemin commun foreground/background et constitue une seconde garde après la sélection auto-port pour couvrir aussi une collision intervenant après sélection.

## Non-objectifs

- aucun changement ACL ;
- aucun changement fresh-auth ;
- aucun changement REST ;
- aucun changement OWASYS spécifique ;
- aucun kill automatique d'un processus existant ;
- aucun fallback silencieux vers un autre port lorsque l'utilisateur a demandé un port explicite.

## Validation

Le smoke doit prouver que la garde existe et se situe avant RAZ diagnostics, log de démarrage et `proc_open()`.

Gate owner :

1. démarrer `owasys-back` sur 8080 ;
2. dans un second terminal tenter le même démarrage ;
3. le second lancement doit échouer immédiatement avec `OPUS_DEV_SERVER_PORT_ALREADY_IN_USE:127.0.0.1:8080` ;
4. le premier backend doit continuer à répondre ;
5. reprendre ensuite le workflow Sécurité `fresh-auth -> preview -> commit` en conservant la matrice ACL admin/developer/viewer.
