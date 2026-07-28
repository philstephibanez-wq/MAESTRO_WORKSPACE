# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R25

Date : 2026-07-28  
État : correctif différentiel de navigation à appliquer et valider côté owner

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base exacte : 544d512b79bac4ca7dab8ac103dd9ff2266593fd
Racine owner : H:\OPUS
```

## Cause corrigée

Le layout commun R24 exigeait `source.browser_enabled`, mais les ViewModels
hors de la page Sources ne définissaient pas `source`. SCORE strict levait
une `ContractException` après la transition réussie vers Applications.

R25 normalise ce contrat dans `OwasysScorePageRenderer` avec la valeur
`false` par défaut. `OwasysSourceController` conserve explicitement
`true`.

## Livrable

```text
ZIP : opus_p117w_r25_score_layout_navigation_contract.zip
SHA-256 : 2762bd9b2a6ae04396168bc7a33793512b084c22cb952504b23cf80246384f3a
Fichiers : 1
Base : OPUS master 544d512b79bac4ca7dab8ac103dd9ff2266593fd
```

## Validation owner

```text
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r25_score_layout_navigation_contract.zip" -C H:\OPUS
php -l sites\owasys-front\application\default\services\ScorePageRenderer.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
git diff --check
git status --short
```

Lancer les deux applications puis vérifier :

```text
Applications -> Sources -> plusieurs fichiers -> Applications
Applications -> Nouvelle application -> Applications
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
