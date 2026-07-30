# MAESTRO WORKSPACE — Handoff OPUS P117W R40 owner

Date : 2026-07-30

## Diagnostic canonique

Le site layered généré en échec que R38 imposait d’identifier puis de supprimer
est :

```text
sites/demo-opus
```

Il est le seul site du HEAD OPUS owner
`d8e72130dbb932df6babd38fd3b0048fcd38405d` à déclarer
`OPUS_SITE_LAYERED_CONTRACT_V2` ou `application_layers`.

Le Registry le refuse correctement. Il ne doit être ni ignoré ni migré.

## Action owner

Supprimer intégralement `sites/demo-opus`, valider le Registry et les deux
applications OWASYS, puis committer et pousser OPUS.

Cette livraison est une suppression owner explicite sans ZIP, car aucun fichier
complet n’est créé ou remplacé.

## Autorité

```text
Assistant : MAESTRO_WORKSPACE uniquement
Owner     : suppression, validation, commit et push OPUS
```

NO SHARED LAYER.  
NO FALLBACK SILENCIEUX.  
TOUJOURS TRAITER LA CAUSE.
