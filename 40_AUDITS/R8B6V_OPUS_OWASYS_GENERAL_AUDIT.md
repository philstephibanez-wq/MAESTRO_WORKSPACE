# R8B6V — Audit général OPUS + OWASYS

## Baseline

- dépôt audité : `philstephibanez-wq/OPUS`
- branche : `master`
- baseline fonctionnelle après R8B6U : `7dfb6206986cf1b7a738065df235fd04ab19fb3b`
- R8B6U est considéré résolu par validation owner.

## Objet

Effectuer un audit transversal et reproductible du framework OPUS, de `owasys-front` et de `owasys-back`, puis traiter les causes des non-conformités par lots bornés et livrables ZIP différentiels.

## Périmètre obligatoire

1. syntaxe PHP sur tout le périmètre maintenu ;
2. contrat framework : toute classe concrète OPUS implémente son interface homonyme, laquelle étend directement `OpusFrameworkComponentInterface`, `OpusExceptionAwareInterface`, `OpusProfilerAwareInterface`, `OpusSelfDocumentingInterface` ;
3. lecture de configuration via les services OPUS File / StructuredFileLoader ;
4. `owasys-front` : Singleton, FSM-first, I18n, ACL deny-by-default, SSO, rendu visible exclusivement SCORE, absence de `echo`/template HTML-PHP ;
5. `owasys-back` : Singleton, REST sécurisé, Composer allow-listé, Logger/Profiler, PHP uniquement, interdiction absolue JS/TS/Node/npm/yarn/pnpm ;
6. séparation déployable front/back : aucune dépendance à un chemin filesystem de l'autre bastion ;
7. validité structurelle et sémantique des EFSM : état initial, IDs uniques, signaux, sources et cibles ;
8. cohérence I18n globale avec toutes les locales actives et marqueur visible de traduction manquante ;
9. ACL deny-by-default et présence SSO ;
10. hygiène du dépôt : fichiers racine accidentels, répertoires legacy/interdits, artefacts générés ou résiduels.

## Évolution UI R8B6V

Lorsque le label visible d'un state ou d'une transition est manquant, le diagramme affiche désormais également son identifiant technique :

- state : `⚠ <state_id>` ;
- transition : `⚠ <transition_id>`.

L'identifiant technique n'est jamais traduit. Lorsqu'un message I18n est présent, seul le libellé traduit est affiché.

## Runner d'audit

Le livrable R8B6V fournit `tools/audit_opus_owasys.py`. Il doit être exécuté localement sur le clone owner afin de couvrir exhaustivement les fichiers réels du worktree et produire sur stdout : baseline, compteurs et findings classés `BLOCKER`, `ERROR`, `WARN`, `INFO`.

Aucun résultat complet ne doit être déclaré avant lecture de la sortie réelle du runner.

## Pré-audit GitHub — constats déjà confirmés

- `owasys-front` et `owasys-back` déclarent une architecture Singleton, `dispatch_model=fsm-module-first` et un échange REST inter-applications.
- leurs ACL déclarent `default=deny`.
- l'arbre GitHub de `owasys-back` ne contient aucun fichier JS/TS/package manager visible.
- le dépôt racine contient des artefacts inattendus (`cd`, `composer`, et un fichier nommé comme une commande de dev-server) : dette d'hygiène à confirmer et traiter après run.
- les politiques I18n des deux `site.json` déclarent encore `fallback_locale: fr-FR`; pour le front, cela est contradictoire avec le contrat visible R8B6S « pas de fallback français », même si le runtime courant n'utilise pas ce fallback pour la résolution R8B6U. Cette divergence doit être auditée avant correction.

## Gate

Le prochain correctif de conformité ne sera défini qu'après exécution du runner R8B6V et lecture intégrale de ses findings. Aucun finding ne sera masqué par une correction locale ponctuelle.
