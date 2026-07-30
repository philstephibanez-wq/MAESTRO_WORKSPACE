# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-31.

## Dépôt

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD owner de base relu : 63470fb43c4b692eea2d7db2c0be5f6086008d1a
Racine owner : H:/OPUS
```

## État acquis

- R42 : serveur de développement générique appliqué.
- R43 : assistant transactionnel appliqué et poussé.
- R44A : diagnostics de validation livrés.
- R44B : choix obligatoire frontend/backend/fullstack restauré.
- La création fullstack anonyme de `owasys-test` réussit : REST `201`, Composer et Registry validés.
- La lecture REST de `layout.score` et `footer.score` réussit en `200`.

## Défaut actif — R44C

Le navigateur de sources rend d'abord la page puis réinjecte son HTML dans le layout SCORE. Les délimiteurs du source affiché sont alors interprétés une seconde fois.

Le ZIP cumulatif R44C rend le fragment opaque pendant le rendu du layout et enrichit Logger/Profiler avec le code OPUS/OWASYS/SCORE sûr extrait de la chaîne d'exceptions.

## Action active

L'owner applique et valide R44C, rouvre les deux scripts SCORE, puis reprend la recette R44. Aucune correction manuelle de `owasys-test`.

## Invariants

- toute mutation OWASYS traverse REST sécurisé puis Composer ;
- SCORE uniquement, sans mélange HTML/PHP ;
- contenu source opaque et échappé ;
- JavaScript uniquement progressif ;
- Logger/Profiler corrélés sans secret ;
- l'assistant ne committe ni ne pousse OPUS/OWASYS.
