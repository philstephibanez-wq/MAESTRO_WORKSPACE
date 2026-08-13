# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-13.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 50d68b724a1f32201bd068e0cb23c9f925780093
Commit : opus_p117w_r45d2a20_standard_local_password_role_provisioning
```

R45D2A21/B/C et R45D2A22 sont appliqués localement par l’owner mais non considérés publiés tant que l’owner ne les a pas commit/push.

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
- R45D2A21C local : cockpit compact ; gate visuel accepté.
- R45D2A22 validé owner : `OPUS_R45D2A22_ROLE_CAPABILITY_MATRIX_OK front_cases=66 back_cases=42`.
- viewer runtime provisionné et authentifié `viewer · viewer`.
- viewer Sécurité : lecture seule validée.
- viewer Sources/Git : lecture seule validée.
- viewer Build : lecture validée, mais lien global `OPUS Profiler` visible => gate non conforme.

## Divergence active — Profiler viewer

La matrice exige : `Profiler = admin ✅ / developer ✅ / viewer ❌`, y compris par URL directe.

Cause confirmée :

- Build n’est pas la source du lien ;
- le layout SCORE partagé affiche le Profiler sans garde ACL ;
- le renderer partagé ne connaît pas la capacité `profiler:view` et utilise seulement la query `profiler=1` ;
- le endpoint de trace est déjà gardé par ACL ;
- les refus ACL du composition root doivent être convertis en HTTP 403.

## Livrable actif — R45D2A22B

```text
ZIP     : opus_p117w_r45d2a22b_profiler_acl_presentation_guard.zip
SHA-256 : 7baa608c1a5c305d6d69cb8e7973de8b3f44e3f1d2c037a68e71def010db79b8
PREREQ  : R45D2A22 appliqué ; R45D2A21C local
FILES   : 2
```

Le correctif central utilise exclusivement la décision ACL effective : aucun test de `primary_role`, aucun hardcode viewer, aucun masquage CSS.

## Gate owner

```text
OPUS_R45D2A22B_APPLIED
OPUS_R45D2A22B_PROFILER_ACL_PRESENTATION_GUARD_OK
OPUS_R45D2A22_ROLE_CAPABILITY_MATRIX_OK front_cases=66 back_cases=42
```

Puis : viewer Build sans lien Profiler, `/fr-FR/build?profiler=1` refusé HTTP 403, puis Compte/password disponible.

## Suite après gate viewer

Si conforme : backend atomique Modifier/Supprimer utilisateur ou agent, avec preview/fresh-auth/commit/rollback/protection du dernier administrateur, puis exposition UI seulement après support réel.

NO HARDCODED ACCOUNT.
NO MANUAL STORE EDIT.
NO PASSWORD IN ARGV/GIT/LOG/PROFILER.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO VIEWER PROFILER.
NO PRIMARY_ROLE AUTHORIZATION.
NO IDENTITY TYPE INFERENCE.
NO JS/MERMAID RUNTIME IN OWASYS.
NO CSS-ONLY HIDING.
NO FAKE MODIFY/DELETE BUTTON.
NO PUSH OPUS/OWASYS BY ASSISTANT.
