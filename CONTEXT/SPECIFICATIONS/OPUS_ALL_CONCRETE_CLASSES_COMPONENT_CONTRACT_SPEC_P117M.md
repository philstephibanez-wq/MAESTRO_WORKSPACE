# OPUS — Spécification de contractualisation exhaustive des classes concrètes P117M

## 1. Objet

Garantir qu'aucune classe concrète du framework OPUS ne puisse rester hors de la documentation et des contrats transverses du framework.

Le périmètre est l'intégralité de :

```text
Opus/**/*.php
```

Les catalogues historiques ou persistés ne constituent pas la source de vérité. La source de vérité est l'arbre PHP réellement présent au moment de l'audit.

## 2. Règle obligatoire

Pour toute classe concrète nommée :

```php
namespace Opus\Domain;

final class Example implements ExampleInterface
{
}
```

le même namespace doit contenir :

```php
interface ExampleInterface extends
    OpusFrameworkComponentInterface,
    OpusExceptionAwareInterface,
    OpusProfilerAwareInterface,
    OpusSelfDocumentingInterface
{
}
```

L'interface homonyme est obligatoire même lorsque la classe implémente déjà une interface fonctionnelle.

Exemple :

```php
final class NativeAdapter implements NativeAdapterInterface
{
}

interface NativeAdapterInterface extends
    AdapterInterface,
    OpusFrameworkComponentInterface,
    OpusExceptionAwareInterface,
    OpusProfilerAwareInterface,
    OpusSelfDocumentingInterface
{
}
```

## 3. Quatre marqueurs standards

Les marqueurs obligatoires sont exclusivement :

```text
Opus\Framework\OpusFrameworkComponentInterface
Opus\Framework\OpusExceptionAwareInterface
Opus\Framework\OpusProfilerAwareInterface
Opus\Framework\OpusSelfDocumentingInterface
```

Ils sont ajoutés à l'interface homonyme, pas directement à la classe concrète.

`OpusSelfDocumentingInterface` rend la classe visible au contrat RefBook. La présence d'une constante nommée `CONTRACT` ne remplace pas cette interface.

## 4. Éléments inclus

Sont inclus :

- classes finales ;
- classes readonly ;
- classes concrètes non finales ;
- exceptions concrètes ;
- value objects concrets ;
- endpoints concrets ;
- services, repositories, loaders, builders et factories concrets ;
- anciennes classes globales contenues dans les fichiers `.class.php` ;
- plusieurs classes concrètes nommées dans un même fichier.

## 5. Éléments exclus

Sont exclus de la création automatique d'une interface homonyme :

- classes abstraites ;
- interfaces ;
- traits ;
- enums ;
- classes anonymes ;
- dépendances sous `node_modules`, `vendor` ou `dist`.

Une classe abstraite peut conserver ses interfaces métier. Elle n'est pas comptée comme classe concrète dans l'audit P117M.

## 6. Préservation des contrats existants

L'outil ne remplace jamais une interface existante.

Lorsqu'une interface homonyme existe :

1. ses méthodes sont conservées ;
2. ses interfaces parentes fonctionnelles sont conservées ;
3. seuls les marqueurs transverses absents sont ajoutés ;
4. la classe est modifiée uniquement si elle n'implémente pas directement cette interface.

Lorsqu'une interface homonyme n'existe pas, elle est créée dans le même répertoire que la classe, sous le nom :

```text
<ClassName>Interface.php
```

## 7. Analyse tokenizer

L'analyse utilise `token_get_all()` et non des expressions régulières globales sur les fichiers PHP.

Le moteur détermine :

- namespace du fichier ;
- déclaration de classe ou d'interface ;
- caractère abstrait ;
- caractère anonyme ;
- position exacte de la déclaration ;
- liste des contrats déjà présents ;
- chemin de l'interface homonyme.

Le moteur refuse les fichiers contenant plusieurs déclarations de namespace, afin d'éviter une migration ambiguë.

## 8. Écriture transactionnelle

Avant toute écriture, le moteur construit le plan complet en mémoire.

Chaque fichier est écrit par un fichier temporaire local, puis renommé atomiquement.

En cas d'échec :

- les fichiers existants sont restaurés ;
- les interfaces nouvellement créées sont supprimées ;
- les fichiers temporaires sont supprimés ;
- le processus retourne un code d'erreur non nul.

Aucun dossier d'extraction, cache ou fichier temporaire ne doit subsister après l'opération.

## 9. Modes

### Audit

```text
--audit
```

Retourne zéro uniquement lorsqu'aucun fichier ne doit être créé ou modifié.

### Application

```text
--apply
```

Applique le plan, rescanne la totalité de `Opus/`, puis exige un audit final sans écart.

## 10. Idempotence

Après une application réussie, une deuxième exécution en mode audit doit retourner :

```text
FILES_TO_CREATE=0
FILES_TO_MODIFY=0
OPUS_COMPONENT_CONTRACT_AUDIT_OK
```

Une deuxième exécution en mode application ne doit modifier aucun fichier.

## 11. Composer et syntaxe

Après contractualisation :

```text
composer dump-autoload
```

est obligatoire, notamment pour les anciennes classes chargées par classmap.

Tous les fichiers PHP sous `Opus/` doivent ensuite passer `php -l`.

## 12. Documentation RefBook

La cartographie P7A1C existante est historique et ne doit plus être utilisée comme attestation de conformité courante.

La génération RefBook doit s'appuyer sur :

- l'arbre réel `Opus/` ;
- les classes réellement chargeables ;
- les interfaces homonymes ;
- les quatre marqueurs ;
- la réflexion runtime canonique.

Un futur audit ou générateur peut appeler le mode `--audit` avant toute génération de documentation et interrompre la génération en cas d'écart.

## 13. Applications OPUS

P117M ne déplace aucune logique applicative dans le framework.

Les applications sous `sites/<application>` restent :

- Singleton ;
- autonomes ;
- pilotées par FSM + ACL + SSO ;
- rendues exclusivement par SCORE ;
- sans `echo` de présentation ;
- sans mélange HTML/PHP ;
- consommatrices des services génériques OPUS.

Lorsqu'un besoin est générique et non strictement métier, l'évolution doit être proposée dans OPUS avant toute duplication locale dans l'application.

## 14. Politique GitHub

Le code OPUS n'est pas poussé directement par l'assistant.

Les fichiers de gouvernance sont écrits directement dans `MAESTRO_WORKSPACE`.

Le correctif OPUS est livré par ZIP différentiel et appliqué localement par l'utilisateur avant commit et push.

## 15. Critères d'acceptation

1. tous les PHP sous `Opus/` sont analysés ;
2. toute classe concrète nommée implémente directement son interface homonyme ;
3. toute interface homonyme étend directement les quatre marqueurs ;
4. les contrats fonctionnels existants sont préservés ;
5. les classes abstraites et anonymes sont exclues ;
6. aucun doublon d'interface n'est créé ;
7. aucun fichier hors `Opus/` n'est contractualisé ;
8. l'application est transactionnelle ;
9. le rescan post-application ne trouve aucun écart ;
10. Composer est régénéré ;
11. tous les fichiers PHP passent le lint ;
12. aucune modification OWASYS n'est requise pour ce jalon.
