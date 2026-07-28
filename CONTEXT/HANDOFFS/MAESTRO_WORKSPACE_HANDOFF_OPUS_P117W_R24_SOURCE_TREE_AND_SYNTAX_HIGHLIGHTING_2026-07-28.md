# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R24

Date : 2026-07-28  
État : livrable cumulatif R22 + R23 + R24 à appliquer et valider côté owner

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base exacte : 4868780af4dd65bb7e28d95c981d1a1c5800a243
Racine owner : H:\OPUS
```

## Correction

R24 restaure dans `owasys-front` les deux capacités perdues lors de R21 :

```text
liste plate                  -> arborescence repliable
bloc de texte sans grammaire -> CodeMirror 6 local avec coloration par extension
```

Les chemins et contenus continuent de provenir exclusivement de :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer
```

Le rendu initial reste SCORE. JavaScript applique uniquement une amélioration
progressive à la projection SCORE déjà fonctionnelle. Aucun ancien site
`sites/owasys`, endpoint monolithique, CDN ou accès filesystem frontend n’est
restauré.

## Livrable

```text
ZIP : opus_p117w_r24_source_tree_and_syntax_highlighting.zip
SHA-256 : 980b1cce3fde606fc907b8b524c8ee61785159b30bbe4fd8ec8653dfd6da7edd
Fichiers : 20
Base : OPUS master 4868780af4dd65bb7e28d95c981d1a1c5800a243
Contenu : R22 + R23 + R24 cumulatif
```

## Validation owner

```text
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r24_source_tree_and_syntax_highlighting.zip" -C H:\OPUS
php -l sites\owasys-front\application\source\controllers\SourceController.php
node --check sites\owasys-front\www\asset\js\source-browser.js
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
git diff --check
git status --short
```

## Lancement

```text
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
```

Valider ensuite dans `Sources et Git` :

```text
arborescence repliable
fichier courant signalé
coloration PHP et JSON
absence de requête CDN
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
