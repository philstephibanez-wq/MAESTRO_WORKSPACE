# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-09.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 730f19032a5b69c66c14d4d4401813e0638353d1
Commit : opus_p117w_r45c3r1_github_recovery_structured_workflow
Dernier état acquis publié : R45C3R1
```

R45C3R1 est désormais la base canonique GitHub pour les évolutions suivantes.

## R45C3R1 — acquis

Workflow OWASYS courant :

```text
Applications
-> Sources de données
-> Structure
-> Sécurité
-> Workflows
-> Sources et Git
-> Construction et validation
```

Sélection d'une application : entrée dans `Sources de données`.

Le commit GitHub canonique R45C3R1 est :

```text
730f19032a5b69c66c14d4d4401813e0638353d1
```

## Incident runtime HTTP 500 — clos sans patch RestClient

L'incident précédent provenait de deux processus PHP résiduels en mémoire. Après arrêt forcé des deux processus et suppression du site de test, OWASYS est reparti normalement.

Les logs owner ont confirmé :

```text
owasys-back 127.0.0.1:8080 actif
GET /api/v1/applications -> succès
owasys:registry-sync -> succès
PUT /api/v1/session/application/... -> succès
owasys:registry-select -> succès
owasys-front 127.0.0.1:8000 actif
/fr-FR/applications -> succès
/fr-FR/data -> succès
```

Aucun changement `RestClient` n'est retenu. R45C4 reste retiré / invalidé.

## Profiler `.lock`

Le cycle de vie des fichiers `.lock` reste un audit OPUS générique séparé :

- un lock actif peut être transitoire ;
- aucun `.lock` ne doit être exposé comme trace profiler ;
- un lock orphelin persistant doit être traité à la source ;
- aucune suppression aveugle n'est autorisée.

Ce sujet ne bloque pas R45D.

## Livrable actif — R45D1 Security Snapshot Workspace

R45D1 remplace le module `Sécurité` OWASYS encore pending/501 par un workspace de sécurité réel en lecture seule pour l'application courante.

```text
ZIP     : opus_p117w_r45d1_security_snapshot_workspace.zip
SHA-256 : 3eb28c2e13b4c3b7f511564c524eaea47d4dad9c6b61041375cab5cf2c68eb27
BASE    : 730f19032a5b69c66c14d4d4401813e0638353d1
FILES   : 38
```

Flux obligatoire :

```text
SCORE
-> FSM + ACL OWASYS front
-> REST sécurisé GET /api/v1/applications/{site_id}/security
-> owasys-back
-> FSM REST backend
-> Composer allow-listé owasys:security-snapshot
-> File + StructuredFileLoader
-> réponse structurée
-> SCORE
```

Vues R45D1 :

```text
Identités
Rôles
Permissions
Attributions
Ressources et ACL
```

R45D1 est strictement en lecture seule. Il ne modifie aucune sécurité cible.

## Séparation de sécurité

OWASYS et l'application cible conservent des référentiels distincts.

```text
NO ROLE MERGE.
NO FSM MERGE.
NO ACL BYPASS.
```

Principe :

```text
LE DROIT APPARTIENT À LA RESSOURCE, PAS AU BOUTON.
```

Les utilisateurs/rôles OWASYS (`admin`, `developer`, `viewer`) ne deviennent jamais les rôles du site généré. Les rôles du site cible restent propres au site.

## Contrats R45D1 lus

```text
ACL : OPUS_ACL_POLICY_V1
ACL : OPUS_GENERATED_APPLICATION_ACL_V1
SSO : OPUS_SSO_CONFIGURATION_V1
SSO : OPUS_GENERATED_APPLICATION_SSO_V1
ONBOARDING optionnel : OPUS_SECURITY_ONBOARDING_V1
```

Aucun secret, mot de passe, hash, token ou clé HMAC n'est projeté vers le frontend.

## Validation R45D1 déjà effectuée hors runtime owner

- PHP lint des 5 PHP modifiés/créés : OK ;
- parsing des 32 JSON du livrable : OK ;
- catalogs REST front/back cohérents ;
- operation -> Composer script -> alias/provider cohérent ;
- 25 catalogues I18n module de base présents, langues UE + ukrainien ;
- aucun JavaScript/TypeScript/Node/package/lockfile JS dans `owasys-back` du livrable ;
- aucune classe `Opus/**/*.php` modifiée.

## Gate owner R45D1

1. HEAD OPUS exact `730f1903...` avant extraction ;
2. extraction directe du ZIP ;
3. PHP lint ;
4. parsing config via `StructuredFileLoader` ;
5. Composer autoload optimisé ;
6. lancer `owasys-back`, puis `owasys-front` ;
7. sélectionner une application ;
8. ouvrir `Sécurité` ;
9. absence de HTTP 501 / écran pending ;
10. cinq vues fonctionnelles ;
11. changement de langue conservant la vue ;
12. corrélation Profiler front -> REST -> back -> Composer -> réponse ;
13. owner commit/push seulement après succès.

## Suite gouvernée

R45D2 : mutations de sécurité cible avec preview déterministe, confirmation explicite, écriture atomique, validation avant commit, rollback et audit.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
