# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-06.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 4b1f621051a306443ada7eb5fada2a8e9363b0aa
Dernier acquis : E3A Git workspace générique/backend
Livrable actif : E3B Git workspace frontend
```

## Jalons acquis

- R45B2A2 : rétention/rotation bornée du Profiler JSONL.
- R45B2A3 : module `application/profiler` dans le scaffold générique.
- R45B2A4 : alignement de `profiler:view` dans le scaffold.
- E1 : `SiteSourceWorkspace`, publié à `60f45aae8ee6f3a10096069076900a41c33d9a19`.
- E2A : frontière Source REST/Composer, publiée à `1fc49e9e53efdd002513cc7b037a07cb2faacffc`.
- E2B : éditeur Sources frontend, publié à `d6548ec0fb1dc4bd376e730a943f45e502eed51e` et validé par édition réelle depuis OWASYS.
- E3A : workspace Git générique/backend, publié à `4b1f621051a306443ada7eb5fada2a8e9363b0aa`.

R46 `dev-server --site=` est abandonné et ne doit jamais être appliqué.

## Contrat dev-server conservé

```text
composer opus:dev-server -- <application-id> [--host=<local-address>] [--port=<local-port>]
```

Le dépôt racine ne déclare pas de script `composer dev-server` sans préfixe `opus:`.

## État E3A

E3A fournit :

- `SiteGitWorkspace` générique et interface homonyme ;
- statut, diff, historique, stage, unstage, commit et restauration ;
- confinement au site OPUS sélectionné ;
- refus d'un commit si l'index contient un chemin extérieur au site ;
- aucune commande Git libre et aucun push ;
- REST sécurisé et Composer allow-listé dans OWASYS-back ;
- ACL viewer lecture, developer/admin mutation ;
- Logger/Profiler sans contenu Git sensible ;
- projection déterministe du rôle principal : `admin > developer > viewer`.

Le commit E3A contient exactement onze fichiers gouvernés et aucun fichier de site généré.

## Livrable owner actif — E3B

```text
ZIP     : opus_p117w_e3b_git_workspace_front.zip
SHA-256 : f6cdd8160f16586851b2983373eedba473e865db237db2c388b005bebcc49743
FILES   : 32
BASE    : 4b1f621051a306443ada7eb5fada2a8e9363b0aa
STATUS  : livré, application, validation fonctionnelle, commit et push owner requis
```

Smoke owner :

```text
smoke_opus_p117w_e3b_git_workspace_front_owner.php
SHA-256 : 4cc4c4cbe15d20d0f83f96d7a8431e420aea3ffcf2b4ecb9dc6a85b953bf5f6a
OUTPUT  : OPUS_P117W_E3B_GIT_WORKSPACE_FRONT_OK
```

E3B ajoute :

- interface Git dans le module `source` existant ;
- status, diff, historique, stage, unstage, commit et restore ;
- SCORE et fallback POST sans JavaScript ;
- CSRF Git distinct du CSRF Source ;
- FSM explicite par action ;
- ACL viewer lecture seule et developer/admin mutation ;
- catalogues I18n des langues UE configurées plus ukrainien ;
- séparation stricte enregistrement Source / stage / commit ;
- aucun accès Git, filesystem ou shell direct depuis OWASYS-front ;
- expurgation récursive générique des corps REST sensibles dans le Profiler.

Le ZIP ne contient aucun fichier OWASYS-back, aucun JavaScript, aucune configuration Composer et aucun site généré.

## Validation owner attendue

1. lint PHP et parsing des 27 JSON ;
2. `composer validate` et autoload optimisé ;
3. smoke owner ;
4. test OWASYS status/diff/history ;
5. stage puis unstage ;
6. stage puis commit explicite ;
7. restauration avec hash et confirmation exacte ;
8. vérification qu'un enregistrement Source ne stage ni ne commit ;
9. vérification viewer lecture seule et developer/admin mutation ;
10. commit et push owner après succès.

## Suite gouvernée

1. acquisition owner E3B ;
2. R45B3 : durcissement et validation croisée du client REST frontend générique ;
3. R45C : wizard OWASYS structuré ;
4. R45D : administration Sécurité.

NO ACL BYPASS.
NO CONTENT, DIFF, COMMIT MESSAGE OR CONFIRMATION IN PROFILER.
NO DIRECT FRONTEND FILESYSTEM OR GIT ACCESS.
NO IMPLICIT GIT OPERATION.
NO FREE GIT COMMAND.
NO FOREIGN STAGED PATH.
NO BACKEND JAVASCRIPT.
NO LOCAL SITE FIX.
NO FALLBACK SILENCIEUX.
NO PUSH OPUS PAR L'ASSISTANT.
