# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-13.

## Dépôt canonique

OPUS master : `89a3004ab44f78b565b0229cd554658670696ff1` — `opus_p117w_r45d2a24_identity_lifecycle_backend`.

## États acquis récents

R45D2A21C cockpit validé. R45D2A22 matrice de capacités validée. Gate navigateur viewer complet validé. R45D2A22B Profiler piloté par ACL. R45D2A22C1 page 403 graphique validée. R45D2A22D alias Compte publié. R45D2A23 routes publiques frontend localisées avec accents validées owner et publiées. R45D2A24 backend atomique du lifecycle Utilisateur/Agent publié.

## R45D2A24 acquis

Le backend Security supporte `identity.reference`, `identity.update` et `identity.delete`. Provider+subject reste immuable ; `identity_type=user|agent` est explicite. La suppression local-password est atomique entre référence applicative et entrée runtime lorsqu'elles existent. Preview expose les pertes d'accès. La dernière identité administrative est protégée par la sémantique ACL sans hardcode du nom de rôle. Le snapshot conserve la classification onboarding lors de la fusion runtime.

## Gate actif

R45D2A25 — exposition graphique SCORE du cycle de vie Utilisateur/Agent.

Pour admin/developer seulement : Modifier Utilisateur↔Agent, classifier les identités legacy `unknown`, Supprimer via Preview/Commit et afficher les accès perdus. L'erreur de suppression de la dernière identité administrative reçoit une présentation utilisateur explicite.

Pour viewer : aucune action lifecycle visible. Le screenshot owner `/fr-FR/sécurité?view=identities` en `viewer · viewer` constitue le baseline de non-régression.

Aucun JavaScript, aucune nouvelle route REST, aucune nouvelle commande Composer.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a25_identity_lifecycle_ui.zip
SHA-256 : 329827a9fff3f70d3d20c80adc7bb8c33651cced8a609c3e6fb2be5d9c045e92
BASE    : 89a3004ab44f78b565b0229cd554658670696ff1
FILES   : 3
```

Gate attendu : `OPUS_R45D2A25_IDENTITY_LIFECYCLE_UI_OK locales=25`.
