# OPUS P117U HF7R2 — DÉCISION I18N DES APPLICATIONS GÉNÉRÉES

Date : 2026-07-24  
Statut : décision owner obligatoire avant correction  
Base relue : `philstephibanez-wq/OPUS@79f261854ee06a9f828fec389adca77d57323d00` + différentiel HF7R1 appliqué localement

## 1. Objet

Contrôler la conformité I18n des applications générées par le framework OPUS après HF7R1.

Ce sujet est générique au framework. Aucune correction locale OWASYS n’est autorisée avant décision explicite d’évolution OPUS.

## 2. Écart confirmé

Le fichier réel du différentiel HF7R1 :

```text
Opus/Scaffold/SiteScaffoldPlan.php
```

génère actuellement dans `config/site.json` :

```text
default_locale : fr
locales        : fr, en, es
```

Il ne génère également que les catalogues `fr`, `en` et `es` dans :

```text
application/default/local/
application/<module>/local/
```

Le module OWASYS Creation contient bien 25 catalogues correspondant aux 24 langues officielles de l’Union européenne et à l’ukrainien, mais cette couverture n’est pas propagée aux applications créées par `SiteScaffoldPlan`.

## 3. Contrats concernés

Les applications OPUS doivent :

- détecter la locale initiale depuis `Accept-Language` du navigateur ;
- utiliser un fallback explicite et diagnostiqué ;
- proposer les langues configurées contractuellement ;
- ne pas réduire silencieusement une application générée à `fr/en/es` ;
- utiliser les services I18n du framework OPUS ;
- conserver SCORE, FSM, ACL, SSO, Logger et Profiler.

Le sélecteur OWASYS visible sur une capture avec `Français` indique uniquement la locale active. Une capture fermée ne prouve pas le nombre d’options disponibles. L’écart ici est fondé sur le contenu réel de `SiteScaffoldPlan.php`, pas sur une interprétation visuelle.

## 4. Nature de l’évolution

Cette correction relève du framework OPUS car elle affecte toutes les applications générées.

La solution locale suivante est interdite :

```text
ajouter 25 langues uniquement dans OWASYS ou dans chaque application après génération
```

La trajectoire contractuelle est officielles de l’Union européenne plus
l’ukrainien, avec locale primaire détectée depuis le navigateur et
fallback explicite diagnostiqué ?
```

Réponse attendue :

```text
OUI : préparer la spécification technique finale et le ZIP différentiel OPUS HF8.
NON : conserver le scaffold actuel fr/en/es ; aucune solution locale OWASYS ne sera ajoutée.
```

## 7. État des autres gates

Les trois captures et le journal backend continuent de valider :

- surface Applications active ;
- entrée Creation visible ;
- intégrité Registry verte ;
- Singleton vert ;
- OWASYS découvert ;
- `registry.sync` par REST sécurisé puis Composer ;
- Logger backend et corrélation `trace_id` actifs.

Les créations effectives `frontend`, `backend` et `fullstack` restent à tester après décision sur le contrat I18n du scaffold.
