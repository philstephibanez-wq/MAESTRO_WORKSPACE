# OPUS P117W R45D2A25 — Identity lifecycle UI

Date : 2026-08-13

## Base canonique

`89a3004ab44f78b565b0229cd554658670696ff1` — `opus_p117w_r45d2a24_identity_lifecycle_backend`.

R45D2A24 est publié. Le backend Security supporte désormais `identity.reference`, `identity.update` et `identity.delete`, avec Preview/Commit, fresh-auth, rollback atomique, pertes d'accès et protection de la dernière identité administrative.

## Observation owner

La page `/fr-FR/sécurité?view=identities` est validée en session `viewer · viewer` : lecture seule, aucune action de mutation visible, 0 Utilisateur, 0 Agent, 3 identités À classifier. Cette présentation viewer est une non-régression obligatoire.

## Objectif R45D2A25

Exposer graphiquement dans OWASYS front, exclusivement via SCORE/CSS et sans JavaScript, le cycle de vie Utilisateur/Agent déjà autorisé par le backend :

- Utilisateur : Modifier = transformer en Agent ; Supprimer ;
- Agent : Modifier = transformer en Utilisateur ; Supprimer ;
- identité legacy `unknown` : classifier explicitement en Utilisateur ou Agent ; Supprimer ;
- provider+subject restent immuables ;
- rôles et permissions restent gérés séparément ;
- toute action passe par le FSM Security existant Preview -> fresh-auth -> Commit ;
- la Preview affiche aussi `access_delta.lost` avant toute suppression ;
- l'erreur `OWASYS_SECURITY_LAST_ADMINISTRATOR_DELETE_FORBIDDEN` reçoit une présentation utilisateur explicite.

## ACL / présentation

Les contrôles lifecycle sont exposés seulement si les deux conditions sont vraies :

1. l'identité OWASYS courante possède `security:manage` ;
2. le snapshot backend annonce la capacité correspondante.

Les flags `identity_update_supported`, `identity_delete_supported` et `destructive_mutations_supported` sont donc tous liés à `$canMutate`. Un viewer ne doit jamais recevoir les formulaires Modifier/Supprimer/Classifier dans le rendu SCORE. Le backend reste l'autorité ACL finale.

## I18n

Les nouveaux libellés sont ajoutés dans les 25 catalogues de langue de base de `application/security/local`. Les catalogues régionaux continuent d'hériter de leur langue de base. Les accents et caractères natifs sont conservés.

## Front uniquement

Aucune nouvelle route REST, aucune nouvelle commande Composer et aucune modification de `owasys-back` ne sont requises par ce livrable. Le backend R45D2A24 est seulement vérifié comme prérequis.

## Livrable

```text
ZIP     : opus_p117w_r45d2a25_identity_lifecycle_ui.zip
SHA-256 : 329827a9fff3f70d3d20c80adc7bb8c33651cced8a609c3e6fb2be5d9c045e92
BASE    : 89a3004ab44f78b565b0229cd554658670696ff1
FILES   : 3
```

Gate attendu :

`OPUS_R45D2A25_IDENTITY_LIFECYCLE_UI_OK locales=25`

Puis contrôle navigateur en `developer` ou `admin` sur une identité de test ; enfin recontrôle `viewer` : aucune action lifecycle visible.

NO VIEWER MUTATION.
NO DIRECT DELETE.
NO IDENTITY KEY RENAME.
NO ROLE MUTATION INSIDE IDENTITY UPDATE.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
