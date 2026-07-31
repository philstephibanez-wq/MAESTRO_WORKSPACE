# MAESTRO WORKSPACE — Handoff OPUS P117W R46C2

Date : 2026-07-31  
Base OPUS relue : `9572f4fa264e21205cd3e4a81f2d19db5a4cc0c6` (`opus_p117w_r46c1_profiler_score_iframe`)

## État réel

- R46A1 est validé et poussé.
- R46B1 est présent sur `OPUS/master`.
- R46C1 est appliqué et poussé au commit `9572f4f`.
- La recette DOM prouve la présence de `iframe.ow-profiler-frame` et l'appel de la route OPUS.
- La route échoue avec `OPUS_ACL_DENIED` pour une session affichée `admin`.
- R46C1 n'est donc pas fonctionnellement accepté.

## Cause démontrée

`OwasysAuthSession::user()` normalise uniquement l'ancienne clé `owasys_user`, mais retourne sans validation toute identité déjà stockée sous `owasys_sso_identity`.

L'interface affiche le rôle primaire avec le fallback `roles[0] ?? profile`, tandis que `OwasysRuntimeSecurity` transmet exclusivement `identity.roles` à `AclPolicy`. Une identité courante contenant `profile: admin` sans `roles` paraît donc administrateur dans l'interface et reste sans rôle pour l'ACL deny-by-default.

Le moteur ACL est conforme : `admin` possède `*:*` et `developer` possède `profiler:view`. Aucun contournement ACL ne doit être ajouté.

## Différentiel R46C2

Archive : `opus_p117w_r46c2_session_identity_acl_normalization.zip`  
SHA-256 : `003c8d4d830fa64f1f136b1b86c045188052e9250c99b76daf198d8e2727fde5`

Le ZIP contient un seul fichier complet :

`sites/owasys-front/application/default/models/AuthSession.php`

Le correctif :

1. normalise la clé courante et la clé historique par le même contrat ;
2. persiste la forme canonique `subject/id/label/roles/profile/provider` ;
3. accepte `profile` comme migration uniquement lorsque `roles` est absent ;
4. refuse explicitement un `roles` présent mais vide, mal typé ou invalide ;
5. applique la même normalisation à `start()` et `update()` ;
6. ne modifie ni `AclPolicy`, ni `RuntimeSecurity`, ni la permission `admin`.

## Validation acquise

- source GitHub relue au HEAD `9572f4f` ;
- archive directe testée sans erreur ;
- un seul fichier complet au chemin final ;
- `git diff --no-index --check` sans anomalie ;
- aucun smoke, rapport, cache, log, dépendance ou secret livré.

PHP/Composer sont absents de l'environnement de construction. Le lint et la recette owner restent obligatoires.

## Recette owner attendue

- identité `roles: ['admin']` : Profiler autorisé ;
- identité historique `profile: admin` sans `roles` : normalisée puis autorisée ;
- identité `roles: ['developer']` : autorisée par `profiler:view` ;
- identité `roles: ['viewer']` : refusée ;
- session absente : refusée ;
- `roles: []` explicite : erreur de contrat, jamais promotion par `profile`.

NO ACL BYPASS.  
NO SILENT FALLBACK.  
NO TEST, NO ACCEPTANCE.
