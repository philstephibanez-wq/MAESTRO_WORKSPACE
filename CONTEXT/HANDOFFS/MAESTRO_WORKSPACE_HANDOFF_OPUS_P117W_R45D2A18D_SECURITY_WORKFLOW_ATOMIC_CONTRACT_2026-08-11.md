# HANDOFF — OPUS P117W R45D2A18D

Date : 2026-08-11

## Base

`d7226d4e0696319876b1bde69dbcfa9aa3feff3e` — R45D2A18C publié.

## Observation owner

UI Sécurité : `Mutation de sécurité refusée` avec `OWASYS_FRESH_AUTH_PROOF_BINDING_INVALID`.

Logs corrélés : POST `/api/v1/applications/essai2/security/fresh-auth-proofs`, script `owasys:security-fresh-auth-proof` démarré, échec dans `OwasysFreshAuthProofService.php` sur le binding.

## Diagnostic canonique

Le master montre une publication partielle des contrats :

- R45D2A17 a publié uniquement la moitié back du phase-binding ;
- `RuntimeSecurity.php` n'envoie pas `phase` ;
- `SecurityController.php` n'est pas raccordé à la FSM de mutation ;
- `OwasysSecurityMutationService.php` appelle encore la preuve sans phase ;
- R45D2A18 a publié uniquement le JSON de FSM.

Le prochain livrable doit être atomique et fermer toutes les frontières avant tout nouveau développement.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a18d_security_workflow_atomic_contract.zip
SHA-256 : cc46c530413d2915dab62ade329bf939b11997d9c5343179d2f82f959f1e33ca
BASE    : d7226d4e0696319876b1bde69dbcfa9aa3feff3e
FILES   : 3
```

## Gate

1. extraire ZIP ;
2. exécuter `r45d2a18d_apply_security_workflow_atomic_contract.php` ;
3. exécuter `smoke_r45d2a18d_security_workflow_atomic_contract.php` ;
4. linter RuntimeSecurity, SecurityController, OwasysSecurityMutationService ;
5. `composer dump-autoload -o` ;
6. vérifier `git status --short` : les fichiers contractuels attendus doivent apparaître ;
7. redémarrer back puis front sans secret manuel ;
8. admin : Preview -> aperçu -> nouvelle fresh-auth -> Commit ;
9. vérifier logs/profiler : FSM, REST, Composer corrélés, aucun secret ;
10. developer : même workflow ;
11. viewer : lecture seulement, contrôles mutation absents.

Ne pas passer au bloc suivant tant que le workflow admin n'atteint pas Preview puis Commit.

Matrice ACL inchangée : admin/developer mutation, viewer lecture seule, viewer sans Profiler.

NO PARTIAL PUBLICATION.
NO SITE-SPECIFIC HACK.
NO MANUAL DEV SECRET.
NO CROSS-PHASE PROOF.
NO PASSWORD/PROOF LOGGING.
NO ACL BYPASS.
NO PUSH OPUS/OWASYS BY ASSISTANT.
