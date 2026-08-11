# OPUS P117W R45D2A18C — Fresh-auth runtime secret policy

Date : 2026-08-11
Statut : livrable owner à appliquer

## Base

OPUS master publié :

```text
9d3c4d5463483cc520d381f7f8de83cfd5e352c4  opus_p117w_r45d2a18b_rest_composer_catalog_integrity
```

## Incident observé

Le POST fresh-auth atteint correctement `owasys-back` et le script public est désormais déclaré :

```text
POST /api/v1/applications/essai2/security/fresh-auth-proofs
script=owasys:security-fresh-auth-proof
```

L'exécution échoue ensuite avec :

```text
OWASYS_FRESH_AUTH_PROOF_SECRET_INVALID
```

Le service attend `OPUS_OWASYS_FRESH_AUTH_PROOF_SECRET`, mais `sites/owasys-back/config/site.json` ne déclare pas encore cette variable dans la politique `OPUS_APPLICATION_ENVIRONMENTS_V1`.

## Cause

Le nouveau secret fresh-auth a été introduit dans le service sans être raccordé à l'autorité canonique d'environnement OPUS.

Le serveur de développement OPUS sait déjà résoudre des variables secrètes via `OPUS_DEVELOPMENT_DERIVED_SECRET_V1`. Les secrets REST existants de `owasys-back` utilisent ce mécanisme. Le fresh-auth doit suivre le même contrat au lieu de dépendre d'un `set` manuel dans le terminal.

## Correction R45D2A18C

Déclarer `OPUS_OWASYS_FRESH_AUTH_PROOF_SECRET` dans `sites/owasys-back/config/site.json` :

- `dev` : secret dérivé automatiquement par OPUS, contrat `OPUS_DEVELOPMENT_DERIVED_SECRET_V1`, channel `owasys-security-fresh-auth` ;
- `test` : variable externe `OPUS_TEST_OWASYS_FRESH_AUTH_PROOF_SECRET` ;
- `prod` : variable externe obligatoire `OPUS_OWASYS_FRESH_AUTH_PROOF_SECRET` ;
- marquage `secret: true` dans les trois environnements.

Le secret fresh-auth est distinct du token/HMAC REST.

## Invariants

- aucun secret dans Git ;
- aucun mot de passe, secret ou preuve complète dans Logger/Profiler ;
- aucune saisie manuelle de secret requise en développement ;
- test/prod restent fail-closed si la variable externe manque ;
- aucune modification ACL ;
- aucune modification de la FSM Sécurité ;
- aucun store REST de replay ;
- aucun JavaScript dans `owasys-back`.

## Livrable

```text
ZIP     : opus_p117w_r45d2a18c_fresh_auth_runtime_secret_policy.zip
SHA-256 : 253b0aba17d839c728ac1a3f602baf2e8b471f27b64314105cef47647c71ec85
BASE    : 9d3c4d5463483cc520d381f7f8de83cfd5e352c4
FILES   : 2
```

## Gate owner

1. appliquer l'applicateur ;
2. smoke ;
3. valider `site.json` ;
4. relancer `owasys-back` sans `set OPUS_OWASYS_FRESH_AUTH_PROOF_SECRET` ;
5. relancer `owasys-front` ;
6. admin : Preview Sécurité ;
7. fresh-auth doit réussir ;
8. Preview doit aboutir ;
9. nouvelle réauthentification ;
10. Commit doit aboutir ;
11. vérifier traces FSM + REST + Composer sans secret ;
12. répéter developer ;
13. viewer reste lecture seule.
