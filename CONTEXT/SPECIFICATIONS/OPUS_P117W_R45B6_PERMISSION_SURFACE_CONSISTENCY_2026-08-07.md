# OPUS / OWASYS P117W — R45B6 Permission Surface Consistency

Date : 2026-08-07  
Statut : livrable owner actif  
Base OPUS exacte : `3a7b891c17be447161d5c70299207f2590c9247a`

## Objet

R45B6 traite la cohérence des permissions OWASYS sur toute la surface actuellement implémentée, et non uniquement la page `Sources et Git`.

Le contrat reste deny-by-default et les rôles restent `admin`, `developer`, `viewer`. R45B6 n'implémente pas l'administration des rôles prévue en R45D.

## Audit de la surface

Pages / états audités :

- `login` ;
- `account/password` ;
- `applications` / Registry ;
- `applications/new` / création ;
- `structure` ;
- `data` ;
- `workflows` ;
- `security` ;
- `source` / Sources et Git ;
- `build` ;
- Web Profiler.

Chaîne contrôlée :

```text
identité SSO -> rôles session -> ACL front -> FSM/navigation -> contrôleur -> ViewModel -> SCORE -> REST -> ACL back -> allow-list Composer
```

## Défauts confirmés

### Registry / Applications

Le rôle `viewer` possède `registry:open` mais le frontend exigeait `registry:write` pour tous les POST Registry. Le backend réservait également `registry.select` et `registry.clear` à admin/developer et `OwasysCommandProvider` testait `registry:write`.

Conséquence : un viewer pouvait voir Applications mais ne pouvait pas établir le contexte applicatif requis par Structure, Données, Workflows, Sécurité, Sources et Git et Build.

Correction :

- introduire l'action ACL `registry:select` pour le viewer ;
- `select-app` et `clear-app-context` utilisent `registry:select` ;
- création reste `creation:open/write` ;
- suppression reste une mutation réservée (`registry:delete`, satisfaite par les wildcards admin/developer) ;
- le template Registry expose ou désactive les contrôles selon le ViewModel de capacités.

### Compte / changement de mot de passe

Le viewer possède `account:open`, mais ni le front, ni le back, ni l'allow-list ne lui accordaient `account:change`, alors que le formulaire était toujours rendu.

Le backend change le mot de passe du sujet authentifié lui-même ; ce n'est pas une administration d'un tiers.

Correction :

- `account:change` est un droit self-service pour les rôles authentifiés y compris viewer ;
- `security.admin-password.change` accepte viewer dans l'allow-list car l'opération agit sur le sujet authentifié ;
- le formulaire SCORE n'est rendu que si le provider est `local-password` et si `account:change` est permis ;
- Auth0-proxy ne reçoit pas un formulaire local incohérent.

### Sources et Git

Les permissions action par action existaient déjà :

```text
source:open
source:preview
source:write
git:read
git:stage
git:unstage
git:commit
git:restore
```

Pour viewer, la lecture seule de la source et Git read-only sont donc contractuels.

Défaut confirmé : le helper local `isAllowed()` capturait tout `Throwable` et retournait `false`. Une erreur ACL/profiler/configuration pouvait ainsi être transformée silencieusement en faux état « lecture seule ».

Correction : utiliser directement `OwasysRuntimeSecurity::isAllowed()`, qui retourne la décision ACL sans masquer des exceptions étrangères au refus d'autorisation.

## Matrice viewer cible

Autorisé :

```text
registry:open
registry:select
structure:open
data:open
workflows:open
security:open
source:open
git:read
build:open
account:open
account:change
```

Refusé notamment :

```text
creation:open
registry:delete
source:preview
source:write
git:stage
git:unstage
git:commit
git:restore
profiler:view
```

Admin reste `*:*`. Developer conserve ses wildcards/mutations actuelles.

## Pages pending

`structure`, `data`, `workflows`, `security` et `build` utilisent actuellement le rendu pending lorsqu'aucun template métier n'est présent. Il n'existe donc pas encore de mutation UI spécifique à auditer sur ces pages ; leur gate actuel est `module:open` + contexte applicatif pour les états qui le requièrent.

Chaque future action ajoutée à ces modules devra obtenir une permission d'action explicite et une capacité ViewModel correspondante avant rendu SCORE.

## Fichiers du différentiel

```text
sites/owasys-front/config/acl.json
sites/owasys-back/config/acl.json
sites/owasys-back/config/backend.operations.json
sites/owasys-back/application/registry/services/OwasysCommandProvider.php
sites/owasys-front/application/default/controllers/RuntimeController.php
sites/owasys-front/application/registry/templates/index.score
sites/owasys-front/application/account/templates/index.score
sites/owasys-front/application/source/controllers/SourceController.php
```

## Gates

- base exacte `3a7b891c17be447161d5c70299207f2590c9247a` ;
- aucune cible déjà modifiée ;
- lint PHP des candidats ;
- parsing JSON OPUS ;
- validation de la matrice effective par `AclPolicy` ;
- smoke owner séparé ;
- test navigateur admin, developer et viewer ;
- pour viewer : sélection d'application possible, pages de lecture accessibles, aucune mutation source/Git exposée, changement de son propre mot de passe local possible ;
- pour Auth0 : aucun formulaire de changement de mot de passe local ;
- admin/developer conservent leurs mutations.

NO ACL BYPASS.  
NO UI ACTION WITHOUT CAPABILITY.  
NO SILENT ACL FALLBACK.  
NO ROLE ADMINISTRATION IN R45B6.  
NO PUSH OPUS BY ASSISTANT.
