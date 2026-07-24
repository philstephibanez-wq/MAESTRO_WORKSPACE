# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-24

## Contrat global actif

Lire en premier :

```text
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/SPECIFICATIONS/OPUS_OWASYS_GOVERNANCE_EXECUTION_SPEC_2026-07-24.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_OWASYS_GOVERNANCE_EXECUTION_2026-07-24.md
```

Ces contrats sont obligatoires pour toute correction, évolution, livraison et reprise MAESTRO / OPUS / OWASYS.

## Périmètre GitHub relu

Dépôts accessibles inspectés sur leur branche courante :

```text
philstephibanez-wq/MAESTRO_WORKSPACE
philstephibanez-wq/OPUS
philstephibanez-wq/Maestro
philstephibanez-wq/Maestro_KB_Engine
philstephibanez-wq/Maestro_KB_Extranet
```

La relecture a couvert les heads distants, contrats, handoffs, historique récent et fichiers nécessaires au contrôle des règles. Elle ne remplace pas le gate exhaustif exécuté sur le clone local owner ni les validations runtime.

## Jalon actif

P117U avec HF1, HF2, HF3, HF4, HF6 et HF7 en attente d’application owner.

```text
OPUS = framework générique
OWASYS = application construite avec OPUS
pages OWASYS = frontend SCORE
REST sécurisé + Composer = backend OWASYS
sites créés = applications OPUS indépendantes
```

## Sources de vérité

- workspace : `philstephibanez-wq/MAESTRO_WORKSPACE`, branche `master` ;
- OPUS : `philstephibanez-wq/OPUS`, branche `master` ;
- OPUS head relu : `79f261854ee06a9f828fec389adca77d57323d00` ;
- état OPUS distant : HF6 committé, HF7 non appliqué.

OWASYS appartient à `sites/owasys/` dans OPUS. Aucun dépôt OWASYS autonome n’est la source de vérité.

## Écart distant confirmé

Le `composer.json` distant contient encore :

```text
owasys:registry-creation-start
```

Cet alias obsolète doit être retiré par HF7, sans hotfix partiel séparé.

## Ordre d’application

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7
```

HF5 est remplacé par HF6.

## Différentiel HF7 retrouvé et vérifié

- ZIP : `opus_owasys_p117u_hf7_application_creation_profiles.zip` ;
- SHA-256 : `16e06b55f3cf2ffcc5118fe0e5c4f17cbc7b51fa437fd06f17bf3dc16ab48141` ;
- fichiers : 45 ;
- ZIP : 54 906 octets ;
- payload : 176 634 octets ;
- racines : `composer.json`, `Opus/`, `sites/`.

L’artefact exact a été retrouvé. Son empreinte et son intégrité ZIP ont été recalculées. Aucun fichier n’a été reconstruit depuis la prose.

## Workflow canonique HF7

```text
Registry
-> Creation
-> frontend | backend | fullstack
-> REST site.create
-> Composer opus:create-site
-> scaffold générique OPUS
-> Registry synchronize/select
-> Build
```

Failure reste dans Creation. Cancellation retourne dans Registry.

## Contrat des classes concrètes

Chaque classe concrète nommée sous `Opus/**/*.php` implémente directement son interface homonyme. Cette interface étend directement :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

La comparaison GitHub depuis P117M jusqu’au head relu confirme les couples classe/interface dans le périmètre nouveau ou modifié. Le gate tokenizer exhaustif doit encore être exécuté sur l’arbre local complet après HF7.

## Architecture obligatoire

- applications Singleton ;
- FSM, I18n, ACL deny-by-default, SSO/Auth0 et bastion ;
- backend-first et SCORE uniquement ;
- aucun `echo` UI, aucun mélange HTML/PHP ;
- locale par défaut depuis `Accept-Language` ;
- configuration via `File`, puis `Json`, `Xml` ou `Yaml` ;
- besoin générique proposé comme évolution OPUS avant une solution locale ;
- toute mutation OWASYS traverse REST sécurisé puis Composer ;
- Logger et Profiler obligatoires ;
- aucun secret dans Git, argv, logs, profiler ou ZIP.

## Diagnostics contractuels

```text
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/logs/owasys-frontend.log
sites/owasys/var/profiler/<trace_id>.json
```

## Surface de lancement vérifiée

Le lanceur générique OPUS accepte un site, un host et un port. OWASYS utilise la même application sur deux processus :

```text
backend  : composer opus:serve-site -- owasys --host=127.0.0.1 --port=8792
frontend : composer opus:serve-site -- owasys --host=127.0.0.1 --port=8000
```

Le client OWASYS cible `http://127.0.0.1:8792/api/v1/executions`. Les deux terminaux doivent recevoir `OPUS_OWASYS_BACKEND_TOKEN` et `OPUS_OWASYS_BACKEND_HMAC` depuis l’environnement sécurisé.

## Nettoyage

Ne supprimer que les caches et temporaires identifiés. Préserver :

```text
sites/owasys/var/logs
sites/owasys/var/profiler
sites/owasys/var/registry
sites/owasys_old
```

Le sort de `sites/owasys_old` reste une décision owner séparée.

## Gates owner en attente

1. vérifier le clone `H:\OPUS` propre et basé sur le head HF6 attendu ;
2. appliquer HF7 ;
3. régénérer l’autoload optimisé ;
4. exécuter l’audit tokenizer P117M et le lint complet ;
5. valider OWASYS et ses routes ;
6. lancer backend puis frontend ;
7. vérifier `/api/v1/status` puis `/fr-FR/applications` ;
8. tester Creation et les profils frontend/backend/fullstack ;
9. vérifier Registry, Build et corrélation Logger/Profiler ;
10. tester mot de passe, sans JavaScript, Auth0, HTTPS, bastion et Windows/Linux ;
11. décider séparément de `sites/owasys_old` ;
12. committer et pousser OPUS après acceptation owner.

## Politique GitHub

La gouvernance est écrite directement dans `MAESTRO_WORKSPACE`. Aucun code OPUS ou OWASYS n’est poussé directement par l’assistant ; le code reste livré par ZIP différentiel.

## Règles permanentes

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO BRICOLAGE DELIVERY.  
NO FALLBACK SILENCIEUX.  
OPUS IS A FRAMEWORK, NOT AN APPLICATION.  
OWASYS IS AN APPLICATION BUILT WITH OPUS.  
ALL OWASYS BUSINESS WRITES CROSS SECURED REST THEN COMPOSER.  
EVERY CONCRETE OPUS CLASS IMPLEMENTS ITS HOMONYMOUS FOUR-MARKER INTERFACE.  
LOGGER AND PROFILER ARE MANDATORY.  
SCORE AND BACKEND-FIRST ARE MANDATORY.
