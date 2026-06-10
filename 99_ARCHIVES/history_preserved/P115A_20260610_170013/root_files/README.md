# MAESTRO_WORKSPACE P111 LIVE AUDIT

Étape après création du workspace et correction de la politique Front/UwAmp.

## But

Générer un état live avant toute décision GitHub / commit / rollback / patch.

## Application

Depuis PowerShell :

```powershell
cd /d H:\MAESTRO_WORKSPACE
python .\p111_live_git_audit.py
```

## Sortie attendue

```text
H:\MAESTRO_WORKSPACE\CONTEXT\REPORTS\P111_LIVE_GIT_AUDIT.md
H:\MAESTRO_WORKSPACE\OUTBOX\P111_LIVE_AUDIT_EXPORT_YYYYMMDD_HHMMSS.zip
```

Upload ensuite le ZIP situé dans `OUTBOX`.

## Contrat

- Non destructif
- Aucun patch
- Aucun commit
- Aucun git add
- Aucun checkout/reset/clean
- Aucune suppression
