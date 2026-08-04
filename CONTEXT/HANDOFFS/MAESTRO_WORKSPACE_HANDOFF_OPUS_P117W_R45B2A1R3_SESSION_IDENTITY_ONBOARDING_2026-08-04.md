# HANDOFF — OPUS P117W R45B2A1R3

Date : 2026-08-04
Base : `21ce3ccbaa2c09adabc18d4bf021fbb126db9717`

R45B2A1 est acquis. Le HEAD owner contient ensuite un commit de nettoyage. R45B2A1R2 n'est pas acquis et est remplacé par R45B2A1R3, cumulatif.

Les pièces owner prouvent `OWASYS_CREATION_USERS_PROVIDER_INVALID` au stade `security` avec le fournisseur `session` et un identifiant initial. La cause est commune au contrôleur OWASYS et au normaliseur du blueprint OPUS.

R45B2A1R3 conserve `everyone` et les corrections de validation de R45B2A1R2, puis rend l'onboarding cohérent avec le fournisseur sélectionné. Aucun fichier de site généré n'est inclus.

```text
ZIP     : opus_p117w_r45b2a1r3_session_identity_onboarding.zip
SHA-256 : 5794c90454beb8df8fefceaba7dc1abb37216ca243f8833ae5c680f596816a46
FILES   : 4
```

Gate owner : lint des quatre fichiers, autoload, validation des deux bastions, création depuis OWASYS avec `Session`, rôle métier `admin`, accueil `everyone`, utilisateur initial `steve` et rôle initial unique `admin`. Aucun commit avant réussite de tous ces contrôles.

Suite après acquisition : analyser séparément la rétention/rotation du Profiler et `OPUS_PROFILER_TRACE_NOT_FOUND`, sans les mêler au blocage de création.
