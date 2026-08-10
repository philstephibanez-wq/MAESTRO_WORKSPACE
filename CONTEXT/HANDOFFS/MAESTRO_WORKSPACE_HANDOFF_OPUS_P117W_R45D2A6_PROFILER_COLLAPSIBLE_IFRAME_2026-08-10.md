# HANDOFF — OPUS P117W R45D2A6 PROFILER COLLAPSIBLE IFRAME

Date : 2026-08-10

## Base

```text
OPUS master = 62ed6c6b7440034c5855e310899fb11d605fdf00
```

## Retour owner

R45D2A5 n'est pas validé fonctionnellement : le Profiler occupe la page et ne peut plus être masqué.

Analyse du code publié : `profiler-iframe.score` contient une section + iframe fixe de hauteur 720 px, sans contrôle d'ouverture/fermeture. La cause est donc dans le composant générique OPUS, pas dans `essai2`.

## Livrable R45D2A6

```text
ZIP     : opus_p117w_r45d2a6_profiler_collapsible_iframe.zip
SHA-256 : 002218b5223511c6becaf732b0c17db81f8a1962573dc4908053c259724f5717
BASE    : 62ed6c6b7440034c5855e310899fb11d605fdf00
FILES   : 1
```

Fichier :

```text
Opus/Application/Runtime/templates/profiler-iframe.score
```

Effet : remplacement de la section permanente par un `<details>` SCORE avec `<summary>` et iframe same-origin. La page reste présente et le Profiler peut être ouvert/replié sans navigation et sans JavaScript.

## essai2 / login

Toujours NON ACQUIS.

Le workspace documente `steve` actif dans le store runtime local-password. Il faut donc relever la preuve du POST de login :

```text
security.sso
authentication.failed
error_code=<code>
```

Commande de lecture locale recommandée :

```cmd
findstr /I /C:"authentication.failed" sites\essai2\var\logs\essai2.log
```

Ne pas corriger `essai2` localement. Le prochain patch SSO doit traiter uniquement la cause générique prouvée par ce code.

NO SITE-SPECIFIC PATCH.
NO ACL/SSO RELAXATION.
NO PROFILER NAVIGATION-AWAY.
NO PUSH OPUS BY ASSISTANT.
