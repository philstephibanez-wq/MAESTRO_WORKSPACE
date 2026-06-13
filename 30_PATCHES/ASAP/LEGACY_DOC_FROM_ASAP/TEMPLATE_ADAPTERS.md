# ASAP Template Adapters

## Rôle

ASAP expose des adaptateurs de templates.

Twig est une dépendance Composer d’ASAP, pas un framework souverain du front.

## Contrat

Un template adapter représente une data déjà validée.

Il ne doit jamais :

- résoudre une route
- charger la data métier
- décider un droit
- décider un état FSM
- fallback silencieusement vers un autre moteur
