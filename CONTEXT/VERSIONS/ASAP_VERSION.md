# CONCERTO_VERSION

## Rôle

Ce fichier pose la version du framework PHP actuellement rattachée au workspace MAESTRO.

Le framework est renommé de `ASAP` vers `Concerto`.

`ASAP` reste le nom historique du framework tant que le dépôt, les namespaces, le package Composer et les références de code n'ont pas été migrés officiellement.

`Concerto` devient le nom fonctionnel cible du framework : un socle PHP mutualisable, indépendant des projets applicatifs, chargé de coordonner routes, modules, controllers, services, templates, I18N, ACL et accès data sans mélanger les responsabilités.

Le workspace ne doit pas embarquer de `vendor/`, de cache runtime, de secret, de chemin absolu projet, ni de fallback silencieux.

## Renommage officiel

- Ancien nom : `ASAP`
- Nouveau nom cible : `Concerto`
- Nom long recommandé : `Concerto Framework`
- Nom court recommandé : `Concerto`
- Package actuel : `logandplay/asap`
- Package cible à prévoir : `logandplay/concerto`
- Dépôt actuel : `philstephibanez-wq/ASAP`
- Dépôt cible à prévoir : `philstephibanez-wq/Concerto` ou renommage contrôlé du dépôt existant

## Source de vérité actuelle

- Dépôt actuel : `philstephibanez-wq/ASAP`
- Package Composer actuel : `logandplay/asap`
- Version Composer déclarée : `0.1.0`
- PHP requis : `>=8.0`
- Dépendance framework : `twig/twig:^3.0`
- Branche actuelle par défaut : `master`

## Commit de référence connu

- `8b0637ba46148b993a8450c72b34d0c0f3800461`
- Message : `P112D1B_ASAP_ROUTER_DEFAULTS_FIX`

## Contrat d'utilisation dans MAESTRO_WORKSPACE

1. Concerto est référencé comme framework externe mutualisable.
2. Le nom `ASAP` reste un alias historique tant que la migration n'est pas effectuée.
3. MAESTRO_WORKSPACE ne devient pas propriétaire du code framework Concerto/ASAP.
4. Les applications consomment le framework comme dépendance contrôlée.
5. Le code métier ScoreTemplate ne doit pas être mélangé au framework.
6. Les documentations générées / Reference Books doivent documenter les APIs publiques sans dupliquer la logique applicative.
7. Toute montée de version ou migration de nom doit mettre à jour ce fichier avec : nom, version Composer, commit source, date, motif, impacts et tests.
8. Aucun renommage de namespaces, chemins, package Composer ou dépôt ne doit être simulé par fallback silencieux.

## Migration à prévoir

La migration réelle `ASAP -> Concerto` devra être faite en palier dédié, avec contrôle explicite de :

1. dépôt GitHub ;
2. nom Composer ;
3. namespaces PHP ;
4. autoload Composer ;
5. chemins applicatifs ;
6. documentation Reference Book ;
7. tests runtime ;
8. compatibilité temporaire éventuelle documentée comme alias de migration, jamais comme fallback silencieux.

## Prochaine étape prévue

Après pose de cette version Concerto/ASAP : démarrer `ScoreTemplate` comme projet/applicatif séparé, consommateur du framework, sans modifier le framework tant qu'un besoin contractuel réel n'est pas démontré.
