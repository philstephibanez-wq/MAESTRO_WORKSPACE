# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-31.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner local validé : 33f37843
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

Le commit OPUS `33f37843` est visible sur GitHub et constitue la base source exacte de R46A1.

## État acquis

- R42 : serveur de développement générique appliqué.
- R43 : assistant transactionnel appliqué.
- R44C : transaction de création et rendu opaque SCORE acquis.
- R45A1 : appliqué et validé par l'owner.
- `test2` : supprimé.
- Nouveau témoin guidé : `fullstack-test`.
- Contrat Profiler développeur R46 : publié et actif.

## Architecture définitive

- `frontend` : client SCORE vers un backend existant ;
- `backend` : API REST/services sécurisés, sans SCORE ni JavaScript ;
- `fullstack` : frontend SCORE + backend REST dans le même site, même déploiement et même serveur par défaut, avec frontière REST obligatoire ;
- jamais de `shared`.

## Sécurité définitive

`identité SSO -> attribution de rôle scopée -> permissions CRUD/métier -> ressource + action -> décision ACL backend`

- identité : `provider + subject` ;
- ressource : `resource:<application_id>:<resource_type>:<resource_id>` ;
- permission : `<resource_type>:<action>` ;
- scopes : application, type de ressource, ressource ;
- deny-by-default et tout deny explicite prioritaire ;
- héritage seulement déclaré ;
- dernier administrateur protégé ;
- aperçu, confirmation, atomicité, concurrence et audit.

## R45

R45A1 apporte :

- deny explicite prioritaire indépendamment de l'ordre ;
- trace séparant les allow/deny applicables ;
- chargement ACL via StructuredFileLoader.

R45A2, R45B, R45C et R45D restent requis. Ils sont temporairement suspendus pendant R46A afin d'obtenir un Profiler capable d'observer la suite du workflow de génération.

## État réel du Profiler

Le panneau OWASYS actuel n'est pas suffisant :

- corrélation `front → REST → back → Composer` codée en dur ;
- aucune preuve que les étapes affichées ont eu lieu ;
- traces V1 réduites à `trace.started` et `trace.stopped` dans plusieurs cas observés ;
- absence d'explication développeur pour HTTP, routage, FSM, SSO/ACL, REST, Composer et SCORE.

Le framework contient historiquement des briques de Web Profiler et des collecteurs. Il faut les consolider dans OPUS et supprimer toute présentation statique non démontrée.

## Livraison active — R46A1

ZIP construit : `opus_p117w_r46a1_profiler_causal_trace_v2.zip`.

Le modèle générique livré définit :

- trace globale corrélée ;
- spans parent/enfant ;
- événements typés ;
- statuts explicites ;
- durées et mémoire ;
- contexte filtré ;
- écriture atomique et rétention bornée ;
- compatibilité de lecture versionnée ou erreur explicite ;
- interfaces homonymes aux quatre marqueurs ;
- smoke générique couvrant causalité, statuts, masquage récursif et lecture V1.

Le ZIP est structurellement validé. PHP étant indisponible dans l'environnement de construction, le lint et le smoke owner sont obligatoires avant R46B.

R46C utilisera une barre légère intégrée et un panneau détaillé rendu par les SCORE génériques OPUS dans une iframe same-origin, sous FSM et ACL `profiler:view`.

Contrat : `CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md`.

## Invariants

- aucune correction locale de `fullstack-test` ;
- toute mutation OWASYS traverse REST sécurisé puis Composer ;
- SCORE uniquement pour toute interface ;
- backend sans JavaScript ;
- Singleton, FSM, I18n, SSO, ACL deny-by-default ;
- Logger/Profiler corrélés sans secret ;
- Profiler uniquement dev/local via `?profiler=1`, indisponible en production ;
- aucune affirmation sans événement collecté ;
- toute classe concrète OPUS implémente son interface homonyme aux quatre marqueurs ;
- l'assistant livre OPUS/OWASYS en ZIP différentiel et ne les pousse pas ;
- aucun `shared`.
