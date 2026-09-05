# P117W R8SEC2A — Windows-safe baseline gate

## Cause

R8SEC2 n'a pas appliqué de modification : son applicateur comparait le SHA Git blob attendu avec un SHA recalculé depuis les octets du working tree. Sous Windows, une conversion de fins de ligne (CRLF) peut produire un SHA différent alors que Git considère le fichier identique et le working tree propre.

## Correction

La gate de baseline doit être basée sur l'objet Git de HEAD et sur la propreté Git du fichier, pas sur les octets matérialisés du working tree.

Pour chaque cible :

1. vérifier que le fichier existe ;
2. vérifier `git diff --quiet -- <path>` ;
3. lire le blob canonique de HEAD via `git rev-parse HEAD:<path>` ;
4. comparer ce SHA au blob SHA attendu du dépôt GitHub master courant ;
5. seulement ensuite modifier le fichier matérialisé.

Cette correction ne change pas le périmètre fonctionnel R8SEC2 : enforcement de la quarantaine persistante avant métier, NMI `security_violation -> security_quarantine`, NMI `critical_error/fail -> fault`, sans recovery automatique.

## Critère

Un dépôt Windows propre avec CRLF ne doit plus produire de faux `BASELINE_MISMATCH`. Un fichier réellement modifié localement doit rester bloquant.
