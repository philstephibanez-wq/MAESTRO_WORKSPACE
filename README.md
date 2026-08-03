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
owner head      : ad33c64cb091711bcf98e7a1c9307cb4029e0ca6
acquired        : R45A2 + R46B15
owner delivery  : R45A3
workspace       : philstephibanez-wq/MAESTRO_WORKSPACE
```

R46B10 est annulé et interdit. Le workflow actif est la création d'un site. R45A3 doit être acquis avant R45B.

## R45A3

```text
ZIP     : opus_p117w_r45a3_rest_profiler_transaction_boundary.zip
SHA-256 : 6ceb5e5a55ca0b501dffc9748190fdc62b4a862ca8767df48fc278843e57b96d
FILES   : 1
BASE    : ad33c64cb091711bcf98e7a1c9307cb4029e0ca6
```

R45A3 empêche une panne de télémétrie postérieure de transformer un succès métier en échec REST, finalise la trace avant lecture et restitue les codes canoniques du scaffold. Après validation owner, R45B rendra les profils `frontend`, `backend` et `fullstack` réellement distincts.

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
