# HANDOFF — OPUS P117W R45D2A22 / R45D2A22B

Date : 2026-08-13

## État acquis

- R45D2A21C visuellement accepté : cockpit Sécurité compact.
- modèle `identity_type=user|agent` conservé ; legacy `unknown` visible comme « À classifier ».
- developer Security Preview + Commit acquis.
- R45D2A22 validé : `OPUS_R45D2A22_ROLE_CAPABILITY_MATRIX_OK front_cases=66 back_cases=42`.
- viewer runtime provisionné avec rôle `viewer`.
- viewer / Sécurité validé en lecture seule.
- viewer / Sources et Git validé en lecture seule.
- viewer / Build lisible, mais capture du 2026-08-13 révèle le lien global `OPUS Profiler` encore visible : divergence contractuelle.

## Cause R45D2A22B

Le défaut n’est pas dans Build. Le layout partagé `default/layouts/layout.score` affiche `OPUS Profiler` sans garde `profiler:view`, et `OwasysScorePageRenderer` dérive la visibilité uniquement de `?profiler=1`.

Le endpoint de trace est ACL-gardé, mais une ACL refusée remontant jusqu’au composition root est rendue en HTTP 500 au lieu de 403.

## Livrable actif — R45D2A22B

```text
ZIP     : opus_p117w_r45d2a22b_profiler_acl_presentation_guard.zip
SHA-256 : 7baa608c1a5c305d6d69cb8e7973de8b3f44e3f1d2c037a68e71def010db79b8
PREREQ  : R45D2A22 appliqué ; R45D2A21C local
FILES   : 2
```

R45D2A22B :

- injecte session + RuntimeSecurity dans le renderer partagé ;
- calcule `profiler.allowed` via ACL `profiler:view` ;
- conditionne lien et iframe SCORE à cette capacité ;
- refuse `?profiler=1` sans capacité ;
- mappe les refus ACL du composition root sur HTTP 403 ;
- ne code aucun rôle en dur.

## Gate immédiat

```text
OPUS_R45D2A22B_APPLIED
OPUS_R45D2A22B_PROFILER_ACL_PRESENTATION_GUARD_OK
OPUS_R45D2A22_ROLE_CAPABILITY_MATRIX_OK front_cases=66 back_cases=42
```

Puis rester connecté comme viewer :

1. Build doit rester lisible sans lien `OPUS Profiler` ;
2. `?profiler=1` doit donner un refus HTTP 403 ;
3. Compte doit permettre le changement de son propre mot de passe.

## Suite

Seulement après gate viewer complet : backend atomique Modifier/Supprimer utilisateur ou agent, puis exposition UI après support réel preview/fresh-auth/commit/rollback.

NO VIEWER PROFILER.
NO VIEWER MUTATION.
NO ACL BYPASS.
NO PRIMARY_ROLE AUTHORIZATION.
NO CSS-ONLY HIDING.
NO PUSH OPUS/OWASYS BY ASSISTANT.
