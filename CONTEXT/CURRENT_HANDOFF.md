# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-27

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R10_SINGLE_ENVIRONMENT_CONFIG_SECTIONS_2026-07-27.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R10_DEV_SECRET_ACTIVATION_2026-07-27.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R10_DEV_SECRET_ACTIVATION_2026-07-27.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
État local : P117W initial et R3 à R10 appliqués
```

## Architecture

Conserver uniquement :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne partager aucun fichier entre les deux applications. Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun secret et aucune racine partagée.

## Configuration active

Conserver toute la configuration d’environnement dans le `config/site.json` de chaque application :

```text
environments.dev
environments.test
environments.prod
```

Sélectionner `dev` automatiquement avec `opus:dev-server`.

Conserver l’adresse et le port d’écoute comme arguments variables.

Référencer les secrets par variables d’environnement. Refuser tout secret littéral et toute variable secrète absente.

## Affectation canonique des serveurs de développement

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
```

Utiliser `composer opus:dev-server` pour les deux applications.

Ne pas utiliser `composer dev-server` tant qu’aucun alias Composer homonyme n’est contractuellement déclaré.

La réponse backend observée sur `http://127.0.0.1:8000/fr-FR/applications` démontre une inversion des applications lancées sur les ports, pas une route frontend invalide.

## Lancer en développement

Frontend, dans un terminal VS Code :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8000
```

Backend, dans un second terminal VS Code :

```text
cd /d H:\OPUS
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8080
```

Définir préalablement dans les deux processus les mêmes valeurs pour :

```text
OPUS_OWASYS_BACKEND_TOKEN
OPUS_OWASYS_BACKEND_HMAC
```

Conserver l’identifiant d’application, l’adresse et le port comme arguments variables.

## Tester

```text
http://127.0.0.1:8000/fr-FR/
http://127.0.0.1:8000/fr-FR/applications
http://127.0.0.1:8080/api/v1/status
```

## Statut

```text
P117W R6 : appliqué
P117W R7 : appliqué
P117W R8 : appliqué
P117W R9 : appliqué puis remplacé
P117W R10 : appliqué
Correction active : affecter le frontend au port 8000 et le backend au port 8080
Nouveau ZIP : non requis pour une inversion de commandes de lancement
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO SECRET IN CONFIG.  
NO DELIVERY ROOT POLLUTION.
