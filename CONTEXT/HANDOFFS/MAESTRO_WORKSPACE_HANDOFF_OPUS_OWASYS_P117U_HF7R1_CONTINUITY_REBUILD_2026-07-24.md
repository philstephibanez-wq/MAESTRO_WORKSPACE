# MAESTRO_WORKSPACE HANDOFF — OPUS / OWASYS P117U HF7R1 CONTINUITY REBUILD

Date : 2026-07-24  
Statut : différentiel préparé ; application et recette owner en attente

## Source de vérité relue

```text
MAESTRO_WORKSPACE : philstephibanez-wq/MAESTRO_WORKSPACE master
OPUS             : philstephibanez-wq/OPUS master
OPUS base         : 79f261854ee06a9f828fec389adca77d57323d00
```

Les dépôts `Maestro`, `Maestro_KB_Engine` et `Maestro_KB_Extranet` ont également été relus pour leurs conventions et historiques actifs. OWASYS reste une application sous `OPUS/sites/owasys`; il n’existe aucun dépôt OWASYS autonome canonique.

## Contrats pris en compte

- contrat ultime et règles de développement MAESTRO ;
- règles globales MAESTRO / OPUS / OWASYS ;
- contractualisation exhaustive P117M ;
- contrat standard des sites OPUS ;
- P117U, HF1, HF2, HF3, HF4 et HF6 ;
- spécification et handoff HF7 précédents ;
- règles de commandes CMD du terminal VS Code.

## État entrant

HF6 est committé et le backend REST/Composer a déjà démontré un `registry.sync` réussi avec FSM backend `succeeded`.

Les écarts HF7 sont toujours présents sur `OPUS/master` :

- transition Registry vers Build avant création ;
- opération et aliases `registry.creation.start` obsolètes ;
- absence de profil dans `site.create` ;
- scaffold unique non profilé ;
- découverte Registry incomplète pour les sites standards OPUS.

## Différentiel livré

```text
opus_owasys_p117u_hf7r1_application_creation_profiles.zip
SHA-256 2317f0f3a76de22f4c51e5c568b8176d2cebb4169d50fc62b75d22458d6a959d
```

Le ZIP contient uniquement :

```text
opus_owasys_p117u_hf7r1_application_creation_profiles.patch
```

Patch :

```text
SHA-256 4e90d025a26474d0c19eaecae92048d1bf6b7ab403f4bfea2db796b9b05e53c8
45 chemins
1 307 insertions
110 suppressions
```

Le patch porte exactement sur les 45 chemins du périmètre HF7 :

- 17 fichiers existants ;
- 2 nouvelles classes applicatives ;
- 1 template SCORE ;
- 25 catalogues I18n de base.

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
- aucune commande libre ;
- configuration via File et StructuredFileLoader ;
- Logger et Profiler frontend obligatoires.

## Validation réalisée

Verte dans le runtime de livraison :

- structure du patch ;
- compteur des 45 chemins ;
- lint PHP des deux nouvelles classes ;
- parsing JSON des catalogues et configurations complètes reconstruites ;
- intégrité ZIP ;
- absence de secret et de pollution de livraison.

Le gate final reste obligatoirement exécuté sur le clone owner réel, car le runtime de livraison n’a pas de clone réseau monté : `git apply --check`, application, autoload, tokenizer P117M, lint/parsing complets et recettes HTTP.

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

1. vérifier `H:\OPUS` propre et au commit `79f261854ee06a9f828fec389adca77d57323d00` ;
2. extraire le ZIP hors du dépôt ;
3. exécuter `git apply --check` ;
4. appliquer le patch ;
5. régénérer l’autoload ;
6. exécuter les audits et validations ;
7. lancer backend puis frontend ;
8. tester les trois profils ;
9. vérifier Registry, Build, logs et traces ;
10. committer et pousser OPUS après validation.

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