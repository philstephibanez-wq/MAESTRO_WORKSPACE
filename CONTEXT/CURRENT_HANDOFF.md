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

## Erreur owner après R10

```text
OPUS_APPLICATION_ENVIRONMENT_SOURCE_MISSING:OPUS_OWASYS_BACKEND_TOKEN
```

## Traiter

Ne pas produire un nouveau ZIP pour cette erreur.

Générer une seule paire de secrets bearer/HMAC dans un terminal parent.

Lancer les deux processus depuis ce même terminal pour faire hériter exactement les mêmes valeurs à `owasys-back` et `owasys-front`.

Ne pas écrire de secret dans `config`, `var`, Git, le ZIP ou argv.

## Statut

```text
P117W R6 : appliqué
P117W R7 : appliqué
P117W R8 : appliqué
P117W R9 : appliqué puis remplacé
P117W R10 : appliqué
Activation runtime : définir les secrets puis lancer les deux processus
Nouveau ZIP : non requis tant qu’aucun défaut source distinct n’est démontré
```

## Lancer en développement

```text
owasys-back : 127.0.0.1:8000
owasys-front : 127.0.0.1:8080
```

Conserver l’identifiant d’application, l’adresse et le port comme arguments variables.

## Tester

```text
http://127.0.0.1:8000/api/v1/status
http://127.0.0.1:8080/fr-FR/
http://127.0.0.1:8080/fr-FR/applications
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO SECRET IN CONFIG.  
NO DELIVERY ROOT POLLUTION.
