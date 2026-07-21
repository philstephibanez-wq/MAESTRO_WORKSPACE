# MAESTRO_WORKSPACE — Handoff OWASYS P117G

**Date :** 2026-07-21  
**Dépôt code relu :** `philstephibanez-wq/OPUS`  
**Branche :** `master`  
**Commit relu :** `e43955ff2a3db1056fdf2d6887432d11bae50bf1` (`p117f`)

## Correction de frontière

Le répertoire `Opus/Owasys` est interdit et a été supprimé par l’utilisateur.

```text
Opus/                  framework générique uniquement
sites/owasys/          application OWASYS autonome
```

Aucun correctif futur ne doit recréer `Opus/Owasys`, ni placer un service, un modèle, un contrôleur, un template ou un asset propre à OWASYS sous `Opus/`.

## État observé après P117F

- le diagramme Mermaid est rendu ;
- les lignes et libellés des transitions sont visibles ;
- les pointes de flèche sont insuffisamment visibles avec le thème sombre ;
- le JavaScript lie déjà les nœuds aux routes ACL, mais ne vérifie pas que tous les nœuds attendus ont effectivement été liés ;
- la référence historique `owasys_old` utilisait des nœuds Mermaid cliquables.

## Cible P117G

1. Rendre les marqueurs de fin de transition visuellement explicites.
2. Conserver les transitions et leurs libellés issus de la FSM canonique.
3. Lier chaque nœud rendu à la route déjà filtrée par l’ACL.
4. Supporter clic, Entrée et Espace.
5. Ne déclarer le diagramme `ready` que si toutes les routes attendues sont liées.
6. Ne pas utiliser les directives Mermaid `click`, incompatibles avec le contrat `securityLevel: strict`.
7. Ne modifier ni la FSM fonctionnelle, ni ACL, ni SSO.
8. Ne recréer aucun chemin `Opus/Owasys`.

## Fichiers runtime prévus

```text
sites/owasys/www/asset/css/fsm-mermaid.css
sites/owasys/www/asset/js/fsm-mermaid.js
sites/owasys/application/default/services/ScorePageRenderer.php
```

## Critères de sortie

- chaque transition possède une pointe de flèche visible ;
- chaque nœud autorisé affiche un curseur de navigation ;
- chaque nœud autorisé est activable à la souris et au clavier ;
- un échec de liaison empêche le statut `ready` ;
- aucune écriture directe dans `philstephibanez-wq/OPUS` ;
- aucun smoke, Markdown ou manifeste dans le ZIP runtime.
