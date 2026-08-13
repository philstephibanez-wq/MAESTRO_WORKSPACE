# OPUS P117W R45D2A25B — SecurityController source canonicalization

Date : 2026-08-13

## Base canonique

`230dd10deb0f2abbc76388c6516f694a3b72ee12` — `opus_p117w_r45d2a25a_identity_lifecycle_ui_installer_fix`.

R45D2A25A est publié. Le lifecycle UI Utilisateur/Agent est présent côté front Security : update/delete, classification des identités legacy, pertes d'accès Preview et protection utilisateur de la dernière identité administrative.

## Observation après publication

Le diff publié de R45D2A25A révèle une dégradation de forme dans `sites/owasys-front/application/security/controllers/SecurityController.php` : le helper d'installation tolérant à l'indentation a réinséré certaines lignes du bloc de capacités Security avec une indentation incorrecte.

Le PHP reste syntaxiquement valide et les expressions métier sont présentes, mais la source n'est plus conforme au niveau de qualité attendu. On ne poursuit pas un nouveau chantier fonctionnel sur cette source dégradée.

## Objectif R45D2A25B

Canoniser uniquement l'indentation du bloc de capacités Security sans modifier sa sémantique :

- `identity_reference_supported` ;
- `identity_update_supported` ;
- `identity_delete_supported` ;
- `role_create_supported` ;
- `permission_grant_supported` ;
- `assignment_grant_supported` ;
- `assignment_grant_unsupported` ;
- `resource_allow_supported` ;
- `destructive_mutations_supported` ;
- `mutation_preview`.

Aucun changement ACL, FSM, REST, Composer, I18n, SCORE ou backend.

## Non-régressions

Le smoke doit confirmer que restent présents :

- `identity.update` ;
- `identity.delete` ;
- `identity_update_supported => $canMutate` ;
- `identity_delete_supported => $canMutate` ;
- `destructive_mutations_supported => $canMutate` ;
- `mutation_lost` ;
- `mutation_error_last_administrator`.

Le viewer reste sans mutation lifecycle.

## Livrable

```text
ZIP     : opus_p117w_r45d2a25b_securitycontroller_source_canonicalization.zip
SHA-256 : f61c7cea1bb7ff37e866b1805c4b0e24aa264007dffdf42ebd8fe031fe4bb96c
BASE    : 230dd10deb0f2abbc76388c6516f694a3b72ee12
FILES   : 2
```

Gates attendus :

- `OPUS_R45D2A25B_APPLIED`
- `OPUS_R45D2A25B_SECURITYCONTROLLER_SOURCE_CANONICAL_OK`

NO BEHAVIOR CHANGE.
NO ACL CHANGE.
NO REST CHANGE.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
