# OPUS P117W R10 — CONFIGURATION UNIQUE PAR APPLICATION AVEC SECTIONS D’ENVIRONNEMENT

Date : 2026-07-27  
État : ZIP différentiel produit ; validation runtime owner requise

## Lire

Lire `README-FIRST.md` et appliquer tous les contrats MAESTRO/OPUS actifs.

## Conserver

Conserver uniquement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser uniquement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne partager aucun fichier entre les deux applications.

## Corriger la configuration fragmentée

Supprimer le modèle P117W R9 fondé sur :

```text
sites/owasys-front/var/development/environment.json
sites/owasys-back/var/development/environment.json
```

Ne plus multiplier les répertoires et fichiers de configuration runtime.

Conserver toute la configuration d’environnement dans le fichier existant de chaque application :

```text
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

Ajouter dans chaque `site.json` une section unique :

```text
environments
  dev
  test
  prod
```

Utiliser le contrat :

```text
OPUS_APPLICATION_ENVIRONMENTS_V1
```

Sélectionner l’environnement par `OPUS_ENV`. Faire sélectionner automatiquement `dev` par `opus:dev-server`.

## Déclarer le réseau

Dans la section `dev` du frontend, déclarer :

```text
adresse du backend
port du backend
endpoint REST du backend
références des secrets bearer et HMAC
```

Dans la section `dev` du backend, déclarer :

```text
adresse du frontend
port du frontend
endpoint du frontend
références des secrets bearer et HMAC
```

Conserver l’adresse et le port d’écoute locaux comme arguments variables de `opus:dev-server`.

Dans les sections `prod`, ne coder aucune adresse, aucun port et aucun secret en dur. Référencer exclusivement les variables d’environnement de déploiement.

Interdire les secrets littéraux dans toutes les sections.

## Corriger génériquement OPUS

Modifier :

```text
Opus/Console/Service/SiteCommandService.php
```

Lire les sections depuis le `site.json` déjà chargé par `StructuredFileLoader`.

Résoudre chaque variable par exactement une source :

```text
value
ou
environment
```

Refuser :

```text
section absente
variables vides
binding ambigu
valeur vide
variable source absente
secret littéral
adresse, port ou URL peer incohérents
```

Faire échouer le lancement avant ouvrir le serveur lorsque les secrets requis manquent, afin de ne plus produire une erreur générique dans le navigateur.

## Conserver I18n

Conserver la politique I18n complète restaurée par P117W R9, dont `i18n.language_defaults` pour toutes les langues de l’Union européenne et l’ukrainien.

## Livrer

```text
ZIP : opus_p117w_r10_single_environment_config_sections.zip
SHA-256 : 590f204c6ea2cb36816499443e735174b51d557813731b54efbe8e93878e3c59
Fichiers : 3
Octets : 12938
```

Inclure uniquement :

```text
Opus/Console/Service/SiteCommandService.php
sites/owasys-front/config/site.json
sites/owasys-back/config/site.json
```

Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier sous `var`, aucune migration, aucun smoke, aucun audit, aucun rapport, aucun secret et aucune racine partagée.

## Valider avant livraison

```text
Analyser la syntaxe PHP                         : OK
Analyser les deux JSON                          : OK
Résoudre la section dev frontend                : OK
Injecter les arguments locaux                   : OK
Valider le peer backend                         : OK
Refuser les secrets absents                     : OK
Détecter les chemins interdits dans le ZIP       : 0
Réouvrir le ZIP                                 : OK
```

Marqueurs :

```text
P117W_R10_ENVIRONMENT_SECTIONS_OK
P117W_R10_ZIP_CLEAN_OK
```

Ne pas présenter cette validation isolée comme une validation runtime Windows owner.

## Nettoyer après application

Après appliquer R10, supprimer uniquement les deux répertoires devenus obsolètes :

```text
sites/owasys-front/var/development
sites/owasys-back/var/development
```

Ne supprimer aucun autre répertoire `var`.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
