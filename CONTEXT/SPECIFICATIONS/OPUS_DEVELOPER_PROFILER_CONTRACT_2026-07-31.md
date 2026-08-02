# OPUS — Contrat du Profiler développeur

Date : 2026-07-31  
Statut : contractuel  
Incrément : P117W R46

## Finalité

Le Profiler OPUS est un outil de diagnostic destiné aux développeurs. Il doit expliquer ce qui s'est réellement produit pendant une requête, une commande ou un traitement, où le temps et la mémoire ont été consommés, quelle décision a été prise et quelle preuve technique la justifie.

Un simple `trace_id`, un état FSM ou une chaîne d'architecture statique ne constitue pas un profiler.

La couverture fonctionnelle vise celle d'un profiler développeur moderne comparable à Symfony, adaptée à OPUS et enrichie de ses domaines propres : FSM, SCORE, corrélation REST distribuée, ACL/SSO, I18n et Composer.

## Portée

Le Profiler est un composant générique du framework OPUS.

- Utiliser le même contrat dans toute application OPUS.
- Activer uniquement en environnement de développement ou local.
- Ouvrir explicitement avec `?profiler=1`.
- Rendre indisponible en production, même si le paramètre est fourni.
- Interdire tout profiler local propre à OWASYS ou à une application générée.
- Rendre toute interface exclusivement avec SCORE.
- Piloter l'ouverture, la fermeture et la consultation par FSM.
- Appliquer une ACL `profiler:view` côté serveur.
- Masquer systématiquement secrets, jetons, cookies, mots de passe et données personnelles non nécessaires.

## Principe de vérité

Le Profiler ne doit afficher que des événements effectivement collectés.

Il est interdit :

- d'afficher `front → REST → back → Composer` si ces étapes n'ont pas toutes eu lieu ;
- d'inférer un appel REST, une commande Composer, une décision ACL ou un rendu SCORE sans événement correspondant ;
- de déclarer une requête réussie lorsque son statut réel est inconnu ;
- de remplacer une donnée absente par une valeur rassurante ;
- de masquer l'échec de collecte ou d'écriture d'une trace.

Une donnée indisponible est affichée comme indisponible avec sa raison.

## Modèle de corrélation

Chaque opération possède :

- un `trace_id` pour la trace globale ;
- un `span_id` pour chaque opération mesurée ;
- un `parent_span_id` pour former la chronologie ;
- un `component` indiquant le producteur réel ;
- une heure de début, une heure de fin et une durée ;
- un statut `success`, `warning`, `error` ou `unavailable`;
- un type d'événement stable ;
- un contexte filtré.

Pour OWASYS :

`owasys-front → REST sécurisé → owasys-back → Composer → réponse → owasys-front`

Le `trace_id` est transmis par un en-tête contractuel sécurisé. Le front et le back conservent chacun leurs propres traces et leurs propres Singletons. Ils ne partagent aucun fichier, état runtime, configuration ou stockage. Le panneau front agrège les informations autorisées reçues par REST ; aucun concept `shared` n'est introduit.

## Événements obligatoires

### Requête et réponse

- `http.request.received`
- `http.route.resolved`
- `http.controller.selected`
- `http.response.created`
- `http.response.sent`
- `http.exception.caught`

Collecter méthode, route normalisée, statut HTTP, contrôleur/action, durée et tailles filtrées.

### FSM

- `fsm.event.received`
- `fsm.guard.evaluated`
- `fsm.transition.applied`
- `fsm.transition.rejected`
- `fsm.action.executed`

Collecter état initial, événement, gardes, transition, état final et raison d'un refus.

### Sécurité

- `sso.identity.resolved`
- `acl.decision.evaluated`
- `acl.decision.denied`

Collecter fournisseur et subject pseudonymisé, rôles effectifs, ressource canonique, action, scope, décision et règle décisive. Ne jamais collecter de secret ni de jeton.

### REST

- `rest.request.started`
- `rest.response.received`
- `rest.request.failed`

Collecter service cible logique, méthode, route, statut, durée, `trace_id`, `span_id` et taille. Ne jamais collecter les credentials.

### Composer

- `composer.command.validated`
- `composer.command.started`
- `composer.command.completed`
- `composer.command.failed`

Collecter identifiant allow-listé de commande, arguments filtrés, code de sortie, durée et synthèse de sortie utile. Ne pas afficher une commande Composer si elle n'a pas été exécutée.

### SCORE

- `score.render.started`
- `score.layout.resolved`
- `score.fragment.rendered`
- `score.render.completed`
- `score.render.failed`

Collecter renderer, layout, fragments, durées et erreur normalisée.

### Configuration et données

- `config.file.loaded`
- `config.file.rejected`
- `data.operation.started`
- `data.operation.completed`
- `data.operation.failed`

Collecter provenance, format, durée, volume et résultat, avec valeurs sensibles masquées. Toute configuration reste lue via File puis Json, Xml ou Yaml avec StructuredFileLoader.

### Base de données et transactions

- `database.connection.opened`
- `database.operation.started`
- `database.operation.completed`
- `database.operation.failed`
- `database.transaction.started`
- `database.transaction.committed`
- `database.transaction.rolled_back`

Collecter pilote, connexion logique pseudonymisée, type d'opération, tables autorisées, empreinte ou forme normalisée, durée, lignes lues ou affectées, origine applicative et statut. Ne jamais collecter mot de passe, DSN secret, SQL brut, paramètres bruts ni données métier. Chaque opération mesurée est un span enfant de la requête ou commande qui l'a déclenchée.

### Session, cache et I18n

- `session.opened`
- `session.read`
- `session.written`
- `session.closed`
- `cache.hit`
- `cache.miss`
- `cache.write`
- `cache.delete`
- `i18n.locale.resolved`
- `i18n.translation.resolved`
- `i18n.translation.missing`

Collecter uniquement noms logiques, compteurs, durées, locale, domaine et clés non sensibles. Ne jamais collecter cookie, identifiant de session brut, contenu de session, valeur de cache ou traduction contenant des données personnelles.

### Runtime et performances

- `runtime.bootstrap.completed`
- `runtime.shutdown.completed`
- `performance.threshold.exceeded`

Collecter versions PHP/OPUS, environnement, extensions pertinentes, durée, mémoire actuelle/de pointe, delta mémoire et seuil dépassé. Les valeurs de configuration sensibles restent masquées.

### Logger, erreurs et dépréciations

- `log.recorded`
- `exception.normalized`
- `deprecation.recorded`

Relier chaque entrée au `trace_id` et, lorsque possible, au `span_id`.

## Interface développeur

### Barre compacte

Afficher en permanence lorsque le Profiler est activé :

- état global par couleur et texte ;
- statut HTTP ;
- durée totale ;
- mémoire de pointe et delta ;
- route ;
- état ou transition FSM ;
- nombre d'erreurs et d'avertissements ;
- nombre d'appels REST ;
- nombre d'opérations BDD et durée cumulée ;
- nombre de commandes Composer ;
- `trace_id`.

Aucun indicateur ne doit prétendre qu'une opération a eu lieu si son compteur est nul.

### Panneau détaillé SCORE dans une iframe

Le panneau détaillé est rendu côté serveur par des SCORE génériques appartenant à OPUS et affiché dans une iframe same-origin ouverte depuis la barre compacte. L'iframe est uniquement une vue du Profiler, jamais une application ou un runtime autonome.

- route dédiée de type `/profiler/trace/<trace_id>` ;
- contrôle backend `profiler:view` avant lecture ;
- FSM de consultation ;
- `frame-ancestors 'self'` et origine identique par défaut ;
- secrets masqués avant construction du view-model ;
- aucun SCORE Profiler copié dans OWASYS ou les applications générées ;
- aucune donnée sensible transmise par JavaScript ou dans l'URL ;
- la barre compacte reste hors iframe.

Le panneau détaillé organise obligatoirement les rubriques ci-dessous sous forme d'onglets fonctionnels navigables. Un onglet regroupe une famille de mesures ; il est interdit de déverser tous les événements en vrac dans une vue unique ou de créer un onglet par événement.

Fournir les onglets suivants :

1. Résumé.
2. Chronologie.
3. Requête et réponse.
4. Routage et contrôleur.
5. FSM.
6. SSO et ACL.
7. REST.
8. Composer.
9. SCORE.
10. Base de données et transactions.
11. Session.
12. Cache.
13. I18n et traductions.
14. Configuration et environnement.
15. Logs, exceptions et dépréciations.
16. Événements internes.
17. Informations PHP et OPUS.
18. Mémoire, performances et opérations lentes.

Chaque onglet doit :

- répondre en langage développeur à « que s'est-il passé ? » ;
- fournir les preuves techniques ;
- indiquer les événements absents ou non collectables ;
- permettre de retrouver le fichier, la classe ou la règle concernée sans exposer un secret ;
- n'afficher que ses propres compteurs, événements, spans et détails ;
- conserver le contexte de la trace active et permettre de revenir au résumé sans recharger une autre trace.

Le panneau frontend peut agréger une synthèse backend autorisée uniquement par REST sécurisé et corrélation explicite. Les traces restent stockées séparément dans chaque application. Une donnée backend absente, inaccessible ou non corrélée est déclarée indisponible ; elle n'est jamais reconstituée par inférence.

## Stockage et rétention

- Conserver un nombre borné de traces par application.
- Utiliser une rotation explicite et configurable.
- Éviter un fichier permanent par événement.
- Garantir une écriture atomique.
- Signaler les traces tronquées.
- Nettoyer sans toucher aux logs métier.
- Interdire toute écriture de trace en production.

## Contrats de classes

Toute nouvelle classe concrète du Profiler doit implémenter une interface homonyme étendant directement :

- `OpusFrameworkComponentInterface`
- `OpusExceptionAwareInterface`
- `OpusProfilerAwareInterface`
- `OpusSelfDocumentingInterface`

Les collecteurs produisent des données typées et ne rendent aucune interface. La présentation SCORE consomme un view-model filtré.

## Découpage de livraison

### R46A — Modèle de trace

- Définir trace, span, événement, statut et corrélation.
- Remplacer le schéma minimal par un schéma versionné complet.
- Conserver la compatibilité de lecture des traces V1 ou échouer explicitement.
- Tester causalité, durées, statuts et masquage.

### R46B — Collecteurs génériques

- Instrumenter HTTP, routage, FSM, SSO/ACL, session, BDD/transactions, REST, Composer, SCORE, configuration, I18n, cache, Logger, exceptions, runtime et performances.
- Ne collecter que les événements réels.
- Tester succès, avertissement, refus et exception.

### R46C — Barre et panneau SCORE

- Créer la barre compacte.
- Créer le panneau détaillé.
- Afficher chronologie, preuves et indisponibilités.
- Piloter par FSM et protéger par ACL.

### R46D — Corrélation OWASYS

- Transmettre la corrélation front/back par REST sécurisé.
- Agréger sans partage de fichiers ni d'état runtime.
- Prouver les étapes réellement traversées.
- Corréler Composer avec la requête d'origine.

### R46E — Génération

- Faire générer l'intégration standard du Profiler pour `frontend`, `backend` et `fullstack`.
- Ne générer aucune implémentation locale.
- Tester le Profiler dans chaque profil.
- Régénérer le site témoin au lieu de le corriger.

## Critères d'acceptation

- Afficher une requête sans REST avec compteur REST à zéro.
- Afficher une requête front/back avec spans corrélés et chronologie prouvée.
- Afficher une décision ACL avec ressource, action, scope et règle décisive.
- Afficher une transition FSM complète.
- Afficher les opérations BDD et transactions réelles avec durée, statut et lignes, sans SQL ni paramètres sensibles.
- Afficher session, cache et I18n sans exposer leurs contenus sensibles.
- Afficher le rendu SCORE et ses fragments.
- Afficher une exception normalisée avec origine exploitable.
- Distinguer durée totale et durées des spans.
- Ne révéler aucun secret.
- Refuser toute activation en production.
- Ne contenir aucun `echo` d'interface ni mélange HTML/PHP.
- Ne contenir aucun JavaScript dans `owasys-back`.
- Ne créer aucun concept `shared`.

NO EVENT, NO CLAIM.  
NO CONTRACT, NO PATCH.  
NO FALLBACK SILENCIEUX.
