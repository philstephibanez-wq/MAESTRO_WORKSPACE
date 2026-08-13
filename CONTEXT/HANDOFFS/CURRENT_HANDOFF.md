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

`230dd10deb0f2abbc76388c6516f694a3b72ee12` — `opus_p117w_r45d2a25a_identity_lifecycle_ui_installer_fix`.

R45D2A25A est publié. Le front Security contient désormais le lifecycle Utilisateur/Agent : classification des identités legacy, `identity.update`, `identity.delete`, Preview des pertes d'accès et message utilisateur de protection de la dernière identité administrative.

## Gates acquis

- cockpit Sécurité graphique ;
- matrice ACL viewer ;
- Profiler viewer masqué et accès direct refusé ;
- page 403 ACL graphique ;
- Compte viewer ;
- routes frontend localisées avec accents ;
- backend `identity.update` / `identity.delete` avec Preview/Commit, rollback, pertes d'accès et protection de la dernière identité administrative ;
- exposition SCORE lifecycle publiée par R45D2A25A.

## Preuve navigateur admin R45D2A25A

Capture owner sur `/fr-FR/sécurité` avec `admin · admin`, application `essai2` :

- route publique localisée avec accent confirmée ;
- cockpit Security chargé ;
- mutations disponibles pour admin : création Utilisateur et Agent visible ;
- compteurs : 0 Utilisateurs, 0 Agents, 3 `À classifier`, 1 Rôle, 3 Ressources/ACL ;
- le panneau `À classifier` est replié sur la capture ; le template publié place bien `Classifier l’identité` et `Supprimer` à l'intérieur de ce `<details>`.

Le gate navigateur lifecycle n'est donc pas encore totalement fermé : il reste à ouvrir le panneau et tester Preview/Commit puis recontrôler viewer.

## Observation post-publication R45D2A25A

Le diff GitHub publié montre une dégradation d'indentation dans le bloc de capacités de `sites/owasys-front/application/security/controllers/SecurityController.php` : certaines lignes ont perdu leur niveau d'indentation lors de la réinsertion par l'installateur tolérant aux espaces.

La sémantique métier reste présente et le PHP reste valide, mais la source n'est pas laissée dans cet état avant le chantier suivant.

## Gate actif

R45D2A25B — canonisation de la source `SecurityController.php` sans changement de comportement.

Le correctif remet uniquement en forme le bloc `identity_reference_supported` / `identity_update_supported` / `identity_delete_supported` / capacités associées et conserve intégralement les expressions ACL et lifecycle.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a25b_securitycontroller_source_canonicalization.zip
SHA-256 : f61c7cea1bb7ff37e866b1805c4b0e24aa264007dffdf42ebd8fe031fe4bb96c
BASE    : 230dd10deb0f2abbc76388c6516f694a3b72ee12
FILES   : 2
```

Gates CLI attendus :

- `OPUS_R45D2A25B_APPLIED`
- `OPUS_R45D2A25B_SECURITYCONTROLLER_SOURCE_CANONICAL_OK`

Après publication owner : reprendre le gate navigateur developer/admin puis recontrôler viewer.

NO BEHAVIOR CHANGE.
NO VIEWER MUTATION.
NO DIRECT DELETE.
NO IDENTITY KEY RENAME.
NO ROLE MUTATION INSIDE IDENTITY UPDATE.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
