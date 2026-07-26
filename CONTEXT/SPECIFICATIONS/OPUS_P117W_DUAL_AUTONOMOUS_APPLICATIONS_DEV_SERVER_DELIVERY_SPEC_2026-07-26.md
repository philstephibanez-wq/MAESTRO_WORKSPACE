# OPUS P117W — LIVRAISON DES DEUX APPLICATIONS AUTONOMES ET DU SERVEUR DE DÉVELOPPEMENT

Date : 2026-07-26  
État : ZIP initial rejeté ; correctif P117W R1 requis

## Source de vérité

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
Base : 4fb3a92605f14d84b8060ff36fde78828da49273
Racine owner : H:\OPUS
```

## Architecture

Conserver exactement :

```text
sites/owasys-front
sites/owasys-back
```

Ne créer aucun `sites/owasys-shared`.

Faire de `owasys-front` une application OPUS complète avec Singleton, FSM, I18n navigateur, ACL deny-by-default, SSO/Auth0-proxy/bastion, SCORE, Logger, Profiler et client REST sécurisé.

Faire de `owasys-back` une application OPUS complète avec Singleton, FSM métier et REST, I18n API, ACL deny-by-default, SSO/identité de service/bastion, Logger, Profiler, API REST sécurisée et Composer allow-listé.

Interdire toute mutation métier et toute exécution Composer côté front. Interdire tout rendu UI côté back.

## Absence de partage

Ne partager aucun fichier, dossier, volume, configuration, secret, état runtime, catalogue ou artefact entre les deux applications.

Réaliser exclusivement des échanges REST sécurisés.

Définir les contrats génériques de transport dans le framework OPUS RCP. Conserver dans chaque application ses propres configurations et validateurs locaux.

## Commande générique de développement

Ajouter au framework OPUS :

```text
composer opus:dev-server -- <application-id> --host=<adresse> --port=<port>
```

Exiger les trois arguments variables. Ne coder aucune adresse ni aucun port fixe.

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

## Corrélation distribuée

Propager le même `trace_id` du frontend vers le backend, puis vers la FSM REST et Composer.

Conserver les diagnostics indépendants :

```text
sites/owasys-front/var/logs/owasys-front.log
sites/owasys-front/var/profiler
sites/owasys-back/var/logs/owasys-back.log
sites/owasys-back/var/profiler
```

## Contrat des classes framework

Faire implémenter son interface homonyme par toute classe concrète ajoutée ou modifiée sous `Opus/**/*.php`.

Faire étendre directement chaque interface homonyme par :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

## Configuration

Lire toute configuration via `File` et `StructuredFileLoader`, puis utiliser `Json`, `Xml` ou `Yaml` selon le format.

Ne coder aucun endpoint backend dans la configuration frontend de production.

## ZIP initial rejeté

Rejeter :

```text
ZIP : opus_p117w_owasys_dual_autonomous_applications_dev_server.zip
SHA-256 : 513cda881f43522e1a852d0420e0afd38047c75c28d7b2b9d3c5a8c74f0c53f4
Base : 4fb3a92605f14d84b8060ff36fde78828da49273
```

Motifs :

- créer `sites/owasys-shared` ;
- placer la migration et le smoke dans cette troisième racine ;
- conserver une notion de partage interdite ;
- référencer `tools/maintenance/opus_contractualize_all.php`, absent du dépôt.

## Correctif P117W R1

Produire un ZIP différentiel direct qui doit :

1. conserver uniquement `owasys-front` et `owasys-back` ;
2. supprimer toute dépendance à `owasys-shared` ;
3. déplacer chaque composant selon sa responsabilité front ou back ;
4. déplacer les contrats génériques non métier vers OPUS RCP après validation framework ;
5. fournir une validation autonome dans chaque application ;
6. fournir un CMD de migration sans troisième racine ;
7. fournir un CMD de nettoyage de `sites/owasys-shared` après validation ;
8. valider REST sécurisé vers Composer ;
9. valider Logger, Profiler et propagation du `trace_id` ;
10. rester directement superposable à `H:\OPUS`.

## Nettoyage

Ne pas supprimer immédiatement `sites/owasys-shared` avant appliquer P117W R1, car le ZIP initial y a placé la migration et le smoke.

Supprimer cette racine après déplacer ces fonctions et valider les deux applications.
