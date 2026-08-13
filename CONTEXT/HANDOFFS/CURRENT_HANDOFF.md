# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-13

## Lecture obligatoire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A24_IDENTITY_LIFECYCLE_BACKEND_2026-08-13.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25_IDENTITY_LIFECYCLE_UI_2026-08-13.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25B_SECURITYCONTROLLER_SOURCE_CANONICALIZATION_2026-08-13.md`
7. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base OPUS publiée

`bde15d01e7e357fe83c257e87de04b3de35065d3` — `opus_p117w_r45d2a25b_securitycontroller_source_canonicalization`.

R45D2A25B est publié. Le bloc de capacités Security de `SecurityController.php` est de nouveau canonique, sans changement de comportement.

## Gates acquis

- cockpit Sécurité graphique ;
- matrice ACL viewer ;
- Profiler viewer masqué et accès direct refusé ;
- page 403 ACL graphique ;
- Compte viewer ;
- routes frontend localisées avec accents ;
- backend `identity.update` / `identity.delete` avec Preview/Commit, rollback, pertes d'accès et protection de la dernière identité administrative ;
- exposition SCORE lifecycle publiée par R45D2A25A ;
- canonisation source SecurityController publiée par R45D2A25B.

## Preuve navigateur admin

Capture owner sur `/fr-FR/sécurité` avec `admin · admin`, application `essai2` :

- route publique localisée avec accent confirmée ;
- cockpit Security chargé ;
- création Utilisateur et Agent visible pour admin ;
- compteurs : 0 Utilisateurs, 0 Agents, 3 `À classifier`, 1 Rôle, 3 Ressources/ACL ;
- le panneau `À classifier` est replié ; le template publié place bien `Classifier l’identité` et `Supprimer` à l'intérieur de ce `<details>`.

## Gate actif

Validation navigateur lifecycle R45D2A25A/B :

1. ouvrir `À classifier` en admin/developer et confirmer `Classifier l’identité` + `Supprimer` ;
2. lancer une Preview de classification ou suppression sans Commit et vérifier le résumé ;
3. vérifier l'affichage des accès perdus pour une suppression ;
4. vérifier la protection de la dernière identité administrative ;
5. reconnecter `viewer` et confirmer l'absence totale de contrôles lifecycle.

Aucun nouvel incrément fonctionnel n'est ouvert avant ce gate navigateur, afin de ne pas masquer une éventuelle régression du lifecycle publié.

NO VIEWER MUTATION.
NO DIRECT DELETE.
NO IDENTITY KEY RENAME.
NO ROLE MUTATION INSIDE IDENTITY UPDATE.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
