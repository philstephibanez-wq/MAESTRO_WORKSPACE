# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-11.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : d7226d4e0696319876b1bde69dbcfa9aa3feff3e
Commit : opus_p117w_r45d2a18c_fresh_auth_runtime_secret_policy
```

## États acquis

- R45D2A12 : UI Sources/Git alignée sur ACL `source/write`.
- R45D2A14B : logout généré acquis.
- R45D2A15B : catalogues REST synchronisés.
- R45D2A16 : matrice Sécurité admin/developer/viewer.
- R45D2A16B : dev-server single-owner binding acquis.
- R45D2A18B : intégrité REST -> Composer acquise ; script fresh-auth résolu.
- R45D2A18C : secret fresh-auth dérivé automatiquement par OPUS en dev ; aucun secret versionné.
- `GET /fr-FR/security` et `security.snapshot` fonctionnent avec corrélation front -> REST -> back -> Composer.

## Publication partielle détectée

Les intitulés R45D2A17/R45D2A18 ne correspondent pas encore à un contrat complet dans le master :

- commit R45D2A17 `8f0d6ba5...` ne contient que les trois fichiers back du service fresh-auth ;
- `RuntimeSecurity.php` courant n'envoie pas `phase` ;
- `OwasysSecurityMutationService.php` courant valide encore la preuve sans phase ;
- commit R45D2A18 `98b0233...` ne contient que `security.mutation.fsm.json` ;
- `SecurityController.php` courant ne pilote pas encore cette FSM.

Ces états ne doivent plus être marqués « acquis » individuellement tant que R45D2A18D n'a pas matérialisé toutes les frontières et passé son smoke atomique.

## Incident courant

Preview Sécurité :

```text
OWASYS_FRESH_AUTH_PROOF_BINDING_INVALID
```

Le script fresh-auth est exécuté et le secret est disponible. Le binding échoue parce que le front courant n'envoie pas `phase`, alors que le service back exige `preview|commit`.

## Livrable actif — R45D2A18D

```text
ZIP     : opus_p117w_r45d2a18d_security_workflow_atomic_contract.zip
SHA-256 : cc46c530413d2915dab62ade329bf939b11997d9c5343179d2f82f959f1e33ca
BASE    : d7226d4e0696319876b1bde69dbcfa9aa3feff3e
FILES   : 3
```

R45D2A18D synchronise atomiquement :

- RuntimeSecurity phase transport ;
- SecurityController + FsmSessionStore ;
- Security Mutation FSM ;
- OwasysSecurityMutationService phase preview/commit ;
- backend.operations fresh-auth ;
- Composer script/alias/provider ;
- REST route + trois catalogues ;
- secret runtime policy.

## Gate owner

Le smoke `OPUS_R45D2A18D_SMOKE_OK` est obligatoire avant navigateur. Ensuite admin : Preview -> aperçu -> nouvelle réauthentification -> Commit. Puis developer. Viewer reste lecture seule et sans Profiler.

## Matrice ACL à préserver

Voir `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`.

Admin + developer mutation Sécurité ; viewer lecture seule ; viewer sans Profiler ; permissions effectives uniquement, jamais `primary_role`.

NO PARTIAL PUBLICATION.
NO MANUAL DEV SECRET.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PASSWORD/PROOF LOGGING.
NO CROSS-PHASE PROOF.
NO REST REPLAY STORE.
NO PUSH OPUS/OWASYS BY ASSISTANT.
