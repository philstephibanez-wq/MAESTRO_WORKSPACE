# OPUS P117V HF10B — OWASYS PHYSICAL FRONT/BACK SPLIT AND RUNTIME BOOTSTRAP

Date : 2026-07-26  
Statut : ZIP différentiel direct produit ; installation et validation owner en attente

## 1. Source de vérité

```text
Repository : philstephibanez-wq/OPUS
Branch     : master
Base HEAD  : 21650601d7025706d4f7008ec0d0028d8cbe9c9d
Milestone  : HF10A committé mais rejeté fonctionnellement
```

La trace owner établit que le frontend s'arrête avant REST avec :

```text
OPUS_RCP_CLIENT_TOKEN_NOT_CONFIGURED
```

Conséquence : aucun appel backend, donc aucun événement dans le journal backend.

## 2. Architecture contractuelle

```text
application/shared
application/front/default
application/front/modules/<module>
application/back/modules/<module>
application/back/api
```

Composition :

```text
frontend  = shared + front
backend   = shared + back
fullstack = shared + front + back
```

`application/full` est interdit.

## 3. Séparation runtime réelle

### Processus front

- bootstrap : `application/front/bootstrap.php` ;
- runtime : `application/front/Runtime.php` ;
- contrôleurs, modèles, vues et templates chargés uniquement depuis `application/front` ;
- modules fonctionnels sous `application/front/modules` ;
- rendu exclusivement SCORE ;
- toute route `/api` est refusée.

### Processus back

- bootstrap : `application/back/bootstrap.php` ;
- runtime : `application/back/Runtime.php` ;
- API chargée uniquement depuis `application/back/api` ;
- aucune classe de présentation chargée ;
- toute route hors API est refusée ;
- mutations via REST sécurisé, FSM d'exécution et Composer allow-listé.

### Composition partagée

- Singleton : `application/shared/Application.php` ;
- interface runtime partagée ;
- catalogues I18n : `application/shared/i18n/default` et `application/shared/i18n/modules/<module>` ;
- Logger et Profiler corrélés par `trace_id`.

## 4. Démarrage direct par Composer

Les commandes owner restent exactement :

```text
composer opus:serve-site -- owasys --mode=back --host=127.0.0.1 --port=8792
composer opus:serve-site -- owasys --mode=front --host=127.0.0.1 --port=8000
```

Aucune génération manuelle de token n'est requise.

`SiteCommandService` et `LayeredSiteCommandService` :

1. lisent `config/site.json` par `File` + `StructuredFileLoader` ;
2. ouvrent le store runtime `var/runtime/rcp-secrets.json` ;
3. créent sous verrou une seule paire token/HMAC si elle n'existe pas ;
4. réutilisent la même paire pour les processus back et front lancés séparément ;
5. injectent les secrets uniquement dans l'environnement enfant ;
6. ne placent aucun secret dans Git, argv, Logger ou Profiler.

Le store runtime est couvert par les règles `.gitignore` de `sites/*/var/*`.

## 5. Journaux et Profiler

Dès le lancement du processus :

```text
front -> sites/owasys/var/logs/owasys-frontend.log
back  -> sites/owasys/var/logs/rcp-backend.log
```

Le journal back reçoit `process.starting` avant `proc_open`. Après une requête REST, le même journal reçoit les événements RCP/Composer.

Profiler :

```text
sites/owasys/var/profiler/front
sites/owasys/var/profiler/back
```

Toute exception traversant le Singleton produit `request.failed`, un code sûr, la classe/fichier/ligne de l'exception et un `trace_id`. Le frontend rend l'erreur via SCORE.

## 6. Migration physique

Le ZIP contient le fichier final :

```text
sites/owasys/tools/cmd/MIGRATE_OWASYS_LAYOUT_HF10B.cmd
```

Ce CMD :

- copie les composants existants vers les nouvelles racines finales ;
- sépare les catalogues dans `application/shared/i18n` ;
- place les modules UI dans `application/front/modules` ;
- place l'API dans `application/back/api` ;
- n'écrase pas les nouveaux fichiers HF10B ;
- valide les cibles obligatoires ;
- ne supprime aucun ancien chemin avant validation runtime owner.

Les anciens chemins deviennent inactifs dès que `www/index.php` sélectionne les nouveaux bootstraps. Leur suppression fera l'objet de commandes CMD après validation des deux processus et des journaux.

## 7. Classes framework

Nouvelle classe concrète :

```text
Opus\Security\Runtime\RuntimeSecretStore
```

Elle implémente directement `RuntimeSecretStoreInterface`. Cette interface étend directement :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

Les classes concrètes framework modifiées conservent leurs interfaces homonymes déjà contractuelles :

```text
SiteCommandService
LayeredSiteCommandService
```

## 8. Configuration

`sites/owasys/config/site.json` déclare :

```text
OPUS_APPLICATION_LAYER_LAYOUT_V1
application/shared
application/front
application/back
runtime_modes = front, back
OPUS_APPLICATION_SINGLETON_V2
OPUS_RUNTIME_SECRET_BINDING_V1
OPUS_RUNTIME_DIAGNOSTICS_V1
```

La locale reste négociée à partir de l'URL explicite, puis du navigateur, avec fallback explicite diagnostiqué.

## 9. Livrable

```text
ZIP     : opus_p117v_hf10b_owasys_physical_front_back_runtime_bootstrap.zip
SHA-256 : 20803dd76b72bbed4704655e782fbf29cd79d7e2f01652a2ef0a6faa46f588ef
BASE    : 21650601d7025706d4f7008ec0d0028d8cbe9c9d
FILES   : 19
```

Mode de livraison : ZIP différentiel direct superposable à `H:\OPUS`, fichiers complets à leurs chemins finaux, sans installateur, payload, patch, staging, rapport ou log.

## 10. Validations exécutées

```text
PHP lint des 16 fichiers PHP                         : OK
JSON site.json                                       : OK
réouverture et lint du ZIP                           : OK
store secret : création + réutilisation 64 hex      : OK
logs process.starting front/back                     : OK
simulation migration default/modules/api/I18n       : OK
smoke séparation physique                            : P117V_HF10B_OWASYS_PHYSICAL_SPLIT_SMOKE_OK
fichier interdit dans ZIP                            : 0
```

## 11. Gates owner

1. vérifier le HEAD exact et le worktree propre ;
2. extraire le ZIP directement dans `H:\OPUS` ;
3. exécuter le CMD de migration ;
4. reconstruire l'autoload Composer ;
5. exécuter lint, audit contractuel et smoke ;
6. lancer le back par Composer ;
7. constater immédiatement `rcp-backend.log` ;
8. lancer le front par Composer ;
9. tester `/fr-FR/applications` et `/fr-FR/applications/new` ;
10. vérifier REST -> Composer et les traces corrélées ;
11. seulement après validation, fournir le nettoyage des anciens chemins ;
12. exécuter le gate tokenizer P117M avant commit owner.
