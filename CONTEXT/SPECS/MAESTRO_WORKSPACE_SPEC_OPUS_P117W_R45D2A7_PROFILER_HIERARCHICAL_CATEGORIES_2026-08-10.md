# SPEC — OPUS P117W R45D2A7 PROFILER HIERARCHICAL CATEGORIES

Date : 2026-08-10

## Base canonique

OPUS master observé : `62ed6c6b7440034c5855e310899fb11d605fdf00` (`opus_p117w_r45d2a5_generated_profiler_iframe_integration`).

## Incident confirmé

Après intégration repliable de l’iframe Profiler, la page `/fr/login` reste visible et le Profiler peut être masqué. Cette partie est acquise visuellement.

Le POST de login affiche néanmoins `Authentication failed` tandis que le panneau `Security / ACL / SSO` affiche `0`.

La cause est générique dans `Opus/Profiler/WebProfilerView.php` : les événements sont filtrés par égalité stricte de catégorie. `GeneratedSiteRuntime` émet notamment la catégorie hiérarchique `security.sso`, qui ne peut donc pas correspondre aux clés de panneau `security`, `acl`, `sso`, `auth`.

## Contrat R45D2A7

Le Web Profiler doit reconnaître une catégorie soit par égalité exacte, soit comme descendante hiérarchique `racine.*`.

Exemples :

- `security.sso` -> panneau Security / ACL / SSO ;
- `rest.client` -> panneau REST ;
- `http.request` -> panneau Request / Response ;
- `composer.command` -> panneau Composer.

Aucun événement ne doit être inventé, recatégorisé ou dupliqué. Le correctif porte uniquement sur la projection des événements réellement collectés.

R45D2A7 conserve également l’iframe Profiler sous surface native `<details>/<summary>` sans JavaScript, afin que le livrable supersède R45D2A6 sur la base GitHub R45D2A5.

## Authentification essai2

Aucune relaxation ACL/SSO et aucun patch spécifique `essai2` ne sont autorisés. Après R45D2A7, reproduire le POST de login et lire l’événement `security.sso / authentication.failed` ainsi que son `error_code`. La correction SSO suivante devra traiter uniquement cette cause prouvée.

NO SITE-SPECIFIC PATCH.
NO ACL/SSO RELAXATION.
NO SILENT FALLBACK.
NO PROFILER NAVIGATION-AWAY.
