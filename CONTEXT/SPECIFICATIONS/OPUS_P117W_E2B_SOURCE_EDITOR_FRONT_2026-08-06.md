# OPUS P117W E2B — ÉDITEUR SOURCES OWASYS-FRONT

Date : 2026-08-06

## Base exacte

```text
OPUS master : 1fc49e9e53efdd002513cc7b037a07cb2faacffc
Commit      : opus_p117w_e2a_source_rest_composer
```

E2A est acquis et publié à cette base.

## Décision owner sur R46

R46 `dev-server --site=` est abandonné et ne doit jamais être appliqué.
Le contrat positionnel existant est conservé :

```text
composer opus:dev-server -- <application-id> [--host=<local-address>] [--port=<local-port>]
```

Le dépôt racine ne déclare pas de script Composer `dev-server` sans préfixe `opus:`.

## Objet E2B

E2B rend le module Sources de `owasys-front` éditable sans accès direct au système de fichiers :

```text
owasys-front SCORE
→ REST sécurisé
→ owasys-back
→ Composer allow-listé
→ SiteSourceWorkspace OPUS
→ réponse REST
→ owasys-front SCORE
```

## Contrats fonctionnels

- GET conserve la locale et le chemin complet du fichier dans l'URL ;
- POST HTML natif prévisualise ou demande l'écriture ;
- la prévisualisation appelle la route REST POST `source.preview` ;
- l'écriture appelle la route REST PUT `source.write` ;
- le contenu et le hash restent dans la requête structurée et ne passent jamais dans `argv` ;
- le hash SHA-256 courant est obligatoire pour le verrouillage optimiste ;
- `OPUS_SITE_SOURCE_CONFLICT` produit un état HTTP 409 explicite ;
- aucun écrasement n'est effectué en cas de conflit ;
- après écriture réussie, le frontend applique le pattern POST/Redirect/GET avec HTTP 303 ;
- enregistrer, stage Git et commit Git restent trois opérations distinctes ;
- aucun push Git implicite.

## Interface

Le fallback sans JavaScript fournit intégralement :

- sélection du fichier ;
- textarea éditable selon ACL ;
- bouton Prévisualiser ;
- bouton Enregistrer ;
- diff SCORE échappé ;
- état enregistré, erreur et conflit ;
- rechargement explicite depuis le serveur.

L'amélioration progressive JavaScript ajoute :

- CodeMirror 6 éditable ;
- numéros de ligne, recherche et coloration déjà fournis par le bundle OWASYS ;
- ouverture asynchrone GET JSON ;
- arborescence hiérarchique ;
- onglets de fichiers ouverts ;
- indicateur de modifications non enregistrées ;
- garde avant changement de fichier ou fermeture de page.

## Sécurité

E2B ajoute une frontière générique OPUS :

```text
Opus/Security/Csrf/CsrfTokenManager.php
Opus/Security/Csrf/CsrfTokenManagerInterface.php
```

Le jeton est :

- lié à la session ;
- scopé par formulaire ;
- aléatoire sur 256 bits ;
- comparé avec `hash_equals` ;
- à usage unique ;
- rejeté par `OPUS_CSRF_TOKEN_INVALID` ;
- conforme à l'interface homonyme étendant directement les quatre marqueurs OPUS.

ACL existante :

- admin : `*:*` ;
- developer : `source:*` ;
- viewer : `source:open` uniquement.

Le frontend ne lit ni n'écrit directement les fichiers. Aucun contenu source n'entre dans Logger, Profiler, URL ou arguments CLI.

## FSM

Signaux ajoutés au module `source` :

```text
preview_source
source_previewed
write_source
source_written
source_conflict
source_action_failed
```

Toutes les transitions restent dans l'état `source`, exigent l'application courante et ne placent aucun contenu source dans la mémoire FSM.

## I18n

E2B ajoute 25 catalogues de langue de base au scope `source`, couvrant toutes les langues configurées de l'Union européenne ainsi que l'ukrainien. Les variantes régionales héritent des catalogues de base via la chaîne de fallback OPUS explicite.

## Livrable

```text
ZIP     : opus_p117w_e2b_source_editor_front.zip
SHA-256 : da9df8d1e17a16797fdf09a78413fde32db5d9307d30f577addc292ecc21254b
FILES   : 34
BASE    : 1fc49e9e53efdd002513cc7b037a07cb2faacffc
```

Répartition :

- 2 fichiers OPUS CSRF génériques ;
- 7 fichiers `owasys-front` de contrôleur, modèle, SCORE, layout, FSM, CSS et JavaScript ;
- 25 catalogues I18n `application/source/local/*.json`.

Aucun fichier `owasys-back`, aucun site généré et aucune opération Git ne figurent dans le ZIP.

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_e2b_source_editor_front_owner.php
SHA-256 : 97055a9b832e84bf9bbcdefbb2f764f25ef341c3b124c17f7bd26b703dc0ace4
OUTPUT  : OPUS_P117W_E2B_SOURCE_EDITOR_FRONT_OK
```

## Validation réalisée

- lint PHP de tous les fichiers PHP ;
- parsing de tous les JSON ;
- `node --check` du JavaScript frontend ;
- test ciblé du modèle REST POST/PUT et conservation exacte du contenu ;
- test ciblé CSRF, y compris refus du rejeu ;
- contrôle des quatre marqueurs de l'interface générique ;
- contrôle des signaux FSM ;
- contrôle des 25 catalogues et de leurs clés ;
- contrôle ZIP extrait : 34 fichiers exacts ;
- absence totale de fichier backend et de dépendance JavaScript backend.

## Suite gouvernée

Après validation et push owner de E2B : E3 Git contrôlé avec statut, diff, historique, stage, unstage, commit et restauration bornée. Aucun push implicite, aucun argument Git libre, aucun reset ou rebase destructif.

NO ACL BYPASS.
NO CONTENT IN ARGV.
NO DIRECT FRONTEND FILESYSTEM ACCESS.
NO IMPLICIT GIT OPERATION.
NO SILENT FALLBACK.
NO LOCAL SITE FIX.
NO PUSH OPUS PAR L'ASSISTANT.
