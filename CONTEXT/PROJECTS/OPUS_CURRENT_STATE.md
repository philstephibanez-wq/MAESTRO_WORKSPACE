# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-13.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 50d68b724a1f32201bd068e0cb23c9f925780093
Commit : opus_p117w_r45d2a20_standard_local_password_role_provisioning
```

R45D2A21/B/C, R45D2A22, R45D2A22B et R45D2A22C1 sont locaux tant que l’owner ne les a pas commit/push.

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
- viewer Build : lecture validée.
- R45D2A22B : le lien Profiler est ACL-driven et l’URL directe `/fr-FR/build?profiler=1` est refusée au viewer.

## Présentation ACL Denied

Le refus ACL fonctionne, mais la page brute `OPUS_ACL_DENIED` doit être remplacée par une surface SCORE graphique.

La première tentative R45D2A22C n’a modifié aucun fichier OPUS : l’applicateur et son smoke avaient un défaut d’interpolation de chaînes PHP (`$message`, `$current`, `$parts`). L’owner a confirmé après échec :

```text
OPUS_R45D2A22B_PROFILER_ACL_PRESENTATION_GUARD_OK
OPUS_R45D2A22_ROLE_CAPABILITY_MATRIX_OK front_cases=66 back_cases=42
git status --short = vide
```

## Livrable actif — R45D2A22C1

```text
ZIP     : opus_p117w_r45d2a22c1_acl_denied_visual_error_installer_fix.zip
SHA-256 : 50bec2004a29e5fdaa71f12664bea8be542cbfe734f7800e6ca2c948a634e7b6
PREREQ  : R45D2A22B appliqué ; R45D2A22C non appliqué
FILES   : 3
```

C1 corrige le livrable, pas la logique ACL :

- chaînes de recherche littérales ;
- smoke sans interpolation ;
- préflight complet avant écriture ;
- page SCORE graphique 403 ;
- détail `resource:action` préservé ;
- locale de la requête conservée ;
- 25 langues de base ;
- aucun JavaScript ;
- aucun hardcode viewer.

## Gate owner

```text
OPUS_R45D2A22C1_APPLIED locales=25
OPUS_R45D2A22C1_ACL_DENIED_VISUAL_ERROR_OK locales=25
OPUS_R45D2A22B_PROFILER_ACL_PRESENTATION_GUARD_OK
OPUS_R45D2A22_ROLE_CAPABILITY_MATRIX_OK front_cases=66 back_cases=42
```

Puis : viewer `/fr-FR/build?profiler=1` => page graphique HTTP 403 avec `profiler:view`, Build normal sans lien Profiler, puis Compte/password disponible.

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
