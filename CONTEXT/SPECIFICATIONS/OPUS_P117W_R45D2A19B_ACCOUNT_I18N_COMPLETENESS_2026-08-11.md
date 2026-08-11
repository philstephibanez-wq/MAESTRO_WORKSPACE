# OPUS P117W R45D2A19B — Account I18n completeness

Date : 2026-08-11

## Contexte

Après R45D2A19, le reset break-glass local-password fonctionne jusqu'à la reconnexion temporaire. Le compte marqué `must_change_password=true` est bien redirigé vers `/account/password`.

Le rendu échoue ensuite avec `OPUS_I18N_MESSAGE_MISSING`.

## Cause racine

Le SCORE `sites/owasys-front/application/account/templates/index.score` exige notamment :

- `menu.account`
- `auth.password.show`
- `auth.password.hide`

Les catalogues base de `application/account/local/*.json` ne fournissent pas ces clés. Les overlays régionaux, par exemple `fr-FR.json`, sont volontairement vides et héritent du catalogue de langue de base conformément à la politique I18n OPUS.

Le défaut est donc un contrat I18n incomplet du module account, pas un défaut du reset, du backend ou du routage.

## Correction contractuelle

R45D2A19B complète les catalogues de base bg/hr/cs/da/nl/en/et/fi/fr/de/el/hu/ga/it/lv/lt/mt/pl/pt/ro/sk/sl/es/sv/uk avec les clés manquantes nécessaires au SCORE account.

Le smoke ne vérifie pas seulement trois clés fixes : il extrait toutes les directives `[[ i18n: ... ]]` du template `account/templates/index.score` et exige leur présence non vide dans chaque catalogue base déclaré par `site.json -> i18n.catalog_base_locales`.

Aucun fallback silencieux n'est ajouté. Les overlays régionaux restent des overlays d'héritage explicites.

## Livrable

```text
ZIP     : opus_p117w_r45d2a19b_account_i18n_completeness.zip
SHA-256 : 972ad4c38ebc22dfd5fa51c745c18db1d9452006377cb6f87ecb92046a221e67
FILES   : 2
```

## Gate owner

1. appliquer l'applicateur ;
2. exécuter le smoke ;
3. redémarrer owasys-front ;
4. se reconnecter avec le mot de passe temporaire issu du break-glass ;
5. `/account/password` doit rendre en SCORE sans `OPUS_I18N_MESSAGE_MISSING` ;
6. saisir temporaire + nouveau mot de passe + confirmation ;
7. changement réussi -> `/applications` ;
8. reprendre ensuite le gate Security Commit, puis developer/viewer.

NO SILENT I18N FALLBACK.
NO BROWSER PASSWORD RESET BYPASS.
NO PASSWORD IN ARGV/LOG/PROFILER.
