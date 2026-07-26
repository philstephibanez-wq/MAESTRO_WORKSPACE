# OPUS P117W R1 — OWASYS SANS SHARED, ÉCHANGES REST UNIQUEMENT

Date : 2026-07-26  
État : décision owner validée ; ZIP P117W initial rejeté ; correctif différentiel requis

## 1. Architecture canonique

Conserver exactement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Supprimer toute troisième racine `owasys-shared` de l'architecture, du développement, du packaging et du déploiement.

## 2. Principe d'absence de partage

Ne partager aucun :

- dossier ;
- fichier ;
- volume ;
- état runtime ;
- secret ;
- configuration ;
- catalogue I18n ;
- manifeste applicatif ;
- outil de migration ;
- snapshot de contrat entre les deux applications.

Ne dépendre d'aucun système de fichiers commun entre les bastions.

Réaliser exclusivement des échanges réseau REST sécurisés entre `owasys-front` et `owasys-back`.

## 3. Frontend

Faire de `owasys-front` une application OPUS complète et autonome :

```text
sites/owasys-front/
  application/default/
  application/<module>/
  config/
  www/
  var/
```

Appliquer :

- Singleton `OwasysFrontApplication` ;
- interface `OwasysFrontApplicationInterface` ;
- FSM frontend ;
- I18n et locale navigateur ;
- ACL deny-by-default ;
- SSO/Auth0-proxy/bastion ;
- SCORE uniquement ;
- Logger et Profiler locaux ;
- client REST sécurisé ;
- aucune mutation métier locale ;
- aucune exécution Composer locale.

## 4. Backend

Faire de `owasys-back` une application OPUS complète et autonome :

```text
sites/owasys-back/
  application/default/
  application/<module>/
  config/
  www/
  var/
```

Appliquer :

- Singleton `OwasysBackApplication` ;
- interface `OwasysBackApplicationInterface` ;
- FSM métier et FSM REST ;
- I18n API ;
- ACL deny-by-default ;
- SSO/identité de service/bastion ;
- API REST sécurisée ;
- Logger et Profiler locaux ;
- Composer allow-listé ;
- aucun rendu UI.

## 5. Contrats d'échange

Définir les contrats génériques de transport dans le framework OPUS RCP.

Conserver dans chaque application uniquement sa configuration locale et ses validateurs locaux. Ne créer aucun package OWASYS commun.

Négocier et vérifier par REST :

```text
api_contract_version
minimum_opus_version
trace_id
request_id
execution_id
```

Refuser explicitement toute version incompatible.

## 6. Bastions distincts

Déployer indépendamment :

```text
Bastion FRONT -> owasys-front
Bastion BACK  -> owasys-back
```

Injecter séparément les secrets, certificats, endpoints et politiques réseau dans chaque bastion.

Ne jamais monter `owasys-front` sur le bastion backend ni `owasys-back` sur le bastion frontend.

## 7. Développement local

Conserver la commande générique :

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

Réserver le registre `runtime/development` au framework OPUS local. Ne pas le considérer comme un partage applicatif et ne jamais l'utiliser en production.

## 8. Statut du ZIP P117W initial

Rejeter :

```text
opus_p117w_owasys_dual_autonomous_applications_dev_server.zip
SHA-256 513cda881f43522e1a852d0420e0afd38047c75c28d7b2b9d3c5a8c74f0c53f4
```

Motifs :

- créer `sites/owasys-shared` ;
- placer migration et smoke dans cette troisième racine ;
- conserver une notion de partage contraire à la décision owner ;
- référencer une commande d'audit inexistante : `tools/maintenance/opus_contractualize_all.php`.

## 9. Correctif différentiel requis

Produire un ZIP différentiel direct qui doit :

1. supprimer toute dépendance à `sites/owasys-shared` ;
2. déplacer les composants nécessaires dans `owasys-front` ou `owasys-back` selon leur responsabilité ;
3. déplacer les contrats génériques non métier vers OPUS RCP après validation framework ;
4. fournir les validations propres à chaque application ;
5. fournir un smoke depuis chaque application ;
6. fournir un CMD de migration sans troisième racine ;
7. fournir un CMD de nettoyage de `sites/owasys-shared` uniquement après validation ;
8. valider REST sécurisé de front vers back ;
9. valider Composer exclusivement côté back ;
10. valider Logger, Profiler et propagation du `trace_id` ;
11. conserver les deux applications installables sur deux bastions distincts ;
12. ne contenir aucun répertoire shared.

## 10. Nettoyage

Ne pas supprimer immédiatement `sites/owasys-shared` tant que le correctif R1 n'a pas déplacé le smoke et la migration et validé les deux applications.

Supprimer cette racine avec un bloc CMD dédié après validation R1.
