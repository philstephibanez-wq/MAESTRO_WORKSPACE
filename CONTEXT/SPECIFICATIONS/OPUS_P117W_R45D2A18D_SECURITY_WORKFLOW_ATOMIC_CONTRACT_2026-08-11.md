# OPUS P117W R45D2A18D — Security workflow atomic contract

Date : 2026-08-11

## Base canonique

`d7226d4e0696319876b1bde69dbcfa9aa3feff3e` — `opus_p117w_r45d2a18c_fresh_auth_runtime_secret_policy`

## Incident observé

Le POST Sécurité atteint `owasys-back`, lance `owasys:security-fresh-auth-proof`, puis échoue avec :

```text
OWASYS_FRESH_AUTH_PROOF_BINDING_INVALID
```

Le secret runtime est donc désormais disponible et le script Composer est résolu. La panne est plus loin dans le contrat de binding.

## Cause racine

Les livrables précédents ont été matérialisés partiellement dans OPUS :

- commit R45D2A17 `8f0d6ba5...` : uniquement `OwasysCommandProvider.php`, `OwasysFreshAuthProofService.php`, `OwasysFreshAuthProofServiceInterface.php` ; aucun raccord front ni catalogue d'opération ;
- commit R45D2A18 `98b0233...` : uniquement `sites/owasys-front/config/security.mutation.fsm.json` ; aucun raccord dans `SecurityController.php` ;
- le `RuntimeSecurity.php` courant transmet seulement `mutation_json` à `/security/fresh-auth-proofs` et ne transmet pas `phase` ;
- `OwasysFreshAuthProofService` exige pourtant `phase=preview|commit` ;
- `OwasysSecurityMutationService` courant appelle encore `assertValid()` sans phase.

La panne n'est donc pas un simple paramètre absent : le contrat fresh-auth/FSM a été publié non atomiquement entre front, REST, back et contrôleur.

## Correction R45D2A18D

Un seul applicateur remet en cohérence toutes les frontières :

1. `RuntimeSecurity::reauthenticate()` accepte `phase` et l'envoie au REST avec `mutation_json` ;
2. `SecurityController` passe la phase, pilote réellement `security.mutation.fsm.json`, persiste uniquement état/hash/vue via `FsmSessionStore`, et ne stocke ni mot de passe ni preuve ;
3. `OwasysSecurityMutationService` valide une preuve `preview` pendant Preview et une preuve `commit` pendant Commit ;
4. `backend.operations.json` déclare `security.fresh-auth-proof.issue` avec `site_id`, `mutation_json`, `phase` et rôles `admin|developer` ;
5. script public Composer, alias/provider interne, route REST et catalogues front/back sont vérifiés/synchronisés ;
6. la politique de secret R45D2A18C est préservée : dérivation automatique en dev, secret externe test/prod ;
7. le smoke traverse toutes les frontières et vérifie aussi le refus cryptographique d'une preuve preview utilisée en commit.

## FSM contractuelle

```text
idle
  -> requested
  -> authenticated
  -> authorized
  -> validated
  -> previewed
  -> confirmed
  -> committed
```

Sorties terminales : `rejected`, `rolled_back`.

Le mot de passe est vérifié avant la transition `authenticated`. L'ACL effective est vérifiée avant `authorized`. Preview réussie est nécessaire avant `previewed`. Une nouvelle réauthentification est exigée avant la confirmation/commit.

## Matrice ACL conservée

- admin : mutation Sécurité ;
- developer : mutation Sécurité ;
- viewer : lecture seule ;
- viewer : aucun Profiler.

Aucune décision basée sur `primary_role`.

## Livrable

```text
ZIP     : opus_p117w_r45d2a18d_security_workflow_atomic_contract.zip
SHA-256 : cc46c530413d2915dab62ade329bf939b11997d9c5343179d2f82f959f1e33ca
BASE    : d7226d4e0696319876b1bde69dbcfa9aa3feff3e
FILES   : 3
```

## Gate owner

Appliquer l'applicateur, exécuter le smoke, lints/autoload, redémarrer back/front, puis tester en admin : Preview -> aperçu -> nouvelle réauthentification -> Commit. Ensuite developer, puis viewer lecture seule.

Le smoke doit afficher `OPUS_R45D2A18D_SMOKE_OK` avant tout test navigateur.

NO PARTIAL CONTRACT PUBLICATION.
NO MANUAL DEV SECRET.
NO PASSWORD/PROOF IN FSM MEMORY OR LOGS.
NO CROSS-PHASE PROOF.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
