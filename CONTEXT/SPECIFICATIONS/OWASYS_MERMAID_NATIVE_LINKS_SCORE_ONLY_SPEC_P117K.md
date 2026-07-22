# OWASYS — Spécification Mermaid cliquable et rendu SCORE exclusif P117K

## 1. Objet

Définir le contrat de navigation du schéma FSM Mermaid OWASYS et verrouiller le rendu UI exclusivement par SCORE avec le moteur i18n OPUS.

## 2. Sources de vérité

```text
FSM
    états, transitions, routes, modules et gardes

ACL
    nœuds accessibles à l’identité courante

SSO
    identité runtime

SCORE
    structure HTML et textes i18n
```

Le diagramme est une projection de la FSM filtrée par ACL. Il ne constitue ni une seconde FSM ni un routeur parallèle.

## 3. Contrat de projection Mermaid

Pour chaque état présent dans la navigation ACL autorisée, le builder émet :

```text
node id      = identifiant FSM
node class   = owasys-fsm-state-<state>
route map    = { url, node_class }
```

Exemple :

```json
{
  "registry": {
    "url": "/fr/applications",
    "node_class": "owasys-fsm-state-registry"
  }
}
```

La classe stable appartient au contrat OWASYS. Les IDs internes produits par Mermaid ne sont pas une API.

## 4. Résolution des nœuds

Ordre obligatoire :

1. classe stable `owasys-fsm-state-<state>` ;
2. attribut Mermaid `data-id` ou `data-node-id` ;
3. ID historique `flowchart-<state>-...` ;
4. position contrôlée uniquement lorsque le nombre de nœuds rendus égale exactement le nombre de routes.

Un nœud non résolu provoque :

```text
OWASYS_FSM_MERMAID_NODE_MISSING:<state>
```

Le panneau reste en état `error`. Il ne doit pas annoncer un binding partiel comme réussi.

## 5. Navigation native SVG

Après rendu Mermaid, chaque groupe de nœud est enveloppé dans :

```xml
<a href="<route localisée>" role="link" tabindex="0">
  <g class="node ...">...</g>
</a>
```

Le lien expose :

```text
data-owasys-fsm-state
data-owasys-fsm-route
aria-label
```

Comportements obligatoires :

- clic principal : navigation ;
- Entrée : comportement natif du lien ;
- Espace : navigation explicite ;
- Ctrl/Cmd/Shift/Alt + clic : comportement navigateur conservé ;
- focus clavier visible ;
- curseur pointeur ;
- descendants SVG avec `pointer-events: all`.

## 6. État de binding

Lorsque toutes les routes sont liées :

```text
data-fsm-mermaid-status="ready"
data-fsm-mermaid-bound-routes="<count>"
data-owasys-fsm-bound-routes="<count>"
```

Le fallback SCORE est masqué uniquement dans cet état.

## 7. i18n

Le moteur P117I est canonique :

```text
application/default/local/<locale>
+
application/<module FSM>/local/<locale>
```

La surcharge module s’applique après le catalogue global.

Le partial Mermaid utilise directement :

```score
[[ i18n: navigation.main ]]
```

Aucun callable `$t`, tableau de libellés PHP ou texte HTML traduit côté JavaScript ne doit être ajouté au diagramme.

## 8. SCORE exclusif

Les pages et composants visuels OWASYS appartiennent exclusivement à :

```text
sites/owasys/application/default/templates/*.score
sites/owasys/application/<module>/templates/*.score
```

Sont interdits :

```text
application/*/views/*.php
HTML dans un contrôleur
HTML dans un modèle
HTML dans un service métier
templates PHP avec <?= ... ?>
```

Le contrôleur sélectionne un template et construit le ViewModel. `OwasysScorePageRenderer` rend le template et le layout SCORE.

L’émission HTTP utilise `OwasysScorePageRenderer::emit()` et `php://output`. Le contrôleur ne fait plus :

```php
echo $this->renderer->render(...);
```

## 9. Frontières techniques

Le JavaScript public OWASYS peut uniquement :

- initialiser Mermaid ;
- relier le SVG déjà autorisé par le serveur ;
- gérer les interactions navigateur.

Il ne peut pas :

- recalculer ACL ;
- créer une route absente du ViewModel ;
- modifier l’état FSM directement ;
- traduire des textes applicatifs ;
- charger une configuration FSM supplémentaire.

## 10. Nettoyage

Les fichiers historiques suivants doivent être supprimés :

```text
sites/owasys/application/default/views/layout.php
sites/owasys/application/login/views/index.php
sites/owasys/application/account/views/index.php
sites/owasys/application/registry/views/index.php
```

Les répertoires `views` vides doivent également être supprimés.

## 11. Critères d’acceptation

1. le SVG est rendu ;
2. le fallback disparaît ;
3. chaque nœud autorisé possède un ancêtre SVG `<a>` ;
4. le nombre de liens égale le nombre de routes ;
5. clic, Entrée et Espace naviguent ;
6. la route conserve la locale active ;
7. un module exigeant une application courante reste soumis à FSM et ACL ;
8. aucune vue PHP HTML ne subsiste ;
9. le titre Mermaid est rendu par la directive i18n SCORE ;
10. login, compte, Registry, SSO, ACL et Registry SQLite ne régressent pas.
