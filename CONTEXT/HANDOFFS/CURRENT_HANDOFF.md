# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-30

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R38_REMOVE_LAYERED_CREATION_AND_REGISTRY_SPLIT_BRAIN_2026-07-29.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R39_OWNER_REMOVE_REST_REPLAY_STORE_2026-07-29.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R40_OWNER_REMOVE_DEMO_OPUS_LAYERED_RESIDUE_2026-07-30.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R41_OWASYS_FULLSTACK_CREATION_ACCEPTANCE_2026-07-30.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R42_GENERIC_DEVELOPMENT_SERVER_2026-07-30.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R43_OWASYS_APPLICATION_CREATION_WIZARD_2026-07-30.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R43_OWASYS_APPLICATION_CREATION_WIZARD_2026-07-30.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source canonique

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche    : master
HEAD owner : 98842dba015402af7e8b3421e62032236c2d8f30
Racine     : H:\OPUS
```

## État acquis

- R38 : génération layered supprimée ;
- R39 : stockage REST replay non borné supprimé ;
- R40 : ancien `sites/demo-opus` layered supprimé ;
- R42 : serveur de développement générique appliqué au commit `bbac194f` ;
- nouveau `sites/opus-demo` supprimé par l’owner au commit `98842dba` ;
- exactement deux applications OWASYS autonomes : `owasys-front` et `owasys-back`.

## Action active — R43

Corriger la cause dans le workflow OWASYS `new`.

Le futur assistant collecte identité, profil, authentification, page de login éventuelle, fournisseur SSO, utilisateurs initiaux, rôles, permissions et ACL. Il initialise les 24 langues officielles de l’Union européenne plus l’ukrainien, affiche un récapitulatif, puis exécute une création atomique via REST sécurisé et Composer allow-listé.

Le site initial contient seulement une page d’accueil, et une page de connexion uniquement si elle est explicitement demandée. Les pages suivantes sont ajoutées par un workflow distinct corrélant route, FSM, ViewModel, SCORE, navigation, ACL et I18n.

## Autorité

```text
Assistant : MAESTRO_WORKSPACE + ZIP différentiel seulement
Owner     : application, validation, commit et push OPUS/OWASYS
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO PARTIAL SITE.
