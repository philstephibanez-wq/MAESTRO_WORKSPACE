ACTIONS OBLIGATOIRES

1. Relire intégralement les dépôts GitHub et appliquer tous les contrats, conventions et règles de développement en vigueur.

2. Mettre à jour directement sur GitHub, en lecture/écriture, les spécifications et handoffs du MAESTRO_WORKSPACE.

2': tjs traiter la cause, jamais l'effet

3. Toute classe concrète du framework OPUS doit implémenter une interface homonyme étendant directement :
- OpusFrameworkComponentInterface
- OpusExceptionAwareInterface
- OpusProfilerAwareInterface
- OpusSelfDocumentingInterface

4. Livrer toute correction ou évolution OPUS/OWASYS sous forme de ZIP différentiel direct (scripts ou fichiers complets), contenant uniquement les fichiers complets à leurs chemins finaux.

L’assistant ne committe et ne pousse jamais OPUS ni OWASYS. L’owner applique le ZIP, valide, committe et pousse OPUS/OWASYS. L’assistant écrit directement uniquement dans MAESTRO_WORKSPACE.

5. Toute application OPUS doit respecter :
- architecture Singleton ;
- pilotage par FSM, I18n, ACL deny-by-default et SSO/Auth0-proxy/bastion ;
- conformité complète au framework OPUS ;
- rendu UI exclusivement via SCORE ;
- aucun echo pour l’interface ;
- aucun mélange HTML/PHP ;
- utilisation prioritaire des services OPUS ;
- détection initiale de la langue depuis le navigateur ;
- proposition explicite d’une évolution générique OPUS avant toute solution locale non strictement métier.

6. Toute configuration doit être lue via File, puis analysée par Json, Xml ou Yaml via StructuredFileLoader.

7. Fournir les commandes CMD nécessaires au lancement, aux contrôles et, uniquement lorsque requis, au nettoyage des fichiers ou répertoires obsolètes depuis le terminal VS Code.

8. Appliquer strictement le contrat de développement MAESTRO.

9. OWASYS est composé de deux applications OPUS autonomes, chacune avec son propre Singleton et son propre contrat complet :
- owasys-front : interface SCORE uniquement ;
- owasys-back : API REST sécurisée, logique métier et exécution Composer allow-listée, exclusivement en PHP et sans JavaScript.

Les deux applications doivent pouvoir être déployées sur des serveurs ou bastions distincts. Toute commande métier passe obligatoirement par :
owasys-front → REST sécurisé → owasys-back → Composer.

10. Logger et Profiler sont obligatoires et contractuels dans les deux applications.

10'. sites/owasys-back ne doit contenir, charger, générer ni exécuter aucun JavaScript, TypeScript, runtime Node.js, gestionnaire de paquets JavaScript, bundle frontend ou dépendance JavaScript. Toute présence de .js, .mjs, .cjs, .ts, .tsx, package.json, lockfile npm/yarn/pnpm ou appel Node/npm/yarn/pnpm dans le backend est une non-conformité bloquante.

11 - Flux: owasys-front -> REST (sécurisé) -> owasys-back -> composer -> owasys-back -> response -> owasys-front
Eventuellement genre de full duplex si back a besoin de notifier front (comme par exemple un scheduler)

GO