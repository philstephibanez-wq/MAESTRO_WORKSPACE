# P111_DISTRIBUTION_POLICY.md

## Décision active

`MO_KB` et toutes ses applications associées sont une infrastructure privée **at home**.

`MAESTRO` et les futurs `VSTi` sont des produits **distribuables**.

## Conséquence directe

Les dépendances embarquées type Python runtime, SQLite runtime, modèles ou runtimes IA ne sont obligatoires comme packaging distribuable que pour les applications distribuables, quand elles en ont réellement besoin.

## Secteurs

| Secteur | Statut | Règle |
|---|---|---|
| `MAESTRO_V5` | distribuable | packaging propre, dépendances maîtrisées, source Git propre |
| `VSTi_*` futurs | distribuables | packaging public/privé propre, licences et dépendances cadrées |
| `MO_KB_DAEMON` | at home | dépendances locales maîtrisées acceptées, pas besoin de bundle public |
| `MO_KB_FRONT` | at home | vraie source applicative front/backoffice |
| `UwAmp` | runtime local | héberge le front via lien/junction ; pas source applicative |
| `MO_KB_STORE` | données privées durables | pas un dépôt code |
| `MO_KB_VENDOR` | dépendances/cache contrôlé at home | pas un dépôt source |

## Règle corrigée UwAmp / Front

```text
H:\MO_KB_FRONT
    = source réelle du front.

H:\UwAmp\www\...
    = hôte web local / lien / junction vers le front.
    = ne doit pas être traité comme source de vérité applicative.
```

## Interdits maintenus

- Aucun fallback silencieux.
- Aucun JSON brut dans l’UI normale.
- Aucun fichier temporaire/scorie dans les vues normales.
- Aucun patch sans source de vérité.
- Aucun patch depuis ZIP partiel.
- Aucun mélange entre données privées `MO_KB_STORE` et code distribuable.
- Aucun vendoring public inutile pour MO_KB at home.
- Ne pas transformer `H:\UwAmp\www` en dépôt source du front.

## Règle de packaging

```text
MO_KB at home:
    dépendances locales documentées et contrôlées OK.

MAESTRO / VSTi distribuables:
    dépendances embarquées ou installateur propre uniquement si nécessaire.
```
