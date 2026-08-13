# OPUS P117W — R45D2A22 Role Capability Matrix Executable Contract

Date : 2026-08-13  
Statut : spécification active  
Prérequis owner : R45D2A21C appliqué et gate visuel accepté  
Base Git publiée : `50d68b724a1f32201bd068e0cb23c9f925780093`

## Déclencheur

La capture owner R45D2A21C valide la direction cockpit : dashboard, métriques, flow, quick-actions Utilisateur/Agent, panneaux principaux et dette legacy « À classifier » tiennent dans le premier viewport. Le gate visuel est donc fermé.

La suite contractuelle est la preuve exécutable de la matrice `admin / developer / viewer` avant toute implémentation de Modifier/Supprimer utilisateur ou agent.

## Objectif R45D2A22

R45D2A22 ajoute un smoke non destructif qui vérifie les décisions ACL front/back admin/developer/viewer, le deny-by-default, la liaison SCORE/contrôleurs et le refus viewer des mutations et du Profiler.

Le gate owner est acquis :

```text
OPUS_R45D2A22_ROLE_CAPABILITY_MATRIX_OK front_cases=66 back_cases=42
```

## Divergence navigateur révélée

Le gate viewer a validé Sécurité et Sources/Git. La capture Build du 2026-08-13 a cependant révélé une divergence : `viewer · viewer` voit encore le lien global `OPUS Profiler`.

L’audit de la cause montre :

- `application/build/templates/index.score` ne rend pas le lien ;
- `application/default/layouts/layout.score` rend le lien Profiler dans le `else` de `profiler.visible` sans garde ACL ;
- `application/default/services/ScorePageRenderer.php` détermine `profiler.visible` uniquement depuis `?profiler=1` ;
- le endpoint de trace possède déjà une garde `profiler:view`, mais les refus qui remontent au composition root sont rendus en 500 au lieu d’un 403 explicite.

## R45D2A22B — Profiler ACL Presentation Guard

R45D2A22B traite la cause au niveau partagé :

1. le composition root injecte `OwasysAuthSession` et `OwasysRuntimeSecurity` dans `OwasysScorePageRenderer` ;
2. le renderer calcule `profiler.allowed` uniquement via `RuntimeSecurity::isAllowed(identity, 'profiler', 'view')` ;
3. le layout SCORE n’affiche lien ou iframe que sous `[[ if: profiler.allowed ]]` ;
4. une requête directe `?profiler=1` non autorisée déclenche `OPUS_ACL_DENIED:profiler:view` ;
5. le composition root mappe toute erreur ACL de ce niveau sur HTTP 403 ;
6. aucun nom de rôle n’est codé dans le renderer ou le layout ;
7. admin/developer restent autorisés par ACL, viewer et rôle inconnu restent refusés.

## Livrable R45D2A22B

```text
ZIP     : opus_p117w_r45d2a22b_profiler_acl_presentation_guard.zip
SHA-256 : 7baa608c1a5c305d6d69cb8e7973de8b3f44e3f1d2c037a68e71def010db79b8
PREREQ  : R45D2A22 appliqué, R45D2A21C cockpit local
FILES   : 2
```

Fichiers du ZIP :

```text
tools/r45d2a22b_apply_profiler_acl_presentation_guard.php
tools/smoke_r45d2a22b_profiler_acl_presentation_guard.php
```

## Gate owner R45D2A22B

Exiger :

```text
OPUS_R45D2A22B_APPLIED
OPUS_R45D2A22B_PROFILER_ACL_PRESENTATION_GUARD_OK
OPUS_R45D2A22_ROLE_CAPABILITY_MATRIX_OK front_cases=66 back_cases=42
```

Puis navigateur `viewer` :

- Build reste lisible ;
- aucun lien `OPUS Profiler` ;
- `?profiler=1` retourne HTTP 403 et n’ouvre aucun panneau ;
- endpoint `/_opus/profiler/trace/<trace>` reste ACL-gardé ;
- reconnecter developer ensuite uniquement si nécessaire pour confirmer que le lien Profiler reste disponible.

Aucun passage à Modifier/Supprimer utilisateur ou agent avant fermeture complète du gate viewer.

NO ACL BYPASS.  
NO VIEWER PROFILER.  
NO PRIMARY_ROLE AUTHORIZATION.  
NO CSS-ONLY HIDING.  
NO FAKE UI-ONLY SECURITY.  
NO PUSH OPUS/OWASYS BY ASSISTANT.
