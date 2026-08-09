# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-09

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D1_SECURITY_SNAPSHOT_WORKSPACE_2026-08-09.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2_CONTROLLED_SECURITY_MUTATIONS_2026-08-09.md`
8. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2_CONTROLLED_SECURITY_MUTATIONS_2026-08-09.md`
9. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base canonique OPUS

```text
af8ac2f5ed2c9d2d528b5f94863d018d3c7aa121
opus_p117w_r45d1_security_snapshot_workspace
```

R45D1 est acquis et publié sur `OPUS/master`.

## Preuve runtime R45D1 reçue

Le screenshot owner du 2026-08-09 montre `/fr-FR/security` avec `owasys-back` sélectionné :

```text
Sécurité rendue réellement
lecture seule
ACL = OPUS_ACL_POLICY_V1
SSO = OPUS_SSO_CONFIGURATION_V1
default = deny
default provider = auth0-proxy
identités = aucune donnée
providers = auth0-proxy + service-hmac
```

L'absence d'identités est cohérente avec l'absence de configuration d'utilisateurs initiaux pour cette application système. Cette preuve confirme le remplacement du pending/501 sur cette vue. Elle ne prouve pas encore les cinq vues, le changement de langue ni toute la corrélation Profiler.

## Workflow acquis

```text
Applications
-> Sources de données
-> Structure
-> Sécurité
-> Workflows
-> Sources et Git
-> Construction et validation
```

Aucun patch `RestClient` n'est retenu. R45C4 reste retiré.

## Livrable actif — R45D2

```text
ZIP     : opus_p117w_r45d2_controlled_security_mutations.zip
SHA-256 : 3f40e620dae36cd57eb671f2efc8071fbe288831558d6201d40e80a4394558ba
BASE    : af8ac2f5ed2c9d2d528b5f94863d018d3c7aa121
FILES   : 38
```

R45D2 ajoute les premières mutations réelles de sécurité cible sous pipeline contrôlée :

```text
identity.reference
role.create
permission.grant
assignment.grant
resource.allow
```

Flux :

```text
SCORE
-> SSO/ACL/CSRF front
-> REST sécurisé preview
-> owasys-back
-> Composer allow-listé
-> plan déterministe
-> SCORE preview
-> confirmation + nouvelle réauthentification
-> REST PATCH
-> owasys-back
-> Composer allow-listé
-> state hash / concurrence
-> File::writeAtomic
-> validation
-> commit|rollback
-> Logger/Profiler
-> SCORE
```

## Protections R45D2

- mutations backend `admin` OWASYS uniquement ;
- ACL `security:manage` front et back ;
- token CSRF lié session/site et usage unique ;
- réauthentification fraîche obligatoire ;
- R45D2 supporte la fresh-auth OWASYS `local-password` uniquement ;
- aucun mot de passe n'est envoyé par REST ;
- `owasys-front` et `owasys-back` toujours protégés/read-only ;
- seule une cible `generated-opus-application` générée par Composer est mutable ;
- preview sans écriture ;
- `current_state_hash` + token de confirmation déterministe ;
- écriture via `File::writeAtomic` ;
- validation et rollback ;
- audit avec acteur, cible, motif, hashes avant/après, résultat, trace_id ;
- aucun secret projeté/loggé/profilé.

Auth0 fresh-auth n'est pas approximé. Si l'admin OWASYS n'est pas `local-password`, les mutations sont indisponibles.

`assignment.grant` exige un véritable store runtime `local-password` cible ; aucun stockage d'attribution inexistant n'est inventé.

Les mutations destructives restent hors R45D2.

```text
NO ROLE MERGE.
NO FSM MERGE.
NO ACL BYPASS.
LE DROIT APPARTIENT À LA RESSOURCE, PAS AU BOUTON.
```

## Validation statique R45D2

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

## Gate owner

1. vérifier HEAD exact `af8ac2f5...` et working tree propre ;
2. extraire le ZIP ;
3. lint/config/autoload ;
4. lancer back puis front ;
5. confirmer `owasys-front`/`owasys-back` read-only ;
6. créer/sélectionner une application générée de test ;
7. preview d'une mutation additive : aucun fichier ne doit changer ;
8. confirmation avec nouvelle réauthentification ;
9. vérifier commit réel + nouveau snapshot ;
10. vérifier rejet d'un hash concurrent obsolète ;
11. vérifier Logger/Profiler sans secret ;
12. owner commit/push OPUS uniquement après succès.

## Profiler `.lock`

Audit OPUS générique séparé ; aucune suppression aveugle. Ne bloque pas R45D2.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO AUTO-START CROSS-APPLICATION.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO SECRET OVER REST.
NO PUSH OPUS BY ASSISTANT.
