# R8B7G — Handoff EFSM I18n complète front + back

Date: 2026-09-01

## Baseline

GitHub OPUS relu: `6f4ed3c5e1dbd8cda3c9da2c7a459b367963227e` (`R8B7F`).

## État validé avant tranche

- runtime OWASYS front déclaré OK après R8B7F;
- worktree déclaré propre par l'owner;
- R8B7F est poussé sur GitHub;
- les géométries EFSM restent propriété de l'owner et sont hors périmètre;
- l'audit NO-FALLBACK global reste ouvert pour les métadonnées/politiques I18n historiques hors résolution EFSM.

## Livrable R8B7G

R8B7G matérialise les labels visibles de tous les states/transitions des micro-EFSM OWASYS inventoriées.

Couverture:
- owasys-front: 8 EFSM, 146 clés exactes par locale;
- owasys-back: EFSM navigation/exécution + security, 26 clés exactes par locale;
- 38 locales régionales, y compris `en-EN`;
- 76 fichiers JSON au total;
- aucun fichier `*.fsm.json` ni `*.fsm.layout.json` modifié.

Les IDs techniques ne sont jamais traduits. Les valeurs visibles sont traduites.
La projection utilise les catalogues régionaux exacts; aucun fallback de locale n'est requis pour ces clés.

## Validation attendue

1. extraction ZIP sur HEAD R8B7F propre;
2. validation JSON des 76 catalogues;
3. `git diff --check`;
4. contrôle que seuls `sites/owasys-front/application/default/local/*.json` et `sites/owasys-back/application/default/local/*.json` changent;
5. runtime: Navigation et Security front, puis au moins une projection EFSM back;
6. absence de `⚠ <id>` sur les states/transitions couverts;
7. absence de 500;
8. commit/push owner uniquement après validation.

## Suite

Après acceptation R8B7G, reprendre l'audit général NO-FALLBACK pour supprimer les métadonnées/politiques historiques (`inherits`, `fallback_locale`, `language_defaults`, routes héritées) sans régression UI.
