# MAESTRO / OPUS / OWASYS — RÈGLES GLOBALES DE DÉVELOPPEMENT

Date : 2026-07-24  
Statut : contrat de développement obligatoire  
Portée : `MAESTRO_WORKSPACE`, framework OPUS, OWASYS et applications construites avec OPUS

## 1. Source de vérité et relecture préalable

Avant toute spécification, correction, évolution ou livraison :

1. relire le dépôt GitHub concerné sur sa branche canonique ;
2. relire les contrats, conventions, handoffs et états courants du workspace ;
3. identifier la cible live et la base exacte du différentiel ;
4. refuser tout patch lorsque la source de vérité ou le fichier réel n'est pas disponible ;
5. ne jamais remplacer un contrat existant par une supposition ou un catalogue historique.

Règles absolues :

```text
NO CONTRACT, NO PATCH.
NO SOURCE OF TRUTH, NO PATCH.
NO FALLBACK SILENCIEUX.
NO BRICOLAGE DELIVERY.
```

Le commit OPUS distant courant relu pour cette mise à jour est :

```text
79f261854ee06a9f828fec389adca77d57323d00
```

Il contient HF6. HF7 reste un différentiel documenté dans le workspace mais non committé sur `OPUS/master` au moment de cette relecture.

## 2. Politique GitHub et livraisons

- Les spécifications, décisions, handoffs et index du workspace sont écrits directement dans `philstephibanez-wq/MAESTRO_WORKSPACE`.
- Le code OPUS et OWASYS n'est pas poussé directement par l'assistant.
- Toute correction ou évolution OPUS/OWASYS est fournie sous forme de ZIP différentiel fondé sur une source de vérité identifiée.
- Un ZIP différentiel ne contient que les fichiers à créer, modifier ou supprimer dans leur arborescence cible.
- Aucun cache, extraction, temporaire, log, rapport, smoke, audit, recette, dépendance vendor ou secret ne doit être livré.
- Aucun fichier OPUS/OWASYS ne doit être reconstitué depuis une description lorsque l'artefact ou la source réelle manque.

## 3. Contrat exhaustif des classes concrètes OPUS

Toute classe concrète nommée sous `Opus/**/*.php` doit implémenter directement une interface contractuelle homonyme placée dans le même namespace.

Exemple :

```php
final class Example implements ExampleInterface
{
}
```

L'interface homonyme étend directement les quatre marqueurs standards :

```php
interface ExampleInterface extends
    OpusFrameworkComponentInterface,
    OpusExceptionAwareInterface,
    OpusProfilerAwareInterface,
    OpusSelfDocumentingInterface
{
}
```

Les contrats fonctionnels existants sont conservés et ajoutés aux parents de l'interface homonyme. Les quatre marqueurs ne sont pas remplacés par une constante `CONTRACT`, une interface métier ou une implémentation indirecte.

Sont inclus : classes finales, readonly, concrètes non finales, exceptions, value objects, endpoints, services, repositories, loaders, builders, factories et anciennes classes nommées `.class.php`.

Sont exclus : classes abstraites, interfaces, traits, enums et classes anonymes.

Toute évolution OPUS doit être bloquée si l'audit exhaustif fondé sur `token_get_all()` détecte une classe concrète non conforme.

## 4. Architecture obligatoire des applications OPUS

Toute application construite avec OPUS doit être :

- Singleton ;
- autonome sous `sites/<application>/` ;
- pilotée intégralement par FSM, I18n, ACL deny-by-default et SSO ;
- compatible proxy Auth0 et bastion derrière les contrats génériques OPUS ;
- backend-first ;
- rendue exclusivement via SCORE ;
- sans `echo` produisant l'interface ;
- sans mélange HTML et PHP ;
- fonctionnelle sans JavaScript obligatoire ;
- basée prioritairement sur les classes et services OPUS ;
- instrumentée par Logger et Profiler ;
- localisée par défaut à partir de `Accept-Language` du navigateur, avec fallback explicite déclaré.

Le point d'entrée `www/index.php` reste minimal et ne contient aucune logique métier, FSM, ACL, SSO, I18n, menu ou rendu applicatif.

Lorsqu'un besoin n'est pas strictement métier à l'application, l'évolution du framework OPUS doit être proposée explicitement avant toute implémentation locale. Aucune duplication générique locale n'est autorisée sans décision owner.

## 5. Configuration et parsers

Tout fichier de configuration est lu via `Opus\File\File` ou son interface contractuelle.

Le contenu structuré est parsé selon son format par les classes OPUS dédiées :

```text
JSON -> Opus\File\Json
XML  -> Opus\File\Xml
YAML/YML -> Opus\File\Yaml
```

La sélection passe par `StructuredFileLoader` lorsqu'elle dépend de l'extension.

Sont interdits pour la configuration :

- lecture locale directe avec `file_get_contents` ;
- `json_decode` local ;
- parseur XML ou YAML ad hoc ;
- fallback silencieux de parser ;
- format deviné sans contrat explicite.

## 6. Frontière OWASYS

OWASYS est uniquement l'application web construite avec OPUS.

```text
OWASYS SCORE UI
-> FSM + I18n + ACL + SSO
-> requête REST typée et sécurisée
-> authentification bearer + HMAC
-> FSM d'exécution backend
-> opération allow-listée
-> commande publique Composer
-> service OPUS ou provider métier OWASYS
-> résultat structuré
-> ViewModel
-> SCORE
```

Toute commande métier ou mutation persistante OWASYS passe obligatoirement par REST sécurisé puis Composer.

OWASYS ne doit jamais :

- écrire directement les fichiers applicatifs depuis l'UI ;
- ouvrir ou modifier directement le Registry ;
- exécuter directement PHP, Composer, Git ou une commande shell depuis le frontend ;
- accepter une commande libre, un chemin exécutable, un CWD ou des options non contractuelles fournis par le navigateur ;
- placer de logique métier OWASYS sous `Opus/`.

## 7. Logger et Profiler

Logger et Profiler sont contractuels pour le framework, le backend et les workflows frontend significatifs.

Chaque opération doit permettre une corrélation par identifiant de trace entre :

- requête frontend ;
- requête REST ;
- FSM backend ;
- appel Composer ;
- résultat ou erreur rendue.

Ne doivent jamais entrer dans Git, argv, logs, profiler, exceptions ou ZIP : mots de passe, tokens, clés HMAC, secrets, corps sensibles, lignes de commande sensibles ou données de formulaire brutes.

## 8. Commandes CMD

Lorsqu'un nettoyage est requis, fournir des commandes CMD destinées au terminal VS Code.

Lorsqu'un site doit être lancé, fournir les commandes CMD contractuelles de lancement.

Dans les blocs `cmd` :

- uniquement des commandes exécutables ;
- aucun prompt, commentaire, sortie attendue, diagnostic, code HTTP ou texte explicatif ;
- aucune suppression d'un répertoire dont l'obsolescence n'est pas validée ;
- pas de `exit /b` dans un terminal interactif VS Code.

## 9. Validation obligatoire

Une livraison ne peut être déclarée conforme avant validation de :

1. source de vérité et base du différentiel ;
2. PHP lint et parsing JSON/XML/YAML concernés ;
3. Composer autoload optimisé ;
4. interfaces homonymes et quatre marqueurs ;
5. Singleton, FSM, I18n, ACL, SSO et SCORE ;
6. locale navigateur et fallback explicite ;
7. absence d'`echo` UI et de vue HTML/PHP mixte ;
8. frontière REST sécurisé puis Composer pour OWASYS ;
9. Logger, Profiler et corrélation de trace ;
10. absence de secret, cache, temporaire, rapport ou pollution de racine ;
11. navigation sans JavaScript ;
12. tests owner Windows/Linux, Auth0, HTTPS et bastion lorsque le périmètre les touche.

## 10. Contrats liés

Ce contrat complète sans les remplacer :

- `CONTEXT/SPECIFICATIONS/OPUS_ALL_CONCRETE_CLASSES_COMPONENT_CONTRACT_SPEC_P117M.md` ;
- `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md` ;
- `CONTEXT/SPECIFICATIONS/OWASYS_BACKEND_REST_COMPOSER_SPEC_P117T.md` pour les principes repris ensuite par P117U ;
- `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_P117U_HF7_APPLICATION_CREATION_PROFILES_SPEC.md` ;
- le contrat de développement MAESTRO et les règles permanentes du workspace.
