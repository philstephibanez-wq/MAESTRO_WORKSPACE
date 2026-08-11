# OPUS P117W — R45D2A19D — Credential ownership atomic cleanup

Date : 2026-08-11  
Statut : livrable owner à appliquer/valider  
Base OPUS publiée : `1908e9ae4e28d599855b5e8d1e424a6c335d0507`

## Constat

Le parcours fonctionnel R45D2A19C est validé par l'owner : le mot de passe `local-password` est changé sur `owasys-front` et le flux de récupération aboutit.

Cependant la publication GitHub R45D2A19C est partielle. La comparaison `ddd71ee3... -> 1908e9ae...` montre uniquement :

- les 25 catalogues I18n `account` issus de R45D2A19B ;
- `sites/owasys-front/application/default/services/RuntimeSecurity.php`.

Les suppressions backend prévues par le contrat R45D2A19C ne sont donc pas matérialisées dans master.

Le master contient encore notamment :

- le script Composer `owasys:admin-password-change` ;
- la commande interne `owasys:security:admin-password:change` ;
- l'opération REST `security.admin-password.change` ;
- la route `PATCH /api/v1/security/admin-password` ;
- le handler `OwasysCommandProvider::changePassword()` ;
- des permissions explicites `account:change` côté `owasys-back`.

## Cause

Le contrat de propriété du credential a été corrigé côté front mais la suppression de l'ancien flux backend n'a pas été publiée atomiquement.

Cette situation est interdite : `owasys-front` possède le store runtime `local-password`; `owasys-back` possède légitimement `auth0-proxy`/service-HMAC et doit rester autonome, y compris lorsqu'il est déployé sur un bastion distinct.

Aucun mot de passe local ne doit traverser REST et le backend ne doit jamais ouvrir le store credential du front.

## Correction R45D2A19D

R45D2A19D supprime atomiquement l'ancien flux backend :

1. suppression du handler password et de ses imports dans `OwasysCommandProvider.php` ;
2. suppression de `owasys:admin-password-change` dans `composer.json` ;
3. suppression commande + alias dans `sites/owasys-back/config/composer.commands.json` ;
4. suppression de `security.admin-password.change` dans `backend.operations.json` ;
5. suppression de `/api/v1/security/admin-password` dans `backend.rest.json` ;
6. régénération identique de `backend.resources.json` et `owasys-front/config/rest.resources.json` ;
7. retrait de `account:change` des rôles explicites developer/viewer du backend ;
8. maintien de `account:change` côté front pour admin/developer/viewer conformément à la matrice contractuelle.

## Invariants

- `local-password` reste développement/runtime et non versionné ;
- le changement de mot de passe est exécuté par le `SsoManager` du front qui possède le store ;
- aucun secret/mot de passe dans REST, argv, logs, Profiler ou Git ;
- `owasys-back/config/sso.json` reste `auth0-proxy` par défaut et ne reçoit pas de provider `local-password` ;
- catalogues REST front/back/serveur ont le même fingerprint ;
- toutes les opérations REST Composer restantes référencent un script Composer déclaré ;
- deny-by-default conservé.

## Livrable

```text
ZIP     : opus_p117w_r45d2a19d_credential_ownership_atomic_cleanup.zip
SHA-256 : 783a9474375d93ef1e2fe2ac336e2b63eec0c528b98a41df257687fee65e26ca
BASE    : 1908e9ae4e28d599855b5e8d1e424a6c335d0507
FILES   : 2
```

## Gate owner

Exiger avant commit :

```text
OPUS_R45D2A19D_APPLIED
OPUS_R45D2A19D_SMOKE_OK fingerprint=... operations=...
```

Puis vérifier que `git status --short` montre bien les suppressions/configurations attendues avant commit/push owner.

Après publication, reprendre la matrice ACL fonctionnelle : developer Security Preview/Commit puis viewer lecture seule et sans Profiler.

NO PARTIAL PUBLICATION.
NO BACKEND ACCESS TO FRONT CREDENTIAL STORE.
NO PASSWORD OVER REST.
NO PASSWORD IN ARGV/LOG/PROFILER.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
