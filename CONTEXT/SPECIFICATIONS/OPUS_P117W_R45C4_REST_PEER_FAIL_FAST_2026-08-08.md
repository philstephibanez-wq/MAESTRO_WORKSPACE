# OPUS P117W R45C4 — REST PEER FAIL-FAST

Date initiale : 2026-08-08
Dernière mise à jour : 2026-08-09
Statut : RETIRÉ / NON ACQUIS

## Décision

Le livrable R45C4 précédent est retiré et ne doit plus être appliqué.

Motifs :

- le ZIP contenait un script d'application au lieu des fichiers complets à leurs chemins finaux, en contradiction avec `README-FIRST.md` ;
- le script exigeait le HEAD global `058984bfb0229bf5f27c74cd2b59c6614bf74b4e` alors que le retour owner montre un HEAD local `0e0e54857214144d6c98ebec85cf9eee007676a0` ;
- ce HEAD local n'est pas publié sur GitHub et la source live exacte n'a donc pas été relue avant livraison ;
- le smoke séparé était invoqué depuis `Downloads` sans garantie qu'il y soit présent ;
- la proposition de préflight TCP n'est pas considérée acquise et doit être réévaluée à partir de la source live et de l'état réel des deux bastions OWASYS.

## Source de vérité disponible

Le dépôt GitHub `philstephibanez-wq/OPUS` publie toujours :

```text
058984bfb0229bf5f27c74cd2b59c6614bf74b4e
opus_p117w_r45c2_dev_preview_runtime_fix
```

Le retour owner local indique :

```text
0e0e54857214144d6c98ebec85cf9eee007676a0
```

Ce commit n'est pas résolvable sur GitHub au moment de la relecture.

## Incident runtime à reprendre

Le front OWASYS renvoie HTTP 500 sur `/fr-FR/applications`.

La pile précédemment observée est :

```text
owasys-front
-> RegistryModel::synchronize()
-> Opus\Api\Rest\RestClient::request()
-> fopen()
-> Maximum execution time exceeded
```

Cette pile ne suffit pas à valider la correction précédente. Il faut relire la source owner live, l'état du backend et les contrats de développement avant tout nouveau patch.

## Gate avant nouvelle correction

```text
NO SOURCE OF TRUTH, NO PATCH.
NO CONTRACT, NO PATCH.
NO BRICOLAGE DELIVERY.
```

Le prochain ZIP différentiel devra :

- être fondé sur la source live owner exacte ;
- contenir uniquement les fichiers complets modifiés à leurs chemins finaux ;
- ne contenir ni script `apply_*`, ni smoke, ni log, ni rapport ;
- être validé avec `owasys-back` et `owasys-front` réellement lancés selon leurs contrats respectifs ;
- ne pas être déclaré acquis avant validation runtime end-to-end.

Voir :

`CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_INCIDENT_OPUS_P117W_R45C3_R45C4_DELIVERY_INVALID_2026-08-09.md`

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO AUTO-START CROSS-APPLICATION.
NO FSM MERGE.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
