# MAESTRO_WORKSPACE_HANDOFF_20260614_P116C3B_REFBOOK_ZERO_FALLBACK_GUARD

## Statut

P116C3B est appliqué côté GitHub sur :

- `philstephibanez-wq/OPUS_REF_BOOK` branche `main`
- `philstephibanez-wq/MAESTRO_WORKSPACE` branche `master`

## Rappel identité

Framework actif : `OPUS Framework`.

Version cible : `8.1.0 Lysenko`.

`ASAP` est legacy uniquement. Aucun nouveau texte actif ne doit présenter ASAP comme nom vivant du framework.

## Objectif P116C3B

Consolider P116C3 avant P116C4 :

- vérifier que le chemin RefBook actif reste `.score` ;
- supprimer le dernier comportement ambigu assimilable à un fallback Twig -> Score ;
- documenter explicitement le smoke local encore à faire côté machine Windows/UwAmp ;
- garder la sécurité P117 en attente, sans mélanger les chantiers.

## Correction appliquée OPUS_REF_BOOK

### Fichier

`application/reference/Controller/AbstractRefBookController.php`

### Changement

Avant P116C3B, `view()` faisait encore :

```php
$template = str_replace('.twig', '.score', $template);
```

Ce comportement était un alias silencieux de migration : un appel `.twig` pouvait encore être accepté puis transformé en `.score`.

P116C3B remplace cela par :

```php
if (str_ends_with($template, '.twig')) {
    throw new RuntimeException('OPUS_REFBOOK_TWIG_TEMPLATE_FORBIDDEN=' . $template);
}

if (!str_ends_with($template, '.score')) {
    throw new RuntimeException('OPUS_REFBOOK_SCORE_TEMPLATE_REQUIRED=' . $template);
}
```

## Contrat renforcé

Le RefBook OPUS actif accepte uniquement des templates `.score`.

- Pas d'alias `.twig`.
- Pas de conversion silencieuse.
- Pas de fallback vers un autre moteur.
- Erreur explicite si un ancien appel Twig réapparaît.

## Commit OPUS_REF_BOOK

- `8392e99d1af3c3a5a89eb30d900a3b9ff1345696` — `P116C3B_FORBID_TWIG_TEMPLATE_ALIAS`

## Vérifications faites dans cette session

- Le README OPUS expose bien `Opus Framework 8.1.0 Lysenko`.
- OPUS_REF_BOOK README documente le pipeline `ScoreTemplateRenderer`.
- Le contrôleur RefBook interdit désormais explicitement `.twig`.
- Les pages connues P116C3 restent sous `application/reference/templates/pages/*.score`.

## Vérification locale encore obligatoire

Cette session n'a pas accès au runtime Windows/UwAmp local.

À vérifier côté machine utilisateur avant P116C4 :

1. home RefBook ;
2. recherche ;
3. API reference ;
4. domaine ;
5. symbole ;
6. guide ;
7. asset diagnostics ;
8. legal ;
9. download/install ;
10. 404 explicite ;
11. absence d'erreur `OPUS_REFBOOK_TWIG_TEMPLATE_FORBIDDEN` sur navigation normale.

## Prochaine étape recommandée

P116C4_LIVE_REFBOOK_RECIPE seulement après smoke local OK.

Si une page déclenche `OPUS_REFBOOK_TWIG_TEMPLATE_FORBIDDEN`, ne pas réintroduire d'alias : corriger le contrôleur ou service fautif pour appeler la vraie page `.score`.
