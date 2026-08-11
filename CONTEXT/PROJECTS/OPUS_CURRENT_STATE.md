# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-11.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 38a053d585bfd0b154183a5ad7b043504634c043
Commit : opus_p117w_r45d2a19d_credential_ownership_atomic_cleanup
```

## États acquis

- R45D2A12 : UI Sources/Git alignée sur ACL `source/write`.
- R45D2A14B : logout généré acquis.
- R45D2A15B : catalogues REST synchronisés.
- R45D2A16 : matrice Sécurité admin/developer/viewer.
- R45D2A16B : dev-server single-owner binding acquis.
- R45D2A18B/C/D : intégrité REST->Composer, secret fresh-auth dev et Security Mutation FSM atomique acquis.
- admin Security Preview + Commit acquis.
- R45D2A19 : break-glass local-password acquis.
- R45D2A19B : page account/password I18n acquise.
- R45D2A19C : changement de mot de passe local exécuté par le SSO front.
- R45D2A19D : ancien flux backend admin-password supprimé ; aucun mot de passe local ne traverse REST.

## Matrice ACL cible

La matrice admin/developer/viewer reste contractuelle. L'ACL front courante donne :

- admin : `*:*` ;
- developer : mutations registry/creation/structure/data/workflows/source/git/build/account/security + `profiler:view` ;
- viewer : lecture registry/structure/data/workflows/security/source/git/build, `account:open` + `account:change`, sans Profiler et sans mutation.

La décision est fondée sur les permissions ACL effectives, jamais `primary_role` seul.

## Livrable actif — R45D2A20

```text
ZIP     : opus_p117w_r45d2a20_standard_local_password_role_provisioning.zip
SHA-256 : c74fb241be1b53237e9271ef5302f0e3ded1d0ae60451c4c34d157ff908e8b0c
BASE    : 38a053d585bfd0b154183a5ad7b043504634c043
FILES   : 4
```

R45D2A20 généralise `LocalPasswordCredentialProvisioner` aux `standard-opus-application` :

- rôle explicite via `--role=<role>` ;
- rôle validé contre `config/acl.json` ;
- password uniquement via STDIN ;
- store runtime non versionné ;
- aucun compte hardcodé ;
- compatibilité generated/onboarding maintenue ;
- override de rôle generated interdit.

## Gate owner

```text
OPUS_R45D2A20_SMOKE_OK
```

Puis provisionner deux identités runtime dans `owasys-front` : developer et viewer, sans édition manuelle du store.

## Suite planifiée

1. browser developer : Security Preview + Commit et autres mutations ;
2. browser viewer : lecture seule ;
3. viewer : Profiler refusé ;
4. backend : refus réel des mutations viewer ;
5. smoke exécutable de toute la matrice admin/developer/viewer.

NO HARDCODED ACCOUNT.
NO MANUAL STORE EDIT.
NO PASSWORD IN ARGV/GIT/LOG/PROFILER.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PRIMARY_ROLE AUTHORIZATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
