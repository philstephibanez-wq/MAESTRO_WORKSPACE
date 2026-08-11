# HANDOFF — OPUS P117W R45D2A18C

Date : 2026-08-11

## Base publiée

```text
9d3c4d5463483cc520d381f7f8de83cfd5e352c4  opus_p117w_r45d2a18b_rest_composer_catalog_integrity
```

## État acquis

- R45D2A16B : single-owner dev-server publié ;
- R45D2A17 : fresh-auth lié à `preview|commit` ;
- R45D2A18 : FSM de mutation Sécurité publiée ;
- R45D2A18B : intégrité REST -> Composer publiée ;
- le POST fresh-auth atteint désormais réellement `owasys:security-fresh-auth-proof`.

## Incident actif

Le script démarre puis échoue avec :

```text
OWASYS_FRESH_AUTH_PROOF_SECRET_INVALID
```

Cause : `OwasysFreshAuthProofService` attend `OPUS_OWASYS_FRESH_AUTH_PROOF_SECRET`, mais la politique d'environnement de `owasys-back` ne déclare pas encore cette variable.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a18c_fresh_auth_runtime_secret_policy.zip
SHA-256 : 253b0aba17d839c728ac1a3f602baf2e8b471f27b64314105cef47647c71ec85
BASE    : 9d3c4d5463483cc520d381f7f8de83cfd5e352c4
FILES   : 2
```

Correction : raccorder le secret fresh-auth à `OPUS_APPLICATION_ENVIRONMENTS_V1` : dérivation OPUS automatique en dev, variable externe obligatoire en test/prod.

## Gate suivant

Redémarrer back sans `set` manuel du secret, puis front. Tester :

`admin -> fresh-auth preview -> previewed -> nouvelle fresh-auth commit -> committed`

Ensuite developer ; viewer lecture seule.

Vérifier Logger/Profiler : aucune valeur secrète, aucun mot de passe, aucune preuve complète.

NO MANUAL DEV SECRET.
NO SECRET IN GIT.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO CROSS-PHASE PROOF.
NO REST REPLAY STORE.
NO PUSH OPUS/OWASYS BY ASSISTANT.
