# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-10.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 31f6c142a1b41a16d6f1cdc17cd48f3d866c3b33
Commit : opus_p117w_r45d2a10_login_prg_profiler_correlation
```

## États acquis

- R45C3R1 : workflow OWASYS structuré acquis.
- R45D1 : workspace Sécurité réel acquis.
- R45D2A2 : provisioning local-password runtime acquis.
- R45D2A3 : observabilité login acquise.
- R45D2A6 : Profiler repliable validé owner.
- R45D2A7 : projection hiérarchique Profiler acquise.
- R45D2A8 : diagnostic local-password détaillé acquis.
- R45D2A9B : message utilisateur login I18n + PRG acquis.
- R45D2A10 : corrélation trace POST login à travers PRG publiée sous `31f6c142...`.

## Preuve essai2

Le credential `steve` existe mais le password soumis ne correspond pas au hash :

```text
OPUS_SSO_LOCAL_PASSWORD_INVALID
```

La cause technique doit rester dans Logger/Profiler. L'UI reste non discriminante.

## Prochaine cause

Le provisioning initial refuse volontairement d'écraser un credential existant ; aucun contrat d'administration ne permet encore de reset le password sans connaître l'ancien. Le message login est fonctionnel mais son rendu n'est pas encore un composant visuel standard.

## Livrable actif — R45D2A11

```text
ZIP     : opus_p117w_r45d2a11_local_password_reset_alert.zip
SHA-256 : 6fd302cca2867ea7e75979c62a2ad8fa8748e12d383e19d558f9f07c048d65df
BASE    : 31f6c142a1b41a16d6f1cdc17cd48f3d866c3b33
FILES   : 5
```

R45D2A11 ajoute :

- `LocalPasswordCredentialResetter` + interface homonyme quatre marqueurs ;
- commande Composer `opus:local-password-reset` lisant le password uniquement via STDIN ;
- conservation de l'identité et des rôles lors du reset ;
- alerte login SCORE/CSS standardisée, accessible ;
- migration générique des applications Composer générées existantes.

Validation assistant : les cinq PHP du ZIP sont lintés sans erreur.

## Gate owner

1. appliquer R45D2A11 ;
2. exécuter l'applicateur ;
3. lint + `composer dump-autoload -o` ;
4. reset `essai2/steve` avec saisie sécurisée ;
5. valider login réussi ;
6. tester un mauvais password et contrôler l'alerte ;
7. contrôler que le Profiler corrélé affiche toujours la cause réelle du POST.

NO SITE-SPECIFIC PATCH.
NO PASSWORD IN ARGV.
NO SECRET IN UI/LOGS/PROFILER.
NO MANUAL STORE EDIT.
NO ACL/SSO RELAXATION.
NO PUSH OPUS BY ASSISTANT.
