# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-11.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 1908e9ae4e28d599855b5e8d1e424a6c335d0507
Commit : opus_p117w_r45d2a19c_local_password_credential_ownership
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
- R45D2A19C : changement de mot de passe local exécuté par le SSO front ; parcours fonctionnel owner acquis.

## Publication partielle R45D2A19C

La comparaison `ddd71ee3... -> 1908e9ae...` montre uniquement les 25 catalogues account et `RuntimeSecurity.php`.

Le master contient encore des éléments obsolètes de l'ancien flux backend password : script Composer, commande interne, opération REST, route REST, handler back et permission explicite account côté back.

Le fonctionnement navigateur ne suffit donc pas à déclarer le contrat atomiquement fermé.

## Livrable actif — R45D2A19D

```text
ZIP     : opus_p117w_r45d2a19d_credential_ownership_atomic_cleanup.zip
SHA-256 : 783a9474375d93ef1e2fe2ac336e2b63eec0c528b98a41df257687fee65e26ca
BASE    : 1908e9ae4e28d599855b5e8d1e424a6c335d0507
FILES   : 2
```

R45D2A19D :

- supprime `owasys:admin-password-change` ;
- supprime `owasys:security:admin-password:change` ;
- supprime `security.admin-password.change` ;
- supprime `/api/v1/security/admin-password` ;
- supprime `OwasysCommandProvider::changePassword()` et imports associés ;
- retire `account:change` explicite du backend developer/viewer ;
- resynchronise backend.rest / backend.resources / front rest.resources ;
- vérifie l'intégrité de toutes les opérations REST Composer restantes.

## Gate owner

```text
OPUS_R45D2A19D_APPLIED
OPUS_R45D2A19D_SMOKE_OK fingerprint=... operations=...
```

Le `git status --short` doit montrer les fichiers back/config attendus avant commit. Après push, revérifier le master GitHub.

## Suite planifiée

Matrice ACL contractuelle :

1. developer : Security Preview + Commit ;
2. viewer : Security lecture seule ;
3. viewer : Profiler refusé ;
4. smoke exécutable de toute la matrice admin/developer/viewer.

Si nécessaire pour les essais navigateur, généraliser `LocalPasswordCredentialProvisioner` aux applications OPUS standard en développement uniquement, sans compte codé en dur et sans versionner le store runtime.

NO PARTIAL PUBLICATION.
NO BACKEND ACCESS TO FRONT CREDENTIAL STORE.
NO PASSWORD OVER REST.
NO MANUAL STORE EDIT.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PRIMARY_ROLE AUTHORIZATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
