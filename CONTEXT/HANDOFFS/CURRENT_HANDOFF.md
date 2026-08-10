# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-11

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A14B_LOGOUT_ATOMIC_MIGRATION_2026-08-11.md`
6. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A14B_LOGOUT_ATOMIC_MIGRATION_2026-08-11.md`
7. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
f195471557727d23d0be036b80382f3ba3ad9787  opus_p117w_r45d2a14_generated_logout
186517fd37c14047e33308500d0699b8ac36ab44  opus_p117w_r45d2a12_source_acl_ui_truth
```

## États owner acquis

- `essai2/steve` : connexion réussie ;
- reset local-password : acquis ;
- message login I18n : acquis ;
- Profiler intégré/repliable + corrélation login : acquis ;
- R45D2A12 : UI Sources/Git alignée sur ACL `source/write` et publiée.

## Régression courante

R45D2A14 a publié le runtime logout mais pas les artefacts générés nécessaires. `essai2` ne contient ni route `/logout` ni clé I18n `auth.logout`. Le runtime tente pourtant de traduire `auth.logout` pour toute session authentifiée, provoquant `OPUS_GENERATED_RUNTIME_FAILED` sur `/fr`.

## Livrable actif — R45D2A14B

```text
ZIP     : opus_p117w_r45d2a14b_logout_atomic_migration.zip
SHA-256 : 7c5116094616bdd93269ff74b99cfde7ad4047a131a06f96b191793bd88c7964
BASE    : f195471557727d23d0be036b80382f3ba3ad9787
FILES   : 2
```

Correction :

- le runtime ne rend le logout que si une route `module=logout` existe réellement ;
- migration atomique des sites Composer avec login : route `/logout`, I18n `auth.logout`, CSS ;
- smoke fail-fast exige route + I18n avant validation.

## Gate immédiat

1. extraire R45D2A14B dans `H:\OPUS` ;
2. `php tools\r45d2a14b_apply_logout_atomic_migration.php` ;
3. `php tools\smoke_r45d2a14b_logout_atomic_migration.php` ;
4. lint runtime ;
5. `composer dump-autoload -o` ;
6. relancer `essai2` ;
7. `/fr` authentifié fonctionne ;
8. `Déconnexion` visible ;
9. logout POST invalide la session et redirige `/fr/login`.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO GET LOGOUT.
NO SSO/ACL RELAXATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
