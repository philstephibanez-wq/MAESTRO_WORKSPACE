# OPUS P117W R45D2A15 — backend fresh-auth proof

Date : 2026-08-11
Statut : livrable actif
Base OPUS : `a3f5b2257628d5b6ea0c98ba92178b4fe51030b2`

## Cause

Le front OWASYS effectue actuellement une réauthentification réelle `local-password`, puis transforme sa réussite en simple valeur `reauthenticated_at`. Le backend n'en vérifie que la fraîcheur temporelle. Cette chaîne temporelle est déclarative et ne constitue pas une preuve backend de réauthentification.

## Contrat R45D2A15

Le flux devient :

`password local -> vérification front bastion -> REST sécurisé -> owasys-back émet une preuve fresh-auth -> preview/commit transportent la preuve -> owasys-back valide la preuve`.

La preuve :

- contrat `OWASYS_FRESH_AUTH_PROOF_V1` ;
- HMAC SHA-256 avec secret backend dédié `OPUS_OWASYS_FRESH_AUTH_PROOF_SECRET` ;
- TTL maximal 120 secondes ;
- nonce aléatoire ;
- liée à `provider + subject` ;
- liée à `site_id` ;
- liée à l'opération `security.mutation` ;
- liée au SHA-256 exact de `mutation_json` ;
- ne contient aucun mot de passe ni secret ;
- refuse signature altérée, expiration, acteur différent, site différent ou mutation différente.

Le timestamp `reauthenticated_at` est supprimé du contrat REST de preview/commit et remplacé par `fresh_auth_proof`.

## REST

Ajout :

`POST /api/v1/applications/{site_id}/security/fresh-auth-proofs`

Opération : `security.fresh-auth-proof.issue`, rôle `admin`.

## Matrice ACL préservée

La matrice `OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md` reste obligatoire. Ce livrable ne modifie pas les capacités viewer/developer/admin. Les mutations Sécurité restent réservées à `admin`; `viewer` conserve la lecture seule de Sécurité.

## Critères d'acceptation

- aucun `reauthenticated_at` dans front/backend mutation pipeline ;
- preuve émise par owasys-back ;
- preview et commit exigent `fresh_auth_proof` ;
- preuve altérée refusée ;
- acteur différent refusé ;
- site différent refusé ;
- mutation différente refusée ;
- preuve expirée refusée ;
- aucune donnée sensible dans Logger/Profiler ;
- backend sans JavaScript ;
- flux front -> REST -> back préservé.
