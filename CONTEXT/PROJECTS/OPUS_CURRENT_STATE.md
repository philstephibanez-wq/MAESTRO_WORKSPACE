# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-13.

## Dépôt canonique

OPUS master : `ca1ecfccaa8162d376af09b05f803bcb42134514` — `opus_p117w_r45d2a23_localized_public_routes`.

## États acquis récents

R45D2A21C cockpit validé. R45D2A22 matrice de capacités validée. Gate navigateur viewer complet validé. R45D2A22B Profiler piloté par ACL. R45D2A22C1 page 403 graphique validée. R45D2A22D alias Compte publié. R45D2A23 routes publiques frontend localisées avec accents validées owner et publiées.

## Gate actif

R45D2A24 — backend atomique du cycle de vie Utilisateur/Agent.

Mutations nouvelles : `identity.update` et `identity.delete`. `identity.reference` reste l'ajout. Le couple provider+subject est immuable et `identity_type=user|agent` reste explicite.

La suppression local-password doit traiter dans le même commit la référence applicative et l'entrée runtime correspondante. Les pertes d'accès sont exposées dans Preview. La dernière identité administrative est protégée par la sémantique ACL sans hardcode du nom de rôle.

Le snapshot conserve la classification onboarding lors de la fusion avec une identité runtime local-password.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a24_identity_lifecycle_backend.zip
SHA-256 : 748efa92f09a13217a86a3ec9863283ec2ad3ac82b1563df609aa05806d4751d
BASE    : ca1ecfccaa8162d376af09b05f803bcb42134514
FILES   : 2
```

Gate attendu : `OPUS_R45D2A24_IDENTITY_LIFECYCLE_BACKEND_OK`.

Après publication owner seulement : R45D2A25 exposera Modifier/Supprimer dans SCORE.
