# CLEAN_GITHUB_REPO_PLAN.md

Generated: `2026-06-04 21:02:35`
Workspace officiel : `H:\MAESTRO_WORKSPACE`

## Contrat

Aucun dépôt GitHub ne doit être initialisé ou nettoyé automatiquement par ce bootstrap.
Ce fichier prépare seulement la décision.

## Plan recommandé

1. Valider manuellement `PROJECT_MAP.md`.
2. Valider manuellement `SCORIES_REPORT.md`.
3. Valider manuellement `GIT_READINESS.md`.
4. Décider de la stratégie Git : mono-repo ou repos séparés.
5. Créer un `.gitignore` propre par secteur.
6. Faire un premier commit propre uniquement après validation.
7. Déclarer GitHub comme source de vérité seulement après push vérifié.

## Sources candidates

- `MAESTRO_V5` : `D:\REAPER_Roaming\REAPER\Scripts\MAESTRO_v5`
- `MO_KB_DAEMON` : `H:\MO_KB_DAEMON`
- `MO_KB_STORE` : `H:\MO_KB_STORE`
- `MO_KB_VENDOR` : `H:\MO_KB_VENDOR`
- `UWAMP_FRONT` : `H:\UwAmp\www`

## Interdits P111

- Pas de patch depuis un ZIP partiel.
- Pas de patch sans source de vérité.
- Pas de patch sans cible live identifiée.
- Pas de fallback silencieux.
- Pas de scories, caches ou fichiers temporaires dans l'UI normale.
- Pas de suppression automatique par ce bootstrap.