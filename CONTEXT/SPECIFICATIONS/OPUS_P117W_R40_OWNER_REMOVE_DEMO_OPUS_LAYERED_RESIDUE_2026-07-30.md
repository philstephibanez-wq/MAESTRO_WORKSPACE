# OPUS P117W R40 — supprimer la scorie layered `demo-opus`

Date : 2026-07-30  
Base OPUS owner : P117W R39, commit `d8e72130dbb932df6babd38fd3b0048fcd38405d`  
Statut : nettoyage à exécuter, valider, committer et pousser exclusivement par l’owner.

## Cause

R38 a supprimé la création de sites layered et a rendu leur détection
explicitement bloquante dans le Registry. Le nettoyage owner prévu par R38
n’a pas supprimé le site généré pendant la session :

```text
sites/demo-opus
```

Son fichier `config/site.json` déclare :

```text
OPUS_SITE_LAYERED_CONTRACT_V2
application_layers
```

`RegistryRepository` refuse donc correctement ce site avec :

```text
OWASYS_REGISTRY_LAYERED_SITE_FORBIDDEN:sites/demo-opus/config/site.json
```

Le blocage de `registry-sync` est l’effet attendu de cette scorie contractuelle.
La cause framework a déjà été traitée par R38 ; la cause résiduelle est le
répertoire layered suivi par Git.

## Preuves GitHub

- base OPUS observée : `d8e72130dbb932df6babd38fd3b0048fcd38405d` ;
- `sites/demo-opus` contient 289 fichiers suivis dans l’arborescence canonique ;
- `sites/demo-opus/config/site.json` est le seul `site.json` sous `sites/`
  portant `OPUS_SITE_LAYERED_CONTRACT_V2` ou `application_layers` ;
- le répertoire utilise les couches interdites
  `application/shared`, `application/front` et `application/back` ;
- aucune migration n’est autorisée : R38 exige la suppression explicite du
  site layered généré en échec après identification.

## Décision

L’owner supprime intégralement et uniquement :

```text
sites/demo-opus
```

Il ne faut :

- ni modifier `RegistryRepository` pour ignorer le site ;
- ni convertir seulement `site.json` ;
- ni migrer cette génération d’échec ;
- ni introduire un fallback ;
- ni modifier `owasys-front` ou `owasys-back`.

Cette opération ne nécessite aucun ZIP différentiel : elle ne contient aucun
fichier à créer ou remplacer. La suppression est réalisée par commande owner
explicite, conformément au contrat de livraison R38.

## Validation owner

Après suppression :

1. aucun contrat layered ne reste sous `sites/*/config/site.json` ;
2. `owasys:registry-sync` exécuté par le flux REST contractuel réussit ;
3. `owasys-front` et `owasys-back` restent valides ;
4. le dépôt OPUS ne contient que la suppression de `sites/demo-opus` ;
5. l’owner committe et pousse OPUS.

NO SHARED LAYER.  
NO FALLBACK SILENCIEUX.  
TOUJOURS TRAITER LA CAUSE.
