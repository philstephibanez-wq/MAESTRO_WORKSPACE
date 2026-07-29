# OPUS P117W R38 — suppression de la création layered et du split-brain Registry

Date : 2026-07-29

## Cause

La session R37 prouve que `opus:create-site` retourne un succès, puis que
`registry.sync` ne retrouve pas le site créé.

La cause est un split-brain contractuel :

- `OpusConsoleApplication::fromRoot()` sélectionne encore
  `LayeredSiteCommandService` ;
- ce service génère `OPUS_SITE_LAYERED_CONTRACT_V2` et les répertoires
  `application/shared`, `application/front` et `application/back` ;
- le Registry n'importe pas ce contrat ;
- le frontend reçoit donc `OWASYS_CREATION_REGISTRY_ENTRY_MISSING` après une
  écriture physique pourtant réussie.

## Contrat

OPUS ne crée plus de site layered. Un site généré est une application OPUS
autonome et plate sous :

```text
sites/<application-id>/application
sites/<application-id>/config
sites/<application-id>/www
```

OWASYS reste composé uniquement de deux applications autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Le flux entre les deux bastions reste exclusivement REST sécurisé puis
Composer allow-listé.

## Corrections

- `OpusConsoleApplication` utilise `SiteCommandService`, jamais
  `LayeredSiteCommandService`.
- `SiteCommandService` refuse explicitement toute configuration
  `application_layers`.
- le Registry refuse explicitement `OPUS_SITE_LAYERED_CONTRACT_V2` au lieu de
  l'ignorer silencieusement.
- les classes exclusivement dédiées au scaffold/runtime layered deviennent
  obsolètes et doivent être supprimées.

## Diagnostic de la session

Le `trace_id` `d7210c501e8d1070` relie correctement :

```text
frontend -> REST -> backend -> opus:create-site -> registry.sync
```

`opus:create-site` réussit en `3026.209 ms`, puis `registry.sync` réussit en
`64.883 ms`. L'erreur finale est
`OWASYS_CREATION_REGISTRY_ENTRY_MISSING`.

R37 reste validé pour :

- log frontend unique ;
- ouverture du Profiler sans faute FSM ;
- corrélation du `trace_id` ;
- exécution Composer `in_process`.

## Nettoyage owner

Le site layered créé pendant la session doit être identifié par son
`config/site.json`, puis supprimé uniquement après confirmation de son
identifiant exact. Aucun chemin n'est déduit des logs, car l'identifiant n'y
est volontairement pas enregistré.

## Livraison

Le ZIP différentiel contient trois fichiers complets. Les suppressions des huit
classes layered sont réalisées par commandes owner explicites, car une archive
différentielle directe ne représente pas une suppression.

NO SHARED LAYER.
NO FALLBACK SILENCIEUX.
TOUJOURS TRAITER LA CAUSE.
