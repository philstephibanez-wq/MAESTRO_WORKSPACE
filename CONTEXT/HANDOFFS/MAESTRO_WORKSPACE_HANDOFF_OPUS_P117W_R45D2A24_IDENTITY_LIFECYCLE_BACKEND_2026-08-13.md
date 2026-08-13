# HANDOFF — OPUS P117W R45D2A24 Identity lifecycle backend

Date : 2026-08-13

Base publiée : `ca1ecfccaa8162d376af09b05f803bcb42134514` — `opus_p117w_r45d2a23_localized_public_routes`.

R45D2A23 est validé owner et publié.

## Gate actif

R45D2A24 prépare le backend atomique pour les futures actions Modifier/Supprimer sur un utilisateur ou un agent.

Nouvelles mutations : `identity.update` et `identity.delete`. La clé provider+subject reste immuable. Le type `user|agent` est explicite. Les rôles restent gérés séparément.

La suppression local-password traite dans le même commit la référence applicative et l'entrée runtime correspondante lorsqu'elles existent. Les pertes d'accès apparaissent dans Preview. La dernière identité administrative est protégée par la sémantique ACL, sans hardcode du nom du rôle.

Le snapshot conserve la classification onboarding lors de la fusion avec une identité runtime local-password.

## Livrable

`opus_p117w_r45d2a24_identity_lifecycle_backend.zip`

SHA-256 : `748efa92f09a13217a86a3ec9863283ec2ad3ac82b1563df609aa05806d4751d`.

Base : `ca1ecfccaa8162d376af09b05f803bcb42134514`.

Gate attendu : `OPUS_R45D2A24_IDENTITY_LIFECYCLE_BACKEND_OK`.

Après validation et publication owner seulement, R45D2A25 exposera graphiquement Modifier/Supprimer dans les cartes Utilisateurs/Agents.

NO UI BEFORE BACKEND GATE.
NO VIEWER MUTATION.
NO IDENTITY TYPE INFERENCE.
NO LAST-ADMIN DELETE.
NO PUSH OPUS/OWASYS BY ASSISTANT.
