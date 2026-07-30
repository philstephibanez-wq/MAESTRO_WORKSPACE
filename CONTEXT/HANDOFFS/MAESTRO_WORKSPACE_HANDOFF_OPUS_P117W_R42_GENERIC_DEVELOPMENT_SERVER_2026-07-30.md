# MAESTRO WORKSPACE — Handoff OPUS P117W R42

Date : 2026-07-30

## Source canonique

```text
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE master
OPUS      : philstephibanez-wq/OPUS master
OPUS HEAD : cefabc43972adaa454e311a99959ae15b09d9809
```

`sites/opus-demo` est le nouveau site fullstack plat conservé après R41.

## Action active

Appliquer le ZIP différentiel R42 pour rendre la commande de développement
générique :

```text
composer opus:dev-server -- <site> [--host=127.0.0.1 --port=8000]
```

Le correctif touche uniquement
`Opus/Console/Service/SiteCommandService.php`. Il ne modifie aucun site et ne
transforme pas Composer en serveur de production.

## Comportement attendu

- tout site OPUS standard valide peut être lancé localement ;
- valeurs par défaut : `127.0.0.1:8000` ;
- document root : `sites/<site>/www` ;
- les contrats réseau avancés d’OWASYS restent appliqués lorsqu’ils sont
  déclarés ;
- aucun pair n’est requis pour une application autonome ;
- seuls `var/logs/<site>.log` et `var/profiler/<site>.jsonl` sont remis à zéro ;
- `development_server.starting` est la première nouvelle trace.

## Production

`php -S` et `opus:dev-server` sont exclusivement des outils de développement.
En production, Apache, Nginx ou un autre serveur web expose
`sites/<site>/www`. Aucun processus de production n’est lancé par Composer.

## Autorité

```text
Assistant : MAESTRO_WORKSPACE + ZIP différentiel seulement
Owner     : application, validation, commit et push OPUS
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO PRODUCTION SERVER THROUGH COMPOSER.
