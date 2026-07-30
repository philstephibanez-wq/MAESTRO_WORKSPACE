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
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R41_FULLSTACK_CREATION_2026-07-30.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source canonique

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche    : master
HEAD owner : a93d9dd11d76fd17e4444ddb32c086d71cd74521
Racine     : H:\OPUS
```

## État acquis

- R38 : génération layered supprimée ;
- R39 : stockage REST replay non borné supprimé par l’owner ;
- R40 : `sites/demo-opus` supprimé, validations OWASYS et Registry réussies ;
- exactement deux applications OWASYS autonomes : `owasys-front` et `owasys-back`.

## Action active — R41

Créer depuis OWASYS un nouveau site de profil `fullstack`, puis le conserver comme nouvelle base applicative.

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer opus:create-site
-> scaffold OPUS autonome -> registry.sync -> sélection -> Construction
```

Le site doit être plat sous `sites/<application-id>/{application,config,www}`. Toute couche `application/shared`, `application/front`, `application/back` ou clé `application_layers` est interdite.

Aucun patch OPUS/OWASYS n’est actif avant l’essai owner. En cas d’échec, diagnostiquer le premier défaut corrélé par `trace_id` et livrer un ZIP différentiel fondé sur le HEAD exact. Ne pas demander de diagnostics locaux pour des fichiers accessibles sur GitHub.

## Autorité

```text
Assistant : MAESTRO_WORKSPACE + ZIP différentiel seulement
Owner     : application, validation, commit et push OPUS/OWASYS
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO SHARED LAYER.
