# HANDOFF — OPUS P117W R45B3 REST CLIENT CONTRACT

Date : 2026-08-06  
Statut : livré, validation et acquisition owner requises

## Base exacte

```text
OPUS master : 7b390b662573b1e71bd8d770bbcad3d3b386325b
Commit       : opus_p117w_e3b_git_workspace_front
Parent       : 4b1f621051a306443ada7eb5fada2a8e9363b0aa
```

E3B est acquis avec exactement 32 fichiers. La capture owner confirme la création effective d’un commit Git depuis OWASYS `Sources et Git`.

## Livrable actif

```text
ZIP     : opus_p117w_r45b3_rest_client_contract.zip
SHA-256 : 06de2d80caebba9aebe9308eeed2f690a3c382ab582bc549e0e96fe3ce9889f7
FILES   : 8
BASE    : 7b390b662573b1e71bd8d770bbcad3d3b386325b
STATUS  : application, validation, commit et push owner requis
```

Smoke owner :

```text
FILE    : smoke_opus_p117w_r45b3_rest_client_contract_owner.php
SHA-256 : e77aefa501706d1e5e9a2c17ddbbe610bd27f0e495c1d9e7423a9e33251ad838
OUTPUT  : OPUS_P117W_R45B3_REST_CLIENT_CONTRACT_OK
```

## Fichiers du ZIP

```text
Opus/Api/Rest/RestClient.php
Opus/Api/Rest/RestResourceCatalog.php
Opus/Api/Rest/RestResourceCatalogInterface.php
Opus/Api/Rest/RestServer.php
sites/owasys-back/config/backend.resources.json
sites/owasys-back/config/backend.rest.json
sites/owasys-front/config/rest-api.json
sites/owasys-front/config/rest.resources.json
```

## Cause traitée

R45B3 remplace la validation REST locale et partielle par un contrat générique partagé :

- chaque requête frontend doit correspondre à une ressource déclarée ;
- client et serveur chargent le même catalogue logique ;
- le fingerprint normalisé est échangé à chaque opération ;
- une dérive de catalogue bloque avant Composer ;
- méthode, statut de succès, enveloppe, content-type et trace sont vérifiés ;
- corps de requête et réponse sont bornés ;
- diagnostics et Profiler restent expurgés.

Catalogue :

```text
CONTRACT    : OPUS_REST_RESOURCE_CATALOG_V1
ROUTES      : 23
FINGERPRINT : 6deb58f201e5e6a8b12cee96ff006a1a4969442af2f1d1dcb05e5374220ace86
HEADER      : X-Opus-Rest-Catalog
MISMATCH    : OPUS_REST_API_CATALOG_MISMATCH / HTTP 409
```

## Compatibilité

`backend.rest.json` conserve ses ressources inline pendant R45B3. `RestServer` compare au boot leur fingerprint au catalogue externe. Cette conservation évite de casser les smokes E2A/E3A tout en supprimant le risque de divergence silencieuse.

Le déploiement sur deux bastions reste supporté : aucun partage de filesystem n’est requis entre front et back.

## Validation owner

```text
1. HEAD exact avant extraction
2. SHA-256 ZIP et smoke
3. extraction à la racine OPUS
4. lint PHP
5. parsing JSON
6. composer validate
7. composer dump-autoload -o
8. smoke owner
9. tests OWASYS Source et Git
10. test volontaire de fingerprint divergent => HTTP 409
11. contrôle Profiler sans contenu sensible
12. commit et push owner
```

## Suite

Après acquisition :

```text
R45C — wizard OWASYS structuré
```

Le wizard devra conserver les profils frontend/backend/fullstack, la création transactionnelle, les utilisateurs/rôles, FSM, I18n, ACL, SSO, SCORE et le flux REST/Composer.

NO UNDECLARED REST RESOURCE.  
NO CLIENT/SERVER CATALOG DRIFT.  
NO UNBOUNDED REST BODY.  
NO TRACE MISMATCH.  
NO ACL BYPASS.  
NO BACKEND JAVASCRIPT.  
NO LOCAL SITE FIX.  
NO PUSH OPUS PAR L’ASSISTANT.
