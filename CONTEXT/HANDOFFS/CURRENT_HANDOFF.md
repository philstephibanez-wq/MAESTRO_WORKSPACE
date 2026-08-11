# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-11

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
5. `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A15_BACKEND_FRESH_AUTH_PROOF_2026-08-11.md`
7. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A15_BACKEND_FRESH_AUTH_PROOF_2026-08-11.md`
8. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
a3f5b2257628d5b6ea0c98ba92178b4fe51030b2  opus_p117w_r45d2a14b_logout_atomic_migration
f195471557727d23d0be036b80382f3ba3ad9787  opus_p117w_r45d2a14_generated_logout
186517fd37c14047e33308500d0699b8ac36ab44  opus_p117w_r45d2a12_source_acl_ui_truth
```

## États owner acquis

- `essai2/steve` : connexion réussie ;
- reset local-password : acquis ;
- message login I18n : acquis ;
- Profiler intégré/repliable + corrélation login : acquis ;
- R45D2A12 : UI Sources/Git alignée sur ACL `source/write` et publiée ;
- R45D2A14B : `/fr` authentifié fonctionne et `Déconnexion` est visible.

## Matrice ACL cible obligatoire

Voir `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`.

Règle : capacités fondées sur permissions ACL effectives, jamais sur `primary_role` seul. Backend décisif, UI alignée, deny-by-default.

## Livrable actif — R45D2A15

```text
ZIP     : opus_p117w_r45d2a15_backend_fresh_auth_proof.zip
SHA-256 : 49a1ca5d8a629a25ea8aa17c46f613f6fde8789b21b1b8d2208082271aa2cc15
BASE    : a3f5b2257628d5b6ea0c98ba92178b4fe51030b2
FILES   : 4
```

Cause traitée : le simple `reauthenticated_at` déclaratif n'est pas une preuve backend. R45D2A15 remplace ce timestamp par une preuve `OWASYS_FRESH_AUTH_PROOF_V1` émise par `owasys-back`, HMAC SHA-256, TTL 120 s, nonce, liée à l'acteur, au site et au hash exact de `mutation_json`.

Secret runtime backend requis : `OPUS_OWASYS_FRESH_AUTH_PROOF_SECRET` (minimum 32 octets, jamais versionné).

## Gate immédiat

1. extraire R45D2A15 dans `H:\OPUS` ;
2. exécuter l'applicateur ;
3. exécuter le smoke ;
4. lint des nouveaux services + front/back modifiés ;
5. `composer dump-autoload -o` ;
6. définir le secret fresh-auth dans l'environnement du backend ;
7. relancer owasys-back et owasys-front ;
8. tester preview Sécurité admin avec réauthentification ;
9. tester commit ;
10. vérifier refus : mot de passe erroné, preuve altérée, acteur/site/mutation différents ;
11. préserver intégralement la matrice admin/developer/viewer.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO TIMESTAMP-ONLY FRESH-AUTH.
NO PASSWORD IN LOG/PROFILER/ARGV.
NO SSO/ACL RELAXATION.
NO PRIMARY_ROLE AUTHORIZATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
