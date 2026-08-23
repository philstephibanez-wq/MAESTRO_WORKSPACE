# P117W — Architecture cible : squelette d'application OPUS en réseau de micro-EFSM

State: ARCHITECTURE DECISION — ACTIVE

## But

Une application générée par OWASYS n'est plus conçue comme une unique FSM monolithique. Elle est un squelette OPUS immédiatement exécutable et navigable, composé de micro-EFSM spécialisées qui coopèrent par signaux.

Le squelette est un mock fonctionnel non jetable : l'architecture, les transitions, la navigation, la sécurité, l'ACL, l'I18n, SCORE/REST, Logger et Profiler sont réels dès la génération. Le développeur complète ensuite le comportement métier principalement en ajoutant les STATE/transitions/pages nécessaires et en programmant les ACTION PHP métier, avec des GUARD métier seulement lorsqu'une condition métier réelle le justifie.

## Principes invariants

- Une micro-EFSM représente un domaine fonctionnel qui possède réellement un état courant, des SIGNALS, des transitions, des GUARD/ACTION et éventuellement de la mémoire/pile.
- Un item de menu est une bonne heuristique de découpage, mais le menu n'est jamais l'autorité architecturale.
- Une EFSM peut ne posséder aucun item de menu si elle travaille en arrière-plan.
- Le STATE courant d'une EFSM reste privé à cette EFSM.
- Une EFSM ne change jamais directement le STATE d'une autre EFSM.
- La coopération inter-EFSM passe par des SIGNALS transportés par un réseau/bus EFSM.
- SIGNAL, GUARD, ACTION et PUSH/POP/POKE/PEEK restent des concepts distincts.
- PUSH/POP/POKE/PEEK sont des primitives natives du runtime EFSM, pas des ACTION métier.
- Les ACTION sont du vrai code PHP développeur enregistré et exécuté par l'application ; pas de pseudo-code JSON et pas de `eval`.
- Les GUARD sont des prédicats développeur ou des prédicats de framework explicites ; une GUARD doit rester pure vis-à-vis du runtime EFSM.
- Les routes restent des conséquences de SIGNALS/navigation ; elles ne définissent pas la sémantique des STATE.
- ACL, I18n, SCORE, Logger, Profiler, repositories/BDD, cache, serializers et loaders restent des services, pas des EFSM par défaut.

## Composition cible

### Frontend

Socle minimal :

- Application EFSM ;
- Security EFSM ;
- Navigation EFSM ;
- Resource EFSM(s) si des ressources applicatives existent ;
- Business Workflow EFSM(s) selon le métier.

### Backend

Socle minimal :

- Application EFSM ;
- Security EFSM ;
- REST/API EFSM ;
- Resource EFSM(s) ;
- Business Workflow EFSM(s) selon le métier.

Selon besoin : Transaction, Async/Job, Notification, Recovery/Supervision.

### Fullstack

Un fullstack reste composé de deux applications OPUS autonomes : front et back, chacune avec son Singleton, son runtime et ses micro-EFSM propres.

Le front et le back coopèrent par le contrat obligatoire :

`front -> REST sécurisé -> back -> Composer/service métier -> back -> response -> front`

Le front ne partage jamais son état interne EFSM avec le back par accès filesystem implicite.

## Réseau EFSM

Le socle générique cible comporte :

- `FsmSignalBusInterface` ;
- un dispatcher/réseau EFSM ;
- une file bornée ;
- adressage unicast/multicast/broadcast explicite ;
- `message_id` ;
- `source_fsm` ;
- `target_fsm` ;
- `signal` ;
- `correlation_id` ;
- `causation_id` ;
- contexte borné ;
- TTL/hop count ;
- instrumentation Logger/Profiler.

Deux catégories sémantiques sont distinguées :

- COMMAND : demande adressée à une EFSM ;
- EVENT : fait déjà établi, éventuellement diffusé à plusieurs EFSM.

Chaque EFSM destinataire décide elle-même si le SIGNAL reçu est applicable à son STATE courant et avec quelles GUARD/transitions.

## Mémoire et piles par injection de dépendances

La mémoire et les piles doivent pouvoir être injectées via interfaces génériques.

- mémoire locale par défaut ;
- contexte/mémoire partagée explicite possible ;
- piles nommées et locales par défaut ;
- pile partagée uniquement sur contrat explicite ;
- état courant EFSM jamais partagé comme variable globale.

Exemple de contexte partagé : identité, rôles, permissions effectives, application courante, correlation/trace.

Une EFSM Security peut être l'autorité d'écriture de `SecurityContext`, tandis que les autres EFSM reçoivent une vue read-only injectée.

## Designer contextuel

Le diagramme EFSM est édité suivant l'application et le domaine courant.

Exemples :

- section Sécurité -> Security EFSM ;
- section Navigation -> Navigation EFSM ;
- section Ressources -> Resource EFSM ;
- section Sources + Git -> SourceGit EFSM ;
- section Build -> Build EFSM.

Le contexte de conception doit afficher explicitement au minimum :

- `application_id` ;
- `efsm_id` ;
- source canonique ;
- SHA-256 de la source ;
- mode diagnostic/conception.

Le navigateur ne choisit jamais arbitrairement le fichier source canonique : il est résolu côté serveur.

Il n'existe pas de menu utilisateur top-level « FSM ». Le designer est un outil de développement contextuel.

Le même graphe canonique est utilisé en diagnostic et en conception ; le mode conception ajoute l'édition au même graphe.

## Vue réseau

En complément des diagrammes individuels, une vue réseau peut présenter chaque micro-EFSM comme un nœud et uniquement les SIGNALS inter-EFSM comme des liens.

Cette vue ne remplace pas les diagrammes internes. Elle permet d'inspecter la coopération et de naviguer vers le diagramme éditable d'une EFSM donnée.

## Édition intégrée des ACTION PHP

Une transition expose séparément :

- SIGNAL ;
- GUARD ;
- ACTION ;
- opérations runtime PUSH/POP/POKE/PEEK.

Pour une ACTION :

- Créer = créer un handler PHP réel ;
- Modifier = charger et éditer le callable PHP réel ;
- Affecter = associer à la transition une ACTION déjà enregistrée.

Le flux d'écriture respecte systématiquement : ACL, CSRF, validation PHP, optimistic locking/hash, autorité source serveur, écriture atomique, Logger et Profiler.

## Squelette/mock généré

Une application générée doit être immédiatement navigable avant implémentation du métier.

Le mock n'est pas une maquette jetable : c'est l'application finale avec ses vraies EFSM, vraies pages SCORE minimales, vraie sécurité, vraie ACL, vraie I18n, vrai REST si nécessaire et vraie observabilité, mais avec les ACTION métier encore absentes/stub.

Le développement normal devient :

1. utiliser le squelette navigable généré ;
2. ajouter/organiser les STATE nécessaires ;
3. relier les STATE par SIGNAL/transitions ;
4. définir les pages SCORE nécessaires ;
5. programmer les ACTION PHP métier ;
6. ajouter uniquement les GUARD métier nécessaires ;
7. relier ressources/persistence/services métier ;
8. valider via Logger/Profiler et tests.

## Ressources et ACL

Le terme architectural est RESSOURCE, pas « source ».

L'ACL décide sur : identité/roles + ressource + opération.

Le modèle cible reste : rôle = droits CRUD sur ressource, avec deny-by-default.

Exemples d'opérations : CREATE, READ, UPDATE, DELETE, plus opérations métier explicites lorsque CRUD ne suffit pas.

Security porte le domaine identification/authentification/autorisation, mais la décision ACL elle-même reste un service pur consultable par les GUARD et autres services.

## Sources + Git

Le domaine OWASYS « Sources + Git » reste fonctionnellement et visuellement tel qu'il est : arborescence, lecture/édition, preview/diff, stage, unstage, restore, commit, etc.

Il reçoit simplement sa micro-EFSM `SourceGit` propre pour orchestrer son workflow.

Les opérations Source/Git existantes restent réalisées par les services réels et deviennent des ACTION PHP de cette micro-EFSM lorsque l'orchestration le nécessite.

## Ordre de mise en œuvre

Le commencement est la Security EFSM, car elle fournit l'identité, l'authentification et le contexte d'autorisation dont les autres micro-EFSM ont besoin pour coopérer sans duplication de sécurité.
