# OPUS P117W R41 — acceptation de la création fullstack depuis OWASYS

Date : 2026-07-30  
Base OPUS owner : `a93d9dd11d76fd17e4444ddb32c086d71cd74521`  
Statut : recette owner active, sans patch préalable.

## Point de départ confirmé

R40 a supprimé le site layered obsolète `sites/demo-opus`. Le Registry synchronise désormais uniquement :

```text
sites/owasys-front
sites/owasys-back
```

Le générateur actif utilise `SiteCommandService` et `SiteScaffoldPlan`. Il produit les trois profils `frontend`, `backend` et `fullstack` sous le contrat plat :

```text
sites/<application-id>/application
sites/<application-id>/config
sites/<application-id>/www
```

Les répertoires layered `application/shared`, `application/front` et `application/back` restent interdits.

## Objectif

Créer depuis l’interface OWASYS un nouveau site de profil `fullstack`, conserver ce site comme nouvelle base applicative et démontrer le flux complet :

```text
owasys-front
-> REST sécurisé
-> owasys-back
-> Composer opus:create-site
-> scaffold OPUS autonome
-> registry.sync
-> sélection du nouveau site
-> Construction
```

L’identifiant est choisi par l’owner dans le formulaire. Aucun identifiant de test n’est imposé par le workspace.

## Critères d’acceptation

- création lancée depuis `/fr-FR/applications/new` ;
- profil `fullstack` explicitement sélectionné ;
- racine créée exactement sous `sites/<application-id>` ;
- `config/site.json` déclare `OPUS_SITE_STANDARD_CONTRACT_CORE`, `generated-opus-application` et le profil `fullstack` ;
- aucun `application_layers` ni répertoire layered ;
- Singleton, FSM, I18n, ACL deny-by-default, SSO, SCORE, Logger et Profiler présents ;
- 24 langues officielles de l’Union européenne plus l’ukrainien ;
- locale initiale négociée depuis le navigateur, fallback français explicite ;
- site immédiatement présent et sélectionné dans le Registry ;
- redirection finale vers Construction ;
- même `trace_id` corrélable du frontend à Composer et au Registry ;
- `composer opus:validate-site -- <application-id>` réussi ;
- aucun changement direct de fichiers par le frontend ;
- aucun JavaScript, TypeScript ou runtime Node dans `sites/owasys-back`.

## Politique de correction

Aucun patch OPUS/OWASYS n’est préparé avant l’essai owner. En cas d’échec, traiter la première cause contractuelle prouvée par les logs/profiler corrélés, puis livrer uniquement un ZIP différentiel fondé sur le HEAD owner exact.

Ne pas supprimer le nouveau site après succès : il devient la nouvelle base fullstack à développer.

NO SHARED LAYER.  
NO FALLBACK SILENCIEUX.  
TOUJOURS TRAITER LA CAUSE.
