# Handoff — OPUS reborn P3 root cleanup audit

Date: 2026-06-22
Projet: OPUS
Repository: philstephibanez-wq/OPUS

## État validé avant P3

- P0 cleanup OPUS reborn validé.
- P1 boot/render smoke validé.
- P1B View -> ScoreTemplate validé.
- P1D naming standardization validé.
- P2 singleton/accessor contract validé.
- Git local utilisateur propre après push `P2_OPUS_SINGLETON_ACCESSOR_CONTRACT`.

## Décision utilisateur

L'utilisateur signale que `OPUS/Opus` contient encore trop de fichiers directement à la racine et questionne les wrappers modernes comme `Acl.php`.

Décision: ne pas sortir les sites maintenant. D'abord auditer la propreté de la racine framework.

## P3 livré

P3 est un audit read-only.

Fichiers ajoutés dans OPUS:

```text
tools/audit_opus_root_cleanup_p3.py
DOC/OPUS_ROOT_CLEANUP_P3.md
```

Objectif:

```text
- lister les fichiers suivis à la racine du repo;
- lister les fichiers directs sous Opus/;
- classer les fichiers directs Opus/ en KEEP_CORE, KEEP_FACADE_REVIEW, MODERN_LAYER_REVIEW, ROOT_WRAPPER_REVIEW, REVIEW_UNKNOWN;
- scanner les références aux wrappers racine Acl/Fsm/I18n/Router;
- lister les scripts outils directement sous tools/ pour future archive/suppression contrôlée.
```

## Prochaine commande utilisateur

```cmd
cd /d H:\OPUS
git pull --ff-only
python tools\audit_opus_root_cleanup_p3.py
git status --short
```

## Prochaine étape logique

Après audit:

```text
P3B_OPUS_ROOT_WRAPPER_DECISION
```

But: traiter uniquement les wrappers évidents (`Acl.php`, `Fsm.php`, `I18n.php`, `Router.php`) après revue des références.

Ne pas toucher à `sites/`, `vendor/`, `var/`, ni à `Kernel/Package` dans P3B sans décision explicite.
