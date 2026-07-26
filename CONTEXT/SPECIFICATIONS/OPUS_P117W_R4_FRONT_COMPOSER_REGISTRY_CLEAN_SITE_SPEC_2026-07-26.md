# OPUS P117W R4 — CORRIGER LE REGISTRE COMPOSER DU FRONTEND

Date : 2026-07-26  
État : ZIP différentiel produit ; application owner requise

## Lire

Lire `README-FIRST.md` et appliquer les contrats MAESTRO/OPUS actifs.

## Conserver

Conserver exactement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser uniquement les échanges suivants :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne partager aucun fichier et ne créer aucune troisième racine.

## Identifier la cause

La migration P117W initiale a copié `sites/owasys/config/composer.commands.json` dans `sites/owasys-front/config/composer.commands.json`.

Le fichier copié déclare `site_id = owasys`, alors que son répertoire d'installation impose `site_id = owasys-front`.

`ApplicationCommandDispatcher` compare obligatoirement le `site_id` déclaré avec le nom de la racine du site. Cette incohérence bloque toutes les commandes Composer OPUS lors de la construction de l'application console.

## Corriger

Remplacer uniquement :

```text
sites/owasys-front/config/composer.commands.json
```

Utiliser :

```json
{
  "contract": "OPUS_APPLICATION_COMMAND_PROVIDER_REGISTRY_V1",
  "site_id": "owasys-front",
  "providers": [],
  "aliases": []
}
```

Déclarer explicitement zéro provider et zéro alias afin d'interdire toute commande Composer applicative locale dans le frontend.

Conserver le registre backend autonome dans :

```text
sites/owasys-back/config/composer.commands.json
```

## Interdire

Ne livrer aucun répertoire `tools`, aucun répertoire opérationnel `scripts/owasys`, aucune migration, aucun smoke, aucun audit et aucune racine `owasys-shared`.

## Livrer

```text
ZIP : opus_p117w_r4_fix_front_composer_registry_clean_site.zip
SHA-256 : 421fbd6d39e01e166b798d5bdee313cb24c39ef8761d62b4fc2ae7edb1dcc7d0
Fichiers : 1
Octets : 309
Base Git : 4fb3a92605f14d84b8060ff36fde78828da49273
Base locale : P117W initial et P117W R3 appliqués
```

## Valider

Valider le JSON : OK.  
Valider la correspondance `site_id` / racine : OK.  
Valider zéro provider frontend : OK.  
Valider zéro alias frontend : OK.  
Valider le registre backend et son bootstrap : OK en simulation.  
Valider l'absence de `owasys-shared` : OK en simulation.  
Valider l'absence de répertoire opérationnel dans le ZIP : OK.

## Exécuter côté owner

Appliquer le ZIP, reconstruire l'autoload, valider `owasys-front`, valider `owasys-back`, lancer le backend, puis lancer le frontend.

Conserver les commandes CMD hors du produit livré.