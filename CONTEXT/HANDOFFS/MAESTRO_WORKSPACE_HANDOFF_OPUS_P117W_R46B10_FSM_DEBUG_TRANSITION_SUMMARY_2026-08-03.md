# OPUS P117W R46B10 — Résumé de débogage des transitions FSM

Date : 2026-08-03  
Statut : ZIP différentiel livré, validation owner requise

## Base

- OPUS : `bf190ab7afecc09493d2d5c98513420613f45fbc`
- Commit owner : `opus_p117w_r46b9_score_render_profiler_collector`
- R46B9 est poussé et acquis.

## Cause

Les événements FSM contiennent déjà les états source/cible et le signal, mais le
résumé générique affiche les trois premiers champs du contexte. Le champ
technique `fsm_contract` masque ainsi l'information utile au débogage.

## Contenu R46B10

- transporte le vrai champ `name` de la configuration sous `fsm_name`;
- affiche systématiquement le nom de la table FSM;
- résume chaque transition sous la forme
  `table · état courant → signal → état suivant`;
- ajoute source, signal et cible aux événements de garde;
- affiche explicitement transition refusée ou état suivant en attente;
- retire `fsm_contract` du résumé, des détails structurés et du JSON brut;
- conserve `fsm_contract` uniquement dans la trace interne pour les garanties
  de compatibilité runtime;
- aucun changement de transition, garde, action ou état.

## ZIP

```text
opus_p117w_r46b10_fsm_debug_transition_summary.zip
SHA-256: f794deae47b3e8c4c8eafac9146d1d292ccf4a768549a1dd2aeb74f387b58537
```

Fichiers complets :

```text
Opus/Fsm/FsmProcessor.php
Opus/Profiler/WebProfilerView.php
```

## Validation owner

1. Appliquer le ZIP sur le HEAD OPUS indiqué.
2. Linter les deux fichiers PHP.
3. Exécuter les smokes FSM, Profiler et OPUS.
4. Ouvrir `/applications?profiler=1` puis l'onglet FSM.
5. Vérifier le nom réel de la table sur chaque ligne.
6. Vérifier `current state → signal → next state`.
7. Vérifier l'absence visible de `fsm_contract`, y compris dans JSON brut.
8. Vérifier les gardes et les transitions refusées.
9. Ne commit/push OPUS qu'après validation owner.
