# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-28.

## Dépôt

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 464b702888314edfab2573e7ebe71d87fc988a33
Racine owner : H:/OPUS
```

## Architecture

Conserver uniquement deux applications OPUS autonomes :

```text
sites/owasys-front
sites/owasys-back
```

Ne partager aucun fichier, dossier, volume, configuration, secret, manifeste ou état runtime.

Réaliser uniquement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

## Résultats acquis

```text
P117W R6  : supprimer le chargement croisé
P117W R7  : valider les sites propres
P117W R8  : aligner le contrat d’environnement
P117W R9  : restaurer I18n et les bindings réseau
P117W R10 : centraliser dev, test et prod dans config/site.json
P117W R11 : supprimer l’accès Registry local du frontend
P117W R12 : lancer sans préparation manuelle de secrets en dev
P117W R13 : lire host et port depuis la configuration
P117W R14 : cibler le provider Composer backend
P117W R15 : restaurer la FSM frontend canonique
P117W R16 : restaurer les alias de commandes applicatives
P117W R17 : conserver un Logger et un Profiler par application
P117W R18 : conserver la cause interne des erreurs Console
P117W R19 : supprimer les vestiges locaux owasys_old*
P117W R20 : restaurer les quatre opérations backend perdues
P117W R21 : restaurer le navigateur Source via REST, Composer et SCORE
P117W R22 : réconcilier SQLite avec les sites physiques canoniques
```

## Runtime confirmé avant R22

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
registry.sync : exit_code 0
frontend /fr-FR/applications : request.completed
```

## Logger et Profiler

Conserver exactement :

```text
sites/owasys-front/var/logs/owasys-front.log
sites/owasys-front/var/profiler/owasys-front.jsonl
sites/owasys-back/var/logs/owasys-back.log
sites/owasys-back/var/profiler/owasys-back.jsonl
```

## P117W R21 — Source Browser

La fonction historique de navigation du code source est restaurée sans reprendre l’ancienne architecture interdite.

Flux :

```text
SCORE frontend
-> FSM + I18n + ACL + SSO
-> REST sécurisé
-> backend Source provider
-> Composer allow-listé
-> SiteSourceInspector OPUS
-> résultat structuré
-> SCORE
```

Le frontend ne lit jamais le filesystem et reste exploitable sans JavaScript obligatoire.

## P117W R22 — Registry physique

Cause corrigée : SQLite conservait les applications supprimées parce que la synchronisation réalisait uniquement des UPSERT et ignorait le contrat courant `OPUS_SITE_STANDARD_CONTRACT_CORE`.

La synchronisation réalise désormais dans une transaction atomique :

```text
migration sûre du schéma
import du seed
découverte déterministe des sites physiques
sélection des racines canoniques
UPSERT des sites canoniques
comparaison SQLite id + root_path avec les couples physiques
suppression des lignes obsolètes
effacement du contexte courant seulement s’il est obsolète
commit ou rollback explicite
```

Résultat exposé :

```text
stale_removed
stale_ids
stale_context_cleared
```

## Racine des applications créées avec OWASYS

Racine owner en développement :

```text
H:\OPUS\sites\<application-id>\
```

Chemin relatif canonique :

```text
sites/<application-id>/
```

Règles :

```text
un niveau directement sous sites/
identifiant identique au nom du répertoire
aucun chemin fourni par le navigateur
aucune racine sous owasys-front, owasys-back, var ou un temporaire
création uniquement via REST sécurisé puis Composer opus:create-site
échec explicite si la racine existe déjà
```

Le déplacement futur vers des dépôts autonomes nécessitera un nouveau contrat OPUS de stockage et de résolution.

## Validation owner R22

```text
cd /d H:\OPUS
php -l sites\owasys-back\application\registry\repositories\RegistryRepository.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
git status --short
```

Lancer les deux applications, puis ouvrir :

```text
http://127.0.0.1:8000/fr-FR/applications
```

Premier chargement attendu :

```text
applications visibles : owasys-back, owasys-front
owasys / sites/owasys_old : absent
stale_removed : 1
stale_ids : [owasys]
```

Chargements suivants :

```text
stale_removed : 0
```

## Statut

```text
P117W R6 à R22 : présents sur OPUS/master
Prochaine étape : validation runtime owner de R22 puis poursuite fonctionnelle
```

## Contrats framework

Faire implémenter son interface homonyme par toute classe concrète sous `Opus/**/*.php`.

Faire étendre directement chaque interface homonyme par :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

Lire toute configuration via `File` et `StructuredFileLoader`. Imposer Logger et Profiler. Interdire tout fallback silencieux.
