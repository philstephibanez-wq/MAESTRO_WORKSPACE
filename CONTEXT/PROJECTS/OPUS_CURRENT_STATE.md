# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-10.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 62ed6c6b7440034c5855e310899fb11d605fdf00
Commit : opus_p117w_r45d2a5_generated_profiler_iframe_integration
```

Historique immédiat :

```text
62ed6c6b7440034c5855e310899fb11d605fdf00  opus_p117w_r45d2a5_generated_profiler_iframe_integration
dfab7d0ae9fe8456887ff3f1f0280c0141f27b26  opus_p117w_r45d2a3_generated_login_observability
f634e337ec0b5df0020bfba6eb240da0395a05bd  cleanup essai
052cc6e177875f9606051bf0f34a2a1f16865329  opus_p117w_r45d2a2_generated_local_password_runtime
01b146876fd96282dfd0f618dc84341b49d6eec6  essai2 !
```

## États acquis / publiés

- R45C3R1 : workflow OWASYS structuré acquis.
- R45D1 : workspace Sécurité réel acquis.
- R45D2 : mutations additives publiées ; preview/commit complète reste à valider.
- R45D2A1 : création sécurité canonicalisée.
- R45D2A2 : redirection login + provisioning local-password runtime.
- R45D2A3 : observabilité login publiée.
- R45D2A5 : iframe Profiler générée publiée.

## Site essai2

Le login navigateur échoue encore avec `Authentication failed`.

La capture owner du 2026-08-10 montre désormais la page `/fr/login` conservée avec le Profiler intégré et repliable. Le problème de navigation-away est donc acquis après la surface R45D2A6 locale.

La même capture montre toutefois `Security / ACL / SSO = 0`. Ce compteur est faux pour les événements hiérarchiques : `GeneratedSiteRuntime` émet `security.sso`, tandis que `WebProfilerView::buildPanels()` filtre par égalité stricte contre `security`, `acl`, `sso`, `auth`.

La cause SSO du refus de credential n'est donc toujours pas lisible dans le panneau tant que cette projection n'est pas corrigée.

## Profiler

Les `.lock` persistants sont des sidecars de synchronisation et restent normaux.

Le Web Profiler fonctionne et l'iframe same-origin est intégrée. Le panneau doit rester repliable/masquable sans JavaScript et sans remplacer la page applicative.

R45D2A7 corrige la projection des catégories hiérarchiques `racine.*` dans les panneaux du Profiler. Le matching exact reste supporté et aucun événement n'est synthétisé.

## Livrable actif — R45D2A7

```text
ZIP     : opus_p117w_r45d2a7_profiler_hierarchical_categories.zip
SHA-256 : cae99b491d5d8c988f3a8d8a59d9cd4775bd902358e7e1749fbb552e2d1d8d35
BASE    : 62ed6c6b7440034c5855e310899fb11d605fdf00
FILES   : 2
```

Fichiers :

```text
Opus/Profiler/WebProfilerView.php
Opus/Application/Runtime/templates/profiler-iframe.score
```

R45D2A7 supersède R45D2A6 et conserve la surface `<details>/<summary>` repliable.

Validation assistant : PHP lint OK sur `WebProfilerView.php`; matching hiérarchique générique ajouté ; aucun changement ACL/SSO ; aucun patch `essai2`.

## Suite

1. owner applique R45D2A7 sur le master OPUS publié ;
2. relance `essai2` ;
3. reproduit le POST login `steve` ;
4. ouvre le panneau `Security / ACL / SSO` ;
5. relève `authentication.failed` et son `error_code` ;
6. corriger uniquement cette cause SSO prouvée ;
7. reprendre ensuite la validation R45D2 preview/commit avec fresh-auth OWASYS.

NO SITE-SPECIFIC PATCH.
NO VALIDATOR RELAXATION.
NO SILENT FALLBACK.
NO ACL/SSO RELAXATION.
NO PROFILER NAVIGATION-AWAY.
NO PROFILER LOCK PURGE.
NO PUSH OPUS BY ASSISTANT.
