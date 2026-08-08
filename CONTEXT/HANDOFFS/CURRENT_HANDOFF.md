# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-08

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45C3_STRUCTURED_WORKFLOW_SEQUENCE_2026-08-08.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45C4_REST_PEER_FAIL_FAST_2026-08-08.md`
7. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45C4_REST_PEER_FAIL_FAST_2026-08-08.md`
8. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base exacte OPUS

OPUS `master` owner publié :

```text
058984bfb0229bf5f27c74cd2b59c6614bf74b4e
opus_p117w_r45c2_dev_preview_runtime_fix
```

R45C2 est acquis.

R45C3 est appliqué localement par l'owner sur cette base mais pas encore publié.

## Retour owner R45C3

La projection FSM/navigation visible est conforme au nouvel ordre :

```text
Applications
-> Sources de données
-> Structure
-> Sécurité
-> Workflows
-> Sources et Git
-> Construction et validation
```

Mais la navigation runtime est bloquée. La pile owner montre :

```text
owasys-front
-> RegistryModel::synchronize()
-> Opus\Api\Rest\RestClient::request()
-> fopen()
-> Maximum execution time exceeded
```

Le front a été lancé sur 8000. Le contrat canonique désigne `owasys-back` comme peer REST de développement sur 8080.

La cause bloquante est donc la frontière REST et non la séquence FSM R45C3.

## Cause R45C4

Le client REST OPUS possède un timeout HTTP long (`timeout_seconds = 120`) mais aucun budget distinct de connexion au peer.

Il tente directement `fopen()` sur l'endpoint REST. Un peer absent ou non joignable peut épuiser le budget global PHP avant que le transport ne récupère la main pour remonter une erreur OPUS contrôlée.

Ce défaut est générique au framework ; aucun patch local de navigation, de Registry ou de site généré n'est autorisé.

## Livrable actif — R45C4

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

## Cibles R45C4

```text
Opus/Api/Rest/RestClient.php
sites/owasys-front/config/rest-api.json
```

R45C4 ajoute `connect_timeout_seconds = 2` et un préflight TCP générique avant l'ouverture HTTP.

Peer absent/non joignable :

```text
OPUS_REST_API_PEER_UNAVAILABLE
```

Le timeout HTTP long reste inchangé pour les requêtes réelles après connexion.

## Empilement R45C3 + R45C4

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

Les cibles sont disjointes.

Ne pas committer R45C3 avant R45C4 : le script R45C4 exige encore le HEAD exact R45C2 `058984...` et tolère les modifications R45C3 parce qu'il ne contrôle que ses propres cibles.

## Gates owner R45C4

1. HEAD toujours `058984bfb0229bf5f27c74cd2b59c6614bf74b4e` ;
2. conserver R45C3 non committé ;
3. appliquer R45C4 ;
4. `OPUS_P117W_R45C4_APPLIED / FILES=2` ;
5. `composer dump-autoload -o` ;
6. smoke -> `OPUS_P117W_R45C4_SMOKE_OK / FILES=2` ;
7. lancer `owasys-back` sur 8080 ;
8. lancer `owasys-front` sur 8000 ;
9. vérifier navigation complète et ordre R45C3 ;
10. arrêter volontairement le back et vérifier un échec rapide `OPUS_REST_API_PEER_UNAVAILABLE` ;
11. relancer le back et vérifier la reprise ;
12. vérifier `Visualiser le site` R45C2 ;
13. commit/push OPUS uniquement par l'owner après succès de R45C3 + R45C4.

## Suite

Après acquisition R45C3/R45C4 : R45D administration Sécurité/RBAC OWASYS admin-only, distincte des rôles et ACL propres aux sites générés.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO AUTO-START CROSS-APPLICATION.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
