# SPEC — OPUS P117W R45D2A10 LOGIN PRG PROFILER CORRELATION

Date : 2026-08-10

## Base canonique

OPUS master = `6dbc92bd48e03ba84325f6d68c304c76f73026e1`

## Incident confirmé

R45D2A9B fournit correctement le message utilisateur I18n après échec de connexion via POST -> 303 -> GET. En revanche, le Web Profiler embarqué affiche la trace du GET de retour. La trace du POST ayant réellement produit `security.sso.authentication.failed` est perdue pour la surface affichée et le panneau `Security / ACL / SSO` retombe artificiellement à 0.

## Cause

Le `trace_id` du POST d'authentification n'est pas transporté dans le flash PRG. `ProfilerLinkProvider` enrichit donc le GET avec la trace active du GET au lieu de la trace fautive du POST.

## Contrat R45D2A10

- conserver le message utilisateur I18n non discriminant ;
- conserver le cycle POST -> 303 -> GET ;
- stocker temporairement le `trace_id` du POST échoué dans la session flash ;
- consommer simultanément le flash utilisateur et le `trace_id` sur le GET ;
- après enrichissement normal du Profiler, substituer uniquement l'URL de l'iframe par la trace du POST corrélé ;
- ne synthétiser aucun événement ;
- ne modifier ni ACL ni politique SSO ;
- ne jamais exposer username, password ou hash ;
- supprimer le `trace_id` flash après consommation ;
- supprimer également tout flash d'erreur lors d'une authentification réussie.

NO SITE-SPECIFIC PATCH.
NO ACL/SSO RELAXATION.
NO SYNTHETIC PROFILER EVENT.
NO SECRET IN PROFILER.
NO PUSH OPUS BY ASSISTANT.
