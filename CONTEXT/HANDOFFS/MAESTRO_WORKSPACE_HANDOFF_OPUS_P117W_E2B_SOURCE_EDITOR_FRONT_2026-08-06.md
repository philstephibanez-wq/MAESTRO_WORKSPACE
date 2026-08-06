# HANDOFF — OPUS P117W E2B ÉDITEUR SOURCES OWASYS-FRONT

Date : 2026-08-06

## État owner

```text
OPUS master : 1fc49e9e53efdd002513cc7b037a07cb2faacffc
E2A         : acquis et publié
R46         : abandonné, ne jamais appliquer
```

Le contrat `opus:dev-server` reste positionnel :

```text
composer opus:dev-server -- <application-id> [--host=<local-address>] [--port=<local-port>]
```

## Livrable actif

```text
ZIP     : opus_p117w_e2b_source_editor_front.zip
SHA-256 : da9df8d1e17a16797fdf09a78413fde32db5d9307d30f577addc292ecc21254b
FILES   : 34
BASE    : 1fc49e9e53efdd002513cc7b037a07cb2faacffc
STATUS  : livré, application, validation et push owner requis
```

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_e2b_source_editor_front_owner.php
SHA-256 : 97055a9b832e84bf9bbcdefbb2f764f25ef341c3b124c17f7bd26b703dc0ace4
OUTPUT  : OPUS_P117W_E2B_SOURCE_EDITOR_FRONT_OK
```

## Cible

E2B fournit dans `owasys-front` :

- édition SCORE sans JavaScript obligatoire ;
- CodeMirror 6 comme amélioration progressive ;
- arbre hiérarchique, onglets et ouverture GET JSON ;
- prévisualisation REST POST séparée ;
- écriture REST PUT ;
- verrou optimiste SHA-256 ;
- conflit HTTP 409 sans écrasement ;
- pattern POST/Redirect/GET ;
- ACL viewer en lecture seule, developer/admin en édition ;
- 25 catalogues de langue de base UE + ukrainien.

E2B ajoute aussi le service CSRF OPUS générique, scopé, lié à la session et à usage unique.

## Périmètre exclu

- aucun fichier `owasys-back` ;
- aucun site généré ;
- aucune correction de `test7` ;
- aucun stage, commit ou push Git ;
- aucun contenu dans Logger, Profiler, URL ou `argv`.

## Validation owner attendue

1. vérifier le HEAD exact ;
2. extraire le ZIP ;
3. linter les quatre fichiers PHP ;
4. valider Composer et reconstruire l'autoload ;
5. exécuter le smoke owner ;
6. démarrer `owasys-back` puis `owasys-front` ;
7. tester Sources avec un rôle developer : prévisualisation, enregistrement, rechargement ;
8. tester Sources avec un rôle viewer : lecture seule ;
9. provoquer un conflit en modifiant le même fichier hors de la page entre lecture et enregistrement ;
10. confirmer qu'aucun écrasement n'a lieu ;
11. commit et push owner uniquement après validation.

## Après acquisition

E3 : Git contrôlé, séparé de l'enregistrement Source : statut, diff, historique, stage, unstage, commit et restauration bornée. Aucun push implicite.

NO ACL BYPASS.
NO CONTENT IN ARGV.
NO DIRECT FRONTEND FILESYSTEM ACCESS.
NO IMPLICIT GIT OPERATION.
NO SILENT FALLBACK.
NO LOCAL SITE FIX.
NO PUSH OPUS PAR L'ASSISTANT.
