# MAESTRO WORKSPACE HANDOFF — OPUS P117W R45C4 REST PEER FAIL-FAST

Date : 2026-08-08

## Base publiée

```text
OPUS master
058984bfb0229bf5f27c74cd2b59c6614bf74b4e
opus_p117w_r45c2_dev_preview_runtime_fix
```

R45C2 est acquis.

R45C3 a été appliqué localement par l'owner sur cette base et sa projection FSM est visible comme attendu, mais son acquisition est bloquée par un défaut de transport REST lors de la navigation OWASYS.

## Retour owner

Le front a été lancé seul sur :

```text
http://127.0.0.1:8000
```

Lors de la page `Applications`, la pile atteint :

```text
RegistryModel::synchronize()
-> Opus\Api\Rest\RestClient::request()
-> fopen()
```

puis termine sur un `Maximum execution time exceeded`.

La navigation n'est donc pas bloquée par la nouvelle séquence FSM R45C3. Elle est bloquée au passage contractuel `owasys-front -> REST -> owasys-back`.

## Cause confirmée par la source

`sites/owasys-front/config/site.json` déclare comme peer de développement :

```text
application : owasys-back
endpoint    : http://127.0.0.1:8080
```

`sites/owasys-front/config/rest-api.json` utilise cet endpoint et un timeout HTTP long de 120 secondes.

`RestClient::request()` ouvre directement le flux HTTP avec `fopen()`. Un peer absent/non joignable peut donc épuiser le budget PHP avant le retour contrôlé du transport.

## Livrable actif R45C4

```text
ZIP     : opus_p117w_r45c4_rest_peer_fail_fast.zip
SHA-256 : 7b6584492135c39e0c5ed0d7422fd4f67cd2b0800480c90bc533f951e423d04e
SCRIPT  : apply_opus_p117w_r45c4_rest_peer_fail_fast.php
SHA-256 : 37edb3e1ed40360ac8f1eff9dd340ef6cbf14b37736b25efc1aafeaa8919ccf3
BASE    : 058984bfb0229bf5f27c74cd2b59c6614bf74b4e
TARGETS : 2
OUTPUT  : OPUS_P117W_R45C4_APPLIED / FILES=2
```

Smoke :

```text
smoke_opus_p117w_r45c4_rest_peer_fail_fast_owner.php
SHA-256 : c4d93515752a1812c5cf2fcce8c54e61b50bbe85e9b8483b2fbcbe773fd70b83
OUTPUT  : OPUS_P117W_R45C4_SMOKE_OK / FILES=2
```

## Correction

R45C4 ajoute au transport REST générique :

```text
connect_timeout_seconds = 2
```

et un préflight TCP borné avant le flux HTTP.

Peer absent :

```text
OPUS_REST_API_PEER_UNAVAILABLE
```

Le timeout HTTP de 120 secondes reste disponible pour une requête réelle lorsque le peer répond.

## Cibles

```text
Opus/Api/Rest/RestClient.php
sites/owasys-front/config/rest-api.json
```

Aucune cible R45C3 n'est modifiée. Aucun fichier de site généré n'est modifié.

## Ordre owner obligatoire

R45C3 n'étant pas encore committé, ne pas le committer avant R45C4.

1. conserver R45C3 dans la working tree ;
2. appliquer R45C4 sur le même HEAD R45C2 ;
3. autoload + smoke ;
4. lancer `owasys-back` puis `owasys-front` ;
5. valider navigation R45C3 + transport R45C4 + preview R45C2 ;
6. commit/push OPUS uniquement par l'owner après succès de l'ensemble.

## Suite

Après acquisition conjointe R45C3/R45C4 : reprendre R45D administration Sécurité/RBAC OWASYS admin-only.

NO SITE-SPECIFIC PATCH.  
NO SILENT FALLBACK.  
NO REST BYPASS.  
NO AUTO-START CROSS-APPLICATION.  
NO FSM MERGE.  
NO BACKEND JAVASCRIPT.  
NO PUSH OPUS BY ASSISTANT.
