# OPUS / OWASYS — SPÉCIFICATION D’EXÉCUTION DE LA GOUVERNANCE

Date : 2026-07-24  
Statut : addendum contractuel obligatoire  
Portée : framework OPUS, application OWASYS et applications construites avec OPUS

## 1. Contrats de référence

Cette spécification complète sans les remplacer :

- `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md` ;
- `CONTEXT/SPECIFICATIONS/OPUS_ALL_CONCRETE_CLASSES_COMPONENT_CONTRACT_SPEC_P117M.md` ;
- `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md` ;
- `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7_APPLICATION_CREATION_PROFILES_SPEC.md` ;
- les règles permanentes du contrat de développement MAESTRO.

## 2. Sources de vérité relues

```text
MAESTRO_WORKSPACE : philstephibanez-wq/MAESTRO_WORKSPACE
Branche            : master
Head de départ     : cf0f0e6697abd4ea581b6255e76ea64df4063bde

OPUS               : philstephibanez-wq/OPUS
Branche            : master
Head relu          : 79f261854ee06a9f828fec389adca77d57323d00
État du head       : P117U + HF1 + HF2 + HF3 + HF4 + HF6
```

OWASYS n’est pas un dépôt autonome. L’application canonique appartient à `sites/owasys/` dans le dépôt OPUS.

## 3. Écart distant confirmé

HF7 n’est pas encore appliqué sur `OPUS/master`.

Le `composer.json` distant au head relu contient encore :

```text
owasys:registry-creation-start
```

Cet alias est obsolète et doit disparaître avec HF7. Aucun correctif partiel isolé ne doit être appliqué à sa place.

## 4. Contrat des classes concrètes OPUS

Toute classe concrète nommée sous `Opus/**/*.php` implémente directement une interface homonyme située dans le même namespace.

Cette interface étend directement :

```text
OpusFrameworkComponentInterface
OpusExceptionAwareInterface
OpusProfilerAwareInterface
OpusSelfDocumentingInterface
```

Les interfaces métier existantes sont conservées. Les classes abstraites, traits, enums, interfaces et classes anonymes ne sont pas comptés comme classes concrètes.

La comparaison GitHub depuis P117M jusqu’au head OPUS relu montre que les nouvelles classes concrètes OPUS introduites après P117M disposent de leurs interfaces homonymes. Les interfaces contrôlées sur le head relu étendent les quatre marqueurs.

La conformité exhaustive finale reste bloquée par l’exécution locale owner du gate tokenizer P117M sur l’arbre OPUS complet après application de HF7.

## 5. Architecture obligatoire des applications OPUS

Toute application OPUS reste :

- Singleton ;
- pilotée intégralement par FSM, I18n, ACL deny-by-default et SSO ;
- compatible proxy Auth0 et bastion ;
- backend-first ;
- rendue exclusivement par SCORE ;
- sans `echo` produisant l’interface ;
- sans mélange HTML/PHP ;
- fonctionnelle sans JavaScript obligatoire ;
- basée prioritairement sur les classes et services OPUS ;
- localisée par défaut depuis `Accept-Language` du navigateur ;
- instrumentée par Logger et Profiler.

Tout besoin générique non strictement métier doit faire l’objet d’une proposition d’évolution OPUS avant toute implémentation locale.

## 6. Configuration

Tout fichier de configuration est lu par `Opus\File\File`, puis parsé explicitement par :

```text
JSON     -> Opus\File\Json
XML      -> Opus\File\Xml
YAML/YML -> Opus\File\Yaml
```

`StructuredFileLoader` assure la sélection contractuelle lorsque le format dépend de l’extension. Aucun parser local ou fallback silencieux n’est admis.

## 7. Frontière OWASYS

```text
OWASYS SCORE UI
-> FSM + I18n + ACL + SSO
-> REST typé et sécurisé
-> bearer + HMAC
-> FSM backend
-> opération allow-listée
-> commande publique Composer
-> service OPUS ou provider métier OWASYS
-> résultat structuré
-> ViewModel
-> SCORE
```

Toute commande métier ou mutation persistante OWASYS traverse REST sécurisé puis Composer. Le frontend ne lance aucun processus et n’écrit aucun fichier métier.

## 8. Logger et Profiler

Logger et Profiler sont obligatoires sur le backend et sur les workflows frontend significatifs.

```text
Backend log  : sites/owasys/var/logs/rcp-backend.log
Frontend log : sites/owasys/var/logs/owasys-frontend.log
Profiler     : sites/owasys/var/profiler/<trace_id>.json
```

Aucun secret, token, HMAC, mot de passe, paramètre brut ou ligne de commande sensible ne doit être journalisé, profilé, committé ou livré.

## 9. Différentiel canonique

Le correctif fonctionnel courant reste :

```text
opus_owasys_p117u_hf7_application_creation_profiles.zip
SHA-256: 16e06b55f3cf2ffcc5118fe0e5c4f17cbc7b51fa437fd06f17bf3dc16ab48141
Fichiers: 45
Taille ZIP: 54 906 octets
```

L’artefact exact a été retrouvé et son empreinte a été recalculée. Il ne doit pas être reconstruit approximativement.

## 10. Commandes opérationnelles

Les commandes de nettoyage et de lancement sont fournies pour CMD dans le terminal VS Code.

Le nettoyage ne supprime que les caches et temporaires explicitement identifiés. Il préserve les logs, les traces Profiler, les données Registry et `sites/owasys_old`.

Le backend OWASYS est lancé sur `127.0.0.1:8792` avant le frontend sur `127.0.0.1:8000`. Les variables `OPUS_OWASYS_BACKEND_TOKEN` et `OPUS_OWASYS_BACKEND_HMAC` doivent être définies dans les deux terminaux sans être inscrites dans Git ou dans les scripts.

## 11. Politique d’écriture GitHub

- gouvernance, spécifications, handoffs et index : écriture directe dans `MAESTRO_WORKSPACE` ;
- code OPUS/OWASYS : aucune écriture directe par l’assistant ;
- correctifs OPUS/OWASYS : ZIP différentiel appliqué localement par l’owner, puis commit et push après validation.

## 12. Ordre d’application

```text
P117U -> HF1 -> HF2 -> HF3 -> HF4 -> HF6 -> HF7
```

HF5 est remplacé par HF6.

## 13. Gates owner obligatoires

1. appliquer HF7 sur une base locale propre au head HF6 ;
2. exécuter `composer dump-autoload -o` ;
3. exécuter le gate tokenizer P117M en audit ;
4. lint de tous les PHP sous `Opus/` et des PHP du différentiel ;
5. valider OWASYS et ses routes ;
6. lancer backend puis frontend ;
7. vérifier `/api/v1/status` puis `/fr-FR/applications` ;
8. tester les profils frontend, backend et fullstack ;
9. vérifier Registry, transition Creation vers Build et corrélation des traces ;
10. valider navigation sans JavaScript, Auth0, HTTPS, bastion et parité Windows/Linux ;
11. décider séparément du sort de `sites/owasys_old` ;
12. committer OPUS uniquement après acceptation owner.
