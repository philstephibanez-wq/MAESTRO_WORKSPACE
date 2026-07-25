# MAESTRO_WORKSPACE HANDOFF — OPUS P117V HF10B RUNTIME REJECTED

Date : 2026-07-26  
Statut : HF10B installé ; backend démarré ; frontend en échec ; trace frontend requise

## Base

```text
OPUS HEAD : 21650601d7025706d4f7008ec0d0028d8cbe9c9d
Local     : H:\OPUS
```

## Résultat owner

```text
back process.starting : OK
back runtime_mode     : back
back port             : 8792
front route           : /fr-FR/
front result          : OWASYS_FRONT_RUNTIME_FAILED
front trace_id        : 5f52a28017dc564d
REST -> backend       : non démontré
```

## Shared

Le noyau partagé est bien dans le différentiel :

```text
application/shared/Application.php
application/shared/RuntimeInterface.php
```

La migration doit avoir produit :

```text
application/shared/i18n/default
application/shared/i18n/modules
```

La page d'erreur SCORE avec trace_id prouve que le Singleton partagé a été chargé. Elle ne prouve pas que tous les catalogues et modules partagés sont complets.

## Diagnostic manquant

```text
sites/owasys/var/logs/owasys-frontend.log
sites/owasys/var/profiler/front/5f52a28017dc564d.json
```

Le fichier backend transmis contient uniquement `process.starting`. Il ne contient pas la cause frontend.

## Décision

```text
HF10B STATUS : RUNTIME REJECTED / NOT ACCEPTED
```

Aucun correctif de cause ne doit être produit avant lecture de la ligne frontend et du fichier Profiler correspondant au trace_id.

## Commandes owner

```cmd
cd /d H:\OPUS
findstr /C:"5f52a28017dc564d" sites\owasys\var\logs\owasys-frontend.log
type sites\owasys\var\profiler\front\5f52a28017dc564d.json
dir /s /b sites\owasys\application\shared
```

## Après réception

1. identifier le fichier et la ligne exacts ;
2. corriger la cause ;
3. remplacer le smoke statique par un smoke runtime front/back ;
4. produire un ZIP différentiel direct ;
5. mettre à jour workspace ;
6. tester accueil, Applications, Creation et REST -> Composer ;
7. seulement ensuite fournir le nettoyage des anciens chemins.
