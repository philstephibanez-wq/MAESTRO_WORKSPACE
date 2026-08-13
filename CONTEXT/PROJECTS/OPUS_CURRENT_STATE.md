# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-13.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 50d68b724a1f32201bd068e0cb23c9f925780093
Commit : opus_p117w_r45d2a20_standard_local_password_role_provisioning
```

R45D2A21 et R45D2A21B sont appliqués localement par l’owner mais ne sont pas considérés publiés tant que l’owner ne les a pas commit/push.

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
- R45D2A21B local : dashboard graphique fonctionnel.

## Retour visuel owner

R45D2A21 : « pas terrible ».

R45D2A21B : **« C'est un peu mieux »**.

Le modèle sécurité n’est pas remis en cause. Le défaut restant est la densité du premier viewport : le formulaire d’ajout ouvert domine encore l’écran et masque les panneaux Utilisateurs / Agents.

## Contrat UX Sécurité

Le modèle reste :

`identité -> attribution de rôle/scope -> rôle -> permission resource:action -> ressource -> ACL -> décision`.

Vocabulaire visible :

- Ajouter un utilisateur ou un agent ;
- à terme Modifier un utilisateur ou un agent ;
- à terme Supprimer un utilisateur ou un agent.

OWASYS doit privilégier cockpit, métriques, cartes, badges, flow graphique et accordéons compacts. SCORE/CSS uniquement au runtime.

## Livrable actif — R45D2A21C

```text
ZIP     : opus_p117w_r45d2a21c_security_compact_cockpit.zip
SHA-256 : 5072d4f5b0e9f2b6ffdbda00f6a16c07df225747ac2b7cc6a3c08bbbc4bd3cd2
PREREQ  : R45D2A21B appliqué
FILES   : 2 scripts PHP
```

R45D2A21C :

- dashboard encore compacté ;
- métrique `À classifier` si legacy présent ;
- deux quick-actions Utilisateur / Agent fermées par défaut ;
- formulaire affiché seulement à la demande ;
- provider déplacé dans Détails techniques, prérempli et modifiable ;
- panneaux Utilisateurs / Agents visibles directement ;
- empty states compacts ;
- état des identités distinguable visuellement ;
- aucune modification backend/FSM/fresh-auth/ACL ;
- aucun JS/Mermaid runtime.

## Gate owner

```text
OPUS_R45D2A21C_APPLIED
OPUS_R45D2A21C_SMOKE_OK
```

Puis capture navigateur developer. La qualité du premier viewport reste le gate avant toute nouvelle fonction.

## Suite après validation visuelle

1. gate viewer ACL ;
2. smoke complet admin/developer/viewer front+back ;
3. backend atomique Modifier/Supprimer utilisateur ou agent ;
4. exposition des boutons seulement après support backend.

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
