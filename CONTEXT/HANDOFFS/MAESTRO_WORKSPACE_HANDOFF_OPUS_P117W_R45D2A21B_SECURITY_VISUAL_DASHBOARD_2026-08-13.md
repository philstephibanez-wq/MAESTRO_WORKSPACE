# HANDOFF — OPUS P117W R45D2A21B Security Visual Dashboard

Date : 2026-08-13

## Contexte

R45D2A21 a été appliqué et a rendu la page Sécurité fonctionnelle avec séparation Utilisateurs / Agents / À classifier, mais l’owner a rejeté le résultat visuel (« pas terrible »).

Le problème n’est pas le modèle de sécurité : il est UX et hiérarchique.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a21b_security_visual_dashboard.zip
SHA-256 : 0ccf2e5d71260dc3917bbc79aab39f817cb4a4bbd5266d3a02707b2de616cca6
PREREQ  : R45D2A21 appliqué
FILES   : 3
```

## Changements

- dashboard sécurité compact ;
- métriques Utilisateurs / Agents / Rôles / Ressources ;
- flow graphique compact ;
- CTA « Ajouter un utilisateur ou un agent » remonté avant les listes ;
- sélecteur graphique Utilisateur/Agent sans JS ;
- deux panneaux principaux Utilisateurs et Agents ;
- détails provider/source repliés ;
- bloc legacy « À classifier » compact ;
- compteurs sur accordéons Rôles / Permissions / Attributions / Ressources ;
- `OWASYS_SECURITY_MUTATION_WORKFLOW_STATE_INVALID` expliqué en langage utilisateur sans supprimer la garde FSM ;
- I18n UE + ukrainien.

## Gate

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45d2a21b_security_visual_dashboard.zip"
php tools\r45d2a21b_apply_security_visual_dashboard.php
php tools\smoke_r45d2a21b_security_visual_dashboard.php
php -l sites\owasys-front\application\security\controllers\SecurityController.php
composer dump-autoload -o
git status --short
```

Résultats obligatoires :

```text
OPUS_R45D2A21B_APPLIED locales=25
OPUS_R45D2A21B_SMOKE_OK locales=25
```

Puis redémarrer front/back et contrôler visuellement la page Sécurité comme `developer`.

## Important

Ne pas commit/push OPUS/OWASYS par l’assistant.

Ne pas implémenter visuellement Modifier/Supprimer tant que les mutations backend correspondantes ne sont pas atomiques et couvertes par fresh-auth, Preview/Commit, rollback et protection du dernier administrateur.
