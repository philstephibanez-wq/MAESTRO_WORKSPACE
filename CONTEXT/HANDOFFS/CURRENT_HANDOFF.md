# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-13

## Lecture obligatoire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A23_LOCALIZED_PUBLIC_ROUTES_2026-08-13.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A24_IDENTITY_LIFECYCLE_BACKEND_2026-08-13.md`
6. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A24_IDENTITY_LIFECYCLE_BACKEND_2026-08-13.md`
7. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base OPUS publiée

`ca1ecfccaa8162d376af09b05f803bcb42134514` — `opus_p117w_r45d2a23_localized_public_routes`.

R45D2A23 est validé owner et publié. Les routes publiques frontend localisées avec accents sont acquises.

## Gates acquis

- cockpit Sécurité graphique acquis ;
- matrice ACL viewer acquise ;
- Profiler viewer masqué et accès direct refusé ;
- page 403 ACL graphique acquise ;
- Compte viewer acquis ;
- routes frontend localisées avec accents acquises.

## Gate actif

R45D2A24 — backend atomique du cycle de vie Utilisateur/Agent.

Le backend ajoute `identity.update` et `identity.delete` au pipeline Security existant. `identity.reference` reste l'ajout. La clé provider+subject reste immuable ; `identity_type=user|agent` est explicite ; rôles et permissions restent séparés.

La suppression local-password traite atomiquement la référence applicative et l'entrée runtime correspondante lorsqu'elles existent. Le Preview expose les pertes d'accès. La dernière identité administrative est protégée par la sémantique ACL sans hardcode du nom du rôle.

Le snapshot doit conserver la classification onboarding lors de la fusion avec une identité runtime local-password.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a24_identity_lifecycle_backend.zip
SHA-256 : 748efa92f09a13217a86a3ec9863283ec2ad3ac82b1563df609aa05806d4751d
BASE    : ca1ecfccaa8162d376af09b05f803bcb42134514
FILES   : 2
```

Gate attendu : `OPUS_R45D2A24_IDENTITY_LIFECYCLE_BACKEND_OK`.

## Suite seulement après gate backend

R45D2A25 : exposition SCORE graphique Modifier/Supprimer dans les cartes Utilisateurs/Agents, avec Preview/Commit et pertes d'accès visibles.

NO UI BEFORE BACKEND GATE.
NO VIEWER MUTATION.
NO IDENTITY TYPE INFERENCE.
NO LAST-ADMIN DELETE.
NO PUSH OPUS/OWASYS BY ASSISTANT.
