# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-08.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 058984bfb0229bf5f27c74cd2b59c6614bf74b4e
Commit HEAD : opus_p117w_r45c2_dev_preview_runtime_fix
R45C2 acquis : 058984bfb0229bf5f27c74cd2b59c6614bf74b4e
R45C3 : appliqué localement, non publié, validation runtime bloquée
Livrable actif : R45C4 REST peer fail-fast
```

## R45C2 acquis

Le bouton OWASYS `Visualiser le site` fonctionne et ouvre la prévisualisation du site généré dans un nouvel onglet.

## R45C3 — état owner

R45C3 a été appliqué sur le HEAD R45C2 sans commit owner intermédiaire.

La capture owner confirme la projection attendue :

```text
Applications
-> Sources de données
-> Structure
-> Sécurité
-> Workflows
-> Sources et Git
-> Construction et validation
```

La séquence FSM n'est donc pas la cause du blocage observé.

La validation runtime de R45C3 reste en attente parce qu'une navigation vers `Applications` bloque lors de la synchronisation Registry.

## Incident REST bloquant

Pile owner :

```text
Opus\Api\Rest\RestClient.php -> fopen()
sites/owasys-front/application/registry/models/RegistryModel.php
sites/owasys-front/application/registry/controllers/RegistryController.php
sites/owasys-front/application/default/controllers/RuntimeController.php
```

Résultat :

```text
PHP Fatal error: Maximum execution time ... exceeded
```

Le front avait été lancé sur 8000.

La configuration canonique de `owasys-front` déclare :

```text
peer_application_id : owasys-back
peer dev endpoint    : http://127.0.0.1:8080
```

Le front et le back sont deux applications OPUS autonomes et doivent être lancés séparément en développement.

## Cause générique

`RestClient` utilise le contrat `OPUS_REST_API_CLIENT_CONFIG_V1` et lit `timeout_seconds`.

La configuration OWASYS front fixe actuellement :

```text
timeout_seconds = 120
```

`RestClient::request()` construit le contexte HTTP puis exécute directement `fopen()`.

Il n'existe pas de timeout de connexion au peer distinct du budget long de la requête. Un peer absent/non joignable peut donc laisser le runtime PHP mourir avant le retour contrôlé du transport.

Le défaut appartient au transport REST générique OPUS. Aucun patch FSM/Registry/site spécifique ne doit le masquer.

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

## R45C4 — comportement cible

Framework OPUS :

- `RestClient` conserve son interface homonyme et les quatre marqueurs contractuels ;
- nouveau `connect_timeout_seconds` validé de 1 à 30 secondes ;
- préflight TCP borné sur l'hôte/port du `baseUrl` déjà validé ;
- peer absent -> `OPUS_REST_API_PEER_UNAVAILABLE` ;
- aucun secret dans le diagnostic ;
- `timeout_seconds = 120` conservé pour la requête HTTP après connexion ;
- aucun fallback silencieux ;
- aucun démarrage cross-application automatique.

Configuration OWASYS front :

```text
connect_timeout_seconds = 2
```

## Cibles et empilement

R45C3 non publié :

```text
sites/owasys-front/config/fsm.json
sites/owasys-front/application/creation/controllers/CreationController.php
```

R45C4 :

```text
Opus/Api/Rest/RestClient.php
sites/owasys-front/config/rest-api.json
```

Les cibles sont disjointes. R45C4 doit être appliqué avant tout commit owner de R45C3, car son script exige toujours le HEAD exact R45C2.

## Validation owner requise

1. appliquer R45C4 en conservant R45C3 dans la working tree ;
2. autoload optimisé ;
3. smoke R45C4 ;
4. lancer `owasys-back` sur 8080 ;
5. lancer `owasys-front` sur 8000 ;
6. vérifier la navigation complète et la séquence R45C3 ;
7. arrêter volontairement le backend et vérifier `OPUS_REST_API_PEER_UNAVAILABLE` rapidement ;
8. relancer le backend et vérifier la reprise ;
9. vérifier la preview R45C2 ;
10. commit/push OPUS exclusivement par l'owner après succès.

## Suite gouvernée

Après acquisition R45C3 + R45C4 :

1. R45D administration Sécurité/RBAC OWASYS réservée à admin ;
2. séparation stricte sécurité OWASYS / sécurité des sites ;
3. poursuite BDD/pages/API/ACL CRUD/workflows selon le profil du site.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO REST BYPASS.
NO AUTO-START CROSS-APPLICATION.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
