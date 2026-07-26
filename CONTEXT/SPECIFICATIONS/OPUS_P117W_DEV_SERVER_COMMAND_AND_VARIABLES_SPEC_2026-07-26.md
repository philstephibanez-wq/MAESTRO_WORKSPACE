# OPUS P117W — DEVELOPMENT SERVER COMMAND AND ARGUMENTS

Date : 2026-07-26  
Statut : décision owner corrigée et validée ; implémentation P117W non encore livrée

## 1. Commande canonique

Le serveur PHP local OPUS sera lancé par :

```text
composer opus:dev-server -- <application-id> --host=<adresse> --port=<port>
```

Les trois valeurs sont fournies à l’exécution :

```text
<application-id>
--host=<adresse>
--port=<port>
```

Aucune de ces valeurs ne doit être codée en dur dans OPUS ou OWASYS.

## 2. État actuel

Au HEAD OPUS `4fb3a92605f14d84b8060ff36fde78828da49273`, `opus:dev-server` n’existe pas encore dans `composer.json`.

Toute tentative avant installation du différentiel P117W produit donc légitimement :

```text
Command "opus:dev-server" is not defined.
```

La commande ne doit pas être présentée comme disponible avant livraison et installation du ZIP différentiel P117W.

## 3. Identifiant d’application obligatoire

Le premier argument positionnel est l’identifiant de l’application OPUS autonome à lancer :

```text
<application-id>
```

Exemples OWASYS :

```text
owasys-front
owasys-back
```

La commande résout exclusivement :

```text
sites/<application-id>/
```

L’identifiant doit respecter le contrat OPUS des identifiants de site/application. Aucun identifiant OWASYS n’est implicite ou codé en dur dans le framework.

## 4. Adresse et port obligatoires

L’adresse et le port sont des arguments CLI obligatoires et variables :

```text
--host=<adresse locale>
--port=<port local>
```

Ils ne sont :

- ni codés en dur ;
- ni déduits de l’application ;
- ni imposés par OPUS ;
- ni lus depuis `OPUS_DEV_SERVER_HOST` ou `OPUS_DEV_SERVER_PORT` ;
- ni utilisés comme configuration de production.

Les variables d’environnement `OPUS_DEV_SERVER_HOST` et `OPUS_DEV_SERVER_PORT` sont abandonnées.

## 5. Développement uniquement

`opus:dev-server` est strictement réservé au développement local.

La commande doit refuser explicitement :

- une utilisation depuis un profil ou artefact de production ;
- une adresse interdite par la politique locale de développement ;
- un port absent, non numérique ou hors plage valide ;
- un identifiant d’application absent ou invalide ;
- toute utilisation comme service système, reverse proxy ou listener de production.

Le caractère développement est porté par le contrat de la commande `dev-server` et par le gate de déploiement OPUS. Il ne transforme pas l’adresse, le port ou l’application en valeurs fixes.

## 6. Commandes OWASYS de développement

### Frontend

```cmd
cd /d H:\OPUS
composer opus:dev-server -- owasys-front --host=127.0.0.1 --port=8080
```

### Backend

```cmd
cd /d H:\OPUS
composer opus:dev-server -- owasys-back --host=127.0.0.1 --port=8000
```

Dans ces exemples :

- `owasys-front` et `owasys-back` sont les identifiants d’application passés en argument ;
- `127.0.0.1` est une valeur choisie pour la session de développement ;
- `8080` et `8000` sont des ports choisis pour la session de développement.

Ces valeurs ne constituent aucune constante OPUS ni configuration de production.

## 7. Production

En production :

- `opus:dev-server` est interdit et bloqué ;
- aucune option `--host` ou `--port` de cette commande n’est utilisée ;
- les listeners, endpoints, ports internes, certificats et reverse proxies sont fournis par l’infrastructure de déploiement ;
- `owasys-front` et `owasys-back` peuvent être installés sur deux bastions distincts ;
- le navigateur ne joint jamais directement `owasys-back`.

## 8. Évolution générique OPUS

Cette capacité appartient au framework OPUS. Elle ne doit pas être implémentée comme un contournement local OWASYS.

P117W doit :

1. ajouter le script Composer `opus:dev-server` ;
2. ajouter la commande interne `dev-server` ;
3. exiger `<application-id>`, `--host` et `--port` ;
4. supprimer toute obligation de `--mode=front|back` ;
5. lancer le `www/index.php` canonique de l’application ciblée ;
6. journaliser et profiler le démarrage sans exposer de secret ;
7. refuser explicitement l’usage production ;
8. déprécier `opus:serve-site` sans le présenter comme commande canonique.

Toute nouvelle classe concrète framework ajoutée pour ce contrat doit implémenter son interface homonyme, laquelle étend directement les quatre marqueurs standards OPUS.
