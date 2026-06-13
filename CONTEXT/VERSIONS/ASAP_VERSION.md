# OPUS_VERSION

## Rôle

Ce fichier pose la version du framework PHP actuellement rattachée au workspace MAESTRO.

Le framework est renommé de `ASAP` vers `Opus`.

`ASAP` reste le nom historique du framework uniquement pendant la migration contrôlée des dépôts, namespaces, packages Composer et références de code.

`Opus` devient le nom fonctionnel cible du framework : un socle PHP mutualisable, indépendant des projets applicatifs, chargé de coordonner routes, modules, controllers, services, templates, I18N, ACL et accès data sans mélanger les responsabilités.

Le workspace ne doit pas embarquer de `vendor/`, de cache runtime, de secret, de chemin absolu projet, ni de fallback silencieux.

## Renommage officiel

- Ancien nom : `ASAP`
- Nouveau nom cible : `Opus`
- Nom long recommandé : `Opus Framework`
- Nom court recommandé : `Opus`
- Package actuel pendant migration : `logandplay/asap`
- Package cible : `logandplay/opus`
- Dépôt actuel pendant migration : `philstephibanez-wq/ASAP`
- Dépôt cible : `philstephibanez-wq/OPUS`

## Convention de version publique

- Forme recommandée : `Opus 8.1.0 "Lysenko"`
- Le préfixe `8.x` indique la génération/runtime PHP ciblée, pas la maturité fonctionnelle du framework.
- La version Composer technique actuelle reste séparée jusqu'à finalisation de la migration Composer.
- Exemple de lecture : `Opus 8.1.0 "Lysenko"` = framework Opus pour génération PHP 8, release nommée Lysenko.

## Nom de release

- Release courante / cible de transition : `Lysenko`
- Nom complet recommandé : `Opus 8.1.0 "Lysenko"`
- Rôle : nom de release/version du framework Opus, pas nom d'application.
- `Lysenko` ne remplace pas `ScoreTemplate` et ne désigne pas le projet applicatif.
- Les futures documentations peuvent employer la formule : `Opus Framework - 8.1.0 "Lysenko"`.

## Source de vérité actuelle

- Dépôt actuel pendant migration : `philstephibanez-wq/ASAP`
- Dépôt cible après migration : `philstephibanez-wq/OPUS`
- Package Composer actuel pendant migration : `logandplay/asap`
- Package Composer cible : `logandplay/opus`
- Version Composer cible : `8.1.0`
- PHP requis : `>=8.0`
- Dépendance framework : `twig/twig:^3.0`
- Branche actuelle par défaut : `master`

## Commit de référence connu

- `8b0637ba46148b993a8450c72b34d0c0f3800461`
- Message : `P112D1B_ASAP_ROUTER_DEFAULTS_FIX`

## Contrat d'utilisation dans MAESTRO_WORKSPACE

1. Opus est référencé comme framework externe mutualisable.
2. Le nom `ASAP` reste un alias historique uniquement pendant la migration contrôlée.
3. `Lysenko` est un nom de release/version du framework Opus, pas un nom d'application.
4. La mention `8.x` dans le nom public indique la génération/runtime PHP ciblée, pas une version majeure métier du framework.
5. MAESTRO_WORKSPACE ne devient pas propriétaire du code framework Opus.
6. Les applications consomment le framework comme dépendance contrôlée.
7. Le code métier ScoreTemplate ne doit pas être mélangé au framework.
8. Les documentations générées / Reference Books doivent documenter les APIs publiques sans dupliquer la logique applicative.
9. Toute montée de version ou migration de nom doit mettre à jour ce fichier avec : nom, release, version Composer, commit source, date, motif, impacts et tests.
10. Aucun renommage de namespaces, chemins, package Composer ou dépôt ne doit être simulé par fallback silencieux.

## Migration en cours / à finaliser

La migration réelle `ASAP -> Opus` doit rester atomique et vérifiable, avec contrôle explicite de :

1. dépôt GitHub `ASAP -> OPUS` ;
2. nom Composer `logandplay/asap -> logandplay/opus` ;
3. namespaces PHP `ASAP\\ -> Opus\\` ;
4. autoload Composer ;
5. chemins applicatifs ;
6. documentation Reference Book `ASAP_REF_BOOK -> OPUS_REF_BOOK` ;
7. tests runtime ;
8. compatibilité temporaire éventuelle documentée comme alias de migration, jamais comme fallback silencieux.

## Prochaine étape prévue

Finaliser le commit local `Opus 8.1.0 "Lysenko"`, puis renommer proprement les dépôts et répertoires `ASAP -> OPUS`, `ASAP_REF_BOOK -> OPUS_REF_BOOK`, avant de démarrer `ScoreTemplate` comme application consommatrice séparée du framework.