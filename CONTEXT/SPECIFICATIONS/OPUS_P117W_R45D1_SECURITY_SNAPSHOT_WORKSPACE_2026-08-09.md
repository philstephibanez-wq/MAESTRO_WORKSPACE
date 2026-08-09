# OPUS P117W R45D1 — SECURITY SNAPSHOT WORKSPACE

Date : 2026-08-09  
Statut : ACQUIS / PUBLIÉ — VALIDATION RUNTIME OWNER PARTIELLE CONFIRMÉE

## Base de construction

```text
730f19032a5b69c66c14d4d4401813e0638353d1
opus_p117w_r45c3r1_github_recovery_structured_workflow
```

## Publication acquise

R45D1 a été appliqué, committé et poussé par l'owner :

```text
OPUS/master
af8ac2f5ed2c9d2d528b5f94863d018d3c7aa121
opus_p117w_r45d1_security_snapshot_workspace
```

Le screenshot owner reçu le 2026-08-09 confirme `/fr-FR/security` avec `owasys-back` sélectionné : workspace `Sécurité` réellement rendu, mode lecture seule, ACL `OPUS_ACL_POLICY_V1`, SSO `OPUS_SSO_CONFIGURATION_V1`, politique `deny`, fournisseur par défaut `auth0-proxy`, fournisseurs `auth0-proxy` et `service-hmac`, aucune identité initiale.

L'absence d'identités est cohérente avec l'absence de `security.onboarding.json` sur cette cible système. Cette preuve confirme la disparition du pending/HTTP 501 pour cette vue. Elle ne vaut pas validation complète des cinq vues, du maintien de vue au changement de langue ou de la corrélation Profiler distribuée.

## Objet acquis

R45D1 remplace l'écran `Sécurité` non implémenté par un workspace réel, en lecture seule, de la sécurité de l'application OPUS sélectionnée dans OWASYS.

Flux :

```text
SCORE
-> FSM + ACL OWASYS front
-> REST sécurisé GET /api/v1/applications/{site_id}/security
-> owasys-back
-> FSM REST backend
-> Composer allow-listé owasys:security-snapshot
-> OwasysCommandProvider
-> File + StructuredFileLoader
-> réponse structurée
-> SCORE
```

Aucune lecture directe de la sécurité cible n'est effectuée par `owasys-front`.

## Vues R45D1

```text
Identités
Rôles
Permissions
Attributions
Ressources et ACL
```

Le sélecteur utilise `GET /<locale>/security?view=...` et ne dépend pas de JavaScript.

## Séparation des référentiels

R45D1 affiche la sécurité de l'application cible sélectionnée sans fusion avec la sécurité propre d'OWASYS.

```text
NO ROLE MERGE.
NO FSM MERGE.
NO ACL BYPASS.
```

```text
LE DROIT APPARTIENT À LA RESSOURCE, PAS AU BOUTON.
```

## Contrats lus

```text
ACL : OPUS_ACL_POLICY_V1
ACL : OPUS_GENERATED_APPLICATION_ACL_V1
SSO : OPUS_SSO_CONFIGURATION_V1
SSO : OPUS_GENERATED_APPLICATION_SSO_V1
ONBOARDING optionnel : OPUS_SECURITY_ONBOARDING_V1
```

Tout autre contrat est rejeté explicitement. L'absence de `security.onboarding.json` est exposée comme absence ; aucun utilisateur, rôle ou mapping inexistant n'est inventé.

Pour les stores `local-password`, seuls les champs non secrets sont projetés. Aucun `password_hash`, mot de passe, token, secret HMAC ou secret proxy n'est renvoyé au frontend, loggé ou profilé.

## Snapshot

Contrat :

```text
OWASYS_SECURITY_SNAPSHOT_V1
```

Sections :

```text
application
overview
providers
identities
roles
permissions
assignments
resources
```

Pour `OPUS_ACL_POLICY_V1`, les associations rôle-permission réellement déclarées sont affichées. Pour `OPUS_GENERATED_APPLICATION_ACL_V1`, R45D1 n'invente pas une association rôle-permission lorsque le contrat ne la persiste pas explicitement.

## REST / Composer

```text
GET /api/v1/applications/{site_id}/security
operation = security.snapshot
status = 200
```

```text
owasys:security-snapshot
-> owasys:security:snapshot
```

Lecture backend autorisée aux rôles OWASYS `admin`, `developer`, `viewer`, avec ACL `security:read` côté back et `security:open` côté front.

## I18n / SCORE

R45D1 reste SCORE-only et fournit les catalogues de base pour :

```text
bg hr cs da nl en et fi fr de el hu ga it lv lt mt pl pt ro sk sl es sv uk
```

Les variantes régionales utilisent la chaîne de fallback OPUS.

## Livrable acquis

```text
ZIP     : opus_p117w_r45d1_security_snapshot_workspace.zip
SHA-256 : 3eb28c2e13b4c3b7f511564c524eaea47d4dad9c6b61041375cab5cf2c68eb27
BASE    : 730f19032a5b69c66c14d4d4401813e0638353d1
FILES   : 38
COMMIT  : af8ac2f5ed2c9d2d528b5f94863d018d3c7aa121
```

## Validation

Statique :

```text
PHP lint                 OK
JSON                     OK
REST front/back          cohérent
Composer allow-list      cohérent
I18n base                25 catalogues
backend JS/Node delta    0
Opus/**/*.php modifié    0
```

Runtime owner confirmé à ce stade :

```text
/fr-FR/security sur owasys-back : OK
pending/501 : absent sur cette vue
snapshot système read-only : cohérent
```

Restent non prouvés par ce seul screenshot : cinq vues complètes, changement de langue conservant la vue et corrélation Profiler distribuée complète.

## Suite

R45D2 porte les premières mutations additives de sécurité cible avec preview déterministe, confirmation explicite, réauthentification, contrôle de concurrence, écriture atomique, validation, rollback et audit. Les mutations destructives restent hors R45D2.
