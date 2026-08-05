# OPUS P117W R45B2A1R5 — ASSETS STATIQUES ET FOOTER DES SITES GÉNÉRÉS

Date : 2026-08-05  
Statut : livrable owner actif  
Base OPUS : `0d593557bdceb700e1985cbe03523e93b83619d2`

## Cause

Le routeur PHP de développement généré dans `www/index.php` transmet toutes les requêtes au bootstrap applicatif, y compris les fichiers statiques existants sous `www/asset`. Le navigateur reçoit donc une réponse applicative à la place du CSS.

Le scaffold affiche également `site.contract` dans le footer SCORE, ce qui expose `OPUS_SITE_STANDARD_CONTRACT_CORE` dans l'interface.

## Correction générique

R45B2A1R5 modifie uniquement `Opus/Scaffold/SiteScaffoldPlan.php` :

- sous `cli-server`, servir directement les fichiers réels dont le chemin canonique reste strictement sous `www` ;
- conserver toutes les autres requêtes dans le bootstrap applicatif ;
- refuser implicitement toute sortie de `www`, traversée ou cible inexistante ;
- afficher `site.name` dans le footer SCORE au lieu de `site.contract`.

Aucun site généré n'est corrigé manuellement. Aucun fallback de contrat n'est ajouté.

## Livrable

```text
ZIP     : opus_p117w_r45b2a1r5_generated_site_static_assets_footer.zip
SHA-256 : fc9028fc703dc29f3d0c5255358e93d1c96170dc2c87aaf422579cc5a5b579ea
FILES   : 1
BASE    : 0d593557bdceb700e1985cbe03523e93b83619d2
```

## Gates owner

- lint PHP de `SiteScaffoldPlan.php` ;
- autoload Composer ;
- validation des deux OWASYS ;
- `git diff --check` ;
- suppression contractuelle de `test4`, puis nouvelle génération ;
- validation et démarrage du nouveau site ;
- réponse CSS réelle pour `/asset/css/default.css` ;
- aucun `OPUS_SITE_STANDARD_CONTRACT_CORE` dans le rendu.

## Suites séparées

Après acquisition :

1. instrumentation réelle du domaine FSM dans le Profiler du runtime généré ;
2. rétention/rotation bornée du Profiler ;
3. E1 éditeur Sources générique OPUS, E2 intégration OWASYS, E3 Git contrôlé.

NO LOCAL SITE FIX.  
NO FALLBACK SILENCIEUX.
