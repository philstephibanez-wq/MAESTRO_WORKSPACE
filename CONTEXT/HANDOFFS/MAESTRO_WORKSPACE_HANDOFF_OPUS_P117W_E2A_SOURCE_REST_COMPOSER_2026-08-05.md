# HANDOFF — OPUS P117W E2A SOURCES REST / COMPOSER

Date : 2026-08-05  
Statut : livré, application, validation et push owner requis

## Base exacte

```text
Repository : philstephibanez-wq/OPUS
Branch     : master
Base       : 60f45aae8ee6f3a10096069076900a41c33d9a19
```

E1 est acquis et publié à cette base sous le commit `opus_p117w_e1_source_workspace`.

## Livrable

```text
ZIP     : opus_p117w_e2a_source_rest_composer.zip
SHA-256 : cb6ff147974ef987cb416a106f28a6b4f13fabcb20a62d6e4b3f986c25ea7f13
FILES   : 7
BASE    : 60f45aae8ee6f3a10096069076900a41c33d9a19
```

Fichiers :

```text
Opus/Api/Composer/ComposerCommandRegistry.php
Opus/Api/Rest/RestServer.php
composer.json
sites/owasys-back/application/source/services/OwasysSourceCommandProvider.php
sites/owasys-back/config/backend.operations.json
sites/owasys-back/config/backend.rest.json
sites/owasys-back/config/composer.commands.json
```

Aucun fichier `owasys-front`, aucun site généré, aucun test, rapport, log, cache, temporaire ou JavaScript backend n’est contenu dans le ZIP.

## Smoke owner séparé

```text
FILE    : smoke_opus_p117w_e2a_source_rest_composer_owner.php
SHA-256 : e2da50dea142a389cf384c442b03890fcb89e81a7baa1f22fca6e584f0f6299e
STATUS  : hors ZIP
```

Le smoke :

- valide les routes et opérations preview/write ;
- vérifie les rôles admin/developer ;
- vérifie que le contenu et le hash ne passent pas dans `argv` ;
- vérifie que les espaces et fins de ligne du contenu sont conservés ;
- appelle le provider OWASYS-back sur un site temporaire contractuel ;
- valide preview sans mutation ;
- valide l’écriture complète ;
- valide le conflit optimiste ;
- valide le refus d’écriture pour viewer ;
- supprime les fixtures dans son bloc `finally`.

## Protocole owner

Le dépôt OPUS doit être propre et exactement sur la base indiquée avant extraction.

```cmd
cd /d H:\OPUS
git status --short
git rev-parse HEAD
tar -xf "%USERPROFILE%\Downloads\opus_p117w_e2a_source_rest_composer.zip"
php -l Opus\Api\Composer\ComposerCommandRegistry.php
php -l Opus\Api\Rest\RestServer.php
php -l sites\owasys-back\application\source\services\OwasysSourceCommandProvider.php
php -r "json_decode(file_get_contents('composer.json'), true, 512, JSON_THROW_ON_ERROR); json_decode(file_get_contents('sites/owasys-back/config/backend.operations.json'), true, 512, JSON_THROW_ON_ERROR); json_decode(file_get_contents('sites/owasys-back/config/backend.rest.json'), true, 512, JSON_THROW_ON_ERROR); json_decode(file_get_contents('sites/owasys-back/config/composer.commands.json'), true, 512, JSON_THROW_ON_ERROR); echo 'OPUS_P117W_E2A_JSON_OK', PHP_EOL;"
composer validate --no-check-publish
composer dump-autoload -o
php "%USERPROFILE%\Downloads\smoke_opus_p117w_e2a_source_rest_composer_owner.php" H:\OPUS
git status --short
```

Résultats attendus :

```text
OPUS_P117W_E2A_JSON_OK
OPUS_P117W_E2A_SOURCE_REST_COMPOSER_OK
```

Après validation owner : commit et push OPUS par l’owner uniquement.

## Gates d’acquisition

E2A est acquis lorsque :

1. le HEAD initial est exactement la base annoncée ;
2. les trois lints réussissent ;
3. les quatre JSON sont valides ;
4. Composer valide le manifeste et régénère l’autoload ;
5. le smoke retourne `OPUS_P117W_E2A_SOURCE_REST_COMPOSER_OK` ;
6. le diff Git contient seulement les sept fichiers annoncés ;
7. aucune fixture temporaire n’est laissée ;
8. le commit owner est publié ;
9. son SHA est reporté dans le workspace.

## Suite après acquisition

E2B : intégration dans `owasys-front` avec POST backend du formulaire, preview distincte de write, ViewModel, SCORE, conflit explicite, conservation du fichier et de la locale dans l’URL, et fonctionnement sans JavaScript obligatoire.

E3 reste séparé : statut/diff/historique/stage/unstage/commit Git contrôlés, sans push implicite.

NO ACL BYPASS.  
NO CONTENT IN ARGV.  
NO LOCAL SITE FIX.  
NO FALLBACK SILENCIEUX.  
NO PUSH OPUS PAR L’ASSISTANT.
