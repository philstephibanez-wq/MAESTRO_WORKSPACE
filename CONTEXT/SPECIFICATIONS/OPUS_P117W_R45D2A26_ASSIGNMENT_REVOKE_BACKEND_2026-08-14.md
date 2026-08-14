# OPUS P117W R45D2A26 — Assignment Revoke Backend

Date : 2026-08-14

## Base OPUS publiée

`de6c8e74985f690f18e77ea701555712aa598c24` — `opus_p117w_r45d2a25f_principal_column_consolidation`.

## Cause

Le lifecycle Identités est acquis, mais la vue Attributions reste additive : le backend sait `assignment.grant` mais ne sait pas révoquer une attribution de rôle. Le contrat de sécurité impose explicitement « attribuer ou révoquer un rôle à une identité dans un scope » et interdit de retirer le dernier administrateur actif.

## Contrat R45D2A26

Ajouter au pipeline Security existant :

- mutation `assignment.revoke` ;
- capacité `assignment_revoke` ;
- mêmes champs normalisés que `assignment.grant` : `subject`, `role` ;
- cible : store `local-password` runtime existant ;
- refus si l’identité ou l’attribution n’existe pas ;
- Preview indiquant `access_delta.lost = <subject>-><role>@application` ;
- Commit atomique via le pipeline existant ;
- rollback inchangé ;
- Logger/Profiler et fresh-auth inchangés ;
- refus `OWASYS_SECURITY_LAST_ADMINISTRATOR_ASSIGNMENT_REVOKE_FORBIDDEN` si la révocation ferait disparaître le dernier administrateur effectif ;
- aucune nouvelle route REST ou commande Composer ;
- aucune UI dans cet incrément ;
- aucun JavaScript.

## Protection administrative

La protection doit être dérivée de l’ACL existante, sans rôle `admin` hardcodé. Le calcul réutilise les rôles administratifs déduits par le backend et simule l’état après retrait du rôle pour le sujet local ciblé avant d’autoriser le plan.

## Gate

Le smoke doit prouver :

1. `assignment_revoke=true` lorsque le store runtime est disponible ;
2. Preview d’une révocation non administrative avec perte d’accès explicite ;
3. Commit supprimant exactement le rôle du store runtime ;
4. seconde révocation absente refusée ;
5. révocation du dernier rôle administratif refusée avant écriture ;
6. aucun secret écrit ou journalisé par le test.

NO VIEWER MUTATION.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
