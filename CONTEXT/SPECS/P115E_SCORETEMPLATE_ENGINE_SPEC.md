# P115E — OPUS ScoreTemplate Engine — Palier 1 MVC

ScoreTemplate appartient à OPUS.

.score appartient à OPUS.

MVC est l'architecture OPUS.

ScoreTemplate est la couche View du MVC OPUS.

Le jalon se nomme Palier 1 MVC.

Namespace cible : Opus/View/ScoreTemplate.

Règles :

- aucun fallback silencieux ;
- aucune logique métier dans la vue ;
- séparation stricte data, traitement, représentation ;
- diagnostics explicites ;
- templates .score ;
- RefBook doit rendre avec .score OPUS.

Classes cibles :

- Opus/View/ScoreTemplate/ScoreTemplateEngine
- Opus/View/ScoreTemplate/ScoreTemplateRenderer
- Opus/View/ScoreTemplate/ScoreTemplateParser
- Opus/View/ScoreTemplate/ScoreTemplateLoader
- Opus/View/ScoreTemplate/ScoreTemplateContext
- Opus/View/ScoreTemplate/ScoreTemplateFilterRegistry
- Opus/View/ScoreTemplate/ScoreTemplateDebugTrace
- Opus/View/ScoreTemplate/ScoreTemplateException
