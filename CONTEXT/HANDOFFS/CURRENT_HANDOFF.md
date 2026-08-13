# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-13

## Lecture obligatoire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A24_IDENTITY_LIFECYCLE_BACKEND_2026-08-13.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25_IDENTITY_LIFECYCLE_UI_2026-08-13.md`
6. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A25_IDENTITY_LIFECYCLE_UI_2026-08-13.md`
7. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base OPUS publiée

`89a3004ab44f78b565b0229cd554658670696ff1` — `opus_p117w_r45d2a24_identity_lifecycle_backend`.

R45D2A24 est publié. Le backend atomique du cycle de vie Utilisateur/Agent est acquis.

## Gates acquis

- cockpit Sécurité graphique ;
- matrice ACL viewer ;
- Profiler viewer masqué et accès direct refusé ;
- page 403 ACL graphique ;
- Compte viewer ;
- routes frontend localisées avec accents ;
- backend `identity.update` / `identity.delete` avec Preview/Commit, rollback, pertes d'accès et protection de la dernière identité administrative.

La capture owner courante de `/fr-FR/sécurité?view=identities` confirme en `viewer · viewer` : lecture seule, aucun contrôle de mutation, 3 identités legacy `À classifier`.

## Gate actif

R45D2A25 — exposition SCORE graphique du lifecycle Utilisateur/Agent.

Le front ajoute, uniquement pour `security:manage` et si le backend annonce la capacité : Modifier Utilisateur↔Agent, classifier une identité `unknown`, Supprimer avec Preview obligatoire, affichage des accès perdus et message explicite de protection de la dernière identité administrative.

Le couple provider+subject reste immuable. Les rôles/permissions restent séparés. Aucun JavaScript. Aucun changement REST/back/Composer.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a25_identity_lifecycle_ui.zip
SHA-256 : 329827a9fff3f70d3d20c80adc7bb8c33651cced8a609c3e6fb2be5d9c045e92
BASE    : 89a3004ab44f78b565b0229cd554658670696ff1
FILES   : 3
```

Gate CLI attendu : `OPUS_R45D2A25_IDENTITY_LIFECYCLE_UI_OK locales=25`.

Gate navigateur : developer/admin voit les actions ; Preview suppression montre les pertes ; dernière identité administrative refusée ; viewer ne voit aucune action lifecycle.

NO VIEWER MUTATION.
NO DIRECT DELETE.
NO IDENTITY KEY RENAME.
NO ROLE MUTATION INSIDE IDENTITY UPDATE.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
