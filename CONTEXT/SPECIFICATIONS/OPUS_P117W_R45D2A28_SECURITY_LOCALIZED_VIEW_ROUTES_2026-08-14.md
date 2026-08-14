# OPUS P117W R45D2A28 — Security Localized View Routes

Date : 2026-08-14
Statut : gate actif
Base OPUS publiée : `3d4b0cb06e8a825326809ce9173b6fefb36827e9` — `opus_p117w_r45d2a27_assignment_revoke_ui`

## Cause

La route publique Security est localisée (`/fr-FR/sécurité`) mais les sous-vues sont encore exposées par la query technique anglaise `?view=identities|roles|permissions|assignments|resources`.

Le défaut vient de `OwasysSecurityController::securityUrl()`, qui construit cette query au lieu d'utiliser `LocalizedRouteResolverInterface` pour les sous-vues.

## Contrat

Les clés internes restent stables et en anglais :

- `security/identities`
- `security/roles`
- `security/permissions`
- `security/assignments`
- `security/resources`

Les chemins publics sont localisés dans `config/routes.localized.json`, selon les 25 langues de base du catalogue OWASYS. Les variantes régionales héritent de leur langue de base selon le contrat existant.

En français :

- `/fr-FR/sécurité/identités`
- `/fr-FR/sécurité/rôles`
- `/fr-FR/sécurité/permissions`
- `/fr-FR/sécurité/attributions`
- `/fr-FR/sécurité/ressources-et-acl`

Aucun `?view=...` ne doit être généré par OWASYS.

L'ancienne forme `/<locale>/<sécurité>?view=<clé>` reste acceptée uniquement pour compatibilité. En GET, elle est redirigée vers le chemin localisé canonique. Un POST legacy reste interprétable pour ne pas perdre une mutation issue d'une page obsolète.

## Contraintes

- SCORE inchangé ;
- aucune mutation Security modifiée ;
- aucune modification backend/REST/ACL/FSM ;
- aucune nouvelle classe concrète ;
- zéro JavaScript ;
- utilisation du `LocalizedRouteResolver` OPUS existant ;
- accents et Unicode NFC conservés ;
- changement de langue conserve la sous-vue courante.

## Livrable

`opus_p117w_r45d2a28_security_localized_view_routes.zip`

SHA-256 : `814030ed1095172fc860805af861dbe9ed8c10f1fd735465d6001de9a75faba6`

## Acceptation

Le smoke doit produire :

`OPUS_R45D2A28_SECURITY_LOCALIZED_VIEW_ROUTES_OK routes=5 languages=25`

et vérifier notamment que `LocalizedRouteResolver::url('', 'fr-FR', 'security/assignments')` retourne exactement `/fr-FR/sécurité/attributions`.
