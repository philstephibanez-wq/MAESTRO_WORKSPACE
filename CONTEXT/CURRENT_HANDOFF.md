# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-28

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R22_REGISTRY_PHYSICAL_RECONCILIATION_AND_APPLICATION_ROOT_2026-07-28.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R22_REGISTRY_PHYSICAL_RECONCILIATION_2026-07-28.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R23_GENERATED_SITE_SECURE_DELETION_2026-07-28.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R23_GENERATED_SITE_SECURE_DELETION_2026-07-28.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base exacte : 4868780af4dd65bb7e28d95c981d1a1c5800a243
Racine owner : H:\OPUS
P117W R21 : présent dans la base relue
```

## Architecture

```text
sites/owasys-front
sites/owasys-back

owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne restaurer aucun site OWASYS monolithique, shared ou `owasys_old*`.

## R22

Le Registry SQLite est réconcilié atomiquement avec les applications physiques
canoniques sous :

```text
H:\OPUS\sites\<application-id>\
```

Il reconnaît `OPUS_SITE_STANDARD_CONTRACT_CORE`, supprime les lignes SQLite
obsolètes et efface le contexte courant uniquement si l’application sélectionnée
a disparu.

## R23

Commande de suppression générique :

```text
composer opus:delete-site -- <id> --confirm=<id> [--write]
```

La suppression OWASYS est absolument interdite :

```text
owasys-front
owasys-back
```

Seules les applications au contrat standard, créées par Composer et placées
directement sous `sites/<id>`, sont supprimables. La suppression UI traverse
SCORE, FSM, ACL, SSO, REST sécurisé, FSM backend et Composer.

## Livrable actif

```text
ZIP : opus_p117w_r23_generated_site_secure_deletion.zip
Base : OPUS master 4868780af4dd65bb7e28d95c981d1a1c5800a243
Contenu : R22 + R23 cumulatif
SHA-256 : b4f29bd657aaec2faf52a883f4bedd03cc09d5356ef67bb2de03970baa17763b
Fichiers : 15
```

## Statut

```text
P117W R6 à R21 : présents dans la base relue
P117W R22 : inclus
P117W R23 : livrable actif
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
