# OPUS P117W R45D2A20 — Standard local-password role provisioning

Date : 2026-08-11

## Base canonique

`38a053d585bfd0b154183a5ad7b043504634c043` — `opus_p117w_r45d2a19d_credential_ownership_atomic_cleanup`

## Cause traitée

La matrice ACL admin/developer/viewer est définie, mais OWASYS local ne dispose pas encore d'identités authentifiables developer/viewer permettant de valider le comportement réel de l'UI et du backend.

Le framework possède déjà `LocalPasswordCredentialProvisioner`, mais son contrat est limité aux sites `generated-opus-application` et récupère les rôles uniquement depuis `security.onboarding.json`. Une édition manuelle de `var/auth/local-users.json` serait interdite : elle contournerait le framework, le contrat ACL et le workflow de provisioning.

## Contrat R45D2A20

Évolution générique OPUS du provisioner existant :

- conservation du comportement actuel pour `generated-opus-application` ;
- support de `standard-opus-application` lorsque `local-password` est provider actif ;
- pour une application standard, rôle(s) explicitement fournis par l'opérateur via `--role=<role>` ;
- chaque rôle est validé contre `config/acl.json` sous contrat `OPUS_ACL_POLICY_V1` deny-by-default ;
- rôle inconnu = refus ;
- application standard sans rôle = refus ;
- override de rôle sur un site généré = refus pour ne pas contourner l'onboarding ;
- store runtime lu depuis la configuration SSO (`store` ou `runtime_store`) ;
- contrat du store standard pris depuis `store_contract` ;
- mot de passe uniquement via STDIN non interactif ; jamais argv, Git, log ou Profiler ;
- aucune identité codée en dur et aucun store runtime versionné.

## Compatibilité

La commande existante reste :

`composer opus:local-password-provision -- <site_id> <subject>`

Pour une application standard, elle accepte en plus un ou plusieurs :

`--role=<role>`

Le flux generated existant reste sans argument rôle et continue à utiliser l'identité d'onboarding.

## Livrable

```text
ZIP     : opus_p117w_r45d2a20_standard_local_password_role_provisioning.zip
SHA-256 : c74fb241be1b53237e9271ef5302f0e3ded1d0ae60451c4c34d157ff908e8b0c
BASE    : 38a053d585bfd0b154183a5ad7b043504634c043
FILES   : 4
```

Fichiers :

- `Opus/Security/Sso/LocalPasswordCredentialProvisioner.php`
- `Opus/Security/Sso/LocalPasswordCredentialProvisionerInterface.php`
- `Opus/Composer/LocalPasswordCredentialProvisionerComposerCommand.php`
- `tools/smoke_r45d2a20_standard_local_password_role_provisioning.php`

## Gate technique

Le smoke doit valider :

- provisioning standard avec rôle ACL connu ;
- mot de passe réellement hashé ;
- store contractuel standard conservé ;
- refus sans rôle ;
- refus d'un rôle ACL inconnu ;
- compatibilité du provisioning generated existant ;
- refus d'un override de rôle pour generated.

Attendu :

`OPUS_R45D2A20_SMOKE_OK`

## Gate fonctionnel suivant

Provisionner deux identités runtime non versionnées dans `owasys-front` :

- une identité rôle `developer` ;
- une identité rôle `viewer`.

Puis valider la matrice contractuelle :

- developer : mutations autorisées, Security Preview/Commit, Sources/Git mutation, Profiler visible ;
- viewer : mêmes pages de lecture, aucune mutation, Profiler inaccessible ;
- backend décisif pour les refus, pas uniquement masquage SCORE.

NO HARDCODED TEST ACCOUNT.
NO MANUAL VAR/AUTH EDIT.
NO PASSWORD IN ARGV/GIT/LOG/PROFILER.
NO GENERATED ONBOARDING BYPASS.
NO ACL BYPASS.
NO PRIMARY_ROLE AUTHORIZATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
