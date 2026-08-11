# OPUS P117W R45D2A19C — Local-password credential ownership

Date : 2026-08-11
Statut : livrable actif, à valider par owner

## Constat

Après R45D2A19 break-glass et R45D2A19B Account I18n completeness, `/fr-FR/account/password` est rendu correctement et le POST atteint le backend.

Le backend échoue avec :

`OWASYS_SECURITY_PROVIDER_UNSUPPORTED`

sur `owasys:admin-password-change`.

## Cause racine

`owasys-front` possède le provider développement `local-password` et son store runtime non versionné. `owasys-back`, autonome et déployable sur un autre bastion, possède `auth0-proxy` / service-HMAC et ne possède pas le store local-password du front.

L'ancien flux envoyait les mots de passe au backend puis `OwasysCommandProvider::changePassword()` lisait `owasys-back/config/sso.json` et exigeait malgré cela `default_provider=local-password`. Ce contrat était impossible par construction.

Il est interdit de corriger ceci en faisant lire au backend le filesystem du front : cela casserait l'autonomie des deux applications et le déploiement séparé.

## Décision

`local-password` étant contractuellement un credential runtime de développement, sa mutation reste sur le bastion frontend qui possède le provider et le store.

`OwasysRuntimeSecurity::changePassword()` délègue directement à `SsoManager::changePassword('local-password', ...)`.

Aucun mot de passe courant ou nouveau ne traverse REST.

Le faux endpoint backend `/api/v1/security/admin-password`, son opération, son script Composer, son alias et son handler sont supprimés.

Les catalogues REST front/back sont resynchronisés atomiquement après suppression de la route.

Les mutations Security métier restent inchangées : `owasys-front -> REST -> owasys-back -> Composer`.

## Invariants

- aucun mot de passe dans argv, logs, Profiler ou REST ;
- aucun accès filesystem back -> front ;
- `local-password` reste développement/runtime uniquement ;
- `auth0-proxy` reste géré par l'IdP ;
- break-glass -> temporaire -> `must_change_password=true` -> `/account/password` -> remplacement obligatoire ;
- ACL `account:change` reste obligatoire ;
- aucun fallback silencieux.

## Livrable

```text
ZIP     : opus_p117w_r45d2a19c_local_password_credential_ownership.zip
SHA-256 : 3437dab7d86e76cbace4d041b5d46e74a00a8e274f1996ebaf2212dd1f4037ba
BASE    : ddd71ee3b0554b685156cfbc22994aba5d35989d + R45D2A19B local
FILES   : 2
```

## Gate owner

1. appliquer R45D2A19C ;
2. smoke + lints ;
3. redémarrer front/back ;
4. login avec mot de passe temporaire ;
5. `/account/password` ;
6. temporaire comme mot de passe courant ;
7. nouveau mot de passe + confirmation ;
8. retour `/applications` ;
9. vérifier que l'ancien temporaire est refusé et le nouveau accepté ;
10. aucun appel `/api/v1/security/admin-password` ne doit apparaître dans les logs backend.
