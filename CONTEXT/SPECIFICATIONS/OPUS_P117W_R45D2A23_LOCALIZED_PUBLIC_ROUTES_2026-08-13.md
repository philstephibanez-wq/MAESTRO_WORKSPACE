# OPUS P117W R45D2A23 — Routes publiques localisées

Date : 2026-08-13
Base OPUS : `2e17008ad0cf23e70195ee2c0f6c947ecb5333be`.

## Décision

OWASYS doit séparer les routes techniques internes des URLs publiques. Les routes internes FSM restent stables ; le frontend génère et résout des slugs localisés.

Exemples français :

- `security` -> `/fr-FR/sécurité`
- `data` -> `/fr-FR/sources-de-données`
- `source` -> `/fr-FR/sources-et-git`
- `build` -> `/fr-FR/construction-et-validation`
- la route du compte -> `/fr-FR/compte/mot-de-passe`

Les accents et caractères propres à chaque langue sont conservés. Aucune translittération ASCII n'est autorisée.

## Évolution générique OPUS

Créer `Opus/Http/LocalizedRouteResolver.php` et son interface homonyme respectant les quatre interfaces marqueurs OPUS. La configuration est chargée via `StructuredFileLoader` et les URLs sont construites via `UrlBuilder`.

Le résolveur fournit les deux sens : route canonique -> chemin public localisé, et chemin public localisé -> route canonique.

Le catalogue `sites/owasys-front/config/routes.localized.json` couvre les 25 langues de base OWASYS. Les variantes régionales héritent de leur langue de base.

Les anciens chemins techniques restent acceptés en entrée pour compatibilité mais ne sont plus émis par la navigation.

La route `source` accepte un suffixe opaque : seul le préfixe UI est traduit ; le chemin réel du fichier ne l'est jamais.

Le sélecteur de langue traduit la route courante et conserve le fichier sélectionné ou la vue courante.

Les routes REST de `owasys-back` restent techniques et non traduites.

## Invariants

FSM, ACL, SSO et signaux restent inchangés. Aucun routeur JavaScript. Aucun retrait d'accent. Aucun chemin de ressource traduit.

## Gate owner

Vérifier les URLs françaises avec accents, puis changer de langue et confirmer que le slug courant est traduit. Vérifier Sources et Git avec un fichier sélectionné. Vérifier que les anciennes URLs techniques restent acceptées. Vérifier que le backend REST n'est pas modifié.
