# MAESTRO_WORKSPACE — Handoff OPUS P117W R46B2

Date : 2026-08-01

## Base exacte

- OPUS GitHub : `7e07e43c1aa148bd198918cb5d8051d06c428620` — `opus_p117w_r46c3_centralized_session_runtime`.
- R46C3 est validé par preuve HTTP/DOM owner et poussé.
- L'iframe SCORE fonctionne avec la session OWASYS et l'ACL `profiler:view`.
- La trace de page GET prouvée contient cinq événements mais zéro span.

## Cause

Le Singleton `OwasysFrontApplication` ouvre une trace par requête, mais ne crée aucun span HTTP racine. Le `RestClient` crée déjà des spans uniquement lorsqu'un véritable appel REST se produit. Zéro span REST sur une page GET est exact ; zéro span HTTP ne respecte pas le contrat R46.

## Livraison active

Archive : `opus_p117w_r46b2_http_root_span.zip`  
SHA-256 : `f2435b8451d4ca64bb0353868445dcbc1464be2c1a256efde79337ffee5fb991`

Fichier complet unique :

`sites/owasys-front/application/default/Application.php`

## Effet contractuel

- un span `http.request` couvre la requête frontend réelle ;
- événements `http.request.received`, `http.route.resolved`, `http.controller.selected`, `http.response.created`, `http.response.sent` ;
- en erreur : `http.exception.caught` et fermeture du span au statut `error` ;
- méthode, route normalisée, contrôleur/action et statut HTTP filtrés ;
- aucune affirmation REST ou Composer sans exécution réelle ;
- aucun changement du site témoin, de l'ACL, de l'identité ou du backend.

## Validation acquise

- construction sur checkout propre du HEAD OPUS exact ;
- `git diff --check` propre ;
- archive vérifiée : un chemin final, aucun log, cache, vendor, smoke ou rapport ;
- PHP indisponible dans l'environnement de construction : lint et recette owner requis.

## Recette owner

Appliquer le ZIP, linter `Application.php`, régénérer l'autoload et contrôler le diff. Recharger une page GET avec `?profiler=1`.

Critères : exactement un span HTTP terminé en succès, événements HTTP liés au même `span_id`, aucun span REST/Composer si ces opérations n'ont pas eu lieu. Tester ensuite une erreur réelle : événement `http.exception.caught` et span HTTP en erreur.

## Autorité

```text
Assistant : MAESTRO_WORKSPACE + ZIP différentiel
Owner : application, validation, commit et push OPUS/OWASYS
```

NO EVENT, NO CLAIM.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
