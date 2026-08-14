# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-14

## Lecture obligatoire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A24_IDENTITY_LIFECYCLE_BACKEND_2026-08-13.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25_IDENTITY_LIFECYCLE_UI_2026-08-13.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25F_PRINCIPAL_COLUMN_CONSOLIDATION_2026-08-14.md`
8. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base OPUS publiée

`de6c8e74985f690f18e77ea701555712aa598c24` — `opus_p117w_r45d2a25f_principal_column_consolidation`.

## Gates acquis — lifecycle Identités

- routes frontend localisées avec accents ;
- backend `identity.update` / `identity.delete` avec Preview/Commit ;
- exposition SCORE lifecycle admin/developer ;
- navigation métrique `À classifier` ;
- suppression réelle d'une identité legacy validée ;
- classification réelle `unknown -> user` validée sur `steve`, rôle `admin` conservé ;
- conflits métier Security localisés explicitement ;
- protection de la dernière identité administrative validée : suppression de `steve` refusée avant écriture ;
- actions Modifier/Supprimer compactes ;
- un seul cadre Utilisateurs et un seul cadre Agents, création intégrée à la liste ;
- les contrôles restent sous capacités dérivées de `$canMutate`, donc aucun contrôle de mutation en viewer.

## État navigateur courant

- 1 Utilisateur : `steve`, état `active`, rôle `admin` ;
- 0 Agent ;
- 1 identité legacy restante : `home`.

## Audit des autres objets Security

Le backend courant ne supporte que les mutations additives :

- `role.create` ;
- `permission.grant` ;
- `assignment.grant` ;
- `resource.allow`.

Le contrat Security exige notamment la révocation d'une attribution de rôle et interdit toute opération supprimant le dernier administrateur actif.

## Gate actif

R45D2A26 — Assignment Revoke Backend :

- ajouter `assignment.revoke` au backend Security ;
- Preview avec `access_delta.lost` ;
- Commit atomique sur le store local ;
- refus si la révocation supprimerait le dernier administrateur effectif ;
- aucune UI dans cet incrément ;
- aucun changement REST/FSM de surface : réutilisation du pipeline mutation existant.

NO VIEWER MUTATION.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
