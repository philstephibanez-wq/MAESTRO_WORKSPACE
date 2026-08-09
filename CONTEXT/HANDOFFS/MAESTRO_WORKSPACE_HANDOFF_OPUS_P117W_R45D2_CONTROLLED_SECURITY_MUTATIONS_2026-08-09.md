# HANDOFF — OPUS P117W R45D2 CONTROLLED SECURITY MUTATIONS

Date : 2026-08-09

## Source de vérité

```text
OPUS/master
af8ac2f5ed2c9d2d528b5f94863d018d3c7aa121
opus_p117w_r45d1_security_snapshot_workspace
```

R45D1 est publié par l'owner. Le screenshot owner confirme le rendu runtime de `/fr-FR/security` sur `owasys-back` : workspace réel, cible protégée/read-only, ACL `OPUS_ACL_POLICY_V1`, SSO `OPUS_SSO_CONFIGURATION_V1`, `deny`, providers `auth0-proxy` et `service-hmac`, aucune identité initiale. Cette cible système ne doit jamais devenir mutable via R45D2.

## Livrable suivant

```text
R45D2
ZIP     : opus_p117w_r45d2_controlled_security_mutations.zip
SHA-256 : 3f40e620dae36cd57eb671f2efc8071fbe288831558d6201d40e80a4394558ba
BASE    : af8ac2f5ed2c9d2d528b5f94863d018d3c7aa121
FILES   : 38
```

R45D2 ajoute une pipeline preview -> confirmation -> commit pour cinq mutations additives :

```text
identity.reference
role.create
permission.grant
assignment.grant
resource.allow
```

## Protections

```text
OWASYS admin only
security:manage front + back
single-use CSRF
fresh local-password reauthentication
no password over REST
protected owasys-front/owasys-back targets
generated-opus-application + generated_by=composer only
current_state_hash optimistic concurrency
deterministic confirmation token
File::writeAtomic
validation
rollback
audit Logger/Profiler
```

Auth0 fresh-auth n'est pas simulé : si l'admin OWASYS n'utilise pas `local-password`, les mutations R45D2 restent indisponibles.

`assignment.grant` n'est proposé que lorsqu'un véritable store runtime `local-password` cible existe. Aucun mapping ou stockage d'attribution inexistant n'est inventé.

Les mutations destructives sont hors R45D2 et restent à traiter avec protection du dernier administrateur, révocation/invalidation d'autorisation et audit renforcé.

## REST / Composer

```text
GET   /api/v1/applications/{site_id}/security
POST  /api/v1/applications/{site_id}/security/previews
PATCH /api/v1/applications/{site_id}/security
```

```text
security.snapshot
security.mutation.preview
security.mutation.commit
```

```text
owasys:security-snapshot
owasys:security-mutation-preview
owasys:security-mutation-commit
```

Flux inchangé :

```text
owasys-front SCORE
-> REST sécurisé
-> owasys-back
-> Composer allow-listé
-> File + StructuredFileLoader
-> réponse
-> SCORE
```

## Validation statique

```text
PHP lint                 OK
JSON                     OK (32)
I18n base                OK (25)
SCORE control balance    OK
REST security catalogs   OK
Composer allow-list      OK
backend JS/Node delta    0
Opus/**/*.php delta      0
mutation plan dynamic    0
```

## Gate owner immédiat

1. `git status --short` vide et HEAD `af8ac2f5...` ;
2. extraire R45D2 ;
3. lint/config/autoload ;
4. lancer back puis front ;
5. confirmer que les deux applications OWASYS restent read-only ;
6. créer une application générée de test ;
7. sélectionner cette application et ouvrir Sécurité ;
8. admin local-password : preview d'une mutation additive ;
9. confirmer qu'aucun fichier n'est modifié à la preview ;
10. commit avec nouvelle réauthentification ;
11. vérifier changement réel, snapshot, audit et Profiler ;
12. tester rejet d'un état concurrent obsolète ;
13. commit/push OPUS par l'owner uniquement après succès.

```text
NO SITE-SPECIFIC PATCH.
NO ROLE MERGE.
NO FSM MERGE.
NO ACL BYPASS.
NO REST BYPASS.
NO BACKEND JAVASCRIPT.
NO SECRET OVER REST.
NO DESTRUCTIVE MUTATION IN R45D2.
NO PUSH OPUS BY ASSISTANT.
```
