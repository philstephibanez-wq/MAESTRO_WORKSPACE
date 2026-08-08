# OWASYS VS GENERATED SITE — FSM / WORKFLOW CONTRACT

Date : 2026-08-08
Statut : contrat architectural obligatoire

## Principe

OWASYS et chaque site généré sont des applications OPUS distinctes. Ils n'ont donc ni la même FSM, ni le même métier, ni le même référentiel de sécurité.

## FSM OWASYS

La FSM OWASYS pilote OWASYS lui-même.

Elle couvre :

- navigation entre écrans OWASYS ;
- guards d'authentification et d'autorisation OWASYS ;
- contexte de l'application actuellement construite ;
- métier propre à OWASYS : construire, configurer, modifier, valider et prévisualiser des applications OPUS.

Workflow fonctionnel cible :

```text
1. Authentification OWASYS avec profil autorisé
2. Ouvrir une application existante ou définir une nouvelle application
3. Choisir le mode : frontend / backend / fullstack
4. Définir la sécurité cible : rôles, utilisateurs, associations
5. Matérialiser/générer le site
6. Configurer une BDD éventuelle
7. Construire la structure : pages/routes/API selon le mode
8. Assigner les droits CRUD par rôle aux ressources/pages
9. Définir les workflows métier du site
10. Modifier le contenu SCORE et les liaisons aux données
11. Valider / Git / build / export / prévisualiser
```

`Sources et Git`, `Construction et validation`, le Profiler et la prévisualisation sont des outils OWASYS transversaux. Ils ne deviennent pas des états métier de la FSM du site généré.

## FSM du site généré

Chaque site généré possède sa propre FSM et l'exécute dans son propre runtime.

Elle couvre :

- pages/routes/navigation du site ;
- guards ACL/SSO du site ;
- états et transitions du métier propre au site ;
- actions et ressources métier du site.

Exemples :

```text
Accueil -> Commandes -> Commande -> Validation -> Facturation
```

ou :

```text
draft -> submitted -> approved -> paid
```

## Interdiction de couplage

OWASYS peut créer, éditer, afficher, valider et versionner la FSM d'un site comme ressource de construction.

OWASYS ne doit jamais :

- utiliser la FSM du site comme sa propre FSM runtime ;
- exécuter directement les transitions métier du site pour piloter sa navigation interne ;
- fusionner les rôles OWASYS avec les rôles du site ;
- déduire les droits du site des droits OWASYS.

## Sécurité séparée

### OWASYS

Référentiel de sécurité d'administration/développement :

```text
admin
developer
viewer
```

L'administration des utilisateurs et des rôles OWASYS est réservée à `admin`. `developer` et `viewer` peuvent uniquement exercer les self-services explicitement autorisés, par exemple le changement de leur propre mot de passe local.

### Site généré

Rôles et utilisateurs propres au site, définis pendant sa construction, par exemple :

```text
customer
editor
accountant
manager
```

Les rôles du site reçoivent des permissions CRUD sur les ressources/pages du site.

Principe :

```text
LE DROIT APPARTIENT À LA RESSOURCE, PAS AU BOUTON.
```

SCORE projette ensuite les capacités autorisées, tandis que le backend applique la même ACL deny-by-default.

## Modes de site

### frontend

```text
pages/routes
ACL CRUD
contenu SCORE
workflows de navigation/métier éventuels
```

### backend

```text
ressources REST
BDD/services
ACL CRUD
FSM métier
```

Aucune page visuelle n'est requise.

### fullstack

```text
frontend + backend
pages/routes + API/BDD
ACL CRUD cohérente sur les ressources
FSM/navigation/métier du site
```

## Prévisualisation développement

Le bouton OWASYS `Visualiser le site` appartient à `Construction et validation`.

Chaîne obligatoire :

```text
SCORE OWASYS
-> FSM/ACL OWASYS
-> REST sécurisé
-> owasys-back
-> commande Composer allow-listée
-> OPUS dev-server
-> runtime du site généré
-> FSM propre au site
```

La prévisualisation n'est disponible que pour les profils de site disposant d'une surface visuelle (`frontend`, `fullstack`).

NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO SITE BUSINESS EXECUTION BY OWASYS FSM.
