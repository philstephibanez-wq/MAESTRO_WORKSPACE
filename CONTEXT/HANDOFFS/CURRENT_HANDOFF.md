# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-26

## Lecture obligatoire

```text
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_OWASYS_DUAL_AUTONOMOUS_SUBAPPLICATIONS_SEPARATE_BASTIONS_SPEC_2026-07-26.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R1_OWASYS_NO_SHARED_EXCHANGES_ONLY_2026-07-26.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_DELIVERY_2026-07-26.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source de vérité

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE master
```

## Architecture owner

Conserver exactement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Supprimer toute notion de `owasys-shared`.

Permettre l'installation des deux applications sur deux bastions distincts.

## Échanges uniquement

Ne partager aucun fichier, dossier, volume, secret, configuration, état runtime, catalogue, manifeste ou artefact entre les deux applications.

Réaliser uniquement des échanges REST sécurisés :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Définir les contrats génériques de transport dans OPUS RCP. Conserver dans chaque application ses propres configurations et validateurs locaux.

## Front

```text
Singleton : OwasysFrontApplication
Interface : OwasysFrontApplicationInterface
Racine : sites/owasys-front
```

Appliquer FSM, I18n navigateur, ACL deny-by-default, SSO/Auth0-proxy/bastion, SCORE, Logger, Profiler et client REST sécurisé.

Interdire toute mutation métier et toute exécution Composer locale.

## Back

```text
Singleton : OwasysBackApplication
Interface : OwasysBackApplicationInterface
Racine : sites/owasys-back
```

Appliquer FSM métier et REST, I18n API, ACL deny-by-default, SSO/identité de service/bastion, Logger, Profiler, API REST sécurisée et Composer allow-listé.

Interdire tout rendu UI.

## Serveur de développement

Utiliser :

```text
composer opus:dev-server -- <application-id> --host=<adresse> --port=<port>
```

Lancer le backend :

```cmd
cd /d H:\OPUS
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
```

Lancer le frontend :

```cmd
cd /d H:\OPUS
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

Réserver cette commande au développement local.

## Statut des livrables

```text
HF10A : rejeté
HF10B : rejeté
P117W initial : installé, smoke réussi, architecture rejetée
P117W R1 : correctif différentiel requis
```

Rejeter :

```text
opus_p117w_owasys_dual_autonomous_applications_dev_server.zip
SHA-256 513cda881f43522e1a852d0420e0afd38047c75c28d7b2b9d3c5a8c74f0c53f4
```

Motifs : créer `sites/owasys-shared` et référencer `tools/maintenance/opus_contractualize_all.php`, absent du dépôt.

## Correctif P117W R1

Produire un ZIP différentiel direct afin de :

1. supprimer toute dépendance à `owasys-shared` ;
2. conserver uniquement `owasys-front` et `owasys-back` ;
3. déplacer chaque composant selon sa responsabilité ;
4. fournir une validation autonome dans chaque application ;
5. fournir un CMD de migration sans troisième racine ;
6. valider REST sécurisé vers Composer ;
7. valider Logger, Profiler et propagation du `trace_id` ;
8. fournir un CMD de suppression de `sites/owasys-shared` après validation.

## Contrats permanents

- faire implémenter son interface homonyme par toute classe concrète sous `Opus/**/*.php` ;
- faire étendre chaque interface homonyme par les quatre marqueurs standards ;
- lire toute configuration via `File` et `StructuredFileLoader` ;
- utiliser `Json`, `Xml` ou `Yaml` selon le format ;
- interdire tout `echo` UI et tout mélange HTML/PHP ;
- rendre uniquement via SCORE côté front ;
- faire passer toute mutation par REST sécurisé puis Composer ;
- imposer Logger et Profiler dans les deux applications ;
- interdire tout fallback silencieux.

## Nettoyage

Ne pas supprimer immédiatement `sites/owasys-shared` avant appliquer P117W R1, car le ZIP initial y a placé la migration et le smoke.

Supprimer cette racine après déplacer ces fonctions et valider les deux applications.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
