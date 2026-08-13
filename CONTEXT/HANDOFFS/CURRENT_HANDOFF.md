# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-13

## Lecture obligatoire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A24_IDENTITY_LIFECYCLE_BACKEND_2026-08-13.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25_IDENTITY_LIFECYCLE_UI_2026-08-13.md`
6. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

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

## Incident R45D2A25 applicateur

Le premier applicateur `r45d2a25_apply_identity_lifecycle_ui.php` s'est arrêté en préflight avec `OPUS_R45D2A25_CONTROLLER_CAPABILITY_TARGET_INVALID`.

Cause : ancre source trop stricte sur l'indentation du bloc `identity_reference_supported` dans `SecurityController.php`. Le contenu métier publié est conforme ; seule la comparaison textuelle de l'installateur était fragile.

Aucune écriture R45D2A25 n'a été effectuée avant l'échec. Le smoke a donc échoué normalement avec `controller-update-capability` absent. Le working tree métier reste sur R45D2A24.

Un chemin non suivi `cd` est apparu localement dans `H:\OPUS` suite à une commande CMD mal interprétée ; il est indépendant du livrable et doit être inspecté/nettoyé avant commit.

## Gate actif

R45D2A25A — correctif d'installateur pour l'exposition SCORE graphique du lifecycle Utilisateur/Agent.

Le contenu fonctionnel R45D2A25 reste inchangé : Modifier Utilisateur↔Agent, classifier une identité `unknown`, Supprimer avec Preview obligatoire, affichage des accès perdus et message explicite de protection de la dernière identité administrative, uniquement pour `security:manage` et capacités backend acquises.

R45D2A25A rend les ancres d'installation tolérantes aux seules différences d'indentation en restant strictes sur le contenu. Préflight complet avant toute écriture.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a25a_identity_lifecycle_ui_installer_fix.zip
SHA-256 : 35a6370e4e6561358fac3fcdf32f7cc17d05c778a2ab4c8aee106ef0ad10abbb
BASE    : 89a3004ab44f78b565b0229cd554658670696ff1
FILES   : 3
```

Gate CLI attendu :
- `OPUS_R45D2A25A_APPLIED locales=25`
- `OPUS_R45D2A25A_IDENTITY_LIFECYCLE_UI_OK locales=25`

Gate navigateur : developer/admin voit les actions ; Preview suppression montre les pertes ; dernière identité administrative refusée ; viewer ne voit aucune action lifecycle.

NO VIEWER MUTATION.
NO DIRECT DELETE.
NO IDENTITY KEY RENAME.
NO ROLE MUTATION INSIDE IDENTITY UPDATE.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
