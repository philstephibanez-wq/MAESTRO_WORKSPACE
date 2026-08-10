# SPEC — OPUS P117W R45D2A9B LOGIN USER FEEDBACK DETERMINISTIC

Date : 2026-08-10

## Objet

Corriger l'échec d'application R45D2A9 et fournir un retour utilisateur de connexion fiable, I18n et non discriminant dans toutes les applications OPUS générées par Composer.

## Contrat

- La cause technique exacte d'un refus local-password reste dans Logger/Profiler.
- Le navigateur ne reçoit jamais `OPUS_SSO_LOCAL_PASSWORD_INVALID`, un hash, un mot de passe ou un détail permettant l'énumération des comptes.
- Après POST refusé, le runtime pose un flash session puis répond 303 vers la route login localisée.
- Le GET suivant rend via SCORE un message utilisateur I18n, puis consomme le flash.
- Le message français est : `Identifiant ou mot de passe incorrect.`
- Les futurs sites reçoivent le même contrat depuis `SiteScaffoldPlan`.
- Les sites existants `role=generated-opus-application`, `generated_by=composer`, contrat `OPUS_SITE_STANDARD_CONTRACT_CORE` sont migrés génériquement.
- Aucun patch local `essai2` n'est autorisé.

## Cause du défaut R45D2A9

Le premier applicateur ciblait une occurrence non unique de `profilerLinkProvider` dans `GeneratedSiteRuntime.php`, entraînant `OPUS_R45D2A9_RUNTIME_FLASH_CONSUME_TARGET_INVALID` avant toute écriture.

R45D2A9B utilise des blocs complets et uniques du runtime canonique R45D2A8 et reste fail-fast/idempotent.
