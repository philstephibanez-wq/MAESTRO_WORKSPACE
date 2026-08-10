# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-11

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A13_GENERATED_LOGIN_ALERT_PROPAGATION_2026-08-11.md`
6. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A13_GENERATED_LOGIN_ALERT_PROPAGATION_2026-08-11.md`
7. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
186517fd37c14047e33308500d0699b8ac36ab44  opus_p117w_r45d2a12_source_acl_ui_truth
76b25c1b2bace4598f3535101a46283fa52684f5  test
509904785c8d9d4b2e6deed7314e1e690c0ee211  opus_p117w_r45d2a11_local_password_reset_alert
```

## États owner acquis

- `essai2/steve` : connexion réussie ;
- reset local-password : acquis ;
- message utilisateur login I18n : acquis ;
- Profiler intégré/repliable + corrélation login : acquis ;
- R45D2A12 : `source.read_only` aligné sur ACL `source/write` et publié.

## Défaut courant

La capture owner dans OWASYS Sources/Git montre que `sites/essai2/application/login/templates/index.score` contient toujours l'ancien :

```score
<p role="alert">[[ i18n: auth.error ]]</p>
```

Le master confirme que `Opus/Scaffold/SiteScaffoldPlan.php` génère encore ce même ancien rendu et que le CSS de `essai2` ne contient aucun composant `opus-alert`.

## Cause

La partie visuelle « alerte login standardisée » prévue avec R45D2A11 n'a pas été propagée dans le scaffold canonique ni dans les sites générés existants.

R45D2A12 a également introduit une simple mise en forme LF du bloc legacy de `essai2`; le correctif doit reconnaître les variantes réelles sans ancre textuelle unique fragile.

## Livrable actif — R45D2A13

```text
ZIP     : opus_p117w_r45d2a13_generated_login_alert_propagation.zip
SHA-256 : f66e6b4614f4326e8b9ba6e14ad698b6443607b253b0f21e9921ac079c96855c
BASE    : 186517fd37c14047e33308500d0699b8ac36ab44
FILES   : 2
```

R45D2A13 corrige le scaffold, ajoute le style `opus-alert`, migre tous les sites Composer générés avec login et smoke la convergence.

## Gate immédiat

1. extraire le ZIP dans `H:\OPUS` ;
2. `php tools\r45d2a13_apply_generated_login_alert_propagation.php` ;
3. `php tools\smoke_r45d2a13_generated_login_alert_propagation.php` ;
4. `php -l Opus\Scaffold\SiteScaffoldPlan.php` ;
5. `composer dump-autoload -o` ;
6. `git status --short` ;
7. relancer `essai2` ;
8. mauvais mot de passe : alerte visuelle OPUS standard + message I18n + Profiler inchangé.

NO SITE-SPECIFIC PATCH.
NO SSO/ACL RELAXATION.
NO SECRET.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
