# MAESTRO_WORKSPACE_HANDOFF_20260614_P116C3_REAL_SCORE_REFBOOK

## Statut

P116C3 est appliqué côté GitHub sur les dépôts :

- `philstephibanez-wq/OPUS_REF_BOOK` branche `main`
- `philstephibanez-wq/OPUS` branche `master`

## Décision d'identité

Le framework actif est OPUS Framework.

Version cible : `8.1.0 Lysenko`.

ASAP est un ancien nom historique. Il ne doit plus être utilisé comme identité active du framework.

## Objectif P116C3

Remplacer le RefBook rendu en PHP hardcodé par un chemin OPUS ScoreTemplate réel.

Contrat :

- les pages RefBook sont des fichiers `.score` réels ;
- le layout principal est `application/reference/templates/layout.score` ;
- les contenus de pages sont sous `application/reference/templates/pages/*.score` ;
- aucun fallback silencieux vers Twig ou un autre moteur ;
- aucun service ne doit reconstruire les pages RefBook en chaînes HTML hardcodées.

## Modifications OPUS_REF_BOOK

### Contrôleur de base

`application/reference/Controller/AbstractRefBookController.php`

- Retrait de la dépendance à `ReferenceScorePageRenderer`.
- Préparation du ViewModel commun conservée dans le contrôleur de base.
- Rendu du contenu de page via `TemplateRendererInterface::render($template, $data)`.
- Rendu final via `ViewModel('layout.score', $data, $status)`.

### Layout ScoreTemplate

`application/reference/templates/layout.score`

- Remplacé par un vrai shell OPUS RefBook : header, recherche, thèmes, langue, menu gauche, breadcrumb, contenu, footer.
- Le contenu de page est injecté en HTML déjà produit par ScoreTemplate.

### Pages ScoreTemplate ajoutées

- `application/reference/templates/pages/home.score`
- `application/reference/templates/pages/search.score`
- `application/reference/templates/pages/api-reference.score`
- `application/reference/templates/pages/domain.score`
- `application/reference/templates/pages/symbol.score`
- `application/reference/templates/pages/guide.score`
- `application/reference/templates/pages/asset-diagnostics.score`
- `application/reference/templates/pages/legal.score`
- `application/reference/templates/pages/download-install.score`
- `application/reference/templates/pages/not-found.score`

### Renderer PHP supprimé

`application/reference/Service/ReferenceScorePageRenderer.php` supprimé.

Ce service était le dernier gros résidu de rendu page hardcodé côté PHP.

### Navigation download/install

`application/reference/Controller/HomeController.php`

- Ajout du support `?page=download-install`.
- Sans cette correction, le lien du menu gauche pointait vers une 404 en navigation query-mode.

### Manifest release OPUS

`content/refbook/releases/opus.json`

- Aligné sur `8.1.0`.
- Ajout du codename `Lysenko`.
- Suppression de la dépendance de distribution à Twig.
- Exigence de template déclarée comme `Opus ScoreTemplate`.

### README OPUS_REF_BOOK

`README.md`

- Pipeline documenté avec `ScoreTemplateRenderer`.
- P116C3 explicite : `.score`, pas de Twig actif, pas de renderer PHP hardcodé.

## Modifications OPUS

`README.md`

- Titre aligné sur `Opus Framework 8.1.0 Lysenko`.
- ASAP marqué comme ancien nom historique, legacy uniquement.

## Commits principaux

OPUS_REF_BOOK :

- `93aeae30d9a1056bd0a5419a94d5b78e89f571aa` — route RefBook through Score templates
- `9a701aa13f5b70720bd9a39cb7f123c775219c70` — real RefBook layout.score
- `d6ef217710cc22dc1278c6323079ee07720e1a97` — home.score
- `f83b173dd104e09c3db6eee2935cb089dba0d924` — search.score
- `4dd8353fcd4ba9c264e7b794bac2db5135ffd9b6` — api-reference.score
- `086d3c6ffeed16047f901330fffdbcd60304a249` — domain.score
- `613308678d2c7777bf8e0530c1c5b88bd47d9df8` — symbol.score
- `4221341e4e12a5b636807c20788f35171d576604` — guide.score
- `c36680b7eefa713aade575ff48057c009c2f79e4` — asset-diagnostics.score
- `7635526be174a71b0ebedb5eefd1fa65a2094362` — legal.score
- `a764b54ee6779bd53d5996d55579a885d0d7137f` — download-install.score
- `08412ee0506d000f153ae840df01bb5d70ff4de1` — not-found.score
- `607a10eaf2142ec4f28608fb85b7361092287861` — README ScoreTemplate pipeline
- `c579bf24deca254da43af82cdf19b03e76441616` — OPUS release manifest 8.1.0 Lysenko
- `fea9fc5d1ce289e1ce06da25cf0130f4735b4a32` — remove hardcoded renderer
- `0c4f66b767e09830f570f8a8b50971e62fe58a07` — remove legacy home pipeline text
- `d9222897991c0e467cc476a9e61b1c786fef30f2` — route query download/install
- `c02bb41258d99ad0af1c2c929b3290ea20734383` — guard optional domain role

OPUS :

- `f62bc78c12237c6414a694779e7adb71e814d6c6` — align README identity

## Validation à faire côté machine locale

Depuis l'environnement Windows/UwAmp local, vérifier :

1. page home RefBook ;
2. recherche ;
3. API reference ;
4. un domaine ;
5. un symbole ;
6. guide ;
7. asset diagnostics ;
8. legal ;
9. download/install ;
10. 404 explicite.

## Risques connus

- Les fichiers i18n historiques peuvent encore contenir quelques libellés éditoriaux parlant de Twig dans les guides textuels. Le chemin actif ne dépend plus de Twig, mais une passe P116C3B pourra nettoyer les textes multilingues FR/EN/ES/DE/UK/IT/PL/CS.
- La validation runtime n'a pas été exécutée depuis l'environnement local UwAmp dans cette session.

## Prochaine étape recommandée

P116C3B : smoke local + nettoyage i18n legacy Twig/ASAP + ajustement CSS si le rendu ScoreTemplate brut demande des finitions.

Ensuite : P116C4_LIVE_REFBOOK_RECIPE.
