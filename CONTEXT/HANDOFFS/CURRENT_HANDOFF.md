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
CONTEXT/SPECIFICATIONS/OPUS_P117W_R42_GENERIC_DEVELOPMENT_SERVER_2026-07-30.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R42_GENERIC_DEVELOPMENT_SERVER_2026-07-30.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source canonique

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche    : master
HEAD owner : cefabc43972adaa454e311a99959ae15b09d9809
Racine     : H:\OPUS
```

## État acquis

- R38 : génération layered supprimée ;
- R39 : stockage REST replay non borné supprimé par l’owner ;
- R40 : `sites/demo-opus` supprimé, validations OWASYS et Registry réussies ;
- exactement deux applications OWASYS autonomes : `owasys-front` et `owasys-back`.

## Action active — R42

Appliquer le correctif générique du serveur de développement, puis valider :

```text
composer opus:dev-server -- opus-demo
composer opus:dev-server -- opus-demo --host=127.0.0.1 --port=8000
```

`php -S` reste exclusivement local et temporaire. La production reste sous
Apache, Nginx ou un autre serveur web avec document root
`sites/<application-id>/www`.

Le ZIP R42 remplace uniquement
`Opus/Console/Service/SiteCommandService.php`. Aucun fichier propre à
`opus-demo`, `owasys-front` ou `owasys-back` n’est modifié.

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
