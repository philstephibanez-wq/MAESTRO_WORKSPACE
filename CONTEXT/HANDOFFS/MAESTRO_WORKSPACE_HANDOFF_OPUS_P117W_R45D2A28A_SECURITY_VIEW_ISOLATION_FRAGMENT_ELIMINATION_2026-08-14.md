# HANDOFF — OPUS P117W R45D2A28A

Date: 2026-08-14

## Base publiée OPUS

`3d4b0cb06e8a825326809ce9173b6fefb36827e9` — R45D2A27 Assignment Revoke UI.

## État local

R45D2A28 a été appliqué pour localiser les sous-vues Security dans le chemin public, mais le gate navigateur a révélé une non-conformité : le fragment historique `#ow-security-unclassified` peut apparaître sur `/sécurité/attributions` et les cinq `view_*` sont encore rendues simultanément.

R45D2A28 ne doit pas être publié seul.

## Gate actif

R45D2A28A — Security View Isolation / Fragment Elimination.

Objectifs:
- une route Security = une seule vue rendue;
- KPI `À classifier` -> route Identités, sans fragment;
- suppression de l’identifiant/CSS `ow-security-unclassified` devenu inutile;
- aucune génération de `?view=...`;
- compatibilité d’entrée legacy conservée;
- catalogue localisé NFC 25 langues conservé;
- zéro JavaScript.

## Important

`%C3%A9` est la sérialisation URI UTF-8 de `é` produite par `UrlBuilder::rawurlencode`; ce n’est pas une fuite de vocabulaire anglais. Le contrat de route français reste `sécurité/attributions`.

ZIP: `opus_p117w_r45d2a28a_security_view_isolation_fragment_elimination.zip`
SHA-256: `9572bdba3e2f7fbfdbe8667288a8f1b80af07828a2ded508e83b360240fa4e16`

NO PUSH OPUS/OWASYS BY ASSISTANT.
