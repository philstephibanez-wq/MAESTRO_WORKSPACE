# HANDOFF — OPUS P117W E3B GIT WORKSPACE FRONTEND

Date : 2026-08-06

## État acquis

OPUS `master` est publié au commit :

```text
4b1f621051a306443ada7eb5fada2a8e9363b0aa
opus_p117w_e3a_git_workspace_backend
```

E3A est acquis. Son commit contient exactement les onze fichiers attendus et aucune modification de site généré.

## Livrable owner actif

```text
ZIP     : opus_p117w_e3b_git_workspace_front.zip
SHA-256 : f6cdd8160f16586851b2983373eedba473e865db237db2c388b005bebcc49743
FILES   : 32
BASE    : 4b1f621051a306443ada7eb5fada2a8e9363b0aa
STATUS  : livré, application, validation fonctionnelle, commit et push owner requis
```

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_e3b_git_workspace_front_owner.php
SHA-256 : 4cc4c4cbe15d20d0f83f96d7a8431e420aea3ffcf2b4ecb9dc6a85b953bf5f6a
OUTPUT  : OPUS_P117W_E3B_GIT_WORKSPACE_FRONT_OK
```

## Ce que fournit E3B

- intégration Git dans le state et module `source` existants ;
- status, diff, historique, stage, unstage, commit et restore ;
- SCORE + formulaires POST fonctionnels sans JavaScript ;
- CSRF Git séparé du CSRF Source ;
- FSM explicite pour chaque demande, succès et échec ;
- ACL viewer lecture seule, developer/admin mutation ;
- vingt-cinq catalogues I18n UE + ukrainien ;
- aucune opération Git ou filesystem directe dans OWASYS-front ;
- aucune opération Git implicite lors de l'enregistrement Source ;
- expurgation récursive générique des corps REST sensibles dans le Profiler OPUS.

## Point de sécurité générique traité

`Opus\Api\Rest\RestClient` ne doit jamais envoyer au Profiler un corps REST brut contenant :

- contenu Source ;
- diff staged/unstaged ;
- message de commit ;
- confirmation de restauration ;
- sujet ou auteur d'historique ;
- token, secret, mot de passe ou autorisation.

E3B conserve uniquement une projection expurgée et mesurée.

## Validation owner

Résultats attendus :

```text
OPUS_P117W_E3B_JSON_OK
OPUS_P117W_E3B_GIT_WORKSPACE_FRONT_OK
```

Validation fonctionnelle OWASYS exigée avant push :

1. ouverture de Sources et Git ;
2. lecture status/diff/history ;
3. stage puis unstage d'une source ;
4. stage puis commit avec message explicite ;
5. restauration avec hash et confirmation exacte ;
6. vérification qu'un simple enregistrement Source ne stage et ne commit rien ;
7. vérification viewer lecture seule ;
8. vérification developer/admin mutation.

## Suite après acquisition E3B

R45B3 : durcissement et validation croisée du client REST frontend générique, sans rouvrir les frontières Source/Git acquises.

Puis :

- R45C : wizard OWASYS structuré ;
- R45D : administration Sécurité.

NO ACL BYPASS.
NO DIRECT FRONTEND FILESYSTEM OR GIT ACCESS.
NO CONTENT OR GIT SENSITIVE VALUE IN PROFILER.
NO IMPLICIT STAGE OR COMMIT.
NO FREE GIT COMMAND.
NO BACKEND JAVASCRIPT.
NO GENERATED SITE FILE.
NO LOCAL SITE FIX.
NO PUSH OPUS PAR L'ASSISTANT.
