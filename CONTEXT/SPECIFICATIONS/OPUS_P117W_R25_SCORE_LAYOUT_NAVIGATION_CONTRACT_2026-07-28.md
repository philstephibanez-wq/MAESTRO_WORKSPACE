# OPUS P117W R25 — CONTRAT SCORE DU LAYOUT ET NAVIGATION

Date : 2026-07-28  
Statut : spécification contractuelle et livrable différentiel à valider côté owner

## Source de vérité

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base exacte : 544d512b79bac4ca7dab8ac103dd9ff2266593fd
Racine owner : H:\OPUS
R22, R23 et R24 : appliqués sur master
```

## Régression et cause

R24 a ajouté dans le layout SCORE commun :

```text
[[ if: source.browser_enabled ]]
```

Le ViewModel de `OwasysSourceController` fournissait ce nœud, mais les pages
rendues par `OwasysRuntimeController` et `OwasysCreationController` ne le
fournissaient pas. Le moteur SCORE strict levait donc une
`Opus\Contract\ContractException` lors du retour de Sources vers
Applications et sur toute autre route partageant le layout sans contexte
`source`.

La synchronisation Registry et la transition FSM terminaient correctement ;
la panne survenait au rendu du layout partagé.

## Correction contractuelle

`OwasysScorePageRenderer` normalise le ViewModel commun avant tout rendu :

```text
source.browser_enabled = false
```

Un contrôleur spécialisé peut remplacer cette valeur par `true`. Sources
conserve donc CodeMirror et son arborescence ; toutes les autres pages
satisfont le contrat total du layout sans charger les scripts Sources.

Cette normalisation centrale traite la cause et évite une duplication dans
chaque contrôleur.

## Validation

```text
ZIP : opus_p117w_r25_score_layout_navigation_contract.zip
SHA-256 : 2762bd9b2a6ae04396168bc7a33793512b084c22cb952504b23cf80246384f3a
Fichiers : 1
Base : OPUS master 544d512b79bac4ca7dab8ac103dd9ff2266593fd
```

Scénario obligatoire :

```text
Applications -> sélectionner owasys-back -> Sources
-> ouvrir plusieurs fichiers -> Applications
-> Nouvelle application -> Applications
```

Chaque page doit rendre sans `ContractException`. CodeMirror doit être chargé
uniquement sur Sources.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
