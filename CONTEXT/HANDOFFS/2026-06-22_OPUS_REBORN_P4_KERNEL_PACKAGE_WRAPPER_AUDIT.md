# Handoff — OPUS reborn P4 Kernel / Package / wrappers audit

Date: 2026-06-22
Scope: OPUS framework cleanup

## Etat valide avant P4

- P0 cleanup valide.
- P1 boot/render smoke valide.
- P1B View -> ScoreTemplate valide.
- P1D naming standardization valide.
- P2 singleton/accessor contract valide.
- P3B tools layout valide.

## Decision utilisateur

L'utilisateur confirme que :

- OPUS doit rester simple et proche de l'esprit ASAP.
- OPUS doit avoir un singleton par site/application.
- Les getter/setter automatiques sont a conserver.
- Les variables de classe doivent rester protegees.
- Les classes ne doivent pas multiplier les getter/setter manuels.
- La racine `Opus/` contient encore trop de fichiers.
- `Acl.php`, `Fsm.php`, `I18n.php`, `Router.php` a la racine sont suspects.

## Livraison P4

Ajouts dans `philstephibanez-wq/OPUS` :

- `tools/audits/audit_opus_kernel_package_wrapper_p4.py`
- `DOC/OPUS_KERNEL_PACKAGE_WRAPPER_P4.md`

## Intention P4

Audit read-only de :

- `Kernel.php`
- `Package.php`
- `PackageRepository.php`
- `Request.php`
- `Response.php`
- `Support.php`
- `View.php`
- wrappers racine `Acl.php`, `Fsm.php`, `I18n.php`, `Router.php`

Aucune suppression et aucun deplacement avant decision.

## Commande locale

```cmd
cd /d H:\OPUS
git pull --ff-only
python tools\audits\audit_opus_kernel_package_wrapper_p4.py
git status --short
```

## Suite probable

- P4B : inspecter les classes historiques correspondantes.
- P4C : decider du sort de `Kernel`.
- P4D : deplacer ou supprimer les wrappers racine seulement apres decision.
