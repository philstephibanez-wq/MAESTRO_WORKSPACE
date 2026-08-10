# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-11

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A14_GENERATED_LOGOUT_2026-08-11.md`
6. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A14_GENERATED_LOGOUT_2026-08-11.md`
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
- message login I18n : acquis ;
- Profiler intégré/repliable + corrélation login : acquis ;
- R45D2A12 : UI Sources/Git alignée sur ACL `source/write` et publiée.

## Besoin courant

`essai2` ne possède aucun moyen de déconnexion propre après authentification.

Le registre de routes publié ne contient que `/` et `/login`. `GeneratedSiteRuntime` sait authentifier et gérer la session mais n'implémente pas de logout.

## Livrable actif — R45D2A14

```text
ZIP     : opus_p117w_r45d2a14_generated_logout.zip
SHA-256 : 2bdfb59b45b54a903722d5a2b63c5ecfc573c4eacb78049fbda3e0d4a88e0dbb
BASE    : 186517fd37c14047e33308500d0699b8ac36ab44
FILES   : 3
```

R45D2A14 supersède R45D2A13 et inclut la propagation du composant visuel `opus-alert`.

Correction :

- route `POST /logout` ;
- CSRF scoped single-use ;
- bouton/formulaire SCORE `Déconnexion` uniquement authentifié ;
- session détruite + cookie expiré ;
- redirection 303 vers `/locale/login` ;
- Logger/Profiler `security.sso.logout.succeeded` ;
- I18n UE + ukrainien ;
- migration des sites Composer générés avec login.

## Gate immédiat

1. extraire R45D2A14 dans `H:\OPUS` ;
2. `php tools\r45d2a14_apply_generated_logout.php` ;
3. `php tools\smoke_r45d2a14_generated_logout.php` ;
4. lint runtime + scaffold ;
5. `composer dump-autoload -o` ;
6. `git status --short` ;
7. relancer `essai2` ;
8. connecté : `Déconnexion` visible ;
9. activation : session supprimée et redirection `/fr/login` ;
10. `/fr` doit redemander l'authentification.

NO SITE-SPECIFIC PATCH.
NO GET LOGOUT.
NO SSO/ACL RELAXATION.
NO SECRET.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
