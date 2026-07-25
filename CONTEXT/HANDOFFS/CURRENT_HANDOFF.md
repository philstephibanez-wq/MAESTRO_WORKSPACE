# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-26

## Lecture obligatoire

```text
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117V_HF10B_RUNTIME_REJECTION_AND_TRACE_GATE_2026-07-26.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117V_HF10B_RUNTIME_REJECTED_TRACE_REQUIRED_2026-07-26.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source de vérité

```text
OPUS repository : philstephibanez-wq/OPUS
branch          : master
remote head     : 21650601d7025706d4f7008ec0d0028d8cbe9c9d
owner local     : H:\OPUS + HF10B overlay/migration
workspace       : philstephibanez-wq/MAESTRO_WORKSPACE master
```

## Architecture validée

```text
frontend  = application/shared + application/front
backend   = application/shared + application/back
fullstack = application/shared + application/front + application/back
```

Structure cible :

```text
application/shared
application/shared/i18n/default
application/shared/i18n/modules/<module>
application/front/default
application/front/modules/<module>
application/back/modules/<module>
application/back/api
```

`application/full` est interdit.

## État HF10B

```text
ZIP     : opus_p117v_hf10b_owasys_physical_front_back_runtime_bootstrap.zip
SHA-256 : 20803dd76b72bbed4704655e782fbf29cd79d7e2f01652a2ef0a6faa46f588ef
BASE    : 21650601d7025706d4f7008ec0d0028d8cbe9c9d
STATUS  : INSTALLED / RUNTIME REJECTED / NOT ACCEPTED
```

## Preuves owner

### Backend

```text
trace_id     : 911f9e7f8708bf84
message      : process.starting
runtime_mode : back
host         : 127.0.0.1
port         : 8792
```

Le backend est un processus distinct et son journal de démarrage existe. Aucune requête REST n'est encore démontrée.

### Frontend

```text
route     : http://localhost:8000/fr-FR/
result    : OWASYS_FRONT_RUNTIME_FAILED
trace_id  : 5f52a28017dc564d
```

La page SCORE avec trace_id prouve que :

- le bootstrap front a été sélectionné ;
- `application/shared/RuntimeInterface.php` et `application/shared/Application.php` ont été chargés ;
- le Singleton partagé, Logger et Profiler sont actifs ;
- l'exception se situe à l'intérieur du runtime frontend.

Le code affiché est générique. La cause exacte n'est pas dans le journal backend transmis.

## Source de vérité requise

```text
sites/owasys/var/logs/owasys-frontend.log
sites/owasys/var/profiler/front/5f52a28017dc564d.json
```

Commandes :

```cmd
cd /d H:\OPUS
findstr /C:"5f52a28017dc564d" sites\owasys\var\logs\owasys-frontend.log
type sites\owasys\var\profiler\front\5f52a28017dc564d.json
dir /s /b sites\owasys\application\shared
```

## Décision

Aucun nouveau ZIP correctif de cause ne doit être produit avant lecture de :

- `error_code` ;
- `exception_class` ;
- `exception_file` ;
- `exception_line` ;
- événements Profiler du trace_id.

Produire un nouveau patch sans cette preuve violerait `NO SOURCE OF TRUTH, NO PATCH`.

## Correctif suivant

Le différentiel suivant devra :

1. corriger la cause exacte ;
2. compléter/valider réellement `application/shared` ;
3. remplacer le smoke statique par des tests runtime front/back ;
4. valider les catalogues partagés et chaque module front ;
5. valider le refus croisé des routes ;
6. valider REST sécurisé -> Composer ;
7. conserver Singleton, FSM, I18n, ACL, SSO/Auth0-proxy, SCORE, Logger et Profiler ;
8. rester un ZIP différentiel direct superposable à `H:\OPUS`.

## Nettoyage

Aucune suppression autorisée. Préserver :

```text
sites/owasys_old
sites/owasys/var/logs
sites/owasys/var/profiler
sites/owasys/var/registry
sites/owasys/var/runtime
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
