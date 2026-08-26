ACTIONS OBLIGATOIRES

1. Relire intégralement les dépôts GitHub (pas de sources sortis de ta mémoire !!! JAMAIS !!!!) et appliquer tous les contrats, conventions et règles de développement en vigueur.

2. Mettre à jour directement sur GitHub, les spécifications et handoffs de MAESTRO_WORKSPACE.

3. Tjs traiter la cause, jamais l'effet

4. Toute classe concrète du framework OPUS doit implémenter une interface homonyme étendant directement :
- OpusFrameworkComponentInterface
- OpusExceptionAwareInterface
- OpusProfilerAwareInterface
- OpusSelfDocumentingInterface

5. Livrer toute correction ou évolution OPUS/OWASYS sous forme de ZIP différentiel direct (scripts ou fichiers complets), contenant uniquement les fichiers complets à leurs chemins finaux.

L’assistant ne committe et ne pousse jamais OPUS ni OWASYS. L’owner applique le ZIP, valide, committe et pousse OPUS/OWASYS. L’assistant écrit directement uniquement dans MAESTRO_WORKSPACE.

6. Toute application OPUS doit respecter :
- architecture Singleton ;
- pilotage par FSM, I18n, ACL deny-by-default et SSO/Auth0-proxy/bastion ;
- conformité complète au framework OPUS ;
- rendu UI exclusivement via SCORE ;
- aucun echo pour l’interface ;
- aucun mélange HTML/PHP ;
- utilisation prioritaire des services OPUS ;
- détection initiale de la langue depuis le navigateur ;
- proposition explicite d’une évolution générique OPUS avant toute solution locale non strictement métier.

7. Toute configuration doit être lue via File, puis analysée par Json, Xml ou Yaml via StructuredFileLoader.

8. Fournir les commandes CMD nécessaires au lancement, aux contrôles et, uniquement lorsque requis, au nettoyage des fichiers ou répertoires obsolètes depuis le terminal VS Code.

Dans tout bloc CMD/PowerShell destiné à être copié, ne mettre QUE des commandes exécutables. Ne jamais inclure prompt (`H:\OPUS>`), sortie attendue, résultat de validation, commentaire, diagnostic ou texte explicatif dans un bloc de commandes. Les résultats attendus sont toujours présentés hors du bloc de commandes.

9. Appliquer strictement le contrat de développement MAESTRO.

10. OWASYS est composé de deux applications OPUS autonomes, chacune avec son propre Singleton et son propre contrat complet :
- owasys-front : interface SCORE uniquement ;
- owasys-back : API REST sécurisée, logique métier et exécution Composer allow-listée, exclusivement en PHP et sans JavaScript.

Les deux applications doivent pouvoir être déployées sur des serveurs ou bastions distincts. Toute commande métier passe obligatoirement par :
owasys-front → REST sécurisé → owasys-back → Composer.

11. Logger et Profiler sont obligatoires et contractuels dans les deux applications. Le Profiler OPUS vise une couverture développeur comparable à Symfony, adaptée à OPUS : HTTP, routage/contrôleur, FSM, SCORE, SSO/ACL, session, BDD/transactions, REST distribué, Composer, configuration, I18n, cache, logs, exceptions, runtime PHP/OPUS, mémoire et performances. Chaque panneau est alimenté uniquement par des événements réellement mesurés, sans secret ni donnée inventée. Pour OWASYS, la corrélation contractuelle est : front → REST → back → BDD/Composer → réponse → front.

12. sites/owasys-back ne doit contenir, charger, générer ni exécuter aucun JavaScript, TypeScript, runtime Node.js, gestionnaire de paquets JavaScript, bundle frontend ou dépendance JavaScript. Toute présence de .js, .mjs, .cjs, .ts, .tsx, package.json, lockfile npm/yarn/pnpm ou appel Node/npm/yarn/pnpm dans le backend est une non-conformité bloquante.

13. Flux: owasys-front -> REST (sécurisé) -> owasys-back -> composer -> owasys-back -> response -> owasys-front
Eventuellement genre de full duplex si back a besoin de notifier front (comme par exemple un scheduler)

14. Interdiction de changer une méthode de livraison qui a fait ses preuves. Tout livrable OPUS/OWASYS est remis directement dans la conversation comme pièce jointe ZIP native téléchargeable, avec un nom court. Ne jamais la remplacer par un lien ChatGPT Library, GitHub/raw, site externe ou par une récupération depuis un dépôt. Le bloc CMD séparé applique explicitement le ZIP avec `tar -xf "%USERPROFILE%\Downloads\<ZIP>" -C H:\OPUS`. Appliquer intégralement `00_COMMON_CONTRACTS/PATCH_DELIVERY_CONTRACT.md`.

et GO pour livrable systématique sauf exception !
