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

## Run local propriétaire validé

Le propriétaire a exécuté le runner canonique sur `H:\OPUS` propre.

Résultat:

- `HEAD=1034e0b7cc0bb323219458dbf08b07cf8843c316`
- `WORKTREE=CLEAN`
- `PHP_FILES=644`
- `FRAMEWORK_CONCRETE_CLASSES=249`
- `SELECTABLE_LOCALES=38`
- `BLOCKER=101`
- `ERROR=2`
- `WARN=0`
- `INFO=0`

Le premier lancement était invalide à cause d'une concaténation accidentelle de commandes dans l'argument du chemin. Le second lancement est valide et constitue l'évidence d'audit.

## Findings confirmés

### BLOCKER — coeur OPUS encore orienté fallback

`Opus/I18n/CatalogLoader.php` parcourt encore `Locale::fallbackChain()`. Même si R8B6Y a temporairement réduit cette chaîne à la locale active seule, le mécanisme de fallback subsiste dans le coeur.

### ERROR — surface de fallback encore publique

`Opus/I18n/Locale.php` et `LocaleInterface.php` conservent `parent()` et `fallbackChain()`. Cette API n'est plus admissible sous le contrat NO-FALLBACK.

### BLOCKER — politique OWASYS front encore fondée sur substitution/héritage

`sites/owasys-front/config/site.json` conserve les clés interdites `fallback_locale`, `regional_overlay_policy`, `bare_language_policy`, `language_defaults`, `catalog_base_locales` et `catalog_base_locales_visible`.

`OwasysLocaleRegistry` conserve également le mécanisme `languageDefaults` qui transforme une langue nue en locale régionale.

### BLOCKER — catalogues régionaux non autonomes

37 catalogues régionaux contiennent encore `inherits=<langue-base>`. Le contrat exige un catalogue régional autonome pour chaque locale sélectionnable.

### BLOCKER — routes régionalisées encore héritées

`config/routes.localized.json` déclare encore `regional_policy=inherit-base-language`, et chaque route manque les 38 clés régionales exactes attendues.

## Qualification du finding `I18N_EXACT_MESSAGES_INCOMPLETE`

Le finding est utile pour détecter les catalogues régionaux réduits à des overlays, mais son algorithme V2 utilise l'union globale de toutes les clés rencontrées. Cette union inclut aussi des clés dynamiques ou spécifiques à une application/EFSM, par exemple `fsm.application.state.essai.label`.

Conséquence: il ne faut pas remplir aveuglément les 38 catalogues avec toutes les clés de cette union. La correction doit d'abord matérialiser les messages statiques hérités réellement applicables à chaque locale, puis traiter les clés dynamiques par leur mécanisme d'affichage `⚠ <id>` lorsqu'elles sont absentes.

Le runner devra être raffiné après la suppression du fallback structurel afin de distinguer:

- catalogue statique OWASYS attendu pour chaque locale;
- clés EFSM/application dynamiques, non obligatoires globalement.

## Point conforme confirmé

`ContextEfsmRegistry` ne classe plus `application` comme EFSM hôte et mappe le module Application vers `navigation` de l'application sélectionnée.

## Ordre de correction retenu

1. **R8B7E** — supprimer la surface fallback du coeur OPUS (`Locale`, `LocaleInterface`, `CatalogLoader`) sans modifier encore les catalogues ni les routes.
2. **R8B7F** — supprimer la substitution locale/configuration OWASYS front.
3. **R8B7G** — matérialiser les catalogues régionaux autonomes et raffiner le runner sur les clés statiques/dynamiques.
4. **R8B7H** — matérialiser les routes exactes pour les 38 locales et supprimer l'héritage régional.
5. relancer l'audit complet et traiter tout finding résiduel.

## Gate

Chaque lot est livré et validé séparément. Aucun lot suivant n'est appliqué avant retour de l'évidence complète du lot précédent.
