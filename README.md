# MAESTRO WORKSPACE

Workspace global de coordination pour MAESTRO, OPUS, OWASYS, la documentation OPUS, LSTSAR, KB et LOGANDPLAY.

OPUS fait partie du workspace ; OPUS n'est ni le workspace ni une application.

## Reprise immédiate

Lire dans cet ordre :

1. `README-FIRST.md`
2. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`
3. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
4. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md`
6. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`
7. `CONTEXT/PROJECTS/PROJECT_INDEX.md`

La continuité vient des dépôts GitHub et du workspace versionné, jamais du seul contexte d'un chat.

## Source de vérité active

```text
OPUS repository : philstephibanez-wq/OPUS
branch          : master
owner head      : bf190ab7afecc09493d2d5c98513420613f45fbc
acquired        : R46B9
owner delivery  : R46B11
workspace       : philstephibanez-wq/MAESTRO_WORKSPACE
```

R46B10 est annulé et interdit. R46B11 est livré sur le HEAD indiqué et attend validation, commit et push owner.

## R46B11

```text
ZIP     : opus_p117w_r46b11_fsm_signal_contract.zip
SHA-256 : 7c78b527357f5adc37d87109b94c06eec2a1be454eee5a3744e4732dc5a3fcd0
FILES   : 17
CONTRACT: table_fsm + current_state + signal -> next_state
```

Aucun alias silencieux `event/from_state/to_state`. Le nom réel de la table est affiché systématiquement. Une garde refusée conserve la cible candidate ; un signal inconnu produit `transition_not_found` sans cible inventée.

## Architecture OWASYS

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer
             <- réponse       <-
```

- `owasys-front` : application OPUS autonome, Singleton, interface SCORE uniquement.
- `owasys-back` : application OPUS autonome, Singleton, REST sécurisé, logique métier et Composer allow-listé.
- Déploiement possible sur deux bastions distincts.
- Aucun JavaScript, TypeScript, Node ou gestionnaire JavaScript dans le backend.
- Logger et Profiler obligatoires dans les deux applications.

## Contrat global

- relire GitHub et les contrats avant tout changement ;
- traiter la cause ;
- toute classe concrète OPUS implémente son interface homonyme à quatre marqueurs ;
- livrer OPUS/OWASYS uniquement par ZIP différentiel direct de fichiers complets ;
- l'assistant n'écrit directement que dans `MAESTRO_WORKSPACE` ;
- applications Singleton, FSM, I18n, ACL deny-by-default, SSO/Auth0-proxy, bastion et SCORE ;
- configuration via `File`, puis `Json`, `Xml` ou `Yaml` ;
- aucun echo UI, aucun mélange HTML/PHP, aucun fallback silencieux ;
- secrets interdits dans Git, argv, logs, Profiler et artefacts.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO BRICOLAGE DELIVERY.  
NO FALLBACK SILENCIEUX.
