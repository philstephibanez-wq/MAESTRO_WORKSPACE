# R8B7D — Nouvel audit de conformité OPUS + OWASYS

Date: 2026-09-01
Baseline GitHub OPUS auditée: `1034e0b7cc0bb323219458dbf08b07cf8843c316` (`R8B7C`).

## Autorités contractuelles

Audit relancé depuis les sources GitHub réelles après relecture de `README-FIRST.md`, `PATCH_DELIVERY_CONTRACT.md` et `CHAT_NATIVE_ZIP_STEPWISE_WORKFLOW_CONTRACT.md`.

## Périmètre

- hygiène Git et séparation front/back;
- syntaxe PHP et dette legacy;
- contrat classe concrète OPUS / interface homonyme / quatre interfaces de base;
- Singleton, FSM, ACL deny-by-default, SSO;
- SCORE-only pour `owasys-front`;
- PHP-only absolu pour `owasys-back`;
- configuration OPUS;
- I18n exacte et politique stricte NO-FALLBACK;
- routes localisées exactes;
- propriété stricte application / EFSM / source;
- validité JSON.

## Constats GitHub déjà établis avant le run local

### BLOCKER — politique I18n encore fondée sur des fallbacks

`sites/owasys-front/config/site.json` contient encore `fallback_locale`, `regional_overlay_policy=explicit-empty-overlay-inherits-base-language`, `bare_language_policy=map-to-default-regional-locale`, `language_defaults` et `catalog_base_locales`.

Ces mécanismes contredisent le contrat NO-FALLBACK: une locale sélectionnée doit être résolue exactement, sans substitution vers une langue de base ni vers une locale régionale par défaut.

### BLOCKER — substitution des langues nues

`OwasysLocaleRegistry::resolveExplicit()` transforme encore une langue nue non sélectionnable en locale régionale via `languageDefaults`. Cette substitution doit disparaître.

### BLOCKER — héritage des catalogues régionaux

Une grande partie des catalogues régionaux contient encore `inherits: <langue-base>`. R8B7C a matérialisé `menu.application`, mais n'a pas encore rendu chaque catalogue régional autonome.

### BLOCKER — routes localisées par héritage de langue de base

`config/routes.localized.json` contient `regional_policy: inherit-base-language` et les chemins sont indexés par langues de base (`fr`, `en`, `de`, etc.) au lieu des 38 locales sélectionnables exactes.

### BLOCKER — CatalogLoader conserve une boucle de fallback

`Opus/I18n/CatalogLoader.php` charge encore via `Locale::fallbackChain()`. R8B6Y avait neutralisé la chaîne à un seul élément, mais l'API et le mécanisme de fallback demeurent dans l'architecture. Ils doivent être supprimés, pas neutralisés.

### ERROR — API de fallback encore présente dans Locale

`Opus/I18n/Locale.php` conserve `parent()` et `fallbackChain()`. Le contrat strict interdit de conserver une surface fonctionnelle conçue pour le fallback.

### Conforme sur le point critique EFSM Application

`ContextEfsmRegistry` ne classe plus `application` comme EFSM hôte et mappe le module Application vers `navigation`, propriété de l'application sélectionnée. Ce point doit néanmoins être contrôlé par le runner à chaque audit.

## Runner reproductible

Le runner canonique est désormais placé dans le workspace, et non dans OPUS:

`60_TOOLS/p117w_opus_owasys_compliance_audit.py`

Il agrège les constats par criticité et vérifie notamment que chaque locale sélectionnable possède son propre catalogue exact sans `inherits`, ainsi que des routes régionales exactes.

## Gate

Aucune correction R8B7D+ ne doit être fabriquée avant le run local complet sur un worktree OPUS propre et sur le HEAD GitHub attendu.
