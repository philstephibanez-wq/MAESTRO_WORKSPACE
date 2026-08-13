# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-13.

## Dépôt canonique

OPUS master : `230dd10deb0f2abbc76388c6516f694a3b72ee12` — `opus_p117w_r45d2a25a_identity_lifecycle_ui_installer_fix`.

## États acquis récents

R45D2A21C cockpit validé. R45D2A22 matrice de capacités validée. Gate navigateur viewer complet validé. R45D2A22B Profiler piloté par ACL. R45D2A22C1 page 403 graphique validée. R45D2A22D alias Compte publié. R45D2A23 routes publiques frontend localisées avec accents validées owner et publiées. R45D2A24 backend atomique du lifecycle Utilisateur/Agent publié. R45D2A25A exposition SCORE du lifecycle Utilisateur/Agent publiée.

## R45D2A24 acquis

Le backend Security supporte `identity.reference`, `identity.update` et `identity.delete`. Provider+subject reste immuable ; `identity_type=user|agent` est explicite. La suppression local-password est atomique entre référence applicative et entrée runtime lorsqu'elles existent. Preview expose les pertes d'accès. La dernière identité administrative est protégée par la sémantique ACL sans hardcode du nom de rôle. Le snapshot conserve la classification onboarding lors de la fusion runtime.

## R45D2A25A acquis fonctionnellement

Le front Security expose, seulement lorsque `$canMutate` et les capacités backend l'autorisent :

- classification d'une identité legacy `unknown` ;
- Utilisateur -> Agent ;
- Agent -> Utilisateur ;
- suppression via Preview/Commit ;
- affichage des accès perdus ;
- message explicite en cas de tentative de suppression de la dernière identité administrative.

Le viewer reste sans contrôle lifecycle.

## Observation qualité source

Le diff publié de R45D2A25A contient une dégradation d'indentation dans le bloc de capacités de `SecurityController.php`. Le code est syntaxiquement valide, mais ce défaut de forme doit être corrigé avant de poursuivre le chantier fonctionnel.

## Gate actif

R45D2A25B — canonisation du bloc de capacités de `SecurityController.php`, sans changement de comportement.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a25b_securitycontroller_source_canonicalization.zip
SHA-256 : f61c7cea1bb7ff37e866b1805c4b0e24aa264007dffdf42ebd8fe031fe4bb96c
BASE    : 230dd10deb0f2abbc76388c6516f694a3b72ee12
FILES   : 2
```

Gates attendus :

- `OPUS_R45D2A25B_APPLIED`
- `OPUS_R45D2A25B_SECURITYCONTROLLER_SOURCE_CANONICAL_OK`
