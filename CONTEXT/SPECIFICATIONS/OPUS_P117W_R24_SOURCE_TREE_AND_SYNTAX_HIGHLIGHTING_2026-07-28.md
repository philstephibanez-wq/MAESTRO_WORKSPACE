# OPUS P117W R24 — ARBORESCENCE DES SOURCES ET COLORATION SYNTAXIQUE

Date : 2026-07-28  
Statut : spécification contractuelle et livrable différentiel à valider côté owner

## Source de vérité

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base exacte : 4868780af4dd65bb7e28d95c981d1a1c5800a243
Racine owner : H:\OPUS
Pré-requis cumulatifs : R22 et R23 inclus au livrable R24
```

## Régression traitée

R21 avait restauré le navigateur de sources via REST et SCORE, mais sa
projection frontend avait aplati tous les chemins et rendu le contenu dans un
simple bloc texte. Le bundle local CodeMirror 6 restait présent sans être
chargé ni piloté par le chemin du fichier.

R24 traite cette cause en restaurant :

- une arborescence de dossiers repliables construite depuis les chemins
  canoniques renvoyés par `source.list` ;
- le nom de fichier à chaque feuille et sa taille ;
- la sélection conservée via formulaire POST SCORE ;
- CodeMirror 6 local en lecture seule pour le fichier sélectionné ;
- la grammaire déterminée par l’extension du chemin ;
- le fallback textarea explicite si JavaScript ou CodeMirror est indisponible.

## Architecture obligatoire

```text
owasys-front SCORE
-> FSM + ACL + SSO
-> REST sécurisé
-> owasys-back
-> Composer allow-listé
-> projection source.list/source.read
-> ViewModel
-> SCORE
-> amélioration progressive locale de l’arbre et du visualiseur
```

Le navigateur ne reçoit aucun chemin physique. Il utilise exclusivement les
chemins relatifs autorisés renvoyés par le backend. Aucun CDN, accès filesystem
frontend, endpoint monolithique `sites/owasys` ou rendu PHP/HTML n’est permis.

## Coloration

Le bundle contractuel `OWASYS_CODEMIRROR_6_V1` sélectionne notamment :

```text
.php
.json
.js .mjs .cjs
.css
.html .htm
.sql
.md .markdown
.score
```

Le visualiseur R24 reste en lecture seule. Les futures opérations d’écriture
doivent continuer à traverser REST, le backend et Composer avec aperçu,
validation et contrôle d’intégrité.

## Validation

```text
ZIP : opus_p117w_r24_source_tree_and_syntax_highlighting.zip
SHA-256 : 980b1cce3fde606fc907b8b524c8ee61785159b30bbe4fd8ec8653dfd6da7edd
Fichiers : 20
```

```text
php -l sites\owasys-front\application\source\controllers\SourceController.php
node --check sites\owasys-front\www\asset\js\source-browser.js
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
git diff --check
git status --short
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
