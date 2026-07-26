# OPUS P117W — DEUX APPLICATIONS OPUS AUTONOMES SUR BASTIONS DISTINCTS

Date : 2026-07-26  
État : architecture owner validée ; correctif P117W R1 requis

## Décision owner

Conserver exactement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Permettre leur installation sur deux serveurs ou deux bastions distincts.

Supprimer toute notion de `shared`. Ne créer aucune troisième application, racine, bibliothèque OWASYS commune, volume commun, snapshot commun ou système de fichiers partagé.

## Frontend

Faire de `owasys-front` une application OPUS complète :

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

## Backend

Faire de `owasys-back` une application OPUS complète :

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

## Échanges uniquement

Faire circuler exclusivement par REST sécurisé :

```text
commandes
requêtes
réponses
données métier
versions de contrat
trace_id
request_id
execution_id
identité déléguée
```

Ne partager aucun fichier, dossier, secret, état, catalogue, configuration ou artefact runtime entre les deux applications.

Définir les contrats de transport génériques dans OPUS RCP. Installer indépendamment le framework OPUS sur chaque bastion.

Faire vérifier par chaque application ses propres configurations et validateurs locaux. Refuser toute version d'API incompatible.

## Sécurité réseau

Appliquer le flux suivant :

```text
Navigateur
  -> HTTPS / Auth0 proxy
  -> Bastion FRONT / owasys-front
  -> REST HTTPS sécurisé / mTLS / HMAC
  -> Bastion BACK / owasys-back
  -> FSM backend
  -> Composer allow-listé
```

Interdire tout accès direct du navigateur au backend.

## Diagnostics distribués

Conserver des diagnostics indépendants :

```text
sites/owasys-front/var/logs/owasys-front.log
sites/owasys-front/var/profiler

sites/owasys-back/var/logs/owasys-back.log
sites/owasys-back/var/profiler
```

Propager le même `trace_id` par les échanges REST. Ne journaliser aucun secret.

## Développement local

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

Réserver cette commande au développement local. Confier les listeners et endpoints de production aux infrastructures des bastions.

## Statut P117W

Rejeter le ZIP initial P117W, car il crée `sites/owasys-shared`.

Produire P117W R1 sans aucune racine shared et sans dépendance commune hors échanges REST.

Lire en priorité :

```text
CONTEXT/SPECIFICATIONS/OPUS_P117W_R1_OWASYS_NO_SHARED_EXCHANGES_ONLY_2026-07-26.md
```
