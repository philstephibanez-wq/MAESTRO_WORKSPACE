# HANDOFF — OPUS P117W R45D2A19 Local-password break-glass recovery

Date : 2026-08-11

## État de départ

OPUS master :

```text
6f82ea0ad46eadd11435e02bc2dd1ff703034c02  opus_p117w_r45d2a18d_security_workflow_atomic_contract
```

R45D2A18D est validé owner côté Preview : l'aperçu de mutation Sécurité est visible et aucune écriture n'est encore effectuée.

## Besoin

Permettre la récupération d'un compte `local-password` OWASYS dont le mot de passe est oublié, sans affaiblir la fresh-auth et sans inventer un canal de récupération navigateur non configuré.

## Livrable R45D2A19

```text
ZIP     : opus_p117w_r45d2a19_local_password_break_glass_recovery.zip
SHA-256 : 59614da089f0b8736823dc1159c3f793424538de0b866c231a06168b6333ecab
BASE    : 6f82ea0ad46eadd11435e02bc2dd1ff703034c02
FILES   : 4
```

Correction : généraliser `opus:local-password-reset` aux applications OPUS standard à provider `local-password`, ajouter `--must-change`, préserver STDIN-only pour le secret et conserver la compatibilité des sites générés.

## Comportement recovery cible

```text
operator console
-> temporary password via STDIN
-> reset owasys-front subject --must-change
-> login with temporary password
-> FSM password_change_required
-> /account/password
-> replace temporary password
-> normal access
```

Pour Auth0-proxy : recovery gérée par l'IdP, jamais par le store local OWASYS.

## Gate immédiat

1. extraire R45D2A19 ;
2. lints ;
3. smoke `OPUS_R45D2A19_SMOKE_OK` ;
4. dump-autoload/status ;
5. test recovery uniquement si souhaité ;
6. retour au gate Sécurité R45D2A18D : saisir de nouveau le mot de passe et effectuer Commit ;
7. ensuite developer puis viewer selon la matrice ACL.

## Invariants

- admin + developer : mutation Sécurité ;
- viewer : lecture seule ;
- viewer sans Profiler ;
- fresh-auth inchangée ;
- aucune preuve/timestamp substituée au mot de passe ;
- aucun mot de passe en argv/log/Profiler ;
- aucun endpoint browser reset local sans canal de récupération vérifié ;
- aucune modification OPUS/OWASYS poussée par l'assistant.
