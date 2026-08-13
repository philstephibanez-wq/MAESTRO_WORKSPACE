# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-13.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 50d68b724a1f32201bd068e0cb23c9f925780093
Commit : opus_p117w_r45d2a20_standard_local_password_role_provisioning
```

R45D2A21/B/C et R45D2A22 sont appliqués localement par l’owner mais ne sont pas considérés publiés tant que l’owner ne les a pas commit/push.

## États acquis

- R45D2A12 : UI Sources/Git alignée sur ACL `source/write`.
- R45D2A14B : logout généré acquis.
- R45D2A15B : catalogues REST synchronisés.
- R45D2A16 : matrice Sécurité admin/developer/viewer.
- R45D2A16B : dev-server single-owner binding acquis.
- R45D2A18B/C/D : intégrité REST->Composer, fresh-auth et Security Mutation FSM atomique acquis.
- admin et developer Security Preview + Commit acquis.
- R45D2A19 : break-glass local-password acquis.
- R45D2A19C/D : changement de mot de passe local possédé par le front ; aucun password local via REST.
- R45D2A20 : provisioning local-password par rôle pour application OPUS standard publié.
- R45D2A21 local : `identity_type=user|agent`, legacy `unknown`.
- R45D2A21B local : dashboard graphique.
- R45D2A21C local : cockpit compact.
- R45D2A21C : gate visuel accepté.
- **R45D2A22 : contrat exécutable de matrice validé owner** : `OPUS_R45D2A22_ROLE_CAPABILITY_MATRIX_OK front_cases=66 back_cases=42`.
- `git status --short` vide après le smoke R45D2A22.

## Contrat UX Sécurité

Le modèle reste :

`identité -> attribution de rôle/scope -> rôle -> permission resource:action -> ressource -> ACL -> décision`.

Vocabulaire visible :

- Ajouter un utilisateur ou un agent ;
- à terme Modifier un utilisateur ou un agent ;
- à terme Supprimer un utilisateur ou un agent.

OWASYS privilégie cockpit, métriques, cartes, badges, flow graphique et accordéons compacts. SCORE/CSS uniquement au runtime.

## Gate actif — viewer navigateur

La matrice statique et structurelle étant acquise, le prochain gate est fonctionnel dans le navigateur :

- session `viewer · viewer` ;
- Applications/Structure/Data/Workflows/Sécurité/Sources-Git/Build accessibles en lecture selon contrat ;
- création/suppression application absentes ;
- mutations Sécurité absentes/refusées ;
- Source preview/write et Git stage/unstage/commit/restore absents/refusés ;
- changement de son propre mot de passe disponible ;
- Profiler absent et `?profiler=1` refusé.

Aucun nouveau patch avant résultat de ce gate.

## Suite après gate viewer

Si conforme : backend atomique Modifier/Supprimer utilisateur ou agent, avec preview/fresh-auth/commit/rollback/protection du dernier administrateur, puis exposition UI seulement après support réel.

NO HARDCODED ACCOUNT.
NO MANUAL STORE EDIT.
NO PASSWORD IN ARGV/GIT/LOG/PROFILER.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PRIMARY_ROLE AUTHORIZATION.
NO IDENTITY TYPE INFERENCE.
NO JS/MERMAID RUNTIME IN OWASYS.
NO FAKE MODIFY/DELETE BUTTON.
NO PUSH OPUS/OWASYS BY ASSISTANT.
