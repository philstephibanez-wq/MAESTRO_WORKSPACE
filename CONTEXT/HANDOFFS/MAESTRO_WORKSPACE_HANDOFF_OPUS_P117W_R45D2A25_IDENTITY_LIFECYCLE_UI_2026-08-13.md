# HANDOFF — OPUS P117W R45D2A25 Identity lifecycle UI

Date : 2026-08-13

## Base OPUS publiée

`89a3004ab44f78b565b0229cd554658670696ff1` — `opus_p117w_r45d2a24_identity_lifecycle_backend`.

## Gate précédent

R45D2A24 est publié. Le backend `identity.update` / `identity.delete` est donc la base autoritative du lifecycle Utilisateur/Agent.

La capture owner de `/fr-FR/sécurité?view=identities` en `viewer · viewer` confirme la non-régression ACL de présentation : page en lecture seule, aucune action de mutation visible.

## Gate actif

R45D2A25 ajoute au front SCORE :

- Modifier Utilisateur -> Agent ;
- Modifier Agent -> Utilisateur ;
- classifier explicitement les identités legacy `unknown` ;
- Supprimer avec Preview obligatoire ;
- affichage des accès perdus dans Preview ;
- message explicite lorsque la dernière identité administrative est protégée ;
- formulaires lifecycle absents pour viewer.

Aucun changement REST/back/Composer. Aucun JavaScript.

## Livrable

```text
ZIP     : opus_p117w_r45d2a25_identity_lifecycle_ui.zip
SHA-256 : 329827a9fff3f70d3d20c80adc7bb8c33651cced8a609c3e6fb2be5d9c045e92
BASE    : 89a3004ab44f78b565b0229cd554658670696ff1
FILES   : 3
```

Gate CLI attendu :

`OPUS_R45D2A25_IDENTITY_LIFECYCLE_UI_OK locales=25`

## Gate navigateur

1. `developer` ou `admin` : une identité classifiée doit afficher Modifier et Supprimer.
2. Une identité `À classifier` doit proposer le classement Utilisateur/Agent.
3. Supprimer doit produire une Preview et montrer les pertes d'accès avant Commit.
4. La dernière identité administrative doit être refusée avec message utilisateur.
5. `viewer` : aucun contrôle Modifier/Supprimer/Classifier.

NO UI BYPASS.
NO VIEWER MUTATION.
NO DIRECT DELETE.
NO PUSH OPUS/OWASYS BY ASSISTANT.
