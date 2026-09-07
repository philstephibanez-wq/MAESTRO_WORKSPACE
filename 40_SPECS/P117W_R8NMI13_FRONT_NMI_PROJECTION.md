# P117W R8NMI13 — Projection des NMI sur OWASYS front

Status: DELIVERED — owner runtime acceptance pending
Date: 2026-09-07

## Autorité

Cette évolution applique `README-FIRST.md`, le contrat de livraison ZIP natif différentiel, le workflow stepwise et le Security Baseline Contract.

## Défaut prouvé

La FSM canonique `sites/owasys-front/config/fsm.json` contient notamment deux NMI :

- `* --critical_error / NMI--> fault` ;
- `* --security_violation / NMI--> security_quarantine`.

Le builder hôte `sites/owasys-front/application/default/services/FsmDiagramBuilder.php` supprimait explicitement toutes les transitions ayant `interrupt = nmi` avant l'appel au renderer OPUS. En outre, les états de destination NMI purs (`fault`, `security_quarantine`) ne faisaient pas partie du sous-ensemble construit depuis les seuls états de navigation visibles.

Le back sachant déjà représenter les NMI, ce défaut est local à la projection front, pas au renderer générique OPUS.

## Correction R8NMI13

Le builder front :

1. découvre et valide les transitions NMI canoniques ;
2. exige `from = *`, un signal déclaré et un état destination existant ;
3. ajoute les états de destination NMI au sous-ensemble du diagramme uniquement, sans les convertir en modules ni en entrées de navigation ;
4. place ces états purs sur un rang supplémentaire afin d'éviter de réutiliser le rang 0 des états sans hint de diagramme ;
5. projette chaque NMI avec sa sémantique canonique `from = *` ;
6. conserve intégralement les filtres et routages des transitions ordinaires/globales ;
7. conserve les actions de navigation fondées uniquement sur `$menuByState` ;
8. laisse `owasys-back` et le renderer OPUS inchangés.

## Fichier livré

`sites/owasys-front/application/default/services/FsmDiagramBuilder.php`

Baseline GitHub blob SHA-1 : `dc23e0303bf95e8315a401058343798b83356706`.

Baseline fichier SHA-256 : `9491b949b72695dbc637bd54a7cf674c062f4af0c599ea848a1224bcdd5c5dbf`.

Post-change fichier SHA-256 : `780175fa7cf71f30b844547c616db24364d3e8a127a0242bcde75c3dcc3f74d7`.

ZIP `R8NMI13.zip` SHA-256 : `b316ec801195222ef0bb39edda8d747e2973201a70bf89de43a1bea13a12b51a`.

## Validation préparée

- archive : un seul fichier complet au chemin final attendu ;
- test ZIP : OK ;
- `php -l` : OK.

## Critères d'acceptation propriétaire

- baseline locale conforme avant extraction ;
- ZIP et contenu conformes ;
- `php -l`, `git diff --check` et validation du site sans erreur ;
- le diagramme hôte du front affiche les NMI `critical_error -> fault` et `security_violation -> security_quarantine` ;
- les transitions ordinaires/globales restent présentes et inchangées ;
- les diagrammes de contexte applicatif restent inchangés ;
- aucun changement dans `owasys-back` ;
- aucune création de module factice pour les états de contrôle NMI ;
- aucun commit/push OPUS avant acceptation runtime.
