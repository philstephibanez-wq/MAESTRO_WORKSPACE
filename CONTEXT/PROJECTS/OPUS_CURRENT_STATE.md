# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-30.

## Dépôt

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 98842dba015402af7e8b3421e62032236c2d8f30
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

Aucun partage de fichiers ou d’état runtime entre les deux bastions. `owasys-back` reste exclusivement PHP, sans JavaScript, TypeScript, Node ou gestionnaire de paquets JavaScript.

## État acquis

- R38 : création layered et split-brain Registry supprimés.
- R39 : stockage REST replay fichier supprimé.
- R40 : ancien `sites/demo-opus` layered supprimé.
- R42 : `opus:dev-server -- <site> [--host --port]` rendu générique pour le développement au commit `bbac194f`.
- `sites/opus-demo` créé par R41 a été supprimé par l’owner au commit `98842dba`.
- Aucun site généré n’est actuellement retenu comme base.
- `owasys-front` et `owasys-back` restent les deux seules applications OWASYS.

## Cause active — R43

Le formulaire OWASYS `new` ne collecte que `site_id` et `profile`, puis appelle directement `site.create`. Le scaffold génère plusieurs modules/pages techniques. Il ne collecte ni login, ni fournisseur SSO, ni utilisateurs, ni rôles, ni permissions, ni ACL, et n’offre aucun récapitulatif.

## Cible R43

OWASYS devient un assistant FSM transactionnel :

- accueil unique ;
- login uniquement si demandé ;
- 24 langues officielles UE plus ukrainien ;
- locale navigateur et fallback français explicite ;
- choix SSO, utilisateurs initiaux, rôles, permissions et ACL ;
- récapitulatif avant mutation ;
- blueprint typé non sensible ;
- création atomique avec rollback ;
- validation OPUS et synchronisation Registry ;
- aucune page technique préfabriquée.

Les pages ultérieures suivent un workflow atomique : page, route, FSM, contrôleur/ViewModel, SCORE, navigation, ACL et I18n.

## Contrats permanents

- toute classe concrète `Opus/**/*.php` implémente son interface homonyme à quatre marqueurs ;
- toute configuration passe par File et StructuredFileLoader ;
- SCORE uniquement pour l’UI ;
- Logger et Profiler obligatoires ;
- aucun fallback silencieux ;
- toute mutation OWASYS traverse REST sécurisé puis Composer ;
- l’assistant ne committe ni ne pousse OPUS/OWASYS ;
- `php -S` reste réservé au développement ; production sous Apache, Nginx ou équivalent.
