# OPUS P117W R20 — RESTAURER LA PARITÉ FONCTIONNELLE DES OPÉRATIONS OWASYS

Date : 2026-07-28  
État : ZIP différentiel produit ; validation runtime owner requise

## Lire

Lire `README-FIRST.md` et appliquer tous les contrats MAESTRO/OPUS actifs.

## Sources de vérité comparées

```text
Ancien OWASYS avant suppression : OPUS commit e1055468213ae62806c039ca0231a49a98d844fe
OWASYS actuel après nettoyage   : OPUS commit dc47342006f7f6a5fc0b6d18fe06d12ac2b82bb5
```

Comparer fonction par fonction `sites/owasys_old2` avec :

```text
sites/owasys-front
sites/owasys-back
```

## Architecture obligatoire

Conserver exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne restaurer aucun site monolithique, aucun répertoire partagé et aucun accès filesystem croisé.

## Parité confirmée

Les fonctions suivantes sont conservées :

```text
connexion et SSO
changement de mot de passe
session et contexte applicatif
registre SQLite
synchronisation, sélection et effacement du registre
création d’application
routes frontend
FSM frontend
ACL deny-by-default
sélecteur I18n UE + ukrainien
rendu SCORE
Logger et Profiler par application
API REST backend
exécution Composer allow-listée
```

Les états suivants étaient déjà des surfaces `OWASYS_MODULE_PENDING` dans l’ancien site ; ils ne constituent donc pas une régression de migration :

```text
structure
data
workflows
security
source
build
```

## Écart fonctionnel identifié

L’ancien catalogue backend contenait 11 opérations. Le catalogue actuel n’en contient plus que 7.

Opérations disparues :

```text
site.language.add -> opus:add-language
site.page.create  -> opus:create-page
site.rubric.create -> opus:create-rubric
site.export       -> opus:export-site
```

Les quatre scripts Composer existent toujours dans `composer.json`. Leur suppression du catalogue REST/Composer constitue donc une perte fonctionnelle réelle.

## Correction P117W R20

Remplacer uniquement :

```text
sites/owasys-back/config/backend.operations.json
```

Restaurer les quatre opérations avec leurs rôles, arguments, validations, options et indicateurs d’écriture historiques.

Conserver les sept opérations actuelles :

```text
site.create
site.validate
site.routes.list
registry.sync
registry.select
registry.clear
security.admin-password.change
```

Résultat attendu :

```text
11 opérations backend
4 opérations restaurées
0 modification frontend
0 modification de classe OPUS
0 tools
0 scripts
0 fichier runtime
```

## Sécurité

Conserver :

```text
admin     : accès complet
 developer : opérations site selon ACL site:*
 viewer    : validation et lecture des routes uniquement
```

Les opérations restaurées restent réservées à `admin` et `developer`.

## Livrable

```text
ZIP : opus_p117w_r20_restore_owasys_functional_operation_parity.zip
SHA-256 : 14c9f5cd4fa0e6228926aec8fe78821ec68d7de600c872657dfebfb70e2e48c5
Fichiers : 1
```

Contenu exclusif :

```text
sites/owasys-back/config/backend.operations.json
```

## Validation effectuée

```text
JSON valide                              : OK
Contrat opération catalog                : OK
Nombre d’opérations                      : 11
site.language.add                        : restaurée
site.page.create                         : restaurée
site.rubric.create                       : restaurée
site.export                              : restaurée
Scripts Composer correspondants présents: OK
Chemins interdits dans le ZIP            : 0
ZIP directement superposable             : OK
```

## Validation owner

```text
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

Contrôler ensuite le catalogue par PHP depuis `H:\OPUS`.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
