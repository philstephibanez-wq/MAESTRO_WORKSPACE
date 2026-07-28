# OPUS P117W R29 — SOURCE ADRESSABLE PAR URL GET

Date : 2026-07-28  
Statut : spécification contractuelle et livrable différentiel à valider côté owner

## Source de vérité

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base exacte : 9416cab744c12191e4d5153b50521befb573d41f
Racine owner : H:\OPUS
Pré-requis : R28 présent sur OPUS/master
```

## Décision owner

La lecture d'un fichier source est une consultation de ressource en `GET`.
L'identité complète de la ressource doit être visible dans l'URL.

Forme canonique :

```text
GET /<locale>/source/<chemin-relatif-encodé-par-segment>
```

Exemple :

```text
GET /fr-FR/source/application/default/bootstrap.php
```

Le chemin n'est plus envoyé dans un formulaire ou un corps `POST`.

## Fonctionnement

- chaque fichier de l'arborescence est un lien GET réel ;
- sans JavaScript, le lien rend la page SCORE complète avec le fichier ;
- avec JavaScript, le même lien retourne la représentation JSON et actualise
  CodeMirror sans reconstruire l'arborescence ;
- `history.pushState` aligne immédiatement la barre d'adresse sur le fichier ;
- actualisation, ouverture dans un nouvel onglet et retour navigateur restent
  cohérents avec l'URL ;
- chaque segment est encodé avec `rawurlencode` ;
- les validations existantes interdisant traversée, chemins absolus, secrets,
  liens symboliques et répertoires exclus restent appliquées ;
- la lecture physique reste derrière
  `owasys-front -> REST sécurisé -> owasys-back -> Composer`.

## Livrable

```text
ZIP : opus_p117w_r29_source_resource_get_url.zip
SHA-256 : 52d1b3cc95038702c43924b204eb21df942635d392b61d47f01943d8c52d5fe3
Fichiers : 4
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
