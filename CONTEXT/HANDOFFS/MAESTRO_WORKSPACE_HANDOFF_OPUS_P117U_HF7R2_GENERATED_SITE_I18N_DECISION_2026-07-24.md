# MAESTRO_WORKSPACE HANDOFF — OPUS P117U HF7R2 I18N DES SITES GÉNÉRÉS

Date : 2026-07-24  
Statut : décision owner requise ; aucune correction locale OWASYS autorisée

## État validé

Les trois captures reçues et le journal backend valident le checkpoint HF7R1 :

- surface Applications active ;
- entrée Creation visible ;
- intégrité Registry verte ;
- Singleton vert ;
- OWASYS découvert comme application OPUS standard `fullstack` ;
- cinq `registry.sync` réussis par REST sécurisé puis Composer ;
- Logger backend et corrélation `trace_id` actifs.

## Écart générique identifié

Le scaffold OPUS actuel génère seulement :

```text
default_locale : fr
locales        : fr, en, es
```

et uniquement les catalogues `fr`, `en` et `es`.

Le module OWASYS Creation dispose de 25 catalogues, mais les applications générées n’en héritent pas.

## Frontière contractuelle

Ce besoin concerne toutes les applications générées. Il relève donc du framework OPUS, pas du métier OWASYS.

Aucune duplication locale des 25 langues n’est autorisée dans OWASYS ou dans les applications après génération.

## Décision attendue

```text
OUI : faire évoluer OPUS pour générer les 24 langues officielles de l’UE + l’ukrainien, avec Accept-Language et fallback diagnostiqué.
NON : conserver fr/en/es sans solution locale OWASYS.
```

En cas de réponse `OUI`, le prochain livrable sera un ZIP différentiel OPUS HF8 fondé sur les fichiers réels du scaffold local post-HF7R1.

## État des livrables

Aucun nouveau ZIP n’est produit avant cette décision. Le différentiel courant reste HF7R1.

Aucun nettoyage n’est requis. `sites/owasys_old`, les logs, le profiler et le Registry restent préservés.
