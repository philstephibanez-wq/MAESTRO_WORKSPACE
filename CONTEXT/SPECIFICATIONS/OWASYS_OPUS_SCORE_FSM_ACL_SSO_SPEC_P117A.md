# Spécification OWASYS — SCORE / FSM / ACL / SSO

## Dépendances

`OWASYS -> OPUS Framework -> ScoreTemplate + FSM + ACL + SSO`.

## SCORE

Templates communs sous `application/default/templates`, templates d'état sous `application/<module>/templates`, extension `.score`. Les contrôleurs fournissent uniquement des view-models; aucun HTML concaténé et aucun `require` de vue PHP.

## FSM

Pipeline obligatoire : `requête -> événement -> garde SSO/ACL -> transition FSM -> actions -> état cible -> contrôleur d'état -> SCORE`. Les branches spéciales de navigation sont interdites.

## SSO

Une identité normalisée contient `subject`, `label`, `roles`, `provider`. Le fournisseur `local-password` sert au développement; OIDC/SAML/Windows pourront être ajoutés sans modifier les contrôleurs fonctionnels. Aucun secret n'est versionné.

## ACL

Deny-by-default, décision `resource:action`, rôles initiaux `admin`, `developer`, `viewer`. Masquer un lien ne remplace jamais le contrôle serveur.

## Store local

`sites/owasys/var/auth/local-users.json`, propre à OWASYS et non versionné.

## Validation

Syntaxes PHP, JSON valides, smoke SCORE/FSM/ACL/SSO, tests HTTP anonyme/authentifié, test de refus ACL, absence de `layout.php`, absence de vues PHP d'interface.
