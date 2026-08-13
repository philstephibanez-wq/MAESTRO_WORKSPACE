# HANDOFF — OPUS P117W R45D2A23

Date : 2026-08-13
Base OPUS : `2e17008ad0cf23e70195ee2c0f6c947ecb5333be`.

## État acquis

R45D2A22D est publié. Le gate navigateur du rôle viewer est fermé : lecture Sécurité, Sources/Git et Build conforme ; Profiler masqué/refusé ; Compte en auto-service conforme.

## Gate actif

R45D2A23 — routes publiques localisées avec accents.

Le besoin est traité par une évolution générique OPUS `LocalizedRouteResolver` puis intégration dans owasys-front. Les routes internes restent stables ; les chemins publics sont localisés. Les 25 langues de base sont couvertes et les variantes régionales héritent de leur langue de base.

Exemples français attendus : `/fr-FR/sécurité`, `/fr-FR/compte/mot-de-passe`, `/fr-FR/sources-de-données`, `/fr-FR/sources-et-git/...`, `/fr-FR/construction-et-validation`.

Les accents ne sont jamais supprimés. Les chemins de fichiers restent opaques. Les routes REST backend ne sont jamais localisées. Aucun routeur JavaScript.

## Livrable

`opus_p117w_r45d2a23_localized_public_routes.zip`

SHA-256 : `f1b6cd0ef27512e425dcfda61254f253559b4b606d0b69ed1a7951687eda3e99`

Contenu : résolveur OPUS + interface, catalogue de routes localisées, applicateur différentiel temporaire.

Après validation owner, reprendre le backend atomique Modifier/Supprimer utilisateur ou agent.
