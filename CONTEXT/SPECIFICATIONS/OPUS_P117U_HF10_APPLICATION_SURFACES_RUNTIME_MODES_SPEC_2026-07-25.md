# OPUS P117U HF10 — APPLICATION SURFACES AND RUNTIME MODES

Date : 2026-07-25  
Statut : architecture owner validée ; ZIP différentiel produit ; installation owner en attente

## 1. Décision contractuelle

La structure canonique des applications OPUS devient :

```text
sites/<application>/application/shared
sites/<application>/application/front
sites/<application>/application/back
```

Composition des profils :

```text
frontend  = shared + front
backend   = shared + back
fullstack = shared + front + back
```

`application/full` est interdit. Fullstack est une composition, pas une quatrième racine ni une duplication de code.

## 2. Répartition

### shared

- contrats applicatifs ;
- domaine et DTO typés ;
- configuration commune ;
- catalogues I18n communs ;
- composition Singleton ;
- corrélation Logger/Profiler ;
- éléments réellement partagés entre front et back.

### front

- modules de présentation ;
- contrôleurs frontend ;
- ViewModels ;
- templates et vues SCORE ;
- navigation ;
- ACL de présentation ;
- assets et interactions non obligatoires.

### back

- modules API ;
- contrôleurs REST ;
- services et providers ;
- commandes Composer allow-listées ;
- ACL backend ;
- persistance et transformations métier.

`shared` ne doit jamais servir de répertoire fourre-tout.

## 3. Runtime

Le rôle d'un processus ne dépend plus de son numéro de port.

```text
--mode=front
--mode=back
```

Le mode front refuse les routes backend. Le mode back refuse les routes frontend. Les ports restent configurables et ne constituent pas une frontière de sécurité.

Développement local recommandé :

```text
front : 127.0.0.1:8000
back  : 127.0.0.1:8792
```

Production : HTTPS 443 derrière reverse proxy, processus/pools front et back séparés, backend non exposé directement.

## 4. Contrats OPUS maintenus

- architecture Singleton ;
- FSM + I18n + ACL deny-by-default + SSO/Auth0 proxy + bastion ;
- locale initiale depuis `Accept-Language`, fallback explicite diagnostiqué ;
- SCORE exclusivement pour l'interface ;
- aucun `echo` UI ;
- aucun mélange HTML/PHP ;
- configuration via `File` puis `Json`, `Xml` ou `Yaml` par `StructuredFileLoader` ;
- toute mutation OWASYS via REST sécurisé puis Composer ;
- Logger et Profiler obligatoires ;
- aucun fallback silencieux.

## 5. Classes framework

HF10 ajoute :

```text
Opus/Application/Structure/ApplicationStructure.php
Opus/Application/Structure/ApplicationStructureInterface.php
```

`ApplicationStructure` implémente son interface homonyme. L'interface étend directement :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

Les autres classes concrètes OPUS modifiées conservent leurs interfaces homonymes existantes.

## 6. Scaffold généré

Les nouvelles applications générées utilisent :

```text
application/shared/Application.php
application/shared/bootstrap.php
application/shared/layouts
application/shared/local
application/front/modules/<module>
application/back/modules/<module>
```

Chaque route générée déclare explicitement `surface: front|back`.

Le frontend produit des documents SCORE. Le backend produit des réponses JSON structurées. Les états FSM sont qualifiés par surface afin d'éviter les collisions entre modules front et back de même nom.

## 7. Observabilité OWASYS

Le runtime Singleton OWASYS est enveloppé par Logger et Profiler.

```text
sites/owasys/var/logs/owasys-runtime.log
sites/owasys/var/logs/rcp-backend.log
sites/owasys/var/profiler/<trace_id>.json
```

Toute exception traversant la composition root produit :

- un événement `request.failed` ;
- un code d'erreur sûr ;
- un `trace_id` ;
- une trace Profiler ;
- l'en-tête `X-Opus-Trace-Id` lorsque les en-têtes sont encore disponibles.

HF10 ajoute l'observabilité du HTTP 500 actuel. Il ne prétend pas corriger sa cause sans trace réelle.

## 8. Migration physique OWASYS

Le cloisonnement de processus front/back est livré dans HF10.

Le déplacement physique de l'arbre OWASYS historique vers `application/shared`, `application/front` et `application/back` est marqué :

```text
owasys-physical-migration-pending
```

Il sera fourni par un différentiel HF10B après récupération du journal et du `trace_id` du HTTP 500. Aucun déplacement massif non validé n'est effectué silencieusement.

## 9. Différentiel

```text
ZIP     : opus_p117u_hf10_application_surfaces_runtime_modes.zip
SHA-256 : 5ca8ddbb1e765ec9a63393cbdb2d70a95e17e0e62b39027e0f921854c0174721
BASE    : OPUS@41f77ad7187c0facb125a5737b62d10928809e66
```

L'installateur refuse un HEAD différent, un dépôt non propre, un blob source différent ou une substitution ambiguë.

## 10. Commandes après installation

```text
sites\owasys\tools\cmd\START_OWASYS_FRONT.cmd
sites\owasys\tools\cmd\START_OWASYS_BACK.cmd
```

Équivalents :

```text
composer opus:serve-site -- owasys --mode=front --host=127.0.0.1 --port=8000
composer opus:serve-site -- owasys --mode=back --host=127.0.0.1 --port=8792
```

## 11. Gates owner

1. dépôt propre sur `41f77ad7187c0facb125a5737b62d10928809e66` ;
2. exécuter `INSTALL_HF10.cmd` ;
3. vérifier le smoke `P117U_HF10_APPLICATION_SURFACES_SMOKE_OK` ;
4. lancer back puis front avec les nouveaux CMD ;
5. reproduire `/fr-FR/applications` ;
6. relever `trace_id` et `owasys-runtime.log` si le 500 persiste ;
7. vérifier qu'une route API est refusée par le front ;
8. vérifier qu'une route UI est refusée par le back ;
9. exécuter le gate tokenizer P117M ;
10. committer OPUS uniquement après validation owner.
