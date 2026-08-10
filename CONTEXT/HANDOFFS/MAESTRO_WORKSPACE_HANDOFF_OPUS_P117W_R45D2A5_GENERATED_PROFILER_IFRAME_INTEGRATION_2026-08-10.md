# HANDOFF — OPUS P117W R45D2A5 GENERATED PROFILER IFRAME INTEGRATION

Date : 2026-08-10

## Base canonique

```text
OPUS master = dfab7d0ae9fe8456887ff3f1f0280c0141f27b26
```

R45D2A3 est publié et fournit l’observabilité du login généré.

## Incident observé

Sur `essai2`, le lien Profiler ouvre `/_opus/profiler/trace/<trace_id>` dans la fenêtre principale. Le Profiler remplace donc la page de login alors que le contrat UI attendu est un Profiler embarqué.

La route Web Profiler fonctionne ; la régression est dans son intégration à la page générée. La capture montre également `SCORE = 0` malgré le rendu d’une page SCORE ; le runtime ne transmettait pas encore le Profiler aux renderers SCORE principaux.

## Livrable R45D2A5

```text
ZIP     : opus_p117w_r45d2a5_generated_profiler_iframe_integration.zip
SHA-256 : 08072a4a09963ce1f0e6dc61fece6be769cb43d54fb7bda3163a62acb757c1a5
BASE    : dfab7d0ae9fe8456887ff3f1f0280c0141f27b26
FILES   : 3
```

Fichiers :

```text
Opus/Application/Runtime/GeneratedSiteRuntime.php
Opus/Application/Runtime/templates/profiler-iframe.score
Opus/Profiler/ProfilerConfiguration.php
```

Effet attendu : page applicative conservée + trace courante dans iframe SCORE same-origin. Le lien direct historique est neutralisé dans le ViewModel après composition de l’iframe. Les renderers SCORE page/erreur/iframe alimentent le Profiler actif.

## Login `essai2`

Toujours NON ACQUIS.

R45D2A3 doit produire sur le POST de login :

```text
security.sso
authentication.failed
error_code=<code normalisé>
```

La capture Profiler fournie montre une trace avec une erreur mais `Security / ACL / SSO = 0`; elle ne suffit donc pas à déterminer la cause du credential refusé. Aucun patch SSO ne doit être émis avant le code corrélé du POST de connexion.

Après application de R45D2A5, reproduire le login `steve` et lire le panneau Security / ACL / SSO dans l’iframe de la même page, ou le Logger si nécessaire.

NO SITE-SPECIFIC PATCH.
NO ACL/SSO RELAXATION.
NO PROFILER NAVIGATION-AWAY.
NO PROFILER LOCK PURGE.
NO PUSH OPUS BY ASSISTANT.
