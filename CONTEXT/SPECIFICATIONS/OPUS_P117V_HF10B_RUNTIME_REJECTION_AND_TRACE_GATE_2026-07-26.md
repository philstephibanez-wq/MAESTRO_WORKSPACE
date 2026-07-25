# OPUS P117V HF10B — RUNTIME REJECTION AND TRACE GATE

Date : 2026-07-26  
Statut : HF10B installé mais non accepté ; correctif suivant bloqué sur la trace frontend exacte

## 1. Base

```text
OPUS repository : philstephibanez-wq/OPUS
branch          : master
base/head       : 21650601d7025706d4f7008ec0d0028d8cbe9c9d
owner local     : H:\OPUS + HF10B overlay/migration
```

## 2. Preuves owner

### Backend

Le journal transmis contient uniquement :

```text
channel      = opus.runtime.process
message      = process.starting
runtime_mode = back
host         = 127.0.0.1
port         = 8792
trace_id     = 911f9e7f8708bf84
```

Conclusion : le processus backend est distinct et son journal est créé, mais aucune requête REST n'a encore atteint le backend.

### Frontend

La route :

```text
http://localhost:8000/fr-FR/
```

rend une page SCORE d'échec :

```text
OWASYS_FRONT_RUNTIME_FAILED
trace_id = 5f52a28017dc564d
```

Cette page établit que :

- `www/index.php` a sélectionné le bootstrap front ;
- `application/shared/RuntimeInterface.php` a été chargé ;
- `application/shared/Application.php` a composé le Singleton ;
- Logger/Profiler ont créé le trace_id ;
- l'exception s'est produite à l'intérieur du runtime front ;
- le code sûr affiché est générique parce que le message original contient des caractères hors contrat de code public.

## 3. État de `application/shared`

Le ZIP HF10B contient directement :

```text
sites/owasys/application/shared/Application.php
sites/owasys/application/shared/RuntimeInterface.php
```

Le CMD de migration doit ajouter :

```text
sites/owasys/application/shared/i18n/default
sites/owasys/application/shared/i18n/modules/<module>
```

Le livrable aurait dû valider le runtime I18n réel, pas seulement la présence statique de quelques chemins. Le smoke HF10B est donc insuffisant.

## 4. Statut HF10B

```text
opus_p117v_hf10b_owasys_physical_front_back_runtime_bootstrap.zip
STATUS : INSTALLED / RUNTIME REJECTED / NOT ACCEPTED
```

Points établis :

- séparation de processus back : visible ;
- journal backend de démarrage : visible ;
- séparation physique déclarée : présente dans le ZIP et la migration ;
- frontend fonctionnel : non ;
- REST -> Composer : non démontré ;
- Profiler frontend : trace créée mais contenu non transmis ;
- suppression des anciens chemins : interdite.

## 5. Source de vérité manquante

Le prochain correctif exige :

```text
sites/owasys/var/logs/owasys-frontend.log
```

pour la ligne contenant :

```text
5f52a28017dc564d
```

et :

```text
sites/owasys/var/profiler/front/5f52a28017dc564d.json
```

Ces diagnostics doivent donner :

- `error_code` ;
- `exception_class` ;
- `exception_file` ;
- `exception_line` ;
- séquence d'événements Profiler.

Sans ces éléments, toute correction de cause serait une hypothèse et violerait :

```text
NO SOURCE OF TRUTH, NO PATCH
NO FALLBACK SILENCIEUX
```

## 6. Correctif suivant obligatoire

Le prochain ZIP différentiel devra :

1. corriger la cause exacte issue de la trace ;
2. rendre le smoke réellement exécutable sur les routes front et back ;
3. valider les catalogues `application/shared/i18n` ;
4. valider le chargement de chaque module frontend ;
5. valider le refus croisé des routes ;
6. valider une requête REST signée jusqu'à Composer ;
7. conserver SCORE-only, Singleton, FSM, I18n, ACL, SSO, Logger et Profiler ;
8. rester un ZIP différentiel direct superposable à `H:\OPUS` ;
9. ne supprimer aucun ancien chemin avant acceptation runtime.

## 7. Commandes de collecte

```cmd
cd /d H:\OPUS
findstr /C:"5f52a28017dc564d" sites\owasys\var\logs\owasys-frontend.log
type sites\owasys\var\profiler\front\5f52a28017dc564d.json
dir /s /b sites\owasys\application\shared
```
