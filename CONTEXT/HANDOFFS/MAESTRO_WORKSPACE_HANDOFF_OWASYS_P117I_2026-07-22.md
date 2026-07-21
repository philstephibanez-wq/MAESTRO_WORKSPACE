# Handoff OWASYS / OPUS — P117I

**Date :** 2026-07-22  
**Dépôt code relu :** `philstephibanez-wq/OPUS`  
**Tête relue :** `6df768703f9573f5f634eca7708cfc704ff585aa` (`p117h`)

## Demande

Restaurer dans OPUS les fonctionnalités i18n historiques d’ASAP et les intégrer nativement à SCORE :

- dictionnaire global de l’application ;
- dictionnaire spécifique au module actif chargé ensuite ;
- surcharge module sur global ;
- substitutions strictes ;
- masculin, féminin et neutre ;
- pluriels simples et complexes, notamment slaves ;
- balise i18n native dans les templates `.score` ;
- ménage de l’ancien pseudo-i18n plat `Opus/I18n`.

## Diagnostic

L’état P117H ne possède pas de moteur i18n complet. `Opus/I18n` contient principalement :

- une validation syntaxique de clé ;
- un validateur de catalogues plats `string => string` ;
- un validateur interdisant certains textes UI bruts.

OWASYS charge encore directement `application/default/local/en.php` puis `application/default/local/<locale>.php` avec `array_replace()`, sans catalogue du module actif. La fonction de traduction peut encore renvoyer la clé manquante. SCORE ne connaît aucune directive i18n.

Le port historique ASAP P112D4A/P112D4C contenait déjà :

- catalogues JSON ;
- messages simples ;
- pluriels ;
- interpolation `{param}` ;
- règles française, anglaise, espagnole et russe ;
- erreurs explicites.

Il ne couvrait toutefois pas complètement la pile global/module ni la combinaison genre × nombre décrite par l’ASAP d’origine.

## Correctif P117I préparé

Archive locale :

```text
opus_owasys_p117i_i18n_asap_score.zip
```

Le correctif ajoute ou remplace :

- moteur canonique `Opus\I18n` ;
- chargeur de catalogues PHP OPUS et JSON ASAP ;
- pile globale puis module ;
- sélection grammaticale masculin/féminin/neutre ;
- règles plurielles des 24 langues UE plus ukrainien ;
- interpolation stricte ;
- `TranslationRuntimeInterface` ;
- intégration native de `[[ i18n: ... ]]` dans `ScoreTemplateRenderer` ;
- branchement OWASYS par locale et module FSM actifs ;
- migration des templates communs, login, compte et registre vers la directive i18n ;
- surcharge module réelle pour les catalogues login français et anglais ;
- normalisation finale des titres, résumés, libellés de navigation et actions Registry par le runtime strict avant rendu SCORE.

## Adaptateur transitoire identifié

`RuntimeController.php` conserve encore le chargeur historique `loadMessages()` et son callable `$translate` pour préparer certains champs du ViewModel, notamment les erreurs dynamiques.

P117I ne le considère plus comme source de vérité pour :

- les textes statiques des templates ;
- les titres et résumés d’état ;
- les libellés de navigation ;
- les boutons de sélection Registry.

Ces champs sont normalisés une seconde fois par `OwasysScorePageRenderer` avec `ApplicationTranslationRuntime`, la locale active et le module de l’état FSM actif.

La suppression physique de `loadMessages()`, `viewLabels()` et des paramètres `callable $translate` du contrôleur nécessite un refactoring ciblé ultérieur du contrôleur complet. Elle ne doit pas être réalisée par remplacement partiel risqué. Les erreurs dynamiques restent temporairement préparées par l’adaptateur historique tant que leurs clés ne sont pas conservées explicitement dans le ViewModel.

## Syntaxe SCORE

```score
[[ i18n: auth.login ]]
[[ i18n: auth.welcome name=identity.label ]]
[[ i18n: registry.application_count count=sync.total ]]
[[ i18n: registry.selected count=selection.total gender=selection.gender ]]
```

Le rendu est échappé par défaut.

## Validation réalisée hors ZIP

- syntaxe PHP de tous les fichiers du correctif ;
- priorité du catalogue module sur le catalogue global ;
- règle ukrainienne `one/few/many` pour 1, 2, 5, 21, 22 et 25 ;
- combinaison féminin + pluriel ;
- substitutions `{count}` ;
- rendu SCORE de la directive i18n ;
- rendu des templates OWASYS communs, login, compte et Registry ;
- normalisation stricte des titres et résumés dans `OwasysScorePageRenderer` ;
- rejet explicite d’une clé absente ;
- absence de Markdown, smoke et `Opus/Owasys` dans l’archive.

Résultats ciblés :

```text
OPUS_P117I_I18N_ASAP_SCORE_OK
OPUS_P117I_OWASYS_TEMPLATES_OK
OWASYS_P117I_SCORE_PAGE_I18N_OK
```

## Non-régressions imposées

- ne pas modifier la FSM fonctionnelle ;
- ne pas affaiblir ACL ou SSO ;
- ne pas recréer `Opus/Owasys` ;
- préserver le Registry SQLite ;
- préserver Mermaid et sa navigation ;
- préserver l’œil du mot de passe ;
- conserver les 25 locales ;
- aucun fallback silencieux dans le nouveau moteur.

## Suite

Après application locale, tester successivement :

1. login français et anglais ;
2. changement de mot de passe ;
3. Registry ;
4. changement de langue sur les 25 locales ;
5. module possédant un catalogue local ;
6. erreur explicite sur clé ou forme manquante ;
7. rendu Mermaid ;
8. état Git avant commit ;
9. futur retrait de l’adaptateur i18n historique du contrôleur après conservation explicite des clés d’erreur dans le ViewModel.
