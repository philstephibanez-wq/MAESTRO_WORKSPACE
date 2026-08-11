# HANDOFF — OPUS P117W R45D2A18B REST / Composer catalog integrity

Date : 2026-08-11

## État de départ

OPUS master observé : `98b0233bf85f33037f45adde916514c6f8305a16` (`opus_p117w_r45d2a18_security_mutation_fsm`).

États acquis :

- R45D2A16B single-owner dev-server publié ;
- R45D2A17 fresh-auth phase binding publié ;
- R45D2A18 Security Mutation FSM publié ;
- `GET /fr-FR/security` sain ;
- `security.snapshot` traverse front -> REST -> back -> Composer en 200 avec trace corrélée.

## Incident courant

Preview Sécurité échoue avant émission de la preuve fresh-auth :

```text
OPUS_REST_API_COMPOSER_SCRIPT_UNDECLARED
```

Le back reçoit correctement :

```text
POST /api/v1/applications/essai2/security/fresh-auth-proofs
operation=security.fresh-auth-proof.issue
```

## Cause

`backend.operations.json` référence le script public `owasys:security-fresh-auth-proof` et `composer.commands.json` possède son alias/provider, mais la section `scripts` du `composer.json` racine ne le déclare pas.

`ComposerCommandRegistry::operation()` refuse donc l'opération.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a18b_rest_composer_catalog_integrity.zip
SHA-256 : a4dc4e13778f96037c5f9e9470e6c673e1f58857572e99757c01304458642a27
FILES   : 2
```

Correction : ajout du script public manquant et smoke global vérifiant que tout `composer_script` de `backend.operations.json` existe dans `composer.json`.

## Gate immédiat

```text
apply -> smoke -> dump-autoload -> restart back/front
-> admin security Preview
-> fresh-auth REST/Composer success
-> preview success
-> nouvelle fresh-auth
-> commit success
```

Après admin : même workflow developer ; viewer reste lecture seule et sans Profiler.

## Invariants

NO SITE-SPECIFIC PATCH.  
NO ACL BYPASS.  
NO VIEWER MUTATION.  
NO PASSWORD/PROOF LOGGING.  
NO CROSS-PHASE PROOF.  
NO REST REPLAY STORE.  
NO AUTO-KILL DEV SERVER.  
NO PRIMARY_ROLE AUTHORIZATION.  
NO PUSH OPUS/OWASYS BY ASSISTANT.
