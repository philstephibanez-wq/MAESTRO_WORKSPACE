# P116 — Contrat RefBook / OPUS vivant

Statut : **décision d'architecture validée**.

Ce document fige le contrat de travail côté OPUS_REF_BOOK.

## Principe souverain

OPUS est la source de vérité.

OPUS_REF_BOOK reflète OPUS vivant. Il ne doit jamais porter une copie autonome de la vérité des classes OPUS.

## Interdiction

Pour les classes OPUS, OPUS_REF_BOOK ne doit pas utiliser comme source de vérité :

- JSON de classes ;
- snapshot persistant ;
- cache disque de symboles ;
- index extrait affiché comme vérité ;
- données hardcodées ;
- fallback silencieux.

Un cache mémoire strictement limité à la requête PHP est autorisé uniquement comme optimisation non persistante.

## Source des classes

Les classes, interfaces, traits, enums et méthodes publiques doivent venir d'un catalogue runtime exposé par OPUS.

RefBook doit consommer ce catalogue vivant et non reconstruire sa propre vérité.

Le catalogue OPUS attendu doit :

- scanner `framework/Opus/**/*.php` ;
- résoudre les FQCN PSR-4 ;
- vérifier l'existence runtime ;
- utiliser la Reflection PHP ;
- retourner uniquement les symboles réellement présents ;
- signaler les incohérences.

## Search

La recherche RefBook doit interroger les classes réelles OPUS.

Exemple :

```text
q=smarty
```

ne doit retourner `Opus\Template\Smarty` que si cette classe existe réellement dans l'OPUS actif.

Si le fichier source ou la classe disparaît, le résultat disparaît immédiatement.

## Plus jamais `unclassified`

`unclassified` est interdit dans l'interface OPUS_REF_BOOK.

Sont également interdits :

- `unknown` ;
- `misc` ;
- `other` ;
- catégorie fallback silencieuse.

Chaque symbole OPUS doit avoir un domaine résolu depuis son namespace et/ou son chemin.

Exemples :

```text
Opus\Template\* -> Template
Opus\Database\* -> Database
Opus\RefBook\*  -> RefBook
Opus\Lstsa\*    -> LSTSA
```

Si RefBook ne sait pas résoudre le domaine, il doit signaler une erreur de contrat :

```text
OPUS_REFBOOK_DOMAIN_UNRESOLVED
```

et ne pas afficher une catégorie publique de secours.

## Responsabilité RefBook

OPUS_REF_BOOK doit :

- consommer OPUS ;
- préparer des ViewModels ;
- afficher ;
- ne pas inventer ;
- ne pas corriger en local ;
- ne pas masquer un bug OPUS ;
- ne pas exposer de données stale comme fiables.

## ScoreTemplate

ScoreTemplate est le moteur cible.

Twig, Smarty et X64 doivent disparaître du runtime final, mais seulement dans le bon ordre :

1. OPUS expose le catalogue vivant ;
2. RefBook consomme ce catalogue ;
3. RefBook migre ses vues vers ScoreTemplate ;
4. OPUS retire Twig, Smarty, X64 et adapters legacy.

## Paliers

```text
P116B2_OPUS_LIVE_CLASS_CATALOG
P116B3_OPUS_REFBOOK_DOMAIN_RESOLVER
P116C_REFBOOK_USES_LIVE_OPUS_CATALOG
P116D_SCORETEMPLATE_REFBOOK_MIGRATION
P116E_REMOVE_TWIG_SMARTY_X64_FINAL
```

## Règle finale

Un RefBook qui affiche une classe absente de l'OPUS actif ment.

Un RefBook qui affiche `unclassified` masque un bug.

Les deux situations sont interdites.
