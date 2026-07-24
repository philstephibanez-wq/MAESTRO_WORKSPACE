# MAESTRO_WORKSPACE HANDOFF — OPUS / OWASYS P117U HF7R1 RUNTIME CHECKPOINT

Date : 2026-07-24  
Statut : HF7R1 actif localement ; Registry REST/Composer et projection OWASYS validés ; création des trois profils en attente

## Source de vérité

```text
OPUS distant : philstephibanez-wq/OPUS master
Head distant : 79f261854ee06a9f828fec389adca77d57323d00
Distant      : HF6 committé
Local owner  : HF7R1 appliqué et exécuté, non encore committé
Workspace    : philstephibanez-wq/MAESTRO_WORKSPACE master
```

OWASYS reste l’application SCORE `sites/owasys/`. Toute mutation métier traverse REST sécurisé puis Composer.

## Preuves reçues

Les captures valident :

- bouton `Créer une nouvelle application` visible ;
- un candidat et une application canonique ;
- zéro identifiant dupliqué ;
- zéro racine ignorée ;
- une application Singleton conforme ;
- OWASYS projeté comme `fullstack`, `standard-opus-application`, racine `sites/owasys`, statut `discovered` ;
- contexte courant encore vide avant `registry.select`.

Le journal backend valide cinq `registry.sync` complets. Chaque trace passe par réception, validation, Composer, succès commande et succès FSM. Toutes les commandes `owasys:registry-sync` terminent avec `exit_code=0` et `stderr_bytes=0`.

## Gates clos

1. HF7R1 chargé dans le runtime local ;
2. backend et frontend démarrés ;
3. surface Applications accessible ;
4. entrée Creation visible ;
5. Registry synchronisé par REST sécurisé puis Composer ;
6. FSM backend `succeeded` ;
7. intégrité Registry verte ;
8. Singleton vert ;
9. application OWASYS standard découverte ;
10. trace backend corrélable.

## Gates ouverts

1. gate tokenizer P117M exhaustif ;
2. lint/parsing exhaustifs post-HF7R1 ;
3. formulaire `/fr-FR/applications/new` ;
4. annulation Creation vers Registry ;
5. erreurs contrôlées et trace frontend/backend ;
6. création frontend ;
7. création backend ;
8. création fullstack ;
9. sélection Registry de chaque application créée ;
10. transition `application_created -> Build` ;
11. conformité structurelle des trois sites ;
12. navigation sans JavaScript ;
13. Auth0, HTTPS, bastion et Windows/Linux ;
14. commit/push OPUS owner.

## Prochaine action owner

Ouvrir :

```text
http://localhost:8000/fr-FR/applications/new
```

Contrôler que l’écran Creation affiche :

```text
identifiant de site
profil frontend
profil backend
profil fullstack
Créer
Annuler
```

Effectuer d’abord `Annuler`, puis rouvrir Creation. Aucune création de fixture ne doit être lancée avant validation visuelle de cet état.

## Fixtures prévues

```text
hf7r1-frontend-check
hf7r1-backend-check
hf7r1-fullstack-check
```

Aucune suppression n’est autorisée tant que leur caractère jetable n’a pas été validé explicitement.

## Différentiel courant

```text
opus_owasys_p117u_hf7r1_application_creation_profiles.zip
SHA-256 : 16b8006dae07b88555c7149fa14bb4f9a1230e47f5d32f973933e0597dcb7858
PATHS : 45
```

Aucun nouveau ZIP n’est généré à ce checkpoint : les preuves reçues ne démontrent aucun défaut nécessitant un correctif.

## Contrats permanents

- classe concrète OPUS -> interface homonyme -> quatre marqueurs ;
- Singleton, FSM, I18n, ACL deny-by-default, SSO/Auth0-proxy et bastion ;
- SCORE uniquement, sans echo UI ni HTML/PHP mélangé ;
- locale navigateur ;
- File + Json/Xml/Yaml ;
- REST sécurisé puis Composer pour OWASYS ;
- Logger et Profiler obligatoires ;
- aucun secret dans Git, argv, logs, profiler ou ZIP.
