# Spécification OWASYS — projection FSM Mermaid P117E

## 1. Objet

Cette spécification définit l’intégration du schéma FSM Mermaid dans OWASYS, application autonome du framework OPUS.

Le schéma est une projection visuelle de la FSM canonique. Il ne constitue ni une FSM secondaire, ni un système de navigation parallèle.

## 2. Sources de vérité

```text
sites/owasys/config/owasys-navigation.fsm.json
```

La FSM reste la source de vérité pour les états, modules, routes, événements, transitions, gardes et actions.

La navigation commune fournit la vue ACL filtrée des états accessibles à l’identité courante.

Le schéma utilise donc :

```text
FSM canonique ∩ navigation autorisée par ACL
```

## 3. Référence historique

Le comportement de référence provient de l’ancien OWASYS :

- schéma `flowchart LR` ;
- états de navigation uniquement ;
- état courant accentué ;
- application courante affichée dans le contexte ;
- transitions visuelles sélectionnées ;
- nœuds utilisables comme navigation.

L’implémentation historique par CDN et `securityLevel: loose` est interdite. Elle est remplacée par le composant Mermaid local et strict du framework OPUS.

## 4. Métadonnées FSM

### 4.1 Configuration du diagramme

La FSM peut contenir :

```json
{
  "diagram": {
    "contract": "OWASYS_FSM_MERMAID_V1",
    "direction": "LR"
  }
}
```

Directions autorisées :

```text
LR RL TB BT
```

### 4.2 Transition visible

Une transition n’est affichée que si elle porte :

```json
{
  "visual": true
}
```

### 4.3 Source graphique d’une transition générique

Une transition runtime peut conserver :

```json
{
  "from": "*"
}
```

et préciser sa projection graphique :

```json
{
  "visual": true,
  "visual_from": "structure"
}
```

`visual_from` ne modifie ni la résolution runtime, ni les gardes, ni les actions, ni l’état cible.

## 5. États projetés

Un état est projeté lorsque :

1. il existe dans `states[]` ;
2. sa navigation est visible ;
3. l’ACL autorise `module:open` pour l’identité courante ;
4. une URL de navigation a été construite ;
5. la page courante est authentifiée et n’est ni `login` ni `account`.

Les états anonymes et techniques restent dans la FSM mais ne sont pas nécessairement projetés.

## 6. Classes graphiques

- `active` : état runtime courant ;
- `work` : état nécessitant une application courante ;
- `primary` : état accessible sans application courante.

Le nœud Structure peut afficher le nom de l’application courante. Cette décoration est issue du ViewModel et n’altère pas la configuration FSM.

## 7. Architecture

### 7.1 Framework

```text
Opus/Assets/src/opus-mermaid-entry.js
Opus/Assets/dist/mermaid/opus-mermaid.js
Opus/Assets/FrameworkAssetResponder.php
Opus/Componants/Diagram/MermaidDiagram.php
```

Le framework :

- possède la dépendance Mermaid ;
- possède le bundle construit ;
- initialise Mermaid avec `securityLevel: strict` ;
- fournit le composant de conteneur ;
- sert l’asset au travers du front controller de l’application.

### 7.2 Application OWASYS

```text
application/default/services/FsmMermaidBuilder.php
application/default/templates/partials/fsm-mermaid.score
www/asset/js/fsm-mermaid.js
www/asset/css/fsm-mermaid.css
```

OWASYS :

- construit la projection propre à sa FSM ;
- fournit les routes ACL filtrées ;
- rend le partial SCORE commun ;
- branche la navigation souris et clavier après le rendu.

## 8. Distribution de l’asset framework

L’URL publique est :

```text
/asset/opus/mermaid/opus-mermaid.js
```

Elle est traitée par `FrameworkAssetResponder` avant le dispatch applicatif.

Contraintes :

- méthodes `GET` et `HEAD` uniquement ;
- liste blanche d’assets ;
- confinement sous `Opus/Assets/dist` ;
- `X-Content-Type-Options: nosniff` ;
- aucune exposition générique du répertoire framework ;
- aucun fichier recopié dans `sites/owasys/www`.

## 9. SCORE

Le schéma commun est inclus par :

```text
application/default/templates/layout.score
```

via :

```text
application/default/templates/partials/fsm-mermaid.score
```

Le contrôleur runtime ne construit aucun HTML Mermaid.

`OwasysScorePageRenderer` enrichit le ViewModel commun avant le rendu du body et du layout.

## 10. ACL

Le diagramme ne doit jamais révéler un état refusé par ACL.

Le filtrage du diagramme utilise la même collection `navigation` que le menu horizontal. Le contrôle serveur reste néanmoins obligatoire lors de l’ouverture d’une route.

## 11. SSO

Le diagramme est visible uniquement avec une identité SSO authentifiée.

Aucune logique d’identité, de rôle ou de session n’est ajoutée dans Mermaid ou dans le JavaScript d’intégration.

## 12. Sécurité Mermaid

- bundle local OPUS uniquement ;
- aucun CDN ;
- `securityLevel: strict` ;
- aucune directive Mermaid `click` injectée dans la source ;
- navigation ajoutée après rendu depuis une table JSON échappée ;
- libellés nettoyés avant construction de la source ;
- routes issues du ViewModel ACL filtré.

## 13. Accessibilité

Chaque nœud navigable reçoit après rendu :

```text
role=link
tabindex=0
```

Activation :

- clic souris ;
- touche Entrée ;
- touche Espace.

Un texte de repli reste visible si Mermaid ou son bundle ne peut pas produire le SVG.

## 14. Interdictions

- aucune seconde FSM dédiée au diagramme ;
- aucun tableau manuel de modules ou de pages ;
- aucun CDN Mermaid ;
- aucune copie Mermaid sous OWASYS ;
- aucun `securityLevel: loose` ;
- aucun HTML construit dans `RuntimeController` ;
- aucune vue PHP ;
- aucun état fonctionnel dans `application/default` ;
- aucun contournement ACL ;
- aucun smoke ou document dans le ZIP runtime.

## 15. Recette

1. Connexion SSO valide.
2. Schéma absent de login et compte.
3. Schéma présent sur Registry et les modules authentifiés.
4. Nœuds conformes aux états FSM autorisés.
5. Arêtes conformes aux transitions `visual`.
6. État courant accentué.
7. Application courante visible dans le contexte graphique.
8. Navigation souris et clavier fonctionnelle.
9. Refus ACL serveur toujours actif.
10. Aucun appel réseau vers un CDN Mermaid.
11. Bundle servi par `/asset/opus/mermaid/opus-mermaid.js`.
12. Registry, menu horizontal, i18n, SSO, mot de passe et page Source sans régression.
