# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-30.

## Dépôt

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD relu : a93d9dd11d76fd17e4444ddb32c086d71cd74521
Racine owner : H:/OPUS
```

## Architecture OWASYS

Conserver exactement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Flux unique :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Aucun partage de fichiers ou d’état runtime entre les deux bastions. `owasys-back` reste exclusivement PHP et ne contient aucun JavaScript, TypeScript, runtime Node ou gestionnaire de paquets JavaScript.

## État acquis

- R38 : `OpusConsoleApplication` utilise `SiteCommandService`; la création layered et le split-brain Registry sont supprimés.
- R39 : le stockage REST replay fichier non borné et `sites/owasys-back/var/rest` sont supprimés.
- R40 : le site layered résiduel `sites/demo-opus` est supprimé.
- `owasys-front` et `owasys-back` sont valides.
- `registry.sync` réussit et découvre les deux applications OWASYS sans doublon.

## Génération canonique

`opus:create-site` accepte les profils :

```text
frontend
backend
fullstack
```

Toute application générée est autonome et plate :

```text
sites/<application-id>/
  application/
  config/
  www/
```

Contrat : `OPUS_SITE_STANDARD_CONTRACT_CORE`.  
Rôle : `generated-opus-application`.

Les couches `application/shared`, `application/front`, `application/back`, le contrat `OPUS_SITE_LAYERED_CONTRACT_V2` et la clé `application_layers` sont interdits.

Le scaffold inclut Singleton, FSM, ACL deny-by-default, SSO/Auth0-proxy, SCORE, Logger, Profiler, négociation `Accept-Language`, fallback français explicite et les 24 langues officielles de l’Union européenne plus l’ukrainien.

## Priorité active — R41

Créer depuis l’interface OWASYS un nouveau site `fullstack`, vérifier sa synchronisation et sa sélection immédiates dans le Registry, puis conserver sa racine comme nouvelle base applicative.

Aucun patch n’est actif avant cette acceptation runtime owner.

## Contrats permanents

- toute classe concrète `Opus/**/*.php` implémente son interface homonyme à quatre marqueurs ;
- toute configuration passe par `File` et `StructuredFileLoader` ;
- SCORE uniquement pour l’UI ;
- Logger et Profiler obligatoires ;
- aucun fallback silencieux ;
- toute mutation OWASYS traverse REST sécurisé puis Composer ;
- l’assistant ne committe ni ne pousse OPUS/OWASYS.
