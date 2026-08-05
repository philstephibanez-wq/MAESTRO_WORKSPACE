# OPUS / OWASYS — ÉDITEUR DE SOURCES SÉCURISÉ ET WORKFLOW GIT CONTRÔLÉ

Date : 2026-08-05  
Statut : décision owner validée, suite planifiée après acquisition de R45B2A1R5  
Portée : framework OPUS, `owasys-front`, `owasys-back`

## 1. Décision

L'éditeur de sources et les opérations Git ne sont pas strictement métier à OWASYS.

Ils doivent être implémentés d'abord comme services génériques OPUS, puis exposés dans OWASYS en respectant exclusivement la frontière :

```text
owasys-front
-> REST sécurisé
-> owasys-back
-> Composer allow-listé
-> services OPUS Source/Git
-> réponse structurée
-> ViewModel
-> SCORE
```

Le navigateur ne reçoit aucun accès direct au système de fichiers, à Git, au shell, à PHP ou à Composer.

Cette évolution reste séparée du correctif atomique R45B2A1R5 relatif au rendu des applications générées.

## 2. Ordre obligatoire des livrables

### E1 — Service générique OPUS d'édition des sources

Capacités :

- lire un fichier texte autorisé ;
- produire son empreinte de version ;
- enregistrer un contenu complet avec verrouillage optimiste ;
- refuser l'écriture si l'empreinte fournie n'est plus courante ;
- exposer les métadonnées nécessaires à l'éditeur ;
- produire un diff de pré-enregistrement ;
- journaliser et profiler chaque lecture, comparaison et écriture.

### E2 — Intégration OWASYS Sources

Capacités UI :

- éditeur SCORE avec numéros de ligne ;
- coloration syntaxique ;
- recherche ;
- onglets ;
- indicateur d'état modifié ;
- comparaison avant enregistrement ;
- message explicite en cas de conflit concurrent ;
- conservation de la ressource et de la locale courantes dans l'URL REST GET.

L'interface est rendue exclusivement via SCORE. Aucun `echo` UI, aucun mélange HTML/PHP et aucun accès fichier local depuis `owasys-front`.

### E3 — Service Git OPUS et intégration OWASYS Git

Première version autorisée :

- statut ;
- diff ;
- historique ;
- stage explicite par chemins validés ;
- unstage explicite ;
- commit explicite avec message validé ;
- restauration contrôlée avec confirmation renforcée.

Première version interdite :

- push automatique ou implicite ;
- commande Git libre ;
- argument arbitraire fourni par le navigateur ;
- shell libre ;
- modification de configuration Git ;
- changement de remote ;
- rebase, reset destructif ou nettoyage non borné.

L'enregistrement d'un fichier, le stage et le commit sont trois opérations distinctes. Aucun enchaînement implicite n'est autorisé.

## 3. Sécurité des chemins et contenus

Les services génériques doivent :

- borner chaque opération à une racine de dépôt résolue et autorisée ;
- canoniser le chemin avant toute lecture ou écriture ;
- refuser `..`, chemins absolus, sorties de dépôt et traversées ;
- refuser les liens symboliques sortant de la racine ;
- refuser les fichiers binaires ;
- imposer une taille maximale configurable à la lecture et à l'écriture ;
- vérifier le type attendu et les tailles source/cible ;
- utiliser une allow-list d'extensions ou de familles textuelles ;
- ne jamais exposer de secret, token, clé, mot de passe ou contenu sensible dans Logger, Profiler ou exception ;
- conserver ACL deny-by-default et corrélation front/REST/back/Composer.

## 4. Concurrence et intégrité

Toute écriture exige au minimum :

```text
repository_id
relative_path
expected_content_hash
new_content
```

Le backend recalcule l'empreinte courante avant mutation.

Si l'empreinte diffère, il refuse l'écriture et retourne un conflit structuré ; aucun écrasement silencieux et aucun fallback ne sont autorisés.

Les écritures doivent être atomiques. L'ancienne version doit rester récupérable par Git lorsque le fichier est suivi.

## 5. Architecture contractuelle OPUS

Toute nouvelle classe concrète sous `Opus/**/*.php` implémente une interface homonyme étendant directement :

- `OpusFrameworkComponentInterface`
- `OpusExceptionAwareInterface`
- `OpusProfilerAwareInterface`
- `OpusSelfDocumentingInterface`

Toute configuration est lue via `File`, puis analysée par `Json`, `Xml` ou `Yaml` via `StructuredFileLoader`.

Les services doivent être réutilisables par toute application OPUS et ne contenir aucune logique métier OWASYS.

## 6. Contrat OWASYS

`owasys-front` :

- SCORE uniquement ;
- FSM, I18n, ACL et SSO obligatoires ;
- aucune mutation fichier ou Git locale ;
- appel REST sécurisé uniquement.

`owasys-back` :

- PHP exclusivement ;
- aucun JavaScript, TypeScript, Node.js ou gestionnaire de paquets JavaScript ;
- endpoints REST typés ;
- FSM et ACL deny-by-default ;
- exécution Composer strictement allow-listée ;
- services OPUS Source/Git comme seuls propriétaires des opérations génériques.

## 7. Validation minimale

Chaque livrable doit valider :

1. source de vérité et base Git exactes ;
2. PHP lint et Composer autoload ;
3. interfaces homonymes et quatre marqueurs ;
4. confinement des chemins et cas de traversée ;
5. liens symboliques sortants ;
6. limites de taille et fichiers binaires ;
7. conflit d'empreinte concurrente ;
8. séparation save/stage/commit ;
9. absence de push implicite ;
10. ACL deny-by-default ;
11. corrélation Logger/Profiler ;
12. rendu SCORE et navigation sans JavaScript obligatoire ;
13. absence totale de JavaScript dans `owasys-back` ;
14. ZIP différentiel limité aux fichiers complets à leurs chemins finaux.

## 8. Hors périmètre initial

- push Git ;
- gestion des remotes ;
- fusion, rebase et résolution graphique de conflits ;
- terminal intégré ;
- commandes shell libres ;
- édition de fichiers binaires ;
- réparation manuelle d'un site témoin.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
NO PUSH IMPLICITE.  
NO LOCAL SITE FIX.
