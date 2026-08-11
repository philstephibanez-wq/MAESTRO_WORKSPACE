# HANDOFF — OPUS P117W R45D2A15 BACKEND FRESH-AUTH PROOF

Date : 2026-08-11

## Base OPUS

`a3f5b2257628d5b6ea0c98ba92178b4fe51030b2` — `opus_p117w_r45d2a14b_logout_atomic_migration`

## Livrable

```text
ZIP     : opus_p117w_r45d2a15_backend_fresh_auth_proof.zip
SHA-256 : 49a1ca5d8a629a25ea8aa17c46f613f6fde8789b21b1b8d2208082271aa2cc15
FILES   : 4
```

## Correction

Le simple `reauthenticated_at` est supprimé. Après vérification locale du mot de passe sur le front bastion, `owasys-front` demande à `owasys-back` une preuve courte durée. Cette preuve est signée côté backend, liée à l'acteur, au site et au hash exact de la mutation, puis exigée par preview et commit.

Secret backend requis : `OPUS_OWASYS_FRESH_AUTH_PROOF_SECRET`, longueur minimale 32 octets, non versionné.

## Gate owner

1. extraire le ZIP dans `H:\OPUS` ;
2. exécuter l'applicateur ;
3. exécuter le smoke ;
4. lint des deux nouveaux services, du front RuntimeSecurity, du SecurityController, du CommandProvider et du MutationService ;
5. `composer dump-autoload -o` ;
6. définir `OPUS_OWASYS_FRESH_AUTH_PROOF_SECRET` dans l'environnement du backend ;
7. relancer owasys-back puis owasys-front ;
8. tester une preview Sécurité admin avec réauthentification ;
9. tester commit ;
10. confirmer refus avec mot de passe erroné et absence de mutation ;
11. préserver la matrice admin/developer/viewer contractuelle.

## Interdits

- aucun timestamp déclaratif comme preuve fresh-auth ;
- aucun password dans argv/log/profiler ;
- aucun secret versionné ;
- aucun bypass ACL ;
- aucun JavaScript dans owasys-back ;
- aucun patch spécifique à essai2 ;
- aucun push OPUS/OWASYS par l'assistant.
