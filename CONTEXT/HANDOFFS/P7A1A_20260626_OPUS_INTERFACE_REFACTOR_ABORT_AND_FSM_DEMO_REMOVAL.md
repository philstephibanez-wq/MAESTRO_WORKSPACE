# HANDOFF — OPUS P7A1A abort propre + suppression FSM démo

## Date

2026-06-26

## Projet concerné

```text
OPUS local root : H:\OPUS
OPUS repo       : philstephibanez-wq/OPUS
Workspace repo  : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État Git OPUS au moment du handoff

Un commit local propre a été créé dans `H:\OPUS` :

```text
41a4d2b Remove demo FSM from OPUS framework
```

Statut local observé après commit :

```text
## master...origin/master [ahead 1]
```

Le commit OPUS doit être poussé côté OPUS si ce n'est pas encore fait :

```cmd
git push
```

## Décision validée

`Opus/Fsm/Fsm.php` a été supprimé volontairement.

Raison : le fichier était une FSM de démonstration, pas une brique framework OPUS propre.

Contenu supprimé :

```text
final class Fsm
{
    public function demoFlow(string $lang): array
    {
        BOOT -> PACKAGE_READY -> I18N_READY -> RENDER_READY -> DONE
    }
}
```

Cette suppression est une décision projet. Aucun run global ne doit restaurer `Opus/Fsm/Fsm.php`.

## Incidents P7A1A à ne pas reproduire

Les runs P7A1A3 à P7A1A9 sont invalidés et ne doivent pas être repris comme base.

Erreurs constatées :

```text
- génération d'interfaces génériques insuffisante ;
- interfaces générées sans implements dans les classes ;
- injection incorrecte de implements provoquant des parse errors ;
- génération par regex sauvage au lieu de tokenizer PHP ;
- faux OK avec CLASSES=0 ;
- création d'interfaces absurdes : andInterface.php, runtimeInterface.php, eMailInterface.php, ToolboxInterface.php, UserInterface.php ;
- suppression trop large de Opus\*Interface.php ayant supprimé deux vraies interfaces OPUS ;
- restauration nécessaire de Opus/Scaffold/ScaffoldPlanInterface.php et Opus/Score/TemplateRendererInterface.php ;
- HTML RefBook généré ou préparé hors pipeline OPUS clair ;
- noms administratifs non parlants : Opus/Contract/PerClass, tools/contracts ;
- tentative de créer Foundation/Support comme élément de contrat, refusée ;
- risque de restaurer la FSM démo supprimée via git restore automatique.
```

## Nettoyage effectué

Les artefacts P7A1A cassés ont été nettoyés côté local.

Les deux interfaces OPUS légitimes supprimées par erreur ont été restaurées :

```text
Opus/Scaffold/ScaffoldPlanInterface.php
Opus/Score/TemplateRendererInterface.php
```

État final propre côté OPUS avant commit :

```text
## master...origin/master
 D Opus/Fsm/Fsm.php
```

Puis commit local validé :

```text
41a4d2b Remove demo FSM from OPUS framework
```

## Règles bloquantes pour la prochaine reprise

Le prochain run doit être unique, lisible et strict.

```text
- partir du HEAD contenant la suppression de Opus/Fsm/Fsm.php ;
- ne jamais restaurer Opus/Fsm/Fsm.php ;
- ne jamais utiliser regex pour détecter les classes PHP ;
- utiliser token_get_all() ;
- détecter uniquement T_CLASS ;
- exclure T_INTERFACE ;
- exclure T_TRAIT ;
- exclure les classes anonymes ;
- ne jamais supprimer globalement *Interface.php ;
- ne jamais toucher les interfaces existantes sauf évolution explicite ;
- générer une interface voisine lisible uniquement pour les vraies classes concrètes ;
- refuser toute interface générée depuis un mot de méthode, variable, commentaire ou fragment interne ;
- aucun dossier Opus/Contract/PerClass ;
- aucun dossier tools/contracts ;
- aucune classe Foundation/Support créée ou détournée ;
- aucun faux OK si CLASSES=0 ;
- PHP lint global bloquant ;
- RefBook HTML généré par OPUS via templates .score, jamais par concaténation Python.
```

## Modèle de nommage attendu

Pour une classe moderne :

```text
Opus/Runtime/Application.php
Opus/Runtime/ApplicationInterface.php
```

Pour une classe legacy :

```text
Opus/Acl/Acl.class.php
Opus/Acl/AclInterface.php
```

La classe doit implémenter son interface voisine :

```php
final class Application implements ApplicationInterface
```

L'interface voisine doit étendre les contrats socle OPUS lisibles :

```php
interface ApplicationInterface extends
    OpusFrameworkComponentInterface,
    OpusExceptionAwareInterface,
    OpusProfilerAwareInterface,
    OpusSelfDocumentingInterface
{
}
```

## Contrat erreurs / exceptions / profiler

La cible reste :

```text
PHP warning / notice / deprecated / runtime error
-> exception OPUS contractuelle
-> normalisation Throwable
-> trace profiler multi-niveaux
-> RefBook / Profiler lisible
```

Les parse errors doivent être bloqués avant runtime :

```text
php -l global obligatoire
```

## Prochaine étape proposée

Nom de reprise :

```text
P7A1B_ONE_RUN_TOKENIZER_BASED_FRAMEWORK_INTERFACES
```

Objectif :

```text
- scanner réel via token_get_all ;
- interfaces voisines lisibles ;
- implements explicite par classe concrète ;
- contrats framework/profiler/exception/autodoc ;
- pipeline error -> exception -> profiler ;
- lint PHP global ;
- RefBook OPUS via templates .score ;
- aucun faux OK ;
- aucune restauration de la FSM démo.
```
