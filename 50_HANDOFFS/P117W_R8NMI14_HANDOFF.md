# P117W R8NMI14 — Handoff

Status: awaiting owner validation
Date: 2026-09-07

## Evidence

- `owasys-front/config/fsm.json` contient `t_critical_error` et `t_security_violation` comme NMI hôte `from = *`.
- Les micro-EFSM front contextuels ne les contiennent pas.
- `OwasysFsmDiagramBuilder::build()` bascule vers `buildSelectedApplicationEfsm()` dès qu'un contexte EFSM est actif ; R8NMI13 ne suffisait donc pas à la vue réellement observée.
- Le log `owasys-front` du 2026-09-07 contient 41 clés distinctes `OPUS_I18N_MESSAGE_MISSING` en `fr-FR`.
- Le catalogue GitHub autoritaire `fr-FR.json` baseline a le blob `a312267ec5409c4e8ea2ec75bb9fff6ca833c7d3`.

## Livrable

ZIP: `R8NMI14.zip`

SHA-256 ZIP: `57a3be2fc19a3a7416a43604335ec275ccaedc2016f608f499cac8f90a921d55`

Fichiers complets :

- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
  - SHA-256: `7cd58b610412c51f51e473ea6ed6acefd56059d8ab47addc056075025ca9ea30`
- `sites/owasys-front/application/default/local/fr-FR.json`
  - SHA-256: `fbc740a73ea3acbdabf89e82b584a2c36632f3c6586cd0b83487e47610c1e43f`

## Changement fonctionnel

- Les micro-EFSM hôte du front héritent, pour le rendu uniquement, des NMI canoniques de la FSM racine.
- L'héritage NMI ne modifie pas la définition source incluse dans le payload designer.
- Le catalogue exact `fr-FR` couvre les 41 clés manquantes observées dans le log et ajoute les labels français des deux états et deux transitions NMI hérités.

## Validation effectuée avant livraison

- `php -l FsmDiagramBuilder.php`: OK ;
- parse JSON `fr-FR.json`: OK ;
- baseline `fr-FR.json` byte-identique au blob GitHub `a312267ec5409c4e8ea2ec75bb9fff6ca833c7d3` avant modification ;
- archive limitée aux deux fichiers complets attendus.

## Gate owner

1. Vérifier l'état local des deux fichiers.
2. Sauvegarder hors source.
3. Vérifier contenu et SHA du ZIP.
4. Extraire dans `H:\OPUS`.
5. Linter PHP, valider JSON, `git diff --check`, `opus:validate-site`.
6. Retourner la sortie complète avant test runtime.

Après validation statique : démarrer `owasys-front`, ouvrir un contexte micro-EFSM hôte et vérifier les deux NMI ainsi que l'absence des warnings I18n ciblés.

Aucun commit/push OPUS/OWASYS par l'assistant.
