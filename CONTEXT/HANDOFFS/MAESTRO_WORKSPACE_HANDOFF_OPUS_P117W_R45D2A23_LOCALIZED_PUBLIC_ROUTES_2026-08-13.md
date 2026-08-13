# HANDOFF — OPUS P117W R45D2A23

Date : 2026-08-13
Base OPUS : `2e17008ad0cf23e70195ee2c0f6c947ecb5333be`.

R45D2A22D est publié et le gate navigateur viewer est fermé.

## Gate actif

R45D2A23 — routes publiques localisées avec accents.

Le besoin est traité par l'évolution générique OPUS `LocalizedRouteResolver` puis intégration dans owasys-front. Les routes internes restent stables. Les 25 langues de base sont couvertes et les variantes régionales héritent de leur langue de base.

Exemples français : `/fr-FR/sécurité`, `/fr-FR/compte/mot-de-passe`, `/fr-FR/sources-de-données`, `/fr-FR/sources-et-git/...`, `/fr-FR/construction-et-validation`.

Les accents sont conservés. Le préfixe Sources/Git est localisé mais le chemin réel du fichier reste opaque, y compris pour la normalisation Unicode. Les routes REST backend restent non localisées. Aucun routeur JavaScript.

## Livrable

`opus_p117w_r45d2a23_localized_public_routes.zip`

SHA-256 : `f0a69450a9673e9f222a9d53512c0a53adcae5d08286bc625bff320d75826dea`

Après validation owner, reprendre le backend atomique Modifier/Supprimer utilisateur ou agent.
