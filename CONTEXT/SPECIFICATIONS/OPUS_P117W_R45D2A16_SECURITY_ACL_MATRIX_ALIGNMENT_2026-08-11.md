# OPUS P117W R45D2A16 — Security ACL matrix alignment

Date : 2026-08-11
Statut : livrable owner à appliquer
Base OPUS : `8b70be74bb83da3f528a0d0e3e2bf74663205fa0`

## Cause

La matrice contractuelle OWASYS exige que `admin` et `developer` disposent des capacités complètes de la page Sécurité, tandis que `viewer` reste lecture seule.

Le master courant est incohérent :

- `owasys-front/config/acl.json` : developer possède seulement `security:open` ;
- `owasys-back/config/acl.json` : developer possède seulement `security:read` ;
- les opérations REST `security.fresh-auth-proof.issue`, `security.mutation.preview`, `security.mutation.commit` sont allow-listées `admin` uniquement.

Cette divergence empêcherait un developer d'exécuter le workflow contractuel fresh-auth -> preview -> commit alors que l'UI cible lui accorde la gestion Sécurité.

## Correction

R45D2A16 aligne les trois frontières :

1. front ACL developer -> `security:*` ;
2. back ACL developer -> `security:*` ;
3. allow-list REST des trois opérations sensibles -> `[admin, developer]` ;
4. viewer reste `security:open` côté front et `security:read` côté back ;
5. viewer ne reçoit jamais `security:manage`, `security:*` ou `profiler:view`.

## Invariants

- ACL deny-by-default conservée ;
- admin inchangé ;
- viewer strictement lecture seule ;
- Profiler interdit au viewer ;
- fresh-auth, CSRF, confirmation, optimistic state hash, transaction/rollback et audit restent obligatoires pour les mutations ;
- aucune autorisation basée sur `primary_role` ;
- backend toujours décisif.

## Gate

Applicateur : `tools/r45d2a16_apply_security_acl_matrix_alignment.php`
Smoke : `tools/smoke_r45d2a16_security_acl_matrix_alignment.php`

Le smoke doit prouver :

- admin manage front/back ;
- developer manage front/back ;
- viewer open/read mais jamais manage ;
- viewer ne voit pas le Profiler ;
- les trois opérations REST sensibles autorisent exactement admin + developer.

Après validation, reprendre le test fonctionnel Sécurité : fresh-auth -> preview -> commit.
