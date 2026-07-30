# OPUS P117W R44 — acceptation du workflow de création transactionnel OWASYS

Date : 2026-07-30  
Base OPUS owner : `63470fb43c4b692eea2d7db2c0be5f6086008d1a`  
Statut : recette owner active.

## État acquis

R43 a été poussé par l’owner dans OPUS avec exactement 39 fichiers au commit `63470fb43c4b692eea2d7db2c0be5f6086008d1a`.

## Objet

Valider le workflow réel :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer
```

L’assistant doit parcourir `basics -> security -> review` sans mutation avant confirmation.

## Cas d’acceptation

Créer depuis `/fr-FR/applications/new` un nouveau site fullstack avec un identifiant neuf.

Vérifier :

- page d’accueil unique ;
- page de connexion uniquement lorsqu’elle est demandée ;
- 24 langues officielles de l’Union européenne plus ukrainien ;
- route, FSM, SCORE, ACL deny-by-default, SSO, Logger et Profiler cohérents ;
- journal `var/logs/<site-id>.log` ;
- aucune page ni aucun module technique préfabriqué ;
- Registry synchronisé après création ;
- aucune scorie si la création ou la synchronisation échoue ;
- validation du site par Composer.

## Autorité

L’owner exécute la recette sur `H:\OPUS`. Toute non-conformité constatée ouvre un correctif générique suivant, sans modification manuelle du site généré.

NO FALLBACK SILENCIEUX.  
TOUJOURS TRAITER LA CAUSE.  
NO PARTIAL SITE.
