# SPEC — OPUS P117W R45D2A6 PROFILER COLLAPSIBLE IFRAME

Date : 2026-08-10

## Base canonique

```text
OPUS master = 62ed6c6b7440034c5855e310899fb11d605fdf00
R45D2A5 = opus_p117w_r45d2a5_generated_profiler_iframe_integration
```

## Incident confirmé

R45D2A5 remplace la navigation directe par un iframe SCORE, mais l'iframe est injecté comme une section permanente de 720 px sans mécanisme natif de fermeture/repli. Le Profiler occupe donc la surface de la page et ne peut plus être masqué.

## Contrat R45D2A6

Le Profiler généré doit :

1. conserver intégralement la page applicative courante ;
2. charger la trace courante uniquement dans un iframe same-origin ;
3. être ouvrable et refermable sans navigation ;
4. ne nécessiter aucun JavaScript pour le toggle ;
5. rester rendu via SCORE ;
6. conserver la route `/_opus/profiler/trace/<trace_id>` comme source de l'iframe ;
7. ne modifier ni ACL, ni SSO, ni FSM.

Implémentation retenue : composant SCORE `<details>/<summary>` contenant l'iframe.

## Login essai2

Le login reste NON ACQUIS. Le workspace documente un store runtime local-password actif pour `steve`; l'absence de `var/auth` dans GitHub n'est donc pas une preuve d'absence du store local, ce répertoire étant runtime/non versionné.

La prochaine preuve exigée est le `error_code` corrélé de `security.sso/authentication.failed` pour le POST de connexion. Aucun relâchement ACL/SSO et aucun patch spécifique à `essai2`.

NO SITE-SPECIFIC PATCH.
NO ACL/SSO RELAXATION.
NO PROFILER NAVIGATION-AWAY.
NO PUSH OPUS BY ASSISTANT.
