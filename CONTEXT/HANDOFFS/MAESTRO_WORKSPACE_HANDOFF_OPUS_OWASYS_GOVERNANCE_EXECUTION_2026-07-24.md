# MAESTRO_WORKSPACE HANDOFF — OPUS / OWASYS GOVERNANCE EXECUTION

Date : 2026-07-24  
Statut : gouvernance écrite ; différentiel HF7 retrouvé et vérifié ; application owner en attente

## Source de vérité

```text
MAESTRO_WORKSPACE master initial : cf0f0e6697abd4ea581b6255e76ea64df4063bde
OPUS master relu                : 79f261854ee06a9f828fec389adca77d57323d00
OPUS état distant               : HF6 committé, HF7 non appliqué
```

OWASYS est l’application `sites/owasys/` du dépôt OPUS. Il n’existe pas de dépôt GitHub OWASYS autonome installé.

## Contrats actifs

1. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
2. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_GOVERNANCE_EXECUTION_SPEC_2026-07-24.md`
3. `CONTEXT/SPECIFICATIONS/OPUS_ALL_CONCRETE_CLASSES_COMPONENT_CONTRACT_SPEC_P117M.md`
4. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7_APPLICATION_CREATION_PROFILES_SPEC.md`

## Écart confirmé

Le `composer.json` de `OPUS/master` expose encore l’alias obsolète :

```text
owasys:registry-creation-start
```

HF7 le supprime avec l’ancien workflow `Registry -> Build` et introduit le workflow canonique :

```text
Registry
-> Creation
-> frontend | backend | fullstack
-> REST site.create
-> Composer opus:create-site
-> scaffold OPUS
-> Registry synchronize/select
-> Build
```

## Différentiel courant

```text
ZIP      : opus_owasys_p117u_hf7_application_creation_profiles.zip
SHA-256  : 16e06b55f3cf2ffcc5118fe0e5c4f17cbc7b51fa437fd06f17bf3dc16ab48141
Fichiers : 45
ZIP      : 54 906 octets
Payload  : 176 634 octets
Racines  : composer.json, Opus/, sites/
```

L’artefact exact a été retrouvé. Son empreinte et son intégrité ZIP ont été vérifiées.

## Contrôles effectués

- lecture des heads GitHub et des contrats actifs ;
- comparaison P117M vers le head OPUS courant ;
- contrôle des interfaces homonymes des classes OPUS nouvelles ou modifiées dans le périmètre courant ;
- contrôle direct de plusieurs interfaces du head, toutes avec les quatre marqueurs ;
- PHP lint des PHP du différentiel HF7 ;
- parsing de tous les JSON du différentiel HF7 ;
- absence d’`echo` UI dans le module Creation ;
- absence de parser de configuration local dans le différentiel ;
- vérification de l’intégrité et de l’empreinte du ZIP.

Le gate tokenizer exhaustif sur l’arbre OPUS complet et les tests runtime Windows restent des gates owner. Ils ne sont pas déclarés exécutés.

## Architecture obligatoire

- OPUS est le framework générique ;
- OWASYS est uniquement l’UI web OPUS ;
- toute mutation métier OWASYS traverse REST sécurisé puis Composer ;
- applications Singleton, FSM, I18n, ACL deny-by-default, SSO/Auth0 et bastion ;
- SCORE uniquement, sans `echo` UI ni mélange HTML/PHP ;
- locale par défaut depuis le navigateur ;
- configuration par `File` puis `Json`, `Xml` ou `Yaml` ;
- Logger et Profiler obligatoires ;
- besoin générique proposé comme évolution OPUS avant toute solution locale.

## Nettoyage autorisé

Seuls les temporaires et caches identifiés peuvent être supprimés. Ne pas supprimer :

```text
sites/owasys/var/logs
sites/owasys/var/profiler
sites/owasys/var/registry
sites/owasys_old
```

Le sort de `sites/owasys_old` reste une décision owner séparée.

## Lancement contractuel

Terminal backend :

```cmd
cd /d H:\OPUS
composer opus:serve-site -- owasys --host=127.0.0.1 --port=8792
```

Terminal frontend :

```cmd
cd /d H:\OPUS
composer opus:serve-site -- owasys --host=127.0.0.1 --port=8000
```

Les deux terminaux doivent recevoir `OPUS_OWASYS_BACKEND_TOKEN` et `OPUS_OWASYS_BACKEND_HMAC` depuis l’environnement local sécurisé.

## Prochaine séquence owner

1. vérifier `git status` propre dans `H:\OPUS` ;
2. extraire HF7 à la racine OPUS ;
3. régénérer l’autoload optimisé ;
4. exécuter l’audit tokenizer P117M et le lint ;
5. valider le site et les routes ;
6. lancer backend puis frontend ;
7. tester Creation et les trois profils ;
8. vérifier Registry, Build, logs et traces ;
9. tester sans JavaScript, Auth0, HTTPS, bastion et Windows/Linux ;
10. committer et pousser après acceptation owner.

## Politique GitHub

La gouvernance est écrite directement dans `MAESTRO_WORKSPACE`. Aucun code OPUS ou OWASYS n’a été poussé directement par l’assistant.
