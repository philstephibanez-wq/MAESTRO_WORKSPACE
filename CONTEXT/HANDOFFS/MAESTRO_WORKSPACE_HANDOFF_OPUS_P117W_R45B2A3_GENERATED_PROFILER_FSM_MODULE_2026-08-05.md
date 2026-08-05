# HANDOFF — OPUS P117W R45B2A3

Date : 2026-08-05

## Base owner publiée

`17bfadf500148d0bf2de9f00a1806bd756053426` — R45B2A2 acquis.

## Incident

Le site nouvellement généré `test6` répond HTTP 500 avec `OPUS_GENERATED_RUNTIME_FAILED`.

Cause prouvée : l'état FSM `profiler` référence le module `profiler`, tandis que le scaffold ne crée pas `application/profiler`. `FsmSiteLoader` refuse cette incohérence avant tout rendu.

## Livrable owner actif

```text
ZIP     : opus_p117w_r45b2a3_generated_profiler_fsm_module.zip
SHA-256 : 66d270c9dc95fa89e11a2fa0c3f35a5b564e95ea6c2866c6764488169ff81c0d
FILES   : 1
BASE    : 17bfadf500148d0bf2de9f00a1806bd756053426
STATUS  : livré, validation fonctionnelle et push owner requis
```

Le correctif porte exclusivement sur le scaffold générique. `test6` doit être supprimé puis régénéré après application.

## Protocole owner corrigé

Le protocole initialement communiqué omettait les options contractuelles de mutation. La suppression sécurisée R23 exige simultanément `--confirm=<id>` et `--write`. La création exige également `--write`; sans cette option, elle reste en mode aperçu.

```cmd
cd /d H:\OPUS
composer opus:delete-site -- test6 --confirm=test6 --write
composer opus:create-site -- test6 --write
composer opus:validate-site -- test6
composer opus:dev-server -- test6 --port=8800
```

Le serveur de développement éventuellement actif sur le port 8800 doit être arrêté avant la suppression. Aucun nouveau correctif OPUS ne doit être produit avant le résultat de cette régénération complète : les erreurs `OPUS_DELETE_SITE_CONFIRMATION_INVALID`, `OPUS_SCAFFOLD_TARGET_ALREADY_EXISTS` et `OPUS_SITE_MODULE_DIRECTORY_MISSING` observées le 2026-08-05 proviennent toutes du fait que l'ancien `test6` n'avait pas été supprimé.

## Suite

Après acquisition fonctionnelle de R45B2A3 : reprendre E1/E2/E3, éditeur Sources et Git contrôlé.

NO LOCAL SITE FIX.
NO FALLBACK SILENCIEUX.
