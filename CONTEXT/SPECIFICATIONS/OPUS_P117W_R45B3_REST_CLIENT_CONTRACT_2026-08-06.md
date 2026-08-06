# OPUS P117W — R45B3 REST CLIENT CONTRACT

Date : 2026-08-06  
Statut : livrable owner prêt  
Base OPUS : `7b390b662573b1e71bd8d770bbcad3d3b386325b`

## 1. Acquisition précédente

E3B est acquis sur `OPUS/master` au commit :

```text
7b390b662573b1e71bd8d770bbcad3d3b386325b
opus_p117w_e3b_git_workspace_front
```

Le commit est le fils direct d’E3A `4b1f621051a306443ada7eb5fada2a8e9363b0aa` et contient exactement les 32 fichiers attendus. La validation owner a confirmé depuis OWASYS la création effective d’un commit Git dans le module `Sources et Git`.

## 2. Cause générique traitée

Avant R45B3, `RestClient` acceptait tout chemin commençant par `/api/v1/` sans vérifier qu’il appartenait au contrat REST réellement exposé par OWASYS-back.

Le client et le serveur validaient séparément leurs configurations. Une dérive de méthode, chemin, opération ou statut pouvait donc n’être détectée qu’à l’exécution distante.

Les réponses n’étaient pas contractuellement liées au catalogue attendu par le client :

- absence de fingerprint partagé ;
- absence de validation stricte du contrat d’enveloppe ;
- absence de corrélation obligatoire entre trace envoyée, en-tête de réponse et corps ;
- absence de limite de corps de requête ;
- lecture de réponse non bornée avant contrôle de taille ;
- validation insuffisante du type de contenu et du statut attendu.

R45B3 traite cette cause dans OPUS, sans correctif local de site.

## 3. Catalogue REST générique

R45B3 ajoute :

```text
Opus/Api/Rest/RestResourceCatalog.php
Opus/Api/Rest/RestResourceCatalogInterface.php
```

Contrat :

```text
OPUS_REST_RESOURCE_CATALOG_V1
```

Le catalogue :

- normalise et valide le `base_path` ;
- valide méthodes, templates, wildcards, opérations, statuts et locations ;
- refuse les doublons méthode/chemin et opération ;
- résout une requête et ses paramètres ;
- retourne les méthodes autorisées ;
- refuse toute ressource non déclarée ;
- produit un fingerprint SHA-256 déterministe, indépendant de l’ordre des routes ;
- vérifie le fingerprint du pair ;
- utilise `StructuredFileLoader` pour les fichiers structurés.

`RestResourceCatalogInterface` étend directement les quatre marqueurs OPUS obligatoires.

## 4. Validation croisée frontend/backend

Deux catalogues identiques sont livrés :

```text
sites/owasys-front/config/rest.resources.json
sites/owasys-back/config/backend.resources.json
```

Ils décrivent les 23 ressources REST actuelles Source, Git, Registry, création, validation, langues, pages, rubriques, export et sécurité.

Empreinte fonctionnelle normalisée :

```text
6deb58f201e5e6a8b12cee96ff006a1a4969442af2f1d1dcb05e5374220ace86
```

Le serveur conserve temporairement `resources` dans `backend.rest.json` pour compatibilité avec les smokes et contrats antérieurs, puis compare au boot le fingerprint inline au catalogue externe. Toute divergence bloque le démarrage.

Le déploiement distribué front/back ne dépend d’aucun chemin partagé : les pairs échangent uniquement le fingerprint par l’en-tête :

```text
X-Opus-Rest-Catalog
```

Toute divergence runtime produit :

```text
OPUS_REST_API_CATALOG_MISMATCH
HTTP 409
```

## 5. Durcissement RestClient

`RestClient` :

- charge le catalogue déclaré par `resource_catalog` ;
- refuse une méthode ou ressource non déclarée avant tout transport ;
- vérifie le statut HTTP exact déclaré pour la route ;
- impose `OPUS_REST_API_RESPONSE_V1` en succès ;
- impose `OPUS_REST_API_ERROR_V1` en erreur ;
- impose `application/json` ;
- impose le fingerprint catalogue attendu ;
- impose un `X-Opus-Trace-Id` valide ;
- compare la trace de requête, l’en-tête de réponse et le corps ;
- normalise l’acteur à `subject`, `roles` triés et `provider` ;
- borne le corps de requête par `max_request_bytes` ;
- borne la lecture de réponse avec `stream_get_contents(max + 1)` ;
- désactive les redirections HTTP ;
- contrôle `Content-Length` lorsqu’il est présent ;
- valide la liste des enregistrements Profiler avant import ;
- expurge explicitement `profiler_records` et les corps sensibles des diagnostics.

## 6. Durcissement RestServer

`RestServer` :

- utilise `RestResourceCatalogInterface` pour la résolution ;
- charge le catalogue externe ;
- compare au boot catalogue externe et ressources inline ;
- exige le fingerprint du client pour toute ressource métier ;
- expose son fingerprint dans les réponses succès et erreur ;
- prend le statut de succès et la `Location` dans le catalogue ;
- retourne HTTP 409 sur dérive catalogue ;
- supprime la duplication locale de parsing/résolution de routes.

Le flux reste strictement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer -> réponse
```

## 7. Configuration

Frontend :

```json
{
  "resource_catalog": "rest.resources.json",
  "max_request_bytes": 2097152
}
```

Backend :

```json
{
  "resource_catalog": "sites/owasys-back/config/backend.resources.json"
}
```

Les limites de requête et de réponse restent bornées à 2 MiB pour OWASYS.

## 8. Livrable

```text
ZIP     : opus_p117w_r45b3_rest_client_contract.zip
SHA-256 : 06de2d80caebba9aebe9308eeed2f690a3c382ab582bc549e0e96fe3ce9889f7
FILES   : 8
BASE    : 7b390b662573b1e71bd8d770bbcad3d3b386325b
```

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_r45b3_rest_client_contract_owner.php
SHA-256 : e77aefa501706d1e5e9a2c17ddbbe610bd27f0e495c1d9e7423a9e33251ad838
OUTPUT  : OPUS_P117W_R45B3_REST_CLIENT_CONTRACT_OK
```

## 9. Validation obligatoire

1. vérifier que le HEAD avant application est exactement la base ;
2. extraire le ZIP à la racine OPUS ;
3. lint des quatre fichiers PHP ;
4. parsing des quatre fichiers JSON ;
5. `composer validate` ;
6. `composer dump-autoload -o` ;
7. exécuter le smoke owner ;
8. démarrer OWASYS-front et OWASYS-back ;
9. confirmer Source et Git avec catalogue identique ;
10. provoquer un fingerprint différent et confirmer HTTP 409 sans exécution Composer ;
11. confirmer la corrélation de trace et l’absence de corps sensible dans le Profiler ;
12. commit et push owner après succès.

## 10. Périmètre exclu

R45B3 ne contient :

- aucun fichier de site généré ;
- aucune correction locale de `test` ;
- aucun JavaScript backend ;
- aucune nouvelle opération métier ;
- aucun contournement REST/Composer ;
- aucun secret, log, cache, rapport ou vendor.

## 11. Suite gouvernée

Après acquisition R45B3 :

```text
R45C — wizard OWASYS structuré
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO UNDECLARED REST RESOURCE.  
NO CLIENT/SERVER CATALOG DRIFT.  
NO UNBOUNDED REST BODY.  
NO TRACE MISMATCH.  
NO SENSITIVE BODY IN PROFILER.  
NO BACKEND JAVASCRIPT.  
NO LOCAL SITE FIX.  
NO PUSH OPUS PAR L’ASSISTANT.
