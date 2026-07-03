# OPUS - Site Standard Contract

Contrat : OPUS_SITE_STANDARD_CONTRACT_CORE

## Portee

Ce contrat est obligatoire pour tous les sites OPUS presents et futurs.

Aucun site OPUS ne doit utiliser une structure specifique improvisee.

## Structure canonique

sites/<site>/
  application/
    default/
      helpers/
      local/
      models/
      templates/
      views/

    <controller>/
      acl/
      helpers/
      javascript/
      local/
        <locale>/
      models/
      templates/
      views/

  config/

  www/
    index.php
    asset/
      css/
      js/
      themes/
        <theme>/

## Regles

- Le repertoire applicatif s'appelle application, pas src.
- Le repertoire web public s'appelle www, pas public.
- Les assets publics vont dans www/asset.
- Les css vont dans www/asset/css.
- Les js vont dans www/asset/js.
- Les themes vont dans www/asset/themes.
- application/default contient uniquement les parties communes, pas un fourre-tout.
- Chaque controller/fonctionnalite a son propre repertoire sous application.
- Chaque controller possede ses propres acl, helpers, javascript, local, models, templates et views si necessaire.
- Les templates et views appartiennent a OPUS, pas aux controllers en HTML concatene.
- L'i18n utilise OPUS local/i18n, pas un service local improvise.
- L'auth, admin, mot de passe, ACL et RBAC utilisent OPUS.
- La navigation utilise OPUS FSM/CL.

## OPUS Manager AMS

OPUS Manager est une application OPUS de type AMS.

Il doit respecter exactement ce contrat comme n'importe quel autre site OPUS.

OPUS, encore OPUS, rien qu'OPUS.
