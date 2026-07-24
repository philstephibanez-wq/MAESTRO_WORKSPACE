# OPUS / OWASYS P117U HF7R1 — RUNTIME CHECKPOINT

Date : 2026-07-24  
Statut : checkpoint runtime owner confirmé par captures et journal backend  
Portée : application OWASYS locale après application de HF7R1

## 1. Sources de vérité

```text
OPUS distant canonique : philstephibanez-wq/OPUS
Branche                 : master
Head distant            : 79f261854ee06a9f828fec389adca77d57323d00
État distant            : HF6 committé
État local observé      : HF7R1 appliqué, non encore committé sur OPUS/master
Workspace               : philstephibanez-wq/MAESTRO_WORKSPACE
```

Le code OPUS/OWASYS n’est pas poussé directement par l’assistant. Le distant reste la base HF6 tant que les gates owner HF7R1 ne sont pas terminés.

## 2. Contrats obligatoires inchangés

- toute classe concrète sous `Opus/**/*.php` implémente directement son interface homonyme ;
- l’interface homonyme étend directement `OpusFrameworkComponentInterface`, `OpusExceptionAwareInterface`, `OpusProfilerAwareInterface` et `OpusSelfDocumentingInterface` ;
- applications Singleton, FSM, I18n, ACL deny-by-default et SSO/Auth0-proxy, compatibles bastion ;
- rendu exclusivement SCORE, sans `echo` UI ni mélange HTML/PHP ;
- locale par défaut négociée depuis le navigateur ;
- configuration lue par `File`, puis parsée par `Json`, `Xml` ou `Yaml` via `StructuredFileLoader` ;
- toute mutation OWASYS traverse REST sécurisé puis Composer ;
- Logger et Profiler obligatoires ;
- aucun secret dans Git, argv, logs, profiler ou livrables.

## 3. Preuves visuelles reçues

### 3.1 État historique avant HF7R1

La première capture conserve l’ancien affichage FSM linéaire et ne propose pas le module Creation dans la surface visible. Elle sert uniquement de comparaison historique.

### 3.2 État Applications après HF7R1

La surface Applications affiche désormais :

```text
Créer une nouvelle application
Candidats : 1
Applications canoniques : 1
Identifiants dupliqués : 0
Racines ignorées : 0
Conformes Singleton : 1
Non conformes Singleton : 0
```

Cette capture valide la présence du point d’entrée Creation, l’intégrité de découverte et le contrôle Singleton.

### 3.3 Projection Registry canonique

Après synchronisation, la surface Applications projette :

```text
Applications : 1
OPUS OWASYS
status : discovered
profile : fullstack
kind : standard-opus-application
root : sites/owasys
locale : fr-FR
id : owasys
conformity : OwasysApplication
```

Le contexte courant reste volontairement vide tant que l’action `Travailler sur cette application` n’a pas déclenché `registry.select`.

## 4. Preuves REST + Composer

Le journal backend fourni contient cinq exécutions `registry.sync` :

```text
2026-07-24T07:51:23Z -> 07:51:28Z
2026-07-24T07:52:31Z -> 07:52:35Z
2026-07-24T11:12:10Z -> 11:12:21Z
2026-07-24T15:42:50Z -> 15:42:54Z
2026-07-24T15:44:08Z -> 15:44:12Z
```

Chaque exécution suit la chaîne :

```text
execution.received
-> execution.validated
-> command.started : owasys:registry-sync
-> command.succeeded : exit_code=0, stderr_bytes=0
-> execution.succeeded : fsm_state=succeeded
```

Durées observées :

```text
4360.705 ms
3776.018 ms
10261.34 ms
3603.44 ms
4112.159 ms
```

Aucune erreur backend, sortie stderr ou transition FSM failed n’est présente dans le journal fourni.

## 5. Gates désormais validés

- HF7R1 est chargé dans le runtime local ;
- backend et frontend OWASYS démarrent ;
- la route Applications est rendue par SCORE ;
- le bouton Creation est visible ;
- la découverte Registry passe par REST sécurisé puis Composer ;
- le backend exécute la commande publique allow-listée ;
- la FSM d’exécution backend atteint `succeeded` ;
- l’application standard OWASYS est projetée ;
- l’intégrité des identifiants est verte ;
- le contrôle Singleton est vert ;
- la corrélation par `trace_id` est présente dans le backend.

## 6. Gates non encore validés

Les éléments suivants ne sont pas attestés par les captures et le journal reçus :

1. audit tokenizer P117M exhaustif sur l’arbre local post-HF7R1 ;
2. PHP lint et parsing structurés exhaustifs post-installation ;
3. ouverture de `/fr-FR/applications/new` et affichage du formulaire Creation ;
4. annulation `Creation -> Registry` ;
5. validation des erreurs site ID, profil et application existante avec trace corrélée ;
6. création effective d’un profil frontend ;
7. création effective d’un profil backend ;
8. création effective d’un profil fullstack ;
9. `registry.select` de l’application créée ;
10. transition FSM `application_created -> Build` ;
11. conformité des trois applications générées ;
12. navigation sans JavaScript ;
13. Auth0, HTTPS, bastion et parité Windows/Linux ;
14. commit et push OPUS owner.

## 7. Prochaine séquence contrôlée

```text
Applications
-> Créer une nouvelle application
-> vérifier état Creation
-> annuler une première fois
-> rouvrir Creation
-> tester une erreur contrôlée
-> créer frontend
-> vérifier Registry select et Build
-> répéter backend
-> répéter fullstack
```

Les identifiants de test recommandés sont :

```text
hf7r1-frontend-check
hf7r1-backend-check
hf7r1-fullstack-check
```

Aucune commande de suppression n’est fournie avant validation explicite que ces applications sont uniquement des fixtures jetables.

## 8. Livraison différentielle

Aucun nouveau défaut de code n’est démontré par les preuves reçues. Aucun ZIP correctif supplémentaire n’est donc fabriqué à ce checkpoint.

Le différentiel installable courant reste :

```text
opus_owasys_p117u_hf7r1_application_creation_profiles.zip
SHA-256 : 16b8006dae07b88555c7149fa14bb4f9a1230e47f5d32f973933e0597dcb7858
PATHS : 45
```

Tout correctif futur sera produit uniquement après reproduction d’un écart sur la base locale post-HF7R1 et identification des fichiers réels concernés.
