# OPUS P117W R44C — rendu opaque des sources SCORE dans OWASYS

Date : 2026-07-31  
Base OPUS owner : `63470fb43c4b692eea2d7db2c0be5f6086008d1a`  
Statut : ZIP différentiel cumulatif livré, application et validation owner requises.

## Test réel acquis

La création fullstack anonyme de `owasys-test` a réussi : REST retourne `201`, Composer termine, le Registry est synchronisé et aucun défaut de scaffold n'est constaté.

L'ouverture de `layout.score` et `footer.score` échoue ensuite dans `owasys-front`, après une lecture REST backend réussie en `200`.

## Cause

`OwasysScorePageRenderer` rend le template de page, place le HTML obtenu dans `body.html`, puis rend le layout SCORE. Les délimiteurs `{{ ... }}` et `[[ ... ]]` présents dans le source affiché survivent à l'échappement HTML et sont interprétés pendant ce second rendu.

Le contenu source cesse donc d'être une donnée opaque.

## Correction R44C

Le différentiel :

- rend le template de page exactement une fois ;
- remplace temporairement le fragment rendu par un marqueur non-SCORE unique ;
- rend ensuite le layout SCORE ;
- exige exactement une occurrence du marqueur ;
- injecte le fragment déjà rendu seulement après l'analyse du layout ;
- conserve l'échappement HTML du `textarea` et le fallback sans JavaScript ;
- laisse CodeMirror améliorer progressivement l'affichage ;
- extrait un code sûr `OPUS_*`, `OWASYS_*` ou `SCORE_*` dans toute la chaîne d'exceptions ;
- ne modifie ni le backend, ni les scripts générés, ni `owasys-test`.

## Livrable

`opus_p117w_r44c_opaque_score_source_rendering.zip`

SHA-256 :

`99b35b604a87a2b9fd836a247059a799513be3649a4bbd72222491f031beba1d`

Le ZIP est cumulatif depuis la base owner et contient 31 fichiers complets : R44A + R44B + les deux fichiers R44C.

## Acceptation owner

Après application :

- lint des deux fichiers PHP R44C ;
- validation Composer de `owasys-front` ;
- réouverture de `layout.score` et `footer.score` ;
- vérification que le source est affiché littéralement et échappé ;
- vérification du fallback `textarea` sans JavaScript ;
- vérification de CodeMirror avec JavaScript ;
- vérification Logger/Profiler avec le vrai code SCORE en cas d'échec ;
- reprise de la recette R44 sans modifier `owasys-test`.

NO FALLBACK SILENCIEUX.  
TOUJOURS TRAITER LA CAUSE.  
SOURCE OPAQUE, SCORE UNIQUE.
