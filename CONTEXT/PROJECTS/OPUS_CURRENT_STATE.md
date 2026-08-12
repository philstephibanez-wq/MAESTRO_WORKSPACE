# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-12.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 50d68b724a1f32201bd068e0cb23c9f925780093
Commit : opus_p117w_r45d2a20_standard_local_password_role_provisioning
```

## États acquis

- R45D2A12 : UI Sources/Git alignée sur ACL `source/write`.
- R45D2A14B : logout généré acquis.
- R45D2A15B : catalogues REST synchronisés.
- R45D2A16 : matrice Sécurité admin/developer/viewer.
- R45D2A16B : dev-server single-owner binding acquis.
- R45D2A18B/C/D : intégrité REST->Composer, secret fresh-auth dev et Security Mutation FSM atomique acquis.
- admin Security Preview + Commit acquis.
- R45D2A19 : break-glass local-password acquis.
- R45D2A19B : page account/password I18n acquise.
- R45D2A19C/D : changement de mot de passe local possédé par le front et ancien flux backend supprimé.
- R45D2A20 : provisioning local-password par rôle pour `standard-opus-application` publié.
- compte runtime developer opérationnel.
- developer Security Preview + Commit acquis.

## Matrice ACL cible

La matrice admin/developer/viewer reste contractuelle :

- admin : toutes capacités ;
- developer : mutations registry/creation/structure/data/workflows/source/git/build/account/security + `profiler:view` ;
- viewer : lecture registry/structure/data/workflows/security/source/git/build, `account:open` + `account:change`, sans Profiler et sans mutation.

La décision est fondée sur les permissions ACL effectives, jamais `primary_role` seul.

## Contrat UX Sécurité

Le vocabulaire visible doit être compréhensible :

- Ajouter un utilisateur ou un agent ;
- Modifier un utilisateur ou un agent ;
- Supprimer un utilisateur ou un agent.

Le modèle interne reste `identity`, unique par `provider + subject`.

Les droits portent sur des ressources selon :

`identité -> attribution de rôle/scope -> rôle -> permission resource:action -> ressource -> ACL -> décision`.

OWASYS doit privilégier une présentation graphique : cartes, badges, arbres, accordéons SCORE natifs et schémas de relations. Mermaid est réservé à la documentation Workspace ; aucune dépendance Mermaid/Node n’est chargée au runtime OWASYS.

## Livrable actif — R45D2A21

```text
ZIP     : opus_p117w_r45d2a21_security_visual_workspace.zip
SHA-256 : 86ad0e9f9815d0af56d416bf6939b944656f344dc62227fb7e2bb513567a426a
BASE    : 50d68b724a1f32201bd068e0cb23c9f925780093
FILES   : 3
```

R45D2A21 :

- ajoute `identity_type=user|agent` aux nouvelles identités ;
- conserve les identités legacy en `unknown` plutôt que de les deviner ;
- rend un schéma relationnel visuel SCORE/CSS ;
- affiche les blocs Sécurité en accordéons ;
- sépare Utilisateurs / Agents / À classifier ;
- remplace le libellé technique « Référencer une identité » par « Ajouter un utilisateur ou un agent » ;
- maintient les mutations backend et la fresh-auth comme autorité ;
- I18n UE + ukrainien ;
- aucun JS/Mermaid runtime.

## Gate owner

```text
OPUS_R45D2A21_APPLIED locales=25
OPUS_R45D2A21_SMOKE_OK locales=25
```

Puis test navigateur developer : carte graphique, accordéons, ajout d’une identité typée, Preview, Commit, classement dans le bon accordéon.

## Suite planifiée

1. gate viewer de la matrice ACL ;
2. smoke exécutable admin/developer/viewer front+back ;
3. implémenter les mutations backend Modifier/Supprimer utilisateur ou agent avant d’exposer ces boutons.

NO HARDCODED ACCOUNT.
NO MANUAL STORE EDIT.
NO PASSWORD IN ARGV/GIT/LOG/PROFILER.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PRIMARY_ROLE AUTHORIZATION.
NO IDENTITY TYPE INFERENCE.
NO MERMAID/JS RUNTIME IN OWASYS.
NO PUSH OPUS/OWASYS BY ASSISTANT.
