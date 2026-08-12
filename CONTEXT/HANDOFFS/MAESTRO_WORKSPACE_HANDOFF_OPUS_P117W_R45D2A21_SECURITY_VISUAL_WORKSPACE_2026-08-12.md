# HANDOFF — OPUS P117W R45D2A21 Security Visual Workspace

Date : 2026-08-12

## Base

OPUS master : `50d68b724a1f32201bd068e0cb23c9f925780093` (`opus_p117w_r45d2a20_standard_local_password_role_provisioning`).

## États owner acquis

- R45D2A20 publié ;
- compte runtime `developer` authentifiable ;
- developer Security accessible ;
- developer Security Preview acquis ;
- developer Security Commit acquis ;
- matrice ACL admin/developer/viewer conservée ;
- changement de mot de passe / break-glass acquis.

## Décisions UX acquises

- libellé compréhensible : **Ajouter / modifier / supprimer un utilisateur ou un agent** ;
- le modèle interne reste `identity` ;
- les droits portent sur des **ressources** ;
- OWASYS doit être aussi graphique que possible ;
- accordéons souhaités pour utilisateurs, agents, rôles, permissions, attributions, ressources/ACL ;
- Mermaid autorisé dans la documentation Workspace, pas comme dépendance runtime OWASYS.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a21_security_visual_workspace.zip
SHA-256 : 86ad0e9f9815d0af56d416bf6939b944656f344dc62227fb7e2bb513567a426a
BASE    : 50d68b724a1f32201bd068e0cb23c9f925780093
FILES   : 3
```

R45D2A21 introduit explicitement `identity_type=user|agent`, classe les identités historiques en `unknown`, puis rend la page Sécurité sous forme de carte de flux + accordéons SCORE/CSS.

## Gate owner immédiat

```text
OPUS_R45D2A21_APPLIED locales=25
OPUS_R45D2A21_SMOKE_OK locales=25
```

Ensuite :

1. redémarrer front/back ;
2. se connecter comme developer ;
3. ouvrir Sécurité ;
4. vérifier la carte graphique et les accordéons ;
5. ajouter une nouvelle identité en choisissant `Utilisateur` ou `Agent` ;
6. Preview ;
7. Commit ;
8. vérifier qu’elle réapparaît dans le bon accordéon ;
9. ne pas tester Modifier/Supprimer : le backend courant garde `destructive_mutations=false`.

## Suite

Après validation R45D2A21 :

- reprendre le gate viewer de la matrice ACL ;
- puis implémenter contractuellement les mutations Modifier/Supprimer utilisateur ou agent, avec protection du dernier administrateur, preview, fresh-auth, commit atomique et rollback.

NO UI-ONLY AUTHORIZATION.
NO IDENTITY TYPE INFERENCE.
NO MERMAID/JS RUNTIME IN OWASYS.
NO DESTRUCTIVE BUTTON WITHOUT BACKEND CONTRACT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
