# OPUS P117W — OWASYS DUAL AUTONOMOUS OPUS APPLICATIONS

Date : 2026-07-26  
Statut : architecture owner validée ; HF10B rejeté ; nouveau différentiel requis

## 1. Décision owner

OWASYS est composé de deux sous-applications OPUS autonomes :

```text
owasys-front
owasys-back
```

Elles peuvent être installées :

- sur le même serveur ;
- sur deux serveurs distincts ;
- sur deux bastions distincts ;
- derrière des reverse proxies et politiques réseau différentes.

Elles ne sont plus modélisées comme deux modes d'un Singleton commun.

## 2. Arborescence canonique

```text
sites/owasys/
  shared/
    contracts/
    schemas/
    defaults/
    i18n-source/
    deployment/

  front/
    application/
      default/
      <module>/
    config/
    www/
    var/

  back/
    application/
      default/
      <module>/
    config/
    www/
    var/
```

Chaque sous-application possède donc sa propre racine OPUS canonique :

```text
application/default
application/<module>
config
www
var
```

Le modèle `application/shared + application/front + application/back` avec Singleton partagé est abandonné pour OWASYS.

## 3. Deux Singletons autonomes

### Frontend

```text
OwasysFrontApplication
OwasysFrontApplicationInterface
```

Responsabilités :

- UI SCORE exclusivement ;
- FSM frontend ;
- I18n et détection navigateur ;
- ACL frontend deny-by-default ;
- SSO/Auth0-proxy ;
- navigation et ViewModels ;
- client REST sécurisé ;
- Logger et Profiler frontend ;
- aucune mutation métier locale ;
- aucune exécution Composer locale.

### Backend

```text
OwasysBackApplication
OwasysBackApplicationInterface
```

Responsabilités :

- API REST sécurisée ;
- FSM backend d'authentification, autorisation, validation et exécution ;
- ACL backend deny-by-default ;
- SSO délégué/proxy, identité de service et contrôle bastion ;
- commandes Composer allow-listées ;
- services/providers typés ;
- Logger et Profiler backend ;
- aucune vue ou page UI.

Chaque Singleton a son propre cycle de vie, son propre bootstrap, sa propre configuration, son propre journal et son propre stockage Profiler.

## 4. Contrat OPUS complet des deux côtés

Les deux sous-applications sont 100 % OPUS :

- Singleton autonome ;
- FSM obligatoire ;
- I18n obligatoire ;
- ACL deny-by-default ;
- SSO/Auth0-proxy et bastion ;
- configuration via `File` puis `Json`, `Xml` ou `Yaml` ;
- Logger obligatoire ;
- Profiler obligatoire ;
- aucun fallback silencieux ;
- erreurs typées et traçables ;
- locale initiale issue du navigateur côté front ;
- négociation de locale explicite côté API ;
- documentation et auto-description contractuelles.

## 5. Shared n'est pas une troisième application

`sites/owasys/shared` ne contient :

- aucun Singleton ;
- aucun bootstrap ;
- aucun serveur ;
- aucun état runtime ;
- aucun secret ;
- aucun fichier `var` ;
- aucune dépendance à un système de fichiers partagé entre bastions.

Il contient uniquement des sources communes versionnées :

- contrats DTO ;
- schémas REST ;
- identifiants d'opérations ;
- clés I18n et catalogues sources communs ;
- valeurs de configuration non secrètes ;
- manifestes de compatibilité ;
- versions minimales OPUS ;
- profils de déploiement.

## 6. Déploiement sur bastions distincts

Le frontend et le backend ne doivent jamais lire un même fichier local à travers les bastions.

Chaque artefact de déploiement embarque une copie résolue et immuable des éléments partagés nécessaires :

```text
owasys-front artifact
  + front
  + shared contracts snapshot
  + shared config snapshot

owasys-back artifact
  + back
  + shared contracts snapshot
  + shared config snapshot
```

Les deux manifests déclarent :

```text
shared_contract_version
shared_contract_sha256
api_contract_version
minimum_opus_version
```

Le démarrage échoue explicitement si les versions ou empreintes attendues sont incompatibles.

## 7. Paramètres et secrets communs

Les paramètres non secrets communs proviennent d'un contrat versionné, puis sont copiés/résolus localement dans chaque sous-application.

Les secrets ne sont jamais placés dans `shared` ni dans Git. Ils sont injectés séparément dans chaque bastion par le mécanisme de déploiement :

- secret manager ;
- variables d'environnement ;
- fichier secret local hors Git ;
- identité machine ;
- certificat mTLS ;
- proxy Auth0/bastion.

Le frontend possède les credentials client nécessaires à REST. Le backend possède les credentials serveur et politiques de vérification correspondantes. La corrélation est un contrat de déploiement, pas un fichier partagé à l'exécution.

## 8. Réseau et sécurité

Architecture de production :

```text
Utilisateur
  -> HTTPS / Auth0 proxy
  -> Bastion FRONT
       -> OWASYS Front Singleton
       -> REST HTTPS/mTLS/HMAC
  -> Bastion BACK
       -> OWASYS Back Singleton
       -> Composer allow-listé
       -> services/providers
```

Règles :

- le backend n'est pas directement accessible au navigateur ;
- le frontend ne peut appeler que les opérations REST déclarées ;
- le backend authentifie le service frontend et l'identité déléguée ;
- chaque bastion a ses propres ACL système/réseau ;
- les `trace_id` sont propagés entre front et back ;
- les journaux restent séparés mais corrélables.

## 9. Journaux et Profiler

Frontend :

```text
sites/owasys/front/var/logs/owasys-front.log
sites/owasys/front/var/profiler/<trace_id>.json
```

Backend :

```text
sites/owasys/back/var/logs/owasys-back.log
sites/owasys/back/var/profiler/<trace_id>.json
```

Une requête distribuée conserve :

```text
trace_id
request_id
actor_subject
front_event_id
back_execution_id
```

Aucun secret n'apparaît dans ces données.

## 10. Cause du rejet HF10B

Le trace owner `5f52a28017dc564d` établit :

```text
exception_class : RuntimeException
exception_file  : Opus/Fsm/FsmSiteLoader.php
exception_line  : 193
```

Le chargeur FSM actuel impose encore :

```text
default_root = application/default
```

HF10B tentait de faire d'OWASYS un même site à racines stratifiées. Le nouveau modèle donne à `front` et `back` leur propre `application/default`, et respecte donc le contrat OPUS canonique sans détourner la notion de site.

## 11. Livrable suivant

Le prochain ZIP différentiel direct doit :

1. remplacer le Singleton partagé par deux Singletons autonomes ;
2. créer `sites/owasys/front` et `sites/owasys/back` ;
3. fournir deux `config/site.json` indépendants ;
4. fournir deux FSM, deux ACL, deux SSO, deux Logger et deux Profiler ;
5. convertir `shared` en sources/contrats sans runtime ;
6. fournir deux commandes Composer de lancement visant deux sites distincts ;
7. fournir deux artefacts de déploiement séparables ;
8. tester une installation sur deux racines/bastions simulés ;
9. tester REST sécurisé et propagation du `trace_id` ;
10. rester un ZIP différentiel direct superposable à `H:\OPUS`.

Aucun nettoyage des chemins HF10B n'est autorisé avant validation de ce nouveau différentiel.
