# HANDOFF — OPUS P117W R45D1 SECURITY SNAPSHOT

Date : 2026-08-09  
Statut : LIVRABLE OWNER À VALIDER

## Base source de vérité

```text
philstephibanez-wq/OPUS
master
730f19032a5b69c66c14d4d4401813e0638353d1
opus_p117w_r45c3r1_github_recovery_structured_workflow
```

## Livrable

```text
opus_p117w_r45d1_security_snapshot_workspace.zip
SHA-256 3eb28c2e13b4c3b7f511564c524eaea47d4dad9c6b61041375cab5cf2c68eb27
38 fichiers
```

ZIP différentiel direct : fichiers complets uniquement à leurs chemins finaux ; aucun apply, smoke, log, rapport, cache, temporaire ou vendor.

## But

Rendre le module OWASYS `Sécurité` réellement exploitable en lecture seule pour la sécurité de l'application actuellement sélectionnée.

Cinq vues :

```text
Identités
Rôles
Permissions
Attributions
Ressources et ACL
```

## Frontière obligatoire

```text
owasys-front SCORE
-> FSM + ACL OWASYS
-> REST sécurisé
-> owasys-back
-> FSM REST backend
-> Composer allow-listé
-> lecture File + StructuredFileLoader
-> réponse structurée
-> SCORE
```

Aucune lecture directe du site cible par le frontend.

## REST ajouté

```text
GET /api/v1/applications/{site_id}/security
security.snapshot
```

## Composer ajouté

```text
owasys:security-snapshot
owasys:security:snapshot
```

## Contrats cibles supportés

```text
OPUS_ACL_POLICY_V1
OPUS_GENERATED_APPLICATION_ACL_V1
OPUS_SSO_CONFIGURATION_V1
OPUS_GENERATED_APPLICATION_SSO_V1
OPUS_SECURITY_ONBOARDING_V1 optionnel
```

R45D1 ne révèle jamais les secrets des stores locaux.

## Séparation des rôles

Les rôles OWASYS et les rôles du site cible restent distincts.

```text
NO ROLE MERGE.
NO FSM MERGE.
NO ACL BYPASS.
```

Le droit reste attaché à la ressource.

## Validation interne effectuée

- lint PHP OK ;
- JSON OK ;
- REST front/back cohérent ;
- operation / Composer / provider cohérents ;
- I18n 25 langues de base UE + ukrainien ;
- aucun backend JS/Node ;
- aucune classe framework `Opus/**/*.php` modifiée.

## Validation owner requise

```text
HEAD exact 730f1903...
application du ZIP
lint/config/autoload
démarrage back puis front
sélection d'une application
Sécurité sans HTTP 501
5 vues fonctionnelles
changement de langue préservant la vue
Profiler distribué corrélé
```

L'owner committe/pousse OPUS uniquement après succès.

## Après acquisition

R45D2 : mutations de sécurité cible, preview déterministe, confirmation explicite, écritures atomiques, validation, rollback et audit.
