# P111_SOURCE_OF_TRUTH_SECTORS.md

## État corrigé

Correction importante : `UwAmp` n’est pas le front.

`UwAmp` contient seulement un lien/junction vers le vrai front et sert de runtime web local.

## Sources de vérité candidates

| Secteur | Chemin officiel candidat | Rôle |
|---|---|---|
| `MAESTRO_WORKSPACE` | `H:\MAESTRO_WORKSPACE` | contexte, rapports, décisions P111 |
| `MAESTRO_V5` | `D:\REAPER_Roaming\REAPER\Scripts\MAESTRO_v5` | produit distribuable REAPER/Lua |
| `MO_KB_DAEMON` | `H:\MO_KB_DAEMON` | backend privé at home |
| `MO_KB_FRONT` | `H:\MO_KB_FRONT` | vraie source front/backoffice privé at home |

## Hors source de vérité code

| Chemin | Rôle | Règle |
|---|---|---|
| `H:\UwAmp\www` | hôte web local | ne pas traiter comme dépôt source |
| `H:\MO_KB_STORE` | données privées, KB, logs, jobs, DB, audio | pas un dépôt code |
| `H:\MO_KB_VENDOR` | dépendances, Python local, modèles, caches contrôlés | pas un dépôt code |
| `H:\MO_KB_BACKUPS` | backups | hors repo |
| `H:\MO_KB_SNAPSHOTS` | snapshots | hors repo sauf décision explicite |

## Résumé Git observé précédemment

| Secteur | Git | État |
|---|---|---|
| `MAESTRO_V5` | oui | clean, remote à définir |
| `MO_KB_DAEMON` | oui | modifications locales à comprendre avant GitHub |
| `MO_KB_FRONT` | à confirmer sur disque | doit être audité directement depuis `H:\MO_KB_FRONT` |

## Alerte importante

Ne pas confondre :

```text
H:\UwAmp\www\MO_KB_FRONT
```

avec la vraie source :

```text
H:\MO_KB_FRONT
```

Si `H:\UwAmp\www\MO_KB_FRONT` existe, il doit être vérifié comme lien/junction uniquement.

## Prochaine étape avant patch

1. Confirmer que `H:\MO_KB_FRONT` existe et contient le front actif.
2. Vérifier que `H:\UwAmp\www\MO_KB_FRONT` est bien un lien/junction vers `H:\MO_KB_FRONT`.
3. Auditer `git status` sur `H:\MO_KB_FRONT`.
4. Lire le diff réel de `H:\MO_KB_DAEMON`.
5. Décider commit / rollback / palier propre.
