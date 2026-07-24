# MAESTRO WORKSPACE — HANDOFF GLOBAL DEVELOPMENT RULES

Date : 2026-07-24  
Statut : actif  
Contrat associé : `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`

## Travail réalisé

- Relecture des heads distants et des derniers différentiels significatifs des dépôts GitHub accessibles : `MAESTRO_WORKSPACE`, `OPUS`, `Maestro`, `Maestro_KB_Engine`, `Maestro_KB_Extranet`.
- Relecture des contrats et handoffs OPUS/OWASYS actifs, notamment P117M, P117U, HF6, HF7 et le contrat standard d'application OPUS.
- Vérification ciblée du code OPUS courant concernant Composer, interfaces contractuelles, `File`, parsers JSON/XML/YAML, locale navigateur, REST/RCP, Logger et Profiler.
- Création du contrat global de développement demandé.
- Mise à jour de `README.md`, `CURRENT_HANDOFF.md`, `OPUS_CURRENT_STATE.md`, `PROJECT_INDEX.md` et `OPUS_SITE_STANDARD_CONTRACT.md`.

## Écart corrigé

Le workspace désignait encore comme head OPUS courant :

```text
96884961248fc82bf5e13187a6ffcfffacb82d9f
```

Le head réel de `OPUS/master` relu est :

```text
79f261854ee06a9f828fec389adca77d57323d00
```

Il correspond à HF6 committé.

## État HF7

HF7 est documenté dans le workspace sous forme de spécification, handoff et empreinte d'un ZIP de 45 fichiers.

L'artefact ZIP original et son contenu source exact ne sont pas présents dans GitHub ni dans le fichier fourni à cette conversation.

En application de `NO SOURCE OF TRUTH, NO PATCH`, aucun fichier OPUS/OWASYS HF7 n'a été reconstitué ou poussé.

## Règles désormais contractuelles

- Toute classe concrète OPUS implémente directement une interface homonyme étendant les quatre marqueurs standards.
- Toute application OPUS est Singleton, FSM/I18n/ACL/SSO, Auth0-proxy/bastion ready, backend-first et SCORE-only.
- Aucun `echo` ne produit l'interface et aucune vue ne mélange HTML et PHP.
- La langue par défaut est négociée depuis le navigateur avec fallback explicite.
- Toute configuration passe par `File`, puis `Json`, `Xml` ou `Yaml` via `StructuredFileLoader`.
- Tout besoin générique est proposé comme évolution OPUS avant une solution locale.
- Toute commande métier ou mutation OWASYS traverse REST sécurisé puis Composer.
- Logger et Profiler sont obligatoires et corrélés sans secret.
- Les corrections OPUS/OWASYS sont livrées uniquement par ZIP différentiel fondé sur les fichiers source réels.
- Les commandes de nettoyage et de lancement sont fournies en CMD exécutable pour le terminal VS Code.

## Commandes frontend vérifiées dans le code courant

```text
composer dump-autoload -o
composer opus:validate-site -- owasys
composer opus:list-routes -- owasys
composer opus:serve-site -- owasys --host=127.0.0.1 --port=8000
```

Le `composer.json` courant ne contient pas d'alias public de démarrage du backend REST. Cette commande doit être récupérée depuis le runtime owner réel ou ajoutée par une évolution générique OPUS explicitement spécifiée.

## Nettoyage

Aucune commande de suppression de `sites/owasys_old` n'est autorisée à ce stade. La décision reste séparée et soumise à validation owner.

Aucun cache, dossier d'extraction, fichier temporaire ou log n'a été ajouté aux dépôts.

## Reprise

1. relire `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md` ;
2. relire le contrat global associé à ce handoff ;
3. récupérer l'artefact HF7 original ou l'arbre source exact qui l'a généré ;
4. confirmer la base locale owner par rapport à `79f261854ee06a9f828fec389adca77d57323d00` ;
5. produire ou appliquer le ZIP différentiel HF7 uniquement depuis cette source ;
6. régénérer l'autoload optimisé ;
7. valider site, routes, backend, frontend, profils, Registry et Build ;
8. valider no-JavaScript, Auth0, HTTPS, bastion, logs/profiler et parité Windows/Linux ;
9. committer OPUS uniquement après validation owner ;
10. décider séparément de `sites/owasys_old`.
