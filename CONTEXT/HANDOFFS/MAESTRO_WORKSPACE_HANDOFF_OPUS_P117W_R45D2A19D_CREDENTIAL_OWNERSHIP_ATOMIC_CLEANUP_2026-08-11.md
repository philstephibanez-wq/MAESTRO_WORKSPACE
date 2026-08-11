# HANDOFF — OPUS P117W R45D2A19D — Credential ownership atomic cleanup

Date : 2026-08-11

## Base OPUS

`1908e9ae4e28d599855b5e8d1e424a6c335d0507` — `opus_p117w_r45d2a19c_local_password_credential_ownership`

## État owner acquis

- break-glass local-password acquis ;
- redirection `must_change_password -> /account/password` acquise ;
- page account/password I18n rendue ;
- changement du mot de passe temporaire vers un nouveau mot de passe fonctionne ;
- admin Security Preview + Commit acquis ;
- R45D2A19C publié et fonctionnel côté front.

## Publication partielle constatée

Le commit R45D2A19C ne contient pas le nettoyage backend annoncé. La comparaison avec son parent montre seulement les catalogues I18n account + `RuntimeSecurity.php`.

Master contient encore l'ancien flux backend password : script Composer, commande interne, opération REST, route REST, handler back et permission explicite account côté back.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a19d_credential_ownership_atomic_cleanup.zip
SHA-256 : 783a9474375d93ef1e2fe2ac336e2b63eec0c528b98a41df257687fee65e26ca
BASE    : 1908e9ae4e28d599855b5e8d1e424a6c335d0507
FILES   : 2
```

R45D2A19D supprime atomiquement l'ancien flux backend `admin-password` et resynchronise les catalogues REST.

## Gate

1. extraire ZIP ;
2. lancer applicator ;
3. lancer smoke ;
4. linter `OwasysCommandProvider.php` ;
5. `composer validate --no-check-publish` ;
6. `composer dump-autoload -o` ;
7. vérifier `git status --short` ;
8. exiger que les fichiers back/config attendus soient réellement modifiés ;
9. owner commit/push ;
10. vérifier GitHub master après push.

Attendus :

```text
OPUS_R45D2A19D_APPLIED
OPUS_R45D2A19D_SMOKE_OK fingerprint=... operations=...
```

## Suite après publication

Matrice ACL contractuelle :

- developer : Security Preview + Commit ;
- viewer : Security lecture seule ;
- viewer : aucun Profiler ;
- vérifier ensuite toute la matrice admin/developer/viewer par smoke exécutable et test navigateur.

Le provisioner `LocalPasswordCredentialProvisioner` existe déjà dans OPUS mais reste actuellement limité aux sites générés. Ne pas créer de comptes test codés en dur ou versionnés. Si des identités developer/viewer authentifiables manquent, faire évoluer ce provisioner génériquement et de façon dev-only plutôt que modifier le store runtime à la main.

NO PARTIAL PUBLICATION.
NO BACKEND ACCESS TO FRONT CREDENTIAL STORE.
NO PASSWORD OVER REST.
NO SITE-SPECIFIC USER HACK.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
