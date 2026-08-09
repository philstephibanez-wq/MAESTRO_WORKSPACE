# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-09

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D1_SECURITY_SNAPSHOT_WORKSPACE_2026-08-09.md`
7. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D1_SECURITY_SNAPSHOT_2026-08-09.md`
8. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base canonique OPUS

```text
730f19032a5b69c66c14d4d4401813e0638353d1
opus_p117w_r45c3r1_github_recovery_structured_workflow
```

R45C3R1 est acquis et publié sur `OPUS/master`.

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

Le screenshot owner confirme l'ordre de navigation. Les logs runtime après suppression de deux processus PHP résiduels confirment le fonctionnement front/back et la sélection vers `/fr-FR/data`.

Aucun patch `RestClient` n'est retenu. R45C4 reste retiré.

## Livrable actif — R45D1

R45D1 implémente le module `Sécurité` actuellement pending/501 comme workspace de sécurité cible en lecture seule.

```text
ZIP     : opus_p117w_r45d1_security_snapshot_workspace.zip
SHA-256 : 3eb28c2e13b4c3b7f511564c524eaea47d4dad9c6b61041375cab5cf2c68eb27
BASE    : 730f19032a5b69c66c14d4d4401813e0638353d1
FILES   : 38
```

Flux :

```text
SCORE
-> FSM + ACL front
-> REST sécurisé
-> owasys-back
-> FSM REST
-> Composer allow-listé
-> File + StructuredFileLoader
-> résultat structuré
-> SCORE
```

Ressource :

```text
GET /api/v1/applications/{site_id}/security
operation = security.snapshot
```

Commande :

```text
owasys:security-snapshot
-> owasys:security:snapshot
```

## Vues R45D1

```text
Identités
Rôles
Permissions
Attributions
Ressources et ACL
```

Le changement de vue est piloté par GET et ne dépend pas de JavaScript.

## Séparation absolue

R45D1 affiche la sécurité de l'application cible sélectionnée et ne fusionne jamais son référentiel avec celui d'OWASYS.

```text
NO ROLE MERGE.
NO FSM MERGE.
NO ACL BYPASS.
```

`admin`, `developer`, `viewer` restent les rôles OWASYS. Les rôles du site sont propres au site.

Principe :

```text
LE DROIT APPARTIENT À LA RESSOURCE, PAS AU BOUTON.
```

## Sécurité des données

R45D1 est en lecture seule et ne projette aucun secret : aucun mot de passe, hash, token, HMAC ou secret proxy.

Contrats reconnus :

```text
OPUS_ACL_POLICY_V1
OPUS_GENERATED_APPLICATION_ACL_V1
OPUS_SSO_CONFIGURATION_V1
OPUS_GENERATED_APPLICATION_SSO_V1
OPUS_SECURITY_ONBOARDING_V1 optionnel
```

Aucun mapping rôle/permission inexistant n'est inventé.

## Validation hors runtime owner

```text
PHP lint : OK
JSON : OK
REST front/back : cohérent
Operation -> Composer -> provider : cohérent
I18n : 25 langues de base UE + ukrainien
Backend JS/Node : absent du livrable
Opus/**/*.php modifié : 0
```

## Gates owner

1. vérifier HEAD `730f1903...` et working tree ;
2. extraire le ZIP directement ;
3. lint PHP ;
4. parser les configurations via `StructuredFileLoader` ;
5. `composer dump-autoload -o` ;
6. lancer `owasys-back` puis `owasys-front` ;
7. sélectionner une application ;
8. ouvrir `Sécurité` ;
9. absence de pending/HTTP 501 ;
10. vérifier les cinq vues ;
11. vérifier maintien de la vue lors du changement de langue ;
12. vérifier Profiler distribué front -> REST -> back -> Composer -> réponse ;
13. owner commit/push OPUS uniquement après succès.

## Profiler `.lock`

Audit générique séparé, sans suppression aveugle. Il ne bloque pas R45D1.

## Suite

Après acquisition R45D1 : R45D2 mutations de sécurité cible avec preview déterministe, confirmation explicite, écritures atomiques, validation, rollback et audit.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO AUTO-START CROSS-APPLICATION.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
