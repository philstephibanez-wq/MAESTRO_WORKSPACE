# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-25

## Lecture obligatoire

```text
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117U_HF8_GENERATED_SITE_I18N_EU_UK_DIAGNOSTICS_SPEC_2026-07-24.md
CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF9_CREATION_FORM_LAYOUT_SPEC_2026-07-24.md
CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF9R1_CREATION_ASSET_SCOPE_AND_FRONT_BACK_DECISION_2026-07-25.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_OWASYS_P117U_HF9R1_CREATION_ASSET_SCOPE_2026-07-25.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source de vérité

```text
OPUS repository : philstephibanez-wq/OPUS
branch          : master
head            : f9d01dca6644f41c10b85fd6da47eb8c21bf15b6
workspace       : philstephibanez-wq/MAESTRO_WORKSPACE master
```

HF7, HF8 sont committés sur OPUS. HF9 a été appliqué localement. HF9R1 corrige la régression introduite par HF9.

## État runtime

```text
/fr-FR/applications/new : OK
/fr-FR/applications     : HS après HF9
```

Le journal backend fourni contient 7 synchronisations Registry complètes :

```text
operation         : registry.sync
Composer          : owasys:registry-sync
exit_code=0       : 7/7
stderr_bytes=0    : 7/7
FSM succeeded     : 7/7
site.create       : 0
```

Aucune création d’application n’a encore été soumise.

## Cause HF9

Le layout SCORE commun référence conditionnellement `assets.creation_css`.

Cette clé est fournie par `OwasysCreationController`, mais pas par `OwasysRuntimeController` qui rend `/applications`.

La feuille spécifique Creation a donc été introduite dans une frontière de données non commune.

## Différentiel HF9R1

```text
ZIP     : opus_owasys_p117u_hf9r1_creation_asset_scope_fix.zip
SHA-256 : 301f461443ec934ddab06ef9883e48a827534a9acc5d8cc235434c1f84e5440e
PATHS   : 2
BASE    : HF9 appliqué sur f9d01dca6644f41c10b85fd6da47eb8c21bf15b6
```

Contenu :

```text
sites/owasys/application/default/layouts/layout.score
sites/owasys/application/creation/templates/index.score
```

Le layout commun ne dépend plus de `assets.creation_css`. Le template SCORE Creation charge lui-même son asset spécifique.

Aucune classe concrète OPUS n’est ajoutée ou modifiée. REST, Composer, FSM, I18n, ACL, SSO, Logger et Profiler restent inchangés.

## Décision architecture front/back

Le contrat `OPUS_SITE_STANDARD_CONTRACT_CORE` impose :

```text
sites/<site>/application/default/
sites/<site>/application/<controller-or-feature>/
```

La structure suivante n’est donc pas autorisée sans évolution générique OPUS :

```text
application/front/
application/back/
```

Recommandation actuelle : conserver les modules fonctionnels directs sous `application` et maintenir la frontière :

```text
SCORE UI
-> REST typé et sécurisé
-> FSM backend
-> Composer allow-listé
-> service/provider
```

Une séparation physique front/back nécessite une décision owner explicite et une évolution du contrat, du scaffold, du bootstrap et de la découverte des modules OPUS. Aucune migration locale OWASYS ne doit être engagée avant cette décision.

## Installation HF9R1

1. extraire le ZIP à la racine de `H:\OPUS` ;
2. recharger `/fr-FR/applications` avec Ctrl+F5 ;
3. vérifier `/fr-FR/applications/new` ;
4. tester Annuler ;
5. ne créer aucune fixture avant validation des deux routes.

## Nettoyage

Aucun nettoyage requis. Préserver :

```text
sites/owasys_old
sites/owasys/var/logs
sites/owasys/var/profiler
sites/owasys/var/registry
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
