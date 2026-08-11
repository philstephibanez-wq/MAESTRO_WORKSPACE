# HANDOFF — OPUS P117W R45D2A19B Account I18n completeness

Date : 2026-08-11

## État acquis avant incident

- R45D2A18D publié et fonctionnel ;
- Security Preview admin fonctionne ;
- R45D2A19 break-glass local-password appliqué ;
- login avec mot de passe temporaire fonctionne ;
- `must_change_password=true` déclenche correctement la route `/account/password`.

## Incident observé

`/fr-FR/account/password` affiche :

```text
OPUS_I18N_MESSAGE_MISSING
```

Le log front confirme l'exception `Opus\I18n\TranslationException` sur cette route.

## Cause

Le template SCORE account exige des clés absentes des catalogues base, notamment `menu.account`, `auth.password.show`, `auth.password.hide`.

`fr-FR.json` est volontairement un overlay vide ; la correction appartient au catalogue base `fr.json` et aux autres langues base.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a19b_account_i18n_completeness.zip
SHA-256 : 972ad4c38ebc22dfd5fa51c745c18db1d9452006377cb6f87ecb92046a221e67
FILES   : 2
```

Le smoke extrait toutes les clés I18n du SCORE account et exige leur couverture dans chaque langue base déclarée.

## Gate suivant

1. applicateur R45D2A19B ;
2. smoke obligatoire ;
3. redémarrer front ;
4. reconnexion temporaire ;
5. `/account/password` doit rendre correctement ;
6. changer le mot de passe ;
7. retour `/applications` ;
8. reprendre Security Commit admin ;
9. developer : même workflow ;
10. viewer : lecture seule, aucun Profiler.

NO SILENT FALLBACK.
NO PASSWORD BYPASS.
NO PUSH OPUS/OWASYS BY ASSISTANT.
