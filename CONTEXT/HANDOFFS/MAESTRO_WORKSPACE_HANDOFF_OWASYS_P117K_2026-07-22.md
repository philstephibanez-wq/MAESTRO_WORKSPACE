# Handoff OWASYS / OPUS — P117K

**Date :** 2026-07-22  
**Dépôt code relu :** `philstephibanez-wq/OPUS`  
**Tête relue :** `9de67367c84bd1c0d55bc1351d08bd95a7c6b031` (`p117j odbc`)

## Demande

- rendre le schéma FSM OWASYS réellement cliquable ;
- vérifier l’implémentation du nouvel i18n ASAP-compatible et son intégration SCORE ;
- garantir que les pages OWASYS sont rendues par des templates `.score`, sans vues PHP mélangeant HTML et PHP ;
- conserver FSM, ACL et SSO comme chemin runtime unique.

## Relecture

Le jalon P117I est bien présent dans la tête relue :

- `Opus\I18n\ApplicationTranslationRuntime` construit le contexte global + module FSM actif ;
- `ScoreTemplateRenderer` accepte un `TranslationRuntimeInterface` ;
- la directive `[[ i18n: ... ]]` est parsée comme un nœud SCORE natif ;
- `OwasysScorePageRenderer` construit le runtime i18n avec `locale.code` et `fsm.module` ;
- `default/templates/layout.score` et les templates fonctionnels utilisent les directives SCORE i18n.

Le défaut Mermaid est dans le binding après rendu : le JavaScript recherche les nœuds par les IDs internes Mermaid `flowchart-<state>-...`. Ces IDs ne constituent pas un contrat stable. Lorsqu’un seul nœud n’est pas trouvé, le binding complet échoue, le SVG reste visible mais aucun nœud n’est navigable et le fallback reste affiché.

Des vues PHP historiques sont encore présentes alors qu’elles ne sont plus utilisées par le runtime SCORE :

- `sites/owasys/application/default/views/layout.php` ;
- `sites/owasys/application/login/views/index.php` ;
- `sites/owasys/application/account/views/index.php` ;
- `sites/owasys/application/registry/views/index.php`.

## Correctif P117K préparé

Archive :

```text
owasys_p117k_mermaid_native_links_score_only.zip
```

SHA-256 :

```text
de8edfb764088c37ddb2e8f82c872a8bc8e605ad7c68d37bcb2a20c9d2f0a0ee
```

Contenu :

- classe stable `owasys-fsm-state-<state>` émise dans la source Mermaid ;
- route map structurée `{url, node_class}` ;
- recherche du nœud par classe stable, attributs Mermaid, ID historique puis ordre contrôlé ;
- enveloppement de chaque nœud dans un vrai lien SVG `<a href>` ;
- navigation souris, Entrée et Espace ;
- focus visible et `pointer-events` explicites ;
- cache-busting P117K ;
- titre et fallback du diagramme traduits directement par `[[ i18n: navigation.main ]]` ;
- méthode `OwasysScorePageRenderer::emit()` écrivant le HTML SCORE dans `php://output` ;
- patch ciblé supprimant l’`echo` du contrôleur runtime.

## Nettoyage obligatoire

Supprimer les quatre vues PHP historiques listées ci-dessus, puis supprimer leurs répertoires `views` s’ils sont vides.

Le runtime doit conserver uniquement :

```text
application/default/templates/*.score
application/<module>/templates/*.score
```

Les contrôleurs, modèles et services restent en PHP mais ne doivent contenir aucun fragment de page HTML.

## Non-régressions

- FSM canonique inchangée ;
- routes et décisions ACL inchangées ;
- SSO inchangé ;
- Registry SQLite inchangé ;
- moteur i18n P117I inchangé ;
- Mermaid local OPUS inchangé ;
- aucun CDN ;
- aucun `Opus/Owasys` ;
- aucun smoke ou Markdown dans le ZIP runtime.

## Validation préparée

- syntaxe PHP des services remplacés ;
- syntaxe JavaScript ;
- présence des classes de nœuds stables ;
- présence des liens SVG natifs ;
- route map structurée ;
- patch RuntimeController applicable ;
- directive i18n SCORE présente dans le partial Mermaid.

La validation visuelle finale doit confirmer que le fallback disparaît et que chaque nœud autorisé par ACL navigue vers sa route localisée.