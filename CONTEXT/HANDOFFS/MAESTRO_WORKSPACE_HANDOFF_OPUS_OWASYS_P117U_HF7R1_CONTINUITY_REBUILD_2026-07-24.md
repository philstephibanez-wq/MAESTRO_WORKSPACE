# MAESTRO_WORKSPACE HANDOFF — OPUS / OWASYS P117U HF7R1 CONTINUITY REBUILD

Date : 2026-07-24  
Statut : différentiel installable préparé ; application et recette owner en attente

## Source de vérité relue

```text
MAESTRO_WORKSPACE : philstephibanez-wq/MAESTRO_WORKSPACE master
OPUS             : philstephibanez-wq/OPUS master
OPUS base         : 79f261854ee06a9f828fec389adca77d57323d00
```

Les dépôts `Maestro`, `Maestro_KB_Engine` et `Maestro_KB_Extranet` ont également été relus. OWASYS reste une application sous `OPUS/sites/owasys`; aucun dépôt OWASYS autonome n’est canonique.

## État entrant

HF6 est committé. Les écarts HF7 restent présents sur `OPUS/master` :

- transition Registry vers Build avant création ;
- opération et aliases `registry.creation.start` obsolètes ;
- absence de profil dans `site.create` ;
- scaffold unique non profilé ;
- découverte Registry incomplète pour les sites standards OPUS.

## Différentiel installable livré

```text
opus_owasys_p117u_hf7r1_application_creation_profiles.zip
SHA-256 16b8006dae07b88555c7149fa14bb4f9a1230e47f5d32f973933e0597dcb7858
```

Contenu :

```text
INSTALL_HF7R1.cmd
START_OWASYS_BACKEND.cmd
START_OWASYS_FRONTEND.cmd
payload/opus_owasys_p117u_hf7r1_application_creation_profiles.patch
```

Patch interne :

```text
SHA-256 4e90d025a26474d0c19eaecae92048d1bf6b7ab403f4bfea2db796b9b05e53c8
45 chemins
1 307 insertions
110 suppressions
```

Le précédent ZIP contenant uniquement le patch est remplacé. Il ne doit pas être utilisé.

## Installation owner

Le propriétaire ne saisit aucune commande `git apply`.

Après extraction du ZIP dans un dossier temporaire, exécuter :

```text
INSTALL_HF7R1.cmd
```

Le programme contrôle automatiquement :

- `H:\OPUS` ;
- le head exact HF6 ;
- la propreté Git ;
- l’applicabilité du différentiel ;
- l’application ;
- l’autoload Composer ;
- la validation du site ;
- la liste des routes.

Le programme échoue explicitement en cas de dépôt absent, sale, mauvais head ou validation non verte.

## Architecture résultante

```text
Registry
-> Creation
-> frontend | backend | fullstack
-> secured REST site.create
-> Composer opus:create-site
-> generic OPUS scaffold
-> Registry synchronize/select
-> Build
```

- Singleton conservé ;
- FSM source de vérité ;
- locale navigateur conservée ;
- ACL `creation:*` pour developer/admin ;
- SSO requis ;
- SCORE uniquement ;
- aucun echo UI ou HTML/PHP mixte ajouté ;
- aucun write frontend ;
- configuration via File et StructuredFileLoader ;
- Logger et Profiler frontend obligatoires.

## Validation réalisée

Verte dans le runtime de livraison :

- structure du patch ;
- compteur des 45 chemins ;
- lint PHP des deux nouvelles classes ;
- parsing JSON des catalogues et configurations reconstruites ;
- intégrité ZIP ;
- présence des trois programmes CMD ;
- absence de secret et de pollution de livraison.

## Nettoyage

Aucune suppression n’est requise avant application. Préserver :

```text
sites/owasys/var/logs
sites/owasys/var/profiler
sites/owasys/var/registry
sites/owasys_old
```

Le sort de `sites/owasys_old` reste une décision owner distincte.

## Reprise owner

1. vérifier que `H:\OPUS` ne contient aucun travail local à conserver ;
2. extraire le ZIP dans `%TEMP%\OPUS_HF7R1` ;
3. exécuter `INSTALL_HF7R1.cmd` ;
4. exécuter les audits tokenizer, lint et parsing complets ;
5. lancer backend par `START_OWASYS_BACKEND.cmd` ;
6. lancer frontend par `START_OWASYS_FRONTEND.cmd` ;
7. tester les trois profils ;
8. vérifier Registry, Build, logs et traces ;
9. committer et pousser OPUS après validation.

## Règles permanentes

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
OPUS IS A FRAMEWORK, NOT AN APPLICATION.  
OWASYS IS THE SCORE WEB UI.  
ALL OWASYS BUSINESS WRITES CROSS SECURED REST THEN COMPOSER.  
EVERY CONCRETE OPUS CLASS IMPLEMENTS ITS HOMONYMOUS FOUR-MARKER INTERFACE.  
LOGGER AND PROFILER ARE MANDATORY.  
NO SILENT FALLBACK.  
NO DELIVERY ROOT POLLUTION.