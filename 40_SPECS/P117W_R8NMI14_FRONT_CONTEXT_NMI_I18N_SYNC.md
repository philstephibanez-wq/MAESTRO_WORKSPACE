# P117W R8NMI14 — NMI héritées dans les micro-EFSM front et synchronisation fr-FR

Status: DELIVERED — validation owner requise
Date: 2026-09-07

## Autorité

Cette évolution applique `README-FIRST.md`, le contrat ZIP natif différentiel, le workflow stepwise et le Security Baseline Contract.

## Causes prouvées

### NMI front

`sites/owasys-front/config/fsm.json` contient les NMI canoniques hôte :

- `t_critical_error`: `* --critical_error / NMI--> fault` ;
- `t_security_violation`: `* --security_violation / NMI--> security_quarantine`.

R8NMI13 a corrigé la projection de la FSM hôte racine, mais la vue réellement utilisée par OWASYS front lorsqu'un contexte est actif passe par `OwasysFsmDiagramBuilder::buildSelectedApplicationEfsm()`. Cette méthode rend la définition du micro-EFSM contextuel (`navigation.fsm.json`, `security.fsm.json`, etc.) telle quelle. Ces micro-EFSM ne contiennent pas les NMI racines : elles restent donc absentes du diagramme front malgré R8NMI13.

## Correction NMI R8NMI14

Pour les contextes hôte uniquement (`OwasysContextEfsmRegistry::isHostEfsm()`), le builder construit une définition de rendu dérivée qui hérite des NMI de `config/fsm.json` :

1. lecture de la FSM hôte via le loader existant ;
2. sélection exclusive des transitions `interrupt = nmi` ;
3. validation `from = *`, signal déclaré, cible déclarée ;
4. ajout au rendu des états cibles, signaux et transitions NMI absents du micro-EFSM ;
5. aucune réécriture de la définition source du micro-EFSM ;
6. le `designer_payload.definition` demeure la définition canonique du micro-EFSM afin que l'héritage visuel ne soit jamais persisté dans le fichier source ;
7. le renderer OPUS et `owasys-back` restent inchangés.

## I18n fr-FR

Les logs front du 2026-09-07 montrent 41 clés distinctes `OPUS_I18N_MESSAGE_MISSING` en `fr-FR`. Le catalogue GitHub autoritaire `sites/owasys-front/application/default/local/fr-FR.json` a le blob `a312267ec5409c4e8ea2ec75bb9fff6ca833c7d3` et ne contient pas ces clés.

R8NMI14 ajoute les 41 clés constatées au runtime, notamment les familles `auth.*`, `registry.*`, `security.*`, `source.*`, `git.*`, ainsi que quatre labels génériques de rendu NMI en français.

La correction ne met en place aucun fallback silencieux et ne modifie pas le contrat de résolution par locale exacte.

## Fichiers livrés

- `sites/owasys-front/application/default/services/FsmDiagramBuilder.php`
- `sites/owasys-front/application/default/local/fr-FR.json`

## Critères d'acceptation

- PHP lint OK ;
- JSON `fr-FR.json` valide ;
- `composer opus:validate-site -- owasys-front` OK ;
- dans un micro-EFSM hôte front, les NMI `t_critical_error` et `t_security_violation` sont visibles ;
- `fault` et `security_quarantine` sont visibles comme états de contrôle hérités ;
- la définition source du micro-EFSM n'est pas enrichie/persistée avec ces NMI ;
- les warnings I18n correspondant aux 41 clés observées disparaissent en `fr-FR` ;
- aucun changement dans `owasys-back` ni dans le renderer OPUS ;
- toute divergence ou régression est une stop condition.
