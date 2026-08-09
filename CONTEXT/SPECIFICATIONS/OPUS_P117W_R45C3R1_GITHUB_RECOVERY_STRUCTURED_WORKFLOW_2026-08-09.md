# OPUS P117W R45C3R1 — GITHUB RECOVERY STRUCTURED WORKFLOW

Date : 2026-08-09  
Statut : livrable owner à valider

## Décision de récupération

À la demande explicite de l'owner, la récupération repart exclusivement du dépôt GitHub canonique OPUS et abandonne les deux commits locaux issus des livraisons précédentes non acquises.

Base canonique :

```text
058984bfb0229bf5f27c74cd2b59c6614bf74b4e
opus_p117w_r45c2_dev_preview_runtime_fix
```

Les commits locaux suivants ne sont pas utilisés comme source :

```text
0e0e5485 opus_p117w_r45c3_structured_workflow_sequence
5994903d cleanup
```

Ils doivent être conservés uniquement sur une branche de sauvegarde avant reset de `master` vers `origin/master`.

## Contrats appliqués

- `README-FIRST.md` ;
- `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md` ;
- `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md` ;
- `CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md`.

## Diagnostic de l'incident HTTP 500 — cause runtime rétablie

La pile owner observée était :

```text
owasys-front
-> RegistryModel::synchronize()
-> Opus\Api\Rest\RestClient::request()
-> fopen()
-> Maximum execution time exceeded
```

La source GitHub canonique confirme :

- `RegistryModel::synchronize()` interroge obligatoirement le backend par REST ;
- `owasys-front` déclare `owasys-back` comme peer de développement ;
- endpoint backend dev : `http://127.0.0.1:8080` ;
- `owasys-front` écoute sur `127.0.0.1:8000` ;
- `opus:dev-server -- owasys-front` lance l'application demandée et injecte/valide le peer, mais ne démarre pas automatiquement `owasys-back`.

Le 2026-08-09, l'owner a constaté deux processus PHP résiduels en mémoire. Après arrêt forcé de ces deux processus et suppression du site de test, OWASYS est reparti normalement.

Les traces runtime fournies après nettoyage confirment :

- `owasys-back` actif sur `127.0.0.1:8080` ;
- `owasys-front` actif sur `127.0.0.1:8000` ;
- `GET /api/v1/applications` réussi ;
- `owasys:registry-sync` réussi ;
- `PUT /api/v1/session/application/owasys-back` réussi ;
- `owasys:registry-select` réussi ;
- navigation frontend `/fr-FR/applications` puis `/fr-FR/data` réussie.

Conclusion : le timeout précédent est classé comme incident runtime lié à des processus PHP résiduels / conflit d'instance, pas comme défaut établi de `RestClient`. Aucun changement `RestClient` n'est retenu dans R45C3R1. R45C4 reste retiré.

## Correction fonctionnelle R45C3R1

Le changement de workflow est reconstruit directement depuis GitHub R45C2, avec seulement deux fichiers complets dans le ZIP.

Workflow cible :

```text
Applications
-> Sources de données
-> Structure
-> Sécurité
-> Workflows
-> Sources et Git
-> Construction et validation
```

Après sélection d'une application existante ou création d'une nouvelle application :

```text
next_state = data
```

`Sources de données` reste éventuelle : elle est l'entrée de la séquence de construction mais n'impose aucune BDD.

## Fichiers modifiés

```text
sites/owasys-front/config/fsm.json
sites/owasys-front/application/creation/controllers/CreationController.php
```

Aucune classe `Opus/**/*.php` n'est modifiée.

### FSM

- `registry=10` ;
- `data=20` ;
- `structure=30` ;
- `security=40` ;
- `workflows=50` ;
- `source=60` ;
- `build=70` ;
- `select_app -> data` ;
- `application_created -> data` ;
- projection visuelle : `registry -> data -> structure -> security -> workflows -> source -> build` ;
- transitions wildcard runtime conservées.

### CreationController

Après création réussie, la redirection HTTP devient :

```text
data
```

au lieu de :

```text
build
```

La redirection et la transition FSM sont ainsi cohérentes.

## Livrable

```text
ZIP     : opus_p117w_r45c3r1_github_recovery_structured_workflow.zip
SHA-256 : d54fb21ca36288dbd9d7db279b92cacc55b34715cb5572be34ab2ca79496e2e7
BASE    : 058984bfb0229bf5f27c74cd2b59c6614bf74b4e
FILES   : 2
```

Le ZIP contient exclusivement les deux fichiers complets à leurs chemins finaux. Aucun `apply_*`, smoke, rapport, log, cache, temporaire ou dépendance n'est livré.

## Procédure owner

1. arrêter les serveurs de développement en cours ;
2. vérifier qu'aucun processus PHP résiduel ne conserve les ports 8000/8080 ;
3. `git fetch origin` ;
4. sauvegarder `5994903d` sur une branche locale dédiée ;
5. reset hard de `master` vers `origin/master` ;
6. vérifier HEAD `058984bf` et working tree propre ;
7. extraire le ZIP directement dans `H:\OPUS` ;
8. lint PHP + chargement FSM via `StructuredFileLoader` + Composer autoload ;
9. lancer `owasys-back` sur 8080 ;
10. lancer `owasys-front` sur 8000 ;
11. valider navigation, sélection/création vers `Sources de données`, preview R45C2 ;
12. seulement après succès, commit/push OPUS par l'owner.

## Gate runtime

R45C3R1 n'est pas acquis avant validation avec les deux applications actives et une seule instance PHP attendue par serveur de développement.

NO SITE-SPECIFIC PATCH.  
NO SILENT FALLBACK.  
NO REST BYPASS.  
NO AUTO-START CROSS-APPLICATION.  
NO FSM MERGE.  
NO ROLE MERGE.  
NO ACL BYPASS.  
NO BACKEND JAVASCRIPT.  
NO PUSH OPUS BY ASSISTANT.
