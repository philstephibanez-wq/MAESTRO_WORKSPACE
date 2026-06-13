# ASAP_VERSION

## Rôle

Ce fichier pose la version ASAP actuellement rattachée au workspace MAESTRO.

ASAP reste un framework PHP mutualisable et indépendant des projets applicatifs.
Le workspace ne doit pas embarquer de `vendor/`, de cache runtime, de secret, de chemin absolu projet, ni de fallback silencieux.

## Source de vérité

- Dépôt ASAP : `philstephibanez-wq/ASAP`
- Package Composer : `logandplay/asap`
- Version Composer déclarée : `0.1.0`
- PHP requis : `>=8.0`
- Dépendance framework : `twig/twig:^3.0`
- Branche ASAP par défaut : `master`

## Commit de référence connu

- `8b0637ba46148b993a8450c72b34d0c0f3800461`
- Message : `P112D1B_ASAP_ROUTER_DEFAULTS_FIX`

## Contrat d'utilisation dans MAESTRO_WORKSPACE

1. ASAP est référencé comme framework externe mutualisable.
2. MAESTRO_WORKSPACE ne devient pas propriétaire du code framework ASAP.
3. Les applications consomment ASAP comme dépendance contrôlée.
4. Le code métier ScoreTemplate ne doit pas être mélangé au framework ASAP.
5. Les documentations générées / Reference Books doivent documenter les APIs publiques sans dupliquer la logique applicative.
6. Toute montée de version ASAP doit mettre à jour ce fichier avec : version Composer, commit source, date, motif, impacts et tests.

## Prochaine étape prévue

Après pose de cette version ASAP : démarrer `ScoreTemplate` comme projet/applicatif séparé, consommateur d'ASAP, sans modifier le framework tant qu'un besoin contractuel réel n'est pas démontré.
