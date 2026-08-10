# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-10

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A12_SOURCE_ACL_UI_TRUTH_2026-08-10.md`
6. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A12_SOURCE_ACL_UI_TRUTH_2026-08-10.md`
7. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
76b25c1b2bace4598f3535101a46283fa52684f5  test
509904785c8d9d4b2e6deed7314e1e690c0ee211  opus_p117w_r45d2a11_local_password_reset_alert
31f6c142a1b41a16d6f1cdc17cd48f3d866c3b33  opus_p117w_r45d2a10_login_prg_profiler_correlation
```

Le commit `76b25c1b...` ne modifie que `sites/essai2/config/site.json` (`site_name`).

## États owner acquis

- `essai2/steve` : connexion réussie après R45D2A11 ;
- reset local-password : acquis ;
- message utilisateur login I18n : acquis ;
- Profiler intégré/repliable et corrélation login : acquis.

## Défaut courant

Dans OWASYS Sources/Git, l'identité admin + développeur peut modifier et enregistrer une source mais un bandeau affirme simultanément que la source est en lecture seule.

La mutation réussie confirme que l'ACL backend `source/write` autorise bien l'identité.

## Cause

Le ViewModel source utilise actuellement :

```text
roleCanWrite = ACL(source/write)
editable = selectedPresent && roleCanWrite
read_only = !editable
```

`read_only` confond donc capacité ACL et absence de sélection. Le premier rendu sans fichier sélectionné affiche le bandeau ; le chargement AJAX suivant active correctement l'éditeur via la capacité ACL sans supprimer ce message statique.

## Livrable actif — R45D2A12

```text
ZIP     : opus_p117w_r45d2a12_source_acl_ui_truth.zip
SHA-256 : 98dc1db93358d5d3b6e6d9c2fda564898a9bb8979109dc4d3d1a9e9298b04be3
BASE    : 76b25c1b2bace4598f3535101a46283fa52684f5
FILES   : 2
```

Correction : `source.read_only` est dérivé exclusivement de `!$roleCanWrite`.

## Gate immédiat

1. extraire le ZIP dans `H:\OPUS` ;
2. exécuter `php tools\r45d2a12_apply_source_acl_ui_truth.php` ;
3. exécuter `php tools\smoke_r45d2a12_source_acl_ui_truth.php` ;
4. lint `SourceController.php` ;
5. `composer dump-autoload -o` ;
6. relancer `owasys-front` ;
7. admin + développeur : aucun faux bandeau lecture seule, écriture toujours autorisée ;
8. identité sans `source/write` : bandeau lecture seule et écriture backend refusée.

NO SITE-SPECIFIC PATCH.
NO ACL BYPASS.
NO ROLE MERGE.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
