# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-28

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R29_SOURCE_RESOURCE_GET_URL_2026-07-28.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R29_SOURCE_RESOURCE_GET_URL_2026-07-28.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 9416cab744c12191e4d5153b50521befb573d41f
Racine owner : H:\OPUS
P117W R28 : présent sur master
```

## R29

Chaque fichier source est une ressource GET adressable sous :

```text
/<locale>/source/<chemin-relatif-encodé-par-segment>
```

Le chemin n'est plus envoyé dans un formulaire POST. Le lien fonctionne sans
JavaScript. Avec JavaScript, CodeMirror et l'URL sont mis à jour sans
reconstruction de l'arborescence.

## Livrable actif

```text
ZIP : opus_p117w_r29_source_resource_get_url.zip
Base : OPUS master 9416cab744c12191e4d5153b50521befb573d41f
SHA-256 : 52d1b3cc95038702c43924b204eb21df942635d392b61d47f01943d8c52d5fe3
Fichiers : 4
```

## Lancement

```text
composer opus:dev-server -- owasys-front
composer opus:dev-server -- owasys-back
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
