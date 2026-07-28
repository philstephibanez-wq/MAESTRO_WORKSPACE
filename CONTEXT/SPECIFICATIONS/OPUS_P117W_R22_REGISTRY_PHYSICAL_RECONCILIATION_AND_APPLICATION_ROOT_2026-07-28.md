# OPUS P117W R22 — RÉCONCILIATION PHYSIQUE DU REGISTRE ET RACINE DES APPLICATIONS

Date : 2026-07-28  
Statut : spécification contractuelle et livrable différentiel à valider côté owner

## 1. Source de vérité

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base exacte : 4868780af4dd65bb7e28d95c981d1a1c5800a243
Racine owner : H:\OPUS
```

À cette base, les seules applications OWASYS physiques sont :

```text
sites/owasys-front
sites/owasys-back
```

`sites/owasys_old` et `sites/owasys_old2` sont absents.

## 2. Cause

`OwasysRegistryRepository::synchronize()` importe le seed et réalise des
UPSERT pour les sites découverts, mais ne supprime jamais les lignes SQLite
dont la racine applicative a disparu.

Le repository de synchronisation accepte encore uniquement les anciens
contrats de site. Les applications au contrat actuel
`OPUS_SITE_STANDARD_CONTRACT_CORE` sont ajoutées séparément par le provider
dans la projection REST, sans devenir la source canonique de SQLite.

Le registre peut donc afficher une application supprimée telle que
`sites/owasys_old` tout en projetant séparément les applications physiques
actuelles.

## 3. Réconciliation obligatoire

Une synchronisation Registry est atomique et réalise dans cet ordre :

1. migration sûre du schéma ;
2. ouverture d’une transaction SQLite immédiate ;
3. import du seed ;
4. découverte déterministe des sites physiques ;
5. sélection des racines canoniques ;
6. UPSERT des applications canoniques ;
7. comparaison des couples SQLite `id + root_path` avec les couples
   canoniques physiques ;
8. suppression des lignes SQLite absentes ou divergentes ;
9. effacement du contexte courant si son application a disparu ;
10. commit.

Toute erreur provoque un rollback explicite. Aucun fallback et aucune
sélection implicite ne sont autorisés.

Le résultat de synchronisation expose :

```text
stale_removed
stale_ids
stale_context_cleared
```

La réconciliation technique ne crée pas d’événement utilisateur
`select_app`.

## 4. Contrats de sites reconnus

La découverte Registry accepte :

```text
OPUS_SITE_STANDARD_CONTRACT_CORE
OPUS_SITE_APPLICATION_TREE_V2
OPUS_SITE_APPLICATION_TREE_V1_ETERNAL
```

Pour le contrat standard courant, le type d’application provient en priorité
de `application_profile.type`, puis de `kind`.

## 5. Racine contractuelle des applications créées avec OWASYS

Toute application créée avec OWASYS est une application OPUS autonome logée
exclusivement sous :

```text
H:\OPUS\sites\<application-id>\
```

Dans le dépôt, son chemin relatif canonique est :

```text
sites/<application-id>/
```

Cette racine est déjà imposée par `OPUS_SITE_STANDARD_CONTRACT_CORE`,
`SiteScaffoldPlan::rootRelativePath()`, `ScaffoldWriter` et
`SiteCommandService`.

Règles :

- un niveau unique directement sous `sites/` ;
- identifiant identique au nom du répertoire ;
- aucune application générée sous `sites/owasys-front`,
  `sites/owasys-back`, `var`, `WORKSPACE` ou un répertoire temporaire ;
- aucun chemin de destination fourni par le navigateur ou la requête REST ;
- création uniquement par
  `owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
  -> opus:create-site`;
- échec explicite si `sites/<application-id>` existe déjà ;
- aucune racine alternative devinée ou créée silencieusement.

Le déplacement futur d’applications vers des dépôts autonomes nécessitera
un nouveau contrat OPUS de stockage et de résolution. Il ne fait pas partie
de R22.

## 6. Fichier différentiel

```text
ZIP : opus_p117w_r22_registry_physical_reconciliation.zip
SHA-256 : 72dbe3d7700dfea0364b807f9e1714ca96218acc692d27c85517d03684538ba1
Taille : 6 868 octets
Fichiers : 1
sites/owasys-back/application/registry/repositories/RegistryRepository.php
```

Aucune classe concrète du framework `Opus/` n’est créée ou modifiée.

## 7. Validation

Gates locaux owner :

```text
php -l sites\owasys-back\application\registry\repositories\RegistryRepository.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
```

Résultat attendu après ouverture de `/fr-FR/applications` :

```text
Applications SQLite : 2
Applications visibles : owasys-back, owasys-front
owasys / sites/owasys_old : absent
stale_removed au premier sync : 1
stale_removed aux sync suivants : 0
```

Le nombre exact avant réconciliation dépend du SQLite local owner.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
