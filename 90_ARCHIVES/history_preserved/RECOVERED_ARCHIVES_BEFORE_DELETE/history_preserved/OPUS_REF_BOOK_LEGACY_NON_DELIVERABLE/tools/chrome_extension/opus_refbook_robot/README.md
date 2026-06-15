# Opus RefBook Robot Chrome Extension

Extension Chrome locale de développement pour OPUS_REF_BOOK.

## Installation

1. Ouvrir `chrome://extensions`.
2. Activer le mode développeur.
3. Cliquer sur `Charger l'extension non empaquetée`.
4. Sélectionner ce dossier :

```text
H:\OPUS_REF_BOOK	ools\chrome_extensionsap_refbook_robot
```

## Contrat

- Manifest V3.
- Extension locale uniquement.
- Aucune permission globale.
- Aucune host permission large.
- Content script limité à :

```text
http://127.0.0.1/OPUS_REF_BOOK/*
http://localhost/OPUS_REF_BOOK/*
```

## Effet attendu

Sur une page RefBook locale, un badge apparaît en bas à droite :

```text
Opus RefBook Robot — OK
```

Le badge passe en `FAILED` si un élément visuel contractuel manque : header, recherche, thème, langue, sidebar ou contenu.
