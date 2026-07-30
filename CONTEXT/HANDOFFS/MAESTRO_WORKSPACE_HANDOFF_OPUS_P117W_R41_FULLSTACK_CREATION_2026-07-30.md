# MAESTRO WORKSPACE — Handoff OPUS P117W R41

Date : 2026-07-30

## Source canonique

```text
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE master
OPUS      : philstephibanez-wq/OPUS master
OPUS HEAD : a93d9dd11d76fd17e4444ddb32c086d71cd74521
```

R40 est appliqué : `sites/demo-opus` est supprimé, les validations OWASYS et `registry-sync` réussissent.

## Action active

Créer depuis OWASYS un nouveau site de profil `fullstack`. Ce site n’est pas un remplacement de `owasys-front` ou `owasys-back` : c’est une application OPUS autonome générée sous `sites/<application-id>`.

Le site créé avec succès est conservé comme base du développement suivant.

## Flux obligatoire

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer opus:create-site
-> registry.sync -> sélection -> Construction
```

## Acceptation owner

1. lancer `owasys-back` et `owasys-front` ;
2. ouvrir `/fr-FR/applications/new` ;
3. saisir l’identifiant choisi et sélectionner `Fullstack` ;
4. créer l’application ;
5. vérifier l’arrivée sur Construction et la sélection du nouveau site ;
6. valider le site avec la commande OPUS ;
7. conserver la racine créée.

Aucun patch n’est actif avant ce test. En cas d’échec, transmettre uniquement les logs et profiler du `trace_id` concerné ; les fichiers versionnés seront lus directement sur GitHub.

## Invariants

- application plate : `application`, `config`, `www` ;
- aucune couche `shared/front/back` imbriquée ;
- Singleton, FSM, I18n UE + ukrainien, ACL deny-by-default, SSO, SCORE ;
- Logger et Profiler obligatoires ;
- aucune mutation métier directe depuis le frontend ;
- backend OWASYS exclusivement PHP.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
