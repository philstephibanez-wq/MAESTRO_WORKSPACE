# OPUS / OWASYS — Spécification i18n ASAP + SCORE P117I

## 1. Objet

Définir l’unique moteur i18n canonique d’OPUS et son intégration native dans SCORE, en restaurant les fonctions historiques d’ASAP : catalogues hiérarchiques, substitutions, genres et pluriels complexes.

## 2. Frontières

Le moteur générique appartient à :

```text
Opus/I18n/
```

Les catalogues d’une application appartiennent à :

```text
sites/<application>/application/default/local/
sites/<application>/application/<module>/local/
```

Aucune traduction OWASYS ne doit être stockée dans `Opus/I18n`.

## 3. Source du module actif

Le module utilisé pour construire le contexte i18n est exclusivement le module de l’état FSM actif :

```text
FSM state -> states[].module -> ApplicationTranslationRuntime
```

Ni la route brute, ni `site.json.modules`, ni un nom de template ne remplacent cette source.

## 4. Ordre des catalogues

Pour une locale et un module donnés :

```text
1. application/default/local/<locale>.php|json
2. application/<module>/local/<locale>.php|json
```

Le deuxième catalogue surcharge le premier clé par clé.

Le catalogue global est obligatoire. Le catalogue du module est optionnel si le module n’a aucun catalogue propre.

Aucun chargement implicite de l’anglais ou d’une autre locale n’est autorisé.

## 5. Formats acceptés

### 5.1 PHP OPUS plat

```php
return [
    '_locale' => 'fr',
    'auth.login' => 'Se connecter',
];
```

### 5.2 OPUS structuré

```php
return [
    '_locale' => 'fr',
    'registry.selected' => [
        'forms' => [
            'masculine' => [
                'one' => '{count} objet sélectionné',
                'other' => '{count} objets sélectionnés',
            ],
            'feminine' => [
                'one' => '{count} application sélectionnée',
                'other' => '{count} applications sélectionnées',
            ],
            'neuter' => [
                'one' => '{count} élément sélectionné',
                'other' => '{count} éléments sélectionnés',
            ],
        ],
    ],
];
```

### 5.3 JSON ASAP

```json
{
  "locale": "uk",
  "messages": {
    "auth.login": "Увійти"
  },
  "plurals": {
    "registry.application_count": {
      "one": "{count} застосунок",
      "few": "{count} застосунки",
      "many": "{count} застосунків",
      "other": "{count} застосунку"
    }
  }
}
```

Les sections historiques ASAP `messages` et `plurals` sont normalisées dans le catalogue OPUS.

## 6. Genres

Valeurs canoniques :

```text
masculine
feminine
neuter
```

Alias d’entrée acceptés :

```text
male, m
female, f
neutral, n
```

Lorsqu’une entrée expose des formes de genre, le paramètre `gender` est obligatoire. Une forme absente provoque `OPUS_I18N_GENDER_FORM_MISSING`.

## 7. Pluriels

Catégories supportées :

```text
zero one two few many other
```

Le registre de règles couvre :

```text
bg hr cs da nl en et fi fr de el hu ga it lv lt mt pl pt ro sk sl es sv uk
```

Les langues slaves disposent de règles dédiées. Au minimum :

- ukrainien et russe : `one/few/many/other` ;
- polonais : `one/few/many/other` ;
- croate : `one/few/other` ;
- tchèque et slovaque : `one/few/many/other` ;
- slovène : `one/two/few/other`.

Le moteur sélectionne exactement la catégorie demandée. Il ne remplace pas silencieusement une forme absente par `other`.

## 8. Substitutions

Syntaxe de catalogue :

```text
{count}
{name}
{application}
```

Chaque placeholder présent doit recevoir une valeur scalaire ou `Stringable`. Une valeur absente ou non convertible produit une erreur explicite.

`count` est automatiquement ajouté aux paramètres lorsqu’un nombre est fourni.

## 9. API runtime

Contrat :

```php
TranslationRuntimeInterface::translate(
    string $key,
    array $parameters = [],
    int|float|null $count = null,
    Gender|string|null $gender = null
): string
```

Le runtime expose également la locale et le module actifs.

## 10. SCORE

Directive native :

```score
[[ i18n: <key> [argument=expression ...] ]]
```

Exemples :

```score
[[ i18n: auth.login ]]
[[ i18n: auth.welcome name=identity.label ]]
[[ i18n: registry.application_count count=sync.total ]]
[[ i18n: registry.selected count=selection.total gender=selection.gender ]]
```

Les expressions utilisent le même résolveur strict que les interpolations SCORE.

La directive produit un nœud AST `i18n`. Elle ne doit pas être implémentée par remplacement textuel préalable, JavaScript ou post-traitement HTML.

Le résultat est échappé avec `ENT_QUOTES | ENT_SUBSTITUTE`. Aucune directive i18n brute n’est autorisée dans ce jalon.

## 11. Responsabilités

### `ApplicationTranslationRuntime`

- valide racine, locale et module ;
- charge global puis module ;
- choisit la règle plurielle ;
- construit le traducteur.

### `CatalogLoader`

- lit PHP ou JSON ;
- valide la locale déclarée ;
- normalise OPUS et ASAP ;
- refuse les formats ambigus.

### `MessageSelector`

- sélectionne genre ;
- sélectionne catégorie plurielle ;
- refuse les formes absentes.

### `MessageInterpolator`

- remplace les paramètres ;
- refuse les paramètres absents ou non scalaires.

### `ScoreTemplateRenderer`

- parse la directive ;
- résout les arguments dans le ViewModel ;
- appelle uniquement `TranslationRuntimeInterface` ;
- échappe le résultat.

## 12. OWASYS

`OwasysScorePageRenderer` construit un runtime i18n par rendu avec :

```text
applicationRoot = sites/owasys/application
locale = ViewModel locale.code
module = ViewModel fsm.module
```

Les templates communs, login, compte et registre utilisent directement les clés i18n pour leurs textes statiques.

Les textes métier dynamiques restent des données du ViewModel.

## 13. Erreurs obligatoires

Codes minimaux :

```text
OPUS_I18N_LOCALE_INVALID
OPUS_I18N_PLURAL_RULE_MISSING
OPUS_I18N_CATALOG_FILE_MISSING
OPUS_I18N_CATALOG_FILE_AMBIGUOUS
OPUS_I18N_CATALOG_LOCALE_MISMATCH
OPUS_I18N_MESSAGE_MISSING
OPUS_I18N_GENDER_REQUIRED
OPUS_I18N_GENDER_FORM_MISSING
OPUS_I18N_COUNT_REQUIRED
OPUS_I18N_PLURAL_FORM_MISSING
OPUS_I18N_PARAMETER_MISSING
OPUS_I18N_PARAMETER_TYPE_INVALID
OPUS_SCORE_I18N_RUNTIME_MISSING
OPUS_SCORE_I18N_COUNT_INVALID
OPUS_SCORE_I18N_GENDER_INVALID
```

## 14. Interdictions

- retour silencieux de la clé ;
- fallback anglais implicite ;
- traduction dans JavaScript après rendu ;
- texte visible codé en dur dans les templates migrés ;
- accès disque aux catalogues depuis SCORE ;
- stockage de catalogues OWASYS sous `Opus/` ;
- recréation de `Opus/Owasys` ;
- HTML brut issu des catalogues.

## 15. Critères de validation

1. priorité du module sur le global ;
2. clé globale accessible depuis tous les modules ;
3. clé absente rejetée ;
4. genre requis et forme exacte ;
5. catégories ukrainiennes correctes pour 1, 2, 5, 21, 22 et 25 ;
6. substitution stricte de `{count}` et autres paramètres ;
7. directive SCORE rendue et échappée ;
8. includes, conditions, boucles et filtres SCORE préservés ;
9. login, compte, Registry et Mermaid non régressés ;
10. ZIP sans Markdown, smoke, manifeste racine ni `Opus/Owasys`.
