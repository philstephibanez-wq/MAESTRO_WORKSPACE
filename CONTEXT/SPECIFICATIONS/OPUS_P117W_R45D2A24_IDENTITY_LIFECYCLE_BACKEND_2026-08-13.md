# OPUS P117W R45D2A24 — Identity lifecycle backend

Date : 2026-08-13

## Base canonique

`ca1ecfccaa8162d376af09b05f803bcb42134514` — `opus_p117w_r45d2a23_localized_public_routes`.

R45D2A23 est validé owner et publié.

## Objet

Préparer le backend atomique nécessaire aux futures actions SCORE : ajouter, modifier et supprimer un utilisateur ou un agent de l'application sélectionnée.

Le couple `provider + subject` reste l'identifiant immuable. `identity_type` est explicite et vaut `user|agent`; il n'est jamais inféré. Les rôles et permissions restent gérés par leurs ressources dédiées.

## Mutations

Le pipeline Security existant Preview/Commit est étendu avec :

- `identity.update` : provider, subject, identity_type ;
- `identity.delete` : provider, subject.

`identity.reference` reste l'ajout.

Pour local-password, une suppression retire atomiquement la référence applicative et l'entrée runtime correspondante lorsqu'elle existe. Pour un provider externe, seule la référence applicative est retirée.

## Protection du dernier administrateur

Aucun nom de rôle n'est hardcodé. Les rôles administratifs sont dérivés de la sémantique ACL effective. La suppression de la dernière identité portant un rôle administratif est refusée avant écriture avec `OWASYS_SECURITY_LAST_ADMINISTRATOR_DELETE_FORBIDDEN`.

## Snapshot

La fusion onboarding + runtime local-password doit conserver `identity_type=user|agent`. Une identité runtime sans classification explicite reste `unknown`.

R45D2A24 ajoute également la validation explicite de `identity_type` pour `identity.reference` et expose les pertes d'accès de `identity.delete` dans le Preview.

## Frontière

Aucune nouvelle route REST ni commande Composer : les opérations Security existantes transportent déjà `mutation_json`. Aucun bouton Modifier/Supprimer n'est ajouté dans ce livrable ; l'UI vient seulement après validation backend.

## Livrable

```text
ZIP     : opus_p117w_r45d2a24_identity_lifecycle_backend.zip
SHA-256 : 748efa92f09a13217a86a3ec9863283ec2ad3ac82b1563df609aa05806d4751d
BASE    : ca1ecfccaa8162d376af09b05f803bcb42134514
FILES   : 2
```

L'applicateur cible :

- `sites/owasys-back/application/registry/services/OwasysSecurityMutationService.php` ;
- `sites/owasys-back/application/registry/services/OwasysCommandProvider.php`.

## Gate owner

Le smoke doit afficher :

`OPUS_R45D2A24_IDENTITY_LIFECYCLE_BACKEND_OK`.

Il valide update, classification snapshot, suppression multi-fichiers, pertes d'accès et protection du dernier administrateur avec un rôle de fixture nommé `owner-role`.

NO FRONT BUTTON BEFORE BACKEND GATE.
NO HARDCODED ADMIN ROLE NAME.
NO IDENTITY TYPE INFERENCE.
NO LAST-ADMIN DELETE.
NO PARTIAL MULTI-FILE COMMIT.
NO VIEWER MUTATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
