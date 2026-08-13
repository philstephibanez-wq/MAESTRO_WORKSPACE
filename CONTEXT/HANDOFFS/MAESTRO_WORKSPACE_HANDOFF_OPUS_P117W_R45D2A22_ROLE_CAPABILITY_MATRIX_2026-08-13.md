# HANDOFF — OPUS P117W R45D2A22 Role Capability Matrix

Date : 2026-08-13

## État acquis

- R45D2A21C visuellement accepté sur capture owner : cockpit Sécurité compact et lisible dans le premier viewport.
- modèle `identity_type=user|agent` conservé ; legacy `unknown` visible comme « À classifier ».
- developer Security Preview + Commit acquis.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a22_role_capability_matrix_contract.zip
SHA-256 : e3f127d709b860a359fd8982806f4097fad5c9d22ed8f33ace3b7ffe1a729793
PREREQ  : R45D2A21C appliqué
FILES   : 1
```

Le ZIP ajoute uniquement :

```text
tools/smoke_r45d2a22_role_capability_matrix.php
```

Le smoke est non destructif et valide front/back : admin, developer, viewer, default-deny, guards SCORE/controller, refus viewer des mutations et du Profiler.

## Gate immédiat

```text
OPUS_R45D2A22_ROLE_CAPABILITY_MATRIX_OK front_cases=66 back_cases=42
```

Puis se connecter comme viewer et valider le navigateur : lecture autorisée, mutations absentes/refusées, Profiler absent/refusé, compte/password disponible.

## Suite

Seulement après gate viewer :

1. corriger toute divergence révélée par la matrice ;
2. sinon passer aux mutations atomiques Modifier/Supprimer utilisateur ou agent ;
3. n’exposer les boutons qu’après support backend réel preview/fresh-auth/commit/rollback.

NO VIEWER MUTATION.
NO ACL BYPASS.
NO PRIMARY_ROLE AUTHORIZATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
