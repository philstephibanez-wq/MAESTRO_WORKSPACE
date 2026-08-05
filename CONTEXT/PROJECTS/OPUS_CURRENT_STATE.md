# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-05.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 0d593557bdceb700e1985cbe03523e93b83619d2
Dernier acquis : R45B2A1R4
```

## Livrable owner actif — R45B2A1R5

```text
ZIP     : opus_p117w_r45b2a1r5_generated_site_static_assets_footer.zip
SHA-256 : fc9028fc703dc29f3d0c5255358e93d1c96170dc2c87aaf422579cc5a5b579ea
FILES   : 1
BASE    : 0d593557bdceb700e1985cbe03523e93b83619d2
STATUS  : livré, validation et push owner requis
```

R45B2A1R4 est acquis. La création de `test4` franchit le chargement FSM et atteint le rendu SCORE.

R45B2A1R5 corrige uniquement `SiteScaffoldPlan` : le routeur PHP de développement rend la main aux fichiers statiques réels confinés sous `www`, et le footer affiche le nom public du site au lieu du contrat interne. Aucun site généré n'est modifié.

## Suites gouvernées

1. instrumentation réelle des événements FSM du runtime généré afin que le panneau Profiler ne reste pas à zéro ;
2. R45B2A2 : rétention bornée et rotation JSONL configurable ;
3. E1/E2/E3 : éditeur Sources générique OPUS, intégration OWASYS, Git contrôlé sans push implicite ;
4. R45B3 : client REST frontend générique et validateurs croisés ;
5. R45C : wizard OWASYS structuré ;
6. R45D : administration Sécurité.

NO ACL BYPASS.
NO LOCAL SITE FIX.
NO FALLBACK SILENCIEUX.
