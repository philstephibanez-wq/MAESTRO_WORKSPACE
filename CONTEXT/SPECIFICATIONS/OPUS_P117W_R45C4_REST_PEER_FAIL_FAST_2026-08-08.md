# OPUS P117W R45C4 — REST PEER FAIL-FAST

Date : 2026-08-08  
Statut : livrable owner à valider  
Portée : OPUS REST générique + configuration client OWASYS front

## Source de vérité

OPUS `master` owner publié :

```text
058984bfb0229bf5f27c74cd2b59c6614bf74b4e
opus_p117w_r45c2_dev_preview_runtime_fix
```

R45C3 a été appliqué localement par l'owner sur cette base mais n'est pas encore publié. Ses deux cibles sont disjointes de R45C4.

## Retour owner bloquant

Après application R45C3, la projection visuelle de la FSM OWASYS est correcte :

```text
Applications
-> Sources de données
-> Structure
-> Sécurité
-> Workflows
-> Sources et Git
-> Construction et validation
```

Mais une navigation vers `Applications` déclenche la synchronisation Registry puis bloque dans :

```text
Opus\Api\Rest\RestClient::request()
-> fopen()
```

jusqu'à :

```text
PHP Fatal error: Maximum execution time ... exceeded
```

La pile owner situe le blocage dans le flux :

```text
owasys-front
-> RegistryModel::synchronize()
-> RestClient::request()
-> peer REST owasys-back
```

## Cause

La configuration canonique de `owasys-front` désigne `owasys-back` comme peer REST de développement :

```text
http://127.0.0.1:8080
```

Le client REST utilise actuellement un seul timeout HTTP long :

```json
"timeout_seconds": 120
```

et tente directement `fopen()` sur l'endpoint REST. Si le peer est absent ou non joignable, le runtime PHP peut atteindre son budget global avant que le client ne récupère la main pour convertir l'échec en erreur OPUS contrôlée.

Ce comportement est générique au transport REST OPUS ; il ne doit donc pas être corrigé dans la FSM OWASYS, dans `RegistryModel` ou dans un site généré.

## Correction R45C4

### 1. Timeout de connexion distinct

`RestClient` reçoit un contrat distinct :

```text
connect_timeout_seconds
```

Il est indépendant de `timeout_seconds`, qui reste le budget de la requête HTTP une fois le peer joignable.

Validation générique :

```text
1 <= connect_timeout_seconds <= 30
```

Configuration OWASYS front développement :

```json
"connect_timeout_seconds": 2
```

### 2. Préflight TCP générique

Avant l'ouverture HTTP, `RestClient` dérive uniquement l'hôte et le port du `baseUrl` déjà validé et exécute une tentative TCP bornée par `connect_timeout_seconds`.

En cas d'absence du peer :

```text
OPUS_REST_API_PEER_UNAVAILABLE
```

Aucun secret, token, HMAC, chemin ou corps de requête n'est exposé dans le code d'erreur.

### 3. Aucun contournement architectural

R45C4 ne :

- démarre pas automatiquement `owasys-back` depuis `owasys-front` ;
- ne fusionne pas les deux Singletons ;
- ne transforme pas REST en appel local ;
- ne contourne ni ACL, ni HMAC/bearer, ni Composer ;
- ne modifie pas `RegistryModel` ;
- ne modifie aucune FSM ;
- ne modifie aucun site généré ;
- ne modifie pas `owasys-back`.

Le contrat de déploiement séparé reste donc intact.

## Exploitation développement

Les deux applications OWASYS autonomes doivent être lancées :

```text
owasys-back  -> http://127.0.0.1:8080
owasys-front -> http://127.0.0.1:8000
```

L'ordre recommandé est backend puis frontend.

Si le backend est arrêté après coup, la navigation front doit désormais échouer rapidement avec `OPUS_REST_API_PEER_UNAVAILABLE`, jamais par dépassement silencieux du temps d'exécution PHP.

## Livrable

```text
ZIP     : opus_p117w_r45c4_rest_peer_fail_fast.zip
SHA-256 : 7b6584492135c39e0c5ed0d7422fd4f67cd2b0800480c90bc533f951e423d04e
SCRIPT  : apply_opus_p117w_r45c4_rest_peer_fail_fast.php
SHA-256 : 37edb3e1ed40360ac8f1eff9dd340ef6cbf14b37736b25efc1aafeaa8919ccf3
BASE    : 058984bfb0229bf5f27c74cd2b59c6614bf74b4e
TARGETS : 2
OUTPUT  : OPUS_P117W_R45C4_APPLIED / FILES=2
```

Smoke owner séparé :

```text
FILE    : smoke_opus_p117w_r45c4_rest_peer_fail_fast_owner.php
SHA-256 : c4d93515752a1812c5cf2fcce8c54e61b50bbe85e9b8483b2fbcbe773fd70b83
OUTPUT  : OPUS_P117W_R45C4_SMOKE_OK / FILES=2
```

## Fichiers cibles

```text
Opus/Api/Rest/RestClient.php
sites/owasys-front/config/rest-api.json
```

`RestClient` conserve son interface homonyme `RestClientInterface`, laquelle étend les quatre marqueurs contractuels OPUS.

## Empilement avec R45C3

R45C3 est actuellement présent dans la working tree owner mais pas encore publié.

Cibles R45C3 :

```text
sites/owasys-front/config/fsm.json
sites/owasys-front/application/creation/controllers/CreationController.php
```

Cibles R45C4 :

```text
Opus/Api/Rest/RestClient.php
sites/owasys-front/config/rest-api.json
```

Les ensembles sont disjoints. Le script R45C4 exige toujours le HEAD exact R45C2 et vérifie uniquement ses deux propres cibles. R45C4 doit donc être appliqué avant tout commit owner de R45C3.

## Gates owner

1. HEAD Git toujours `058984bfb0229bf5f27c74cd2b59c6614bf74b4e` ;
2. conserver les deux modifications R45C3 non committées ;
3. vérifier que les deux cibles R45C4 sont propres ;
4. appliquer R45C4 ;
5. `composer dump-autoload -o` ;
6. smoke séparé -> `OPUS_P117W_R45C4_SMOKE_OK / FILES=2` ;
7. lancer `owasys-back` sur 8080 ;
8. lancer `owasys-front` sur 8000 ;
9. vérifier que `Applications` et les autres onglets naviguent normalement ;
10. vérifier que la séquence R45C3 reste correcte ;
11. arrêter volontairement le backend et vérifier un échec rapide `OPUS_REST_API_PEER_UNAVAILABLE` ;
12. relancer le backend et vérifier la reprise normale ;
13. vérifier la prévisualisation R45C2 ;
14. seulement après succès, commit/push OPUS par l'owner.

NO SITE-SPECIFIC PATCH.  
NO SILENT FALLBACK.  
NO REST BYPASS.  
NO AUTO-START CROSS-APPLICATION.  
NO FSM MERGE.  
NO BACKEND JAVASCRIPT.  
NO PUSH OPUS BY ASSISTANT.
