# OPUS P117W R42 — serveur de développement générique

Date : 2026-07-30  
Base OPUS owner : `cefabc43972adaa454e311a99959ae15b09d9809`  
Statut : correctif différentiel à appliquer, valider, committer et pousser exclusivement par l’owner.

## Cause

La commande publique existe :

```text
composer opus:dev-server -- <site>
```

mais `SiteCommandService::devServer()` exige encore que chaque application
déclare :

- `development_server.enabled = true` ;
- un contrat `environments` avec une section `dev` ;
- une topologie `development_server.network` comprenant un pair.

Ces exigences sont spécifiques aux deux applications OWASYS. Elles ne font pas
partie du contrat minimal d’un site OPUS standard généré. `sites/opus-demo`
est valide et possède `config/site.json`, `www` et `www/index.php`, mais la
commande s'arrête avec `OPUS_DEV_SERVER_NOT_ENABLED`.

## Contrat

La commande canonique de développement est :

```text
composer opus:dev-server -- <site>
composer opus:dev-server -- <site> --host=127.0.0.1 --port=8000
```

- `<site>` est l’identifiant obligatoire sous `sites/<site>`.
- L’hôte par défaut est `127.0.0.1`.
- Le port par défaut est `8000`.
- Le document root est exclusivement `sites/<site>/www`.
- Le routeur est `sites/<site>/www/index.php`.
- `php -S` est lancé uniquement par cette commande explicite de développement.
- Composer ne lance jamais un site en production.
- Apache, Nginx ou un autre serveur web assure l’hébergement de production.
- Un site peut affiner son environnement, son réseau, son pair et ses
  diagnostics dans `site.json`, mais cette configuration n’est pas un opt-in
  obligatoire à la commande générique.

## Diagnostics

À chaque relance, le framework réinitialise uniquement :

```text
sites/<site>/var/logs/<site>.log
sites/<site>/var/profiler/<site>.jsonl
```

La première nouvelle trace est :

```text
development_server.starting
```

Aucun log ou profiler d’une autre application n’est modifié.

## Correctif

Le correctif générique :

- supprime le gate `development_server.enabled` ;
- synthétise le contrat local minimal lorsque `development_server` est absent ;
- applique `127.0.0.1:8000` lorsque ni options ni environnement ne fournissent
  de binding ;
- n’exige un pair que lorsqu’un pair est déclaré ;
- n’exige `environments.dev` que lorsque le manifeste déclare `environments` ;
- conserve sans les simplifier les contrats OWASYS existants ;
- conserve la validation explicite de toute configuration déclarée invalide ;
- ne modifie pas le scaffold de `opus-demo` et n’ajoute aucun contrat local
  artificiel à ce site.

## Livrable

Le ZIP différentiel contient uniquement le fichier complet :

```text
ZIP : opus_p117w_r42_generic_development_server.zip
SHA-256 : 8794d3426e3a0ec881937f108f892381051b092f33d6ed0f195f99376a032456

Opus/Console/Service/SiteCommandService.php
```

Il ne contient ni `tools`, ni `scripts`, ni rapport, log, profiler, cache,
vendor ou fichier temporaire.

## Validation owner

```text
composer dump-autoload -o
composer opus:validate-site -- opus-demo
composer opus:dev-server -- opus-demo
```

Puis, dans une autre session :

```text
composer opus:dev-server -- opus-demo --host=127.0.0.1 --port=8000
```

Contrôler que le site répond, que seuls ses deux fichiers diagnostiques ont été
réinitialisés et que leur première trace est `development_server.starting`.

NO PRODUCTION SERVER THROUGH COMPOSER.  
NO SITE-SPECIFIC WORKAROUND.  
TOUJOURS TRAITER LA CAUSE.
