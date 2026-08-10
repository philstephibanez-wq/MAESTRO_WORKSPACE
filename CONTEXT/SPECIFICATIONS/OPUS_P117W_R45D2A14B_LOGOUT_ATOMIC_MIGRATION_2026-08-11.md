# OPUS P117W R45D2A14B — LOGOUT ATOMIC MIGRATION

Date : 2026-08-11
Statut : livrable owner à valider
Base OPUS : `f195471557727d23d0be036b80382f3ba3ad9787`

## Constat owner

Après application de R45D2A14, `essai2` retourne `OPUS_GENERATED_RUNTIME_FAILED` sur `/fr` pour une session authentifiée.

## Cause

Le runtime R45D2A14 rend immédiatement un bouton logout et traduit `auth.logout` pour toute identité authentifiée locale. Or le commit publié R45D2A14 ne contient que :

- `Opus/Application/Runtime/GeneratedSiteRuntime.php` ;
- `Opus/Application/Runtime/templates/logout-form.score`.

Les artefacts générés existants n'ont pas été migrés : `sites/essai2/config/routes.json` n'a pas de route `/logout` et `sites/essai2/application/home/local/fr.json` n'a pas `auth.logout`.

## Correction contractuelle

1. Le runtime ne rend le logout que si une route de module `logout` existe réellement dans le registre de routes.
2. Migration atomique de tous les sites Composer générés avec login :
   - ajout de `/logout` ;
   - ajout I18n `auth.logout` dans tous les catalogues supportés ;
   - ajout CSS logout ;
3. Smoke fail-fast exige route + traduction avant validation.

## Invariants

- POST uniquement ;
- CSRF OPUS scoped/single-use ;
- destruction propre de session ;
- Logger/Profiler `security.sso.logout.succeeded` ;
- aucune dépendance silencieuse à un artefact absent ;
- aucun patch spécifique à `essai2` ;
- aucun push OPUS/OWASYS par l'assistant.

## Livrable

```text
ZIP     : opus_p117w_r45d2a14b_logout_atomic_migration.zip
SHA-256 : 7c5116094616bdd93269ff74b99cfde7ad4047a131a06f96b191793bd88c7964
BASE    : f195471557727d23d0be036b80382f3ba3ad9787
FILES   : 2
```

## Gate owner

1. appliquer le ZIP ;
2. exécuter l'applicateur ;
3. exécuter le smoke ;
4. lint runtime ;
5. dump-autoload ;
6. relancer `essai2` ;
7. `/fr` authentifié doit rendre sans 500 ;
8. `Déconnexion` doit être visible ;
9. POST logout doit retourner vers `/fr/login` et invalider la session.
