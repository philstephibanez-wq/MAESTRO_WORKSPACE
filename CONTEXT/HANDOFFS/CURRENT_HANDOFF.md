# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-13

## Lecture obligatoire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A24_IDENTITY_LIFECYCLE_BACKEND_2026-08-13.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25_IDENTITY_LIFECYCLE_UI_2026-08-13.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25B_SECURITYCONTROLLER_SOURCE_CANONICALIZATION_2026-08-13.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25C_UNCLASSIFIED_METRIC_NAVIGATION_2026-08-13.md`
8. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base OPUS publiée

`bde15d01e7e357fe83c257e87de04b3de35065d3` — `opus_p117w_r45d2a25b_securitycontroller_source_canonicalization`.

R45D2A25B est publié et son diff est limité à la canonisation d'indentation de `SecurityController.php`, sans changement fonctionnel.

## Gates acquis

- cockpit Sécurité graphique ;
- matrice ACL viewer ;
- Profiler viewer masqué et accès direct refusé ;
- page 403 ACL graphique ;
- Compte viewer ;
- routes frontend localisées avec accents ;
- backend `identity.update` / `identity.delete` avec Preview/Commit, rollback, pertes d'accès et protection de la dernière identité administrative ;
- exposition SCORE lifecycle publiée par R45D2A25A ;
- canonisation source publiée par R45D2A25B.

## Incident navigateur confirmé

Capture owner en admin sur `essai2` : le clic sur la tuile métrique `3 — À classifier` ne produit aucune ouverture.

Cause vérifiée dans `index.score` publié : la métrique est un simple `<article>` statique. Le vrai panneau est un `<details>` distinct plus bas. L'apparence suggère une interaction qui n'existe pas.

## Gate actif

R45D2A25C — navigation SCORE de la métrique `À classifier` vers le panneau réel.

Contrat :

- métrique `À classifier` = lien vers `#ow-security-unclassified` ;
- panneau legacy identifié et rendu ouvert lorsqu'il existe ;
- aucun JavaScript ;
- aucune modification backend/REST/ACL/FSM ;
- les contrôles lifecycle restent protégés par les capacités Security, donc aucun contrôle de mutation pour viewer.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a25c_unclassified_metric_navigation.zip
SHA-256 : 83c19ae44dacd128beae6660afccdf41a03777ee1123412fd8bcb42154d1c3c6
BASE    : bde15d01e7e357fe83c257e87de04b3de35065d3
FILES   : 2
```

Gate CLI attendu :
- `OPUS_R45D2A25C_APPLIED`
- `OPUS_R45D2A25C_UNCLASSIFIED_METRIC_NAVIGATION_OK`

Gate navigateur : clic sur `À classifier` atteint immédiatement le panneau ouvert ; admin/developer voit Classifier/Supprimer ; viewer n'a aucun contrôle lifecycle.

NO VIEWER MUTATION.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
