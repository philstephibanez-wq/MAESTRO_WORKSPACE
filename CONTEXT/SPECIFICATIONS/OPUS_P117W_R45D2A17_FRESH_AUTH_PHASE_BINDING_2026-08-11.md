# OPUS P117W R45D2A17 — Fresh-auth phase binding

Date : 2026-08-11

## Base

OPUS master visible : `9330511436d2e3c40728d1d1bbc93ce15598aa8f` (`opus_p117w_r45d2a16_security_acl_matrix_alignment`).

R45D2A16B `dev_server_single_owner_binding` a été appliqué et validé localement par l'owner : un second lancement `owasys-back` est refusé avec `OPUS_DEV_SERVER_PORT_ALREADY_IN_USE`. R45D2A16B n'est pas encore visible sur GitHub au moment de cette spécification. R45D2A17 ne touche pas `SiteCommandService.php` et ne chevauche donc pas ce changement local.

## Cause

`OwasysFreshAuthProofService` lie actuellement la preuve à :

- acteur (`subject`, `provider`) ;
- application cible (`site_id`) ;
- hash exact de `mutation_json` ;
- opération générique `security.mutation` ;
- TTL court et nonce.

La preuve ne distingue cependant pas cryptographiquement les phases `preview` et `commit`. Une preuve valide pour la même identité, le même site et la même mutation peut donc être présentée à l'autre phase tant qu'elle reste temporellement valide.

Le workflow contractuel impose au contraire une progression explicite :

`requested -> authenticated -> authorized -> validated -> previewed -> confirmed -> committed|rejected|rolled_back`.

Une preuve de réauthentification destinée à `preview` ne doit donc pas être acceptable pour `commit`, et réciproquement.

## Correction

R45D2A17 ajoute la phase `preview|commit` au contrat de fresh-auth :

1. `OwasysFreshAuthProofServiceInterface::issue()` et `assertValid()` reçoivent la phase.
2. Les claims HMAC signés contiennent :
   - `operation = security.mutation.<phase>` ;
   - `phase = preview|commit`.
3. `security.fresh-auth-proof.issue` exige désormais un paramètre REST `phase` validé par `^(preview|commit)$`.
4. `owasys-front` transmet la phase déjà validée par `SecurityController` lors de la vraie réauthentification locale.
5. `OwasysSecurityMutationService` valide une preuve `preview` dans `preview()` et une preuve `commit` dans `commit()`.
6. Aucun nouveau stockage de replay n'est introduit ; aucun `var/rest` n'est recréé.
7. Aucun changement de matrice ACL : admin + developer mutation Sécurité ; viewer lecture seule ; viewer sans Profiler.

## Gate

Le smoke doit prouver qu'une preuve émise pour `preview` :

- est acceptée pour `preview` ;
- est refusée pour `commit` avec `OWASYS_FRESH_AUTH_PROOF_BINDING_MISMATCH`.

Puis test fonctionnel :

1. admin : preview avec mot de passe réel ;
2. commit avec nouvelle réauthentification ;
3. developer : même workflow ;
4. viewer : aucune UI de mutation, accès lecture seulement.

## Livrable

`opus_p117w_r45d2a17_fresh_auth_phase_binding.zip`

SHA-256 : `a216a0619d69eab274aaca54bc21ea7a4ff7a92b35fc891c2e6fecf590abbcb7`

Fichiers : 2 (`applicator` + `smoke`).

## Interdits préservés

- NO SITE-SPECIFIC PATCH.
- NO ACL BYPASS.
- NO VIEWER MUTATION.
- NO PROFILER FOR VIEWER.
- NO TIMESTAMP-ONLY FRESH-AUTH.
- NO CROSS-PHASE FRESH-AUTH PROOF.
- NO PASSWORD IN LOG/PROFILER/ARGV.
- NO REST REPLAY STORE.
- NO PUSH OPUS/OWASYS BY ASSISTANT.
