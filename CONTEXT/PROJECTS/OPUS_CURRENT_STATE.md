# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-05.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 381de7d4a6ca145c7a572630cb84d97a0741da6c
Dernier acquis : R45B2A1R6
```

## Livrable owner actif — R45B2A1R7

```text
ZIP     : opus_p117w_r45b2a1r7_generated_web_profiler_surface.zip
SHA-256 : 21b70a957df89954814d7e19610a38014734012a6a1841dca72ba6e1f29f2359
FILES   : 2
BASE    : 381de7d4a6ca145c7a572630cb84d97a0741da6c
STATUS  : livré, validation et push owner requis
```

R45B2A1R6 est acquis. Le runtime généré reçoit le Profiler actif et mesure réellement la FSM.

R45B2A1R7 ajoute la route, l'état FSM, la politique ACL deny-by-default et le lien SCORE nécessaires pour ouvrir une trace terminée uniquement en environnement de développement. Aucun site généré n'est modifié.

## Suites gouvernées

1. R45B2A2 : rétention bornée et rotation JSONL configurable ;
2. E1/E2/E3 : éditeur Sources générique OPUS, intégration OWASYS, Git contrôlé sans push implicite ;
3. R45B3 : client REST frontend générique et validateurs croisés ;
4. R45C : wizard OWASYS structuré ;
5. R45D : administration Sécurité.

NO ACL BYPASS.
NO LOCAL SITE FIX.
NO FALLBACK SILENCIEUX.
