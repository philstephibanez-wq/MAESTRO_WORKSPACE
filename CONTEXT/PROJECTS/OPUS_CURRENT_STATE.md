# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-13.

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
- R45D2A21 appliqué localement : `identity_type=user|agent`, anciennes identités `unknown`, accordéons fonctionnels.

## Retour visuel owner

R45D2A21 n’est pas accepté visuellement.

La page reste trop proche d’un formulaire technique : cadres imbriqués, trop d’espace vide, bloc legacy surdimensionné, action principale trop basse, détails techniques trop visibles et message FSM trop dominant.

Aucune remise en cause du modèle :

`identité -> attribution de rôle/scope -> rôle -> permission resource:action -> ressource -> ACL -> décision`.

## Contrat UX Sécurité

Vocabulaire visible :

- Ajouter un utilisateur ou un agent ;
- à terme Modifier un utilisateur ou un agent ;
- à terme Supprimer un utilisateur ou un agent.

OWASYS doit viser un cockpit graphique : dashboard, compteurs, cartes, badges, schéma de relations et accordéons compacts. SCORE/CSS uniquement au runtime.

## Livrable actif — R45D2A21B

```text
ZIP     : opus_p117w_r45d2a21b_security_visual_dashboard.zip
SHA-256 : 0ccf2e5d71260dc3917bbc79aab39f817cb4a4bbd5266d3a02707b2de616cca6
PREREQ  : R45D2A21 appliqué
FILES   : 3
```

R45D2A21B :

- dashboard sécurité compact ;
- métriques Utilisateurs / Agents / Rôles / Ressources ;
- flow graphique compact ;
- CTA Ajouter remonté ;
- sélecteur graphique user/agent sans JS ;
- panneaux Utilisateurs/Agents ;
- détails techniques repliés ;
- legacy « À classifier » compact ;
- compteurs techniques ;
- message humain pour workflow-state invalid, sans bypass FSM ;
- I18n UE + ukrainien.

## Gate owner

```text
OPUS_R45D2A21B_APPLIED locales=25
OPUS_R45D2A21B_SMOKE_OK locales=25
```

Puis jugement visuel owner dans le navigateur avant toute nouvelle fonction.

## Suite planifiée après validation visuelle

1. gate viewer ACL ;
2. smoke complet admin/developer/viewer front+back ;
3. backend atomique Modifier/Supprimer utilisateur ou agent ;
4. exposition UI de ces actions seulement après backend.

NO HARDCODED ACCOUNT.
NO MANUAL STORE EDIT.
NO PASSWORD IN ARGV/GIT/LOG/PROFILER.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PRIMARY_ROLE AUTHORIZATION.
NO IDENTITY TYPE INFERENCE.
NO MERMAID/JS RUNTIME IN OWASYS.
NO FAKE MODIFY/DELETE BUTTON.
NO PUSH OPUS/OWASYS BY ASSISTANT.
