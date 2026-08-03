# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-03.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : bf190ab7afecc09493d2d5c98513420613f45fbc
Commit : opus_p117w_r46b9_score_render_profiler_collector
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis R46

- Trace causale V2, HTTP, REST, ACL, BDD, FSM et corrélation distribuée acquis.
- Profiler SCORE dans une iframe same-origin avec 18 onglets acquis.
- Collecte détaillée et assainie des requêtes/résultats BDD et REST acquise.
- Onglet actif, détails hiérarchiques repliables, JSON brut secondaire et terme
  visible **Étape** acquis avec R46B8.
- Instrumentation réelle template/layout/fragments SCORE acquise avec R46B9.
- R46C2 reste rejeté et n'a jamais été intégré.
- Témoin guidé : `fullstack-test`, jamais corrigé directement.

## Défaut actif

Le panneau FSM reçoit les données réelles de transition, mais son résumé
générique expose d'abord `fsm_contract`. Il ne raconte donc pas directement la
transition et n'identifie pas la table FSM par son nom fonctionnel.

## Cible active — R46B10

R46B10 :

- transporte le vrai `name` de chaque configuration sous `fsm_name`;
- affiche systématiquement le nom de table;
- résume `état courant → signal → état suivant`;
- complète les événements de garde avec source, signal et cible;
- masque `fsm_contract` dans toute l'interface sans le retirer du runtime;
- ne modifie aucune transition, garde, action ou donnée métier.

## Suite R46

1. appliquer et linter R46B10 sur le HEAD owner;
2. exécuter les smokes FSM, Profiler et OPUS;
3. prouver le nom de table et la transition complète dans l'onglet FSM;
4. vérifier l'absence visible de `fsm_contract`;
5. pousser uniquement après validation owner;
6. poursuivre les collecteurs réellement incomplets selon le contrat.

## Invariants

- aucune correction locale de `fullstack-test`;
- SCORE uniquement; Singleton, FSM, I18n, SSO et ACL deny-by-default;
- backend sans JavaScript; aucun `shared`;
- frontend sans accès direct à la BDD;
- Logger/Profiler corrélés sans secret;
- Profiler uniquement dev/local;
- aucune affirmation sans événement collecté;
- assistant : ZIP différentiel seulement pour OPUS/OWASYS;
- owner : validation et push.

NO ACL BYPASS.  
NO EVENT, NO CLAIM.  
NO FALLBACK SILENCIEUX.
