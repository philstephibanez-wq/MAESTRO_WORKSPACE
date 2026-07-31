# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-31.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R42 : serveur de développement générique appliqué.
- R43 : assistant transactionnel appliqué et poussé.
- R44A : diagnostics de validation livrés.
- R44B : choix obligatoire frontend/backend/fullstack restauré.
- R44C : poussé par l'owner avec `test2` ; création fullstack anonyme et ouverture des sources SCORE déclarées fonctionnelles.
- La lecture REST et le rendu opaque des sources SCORE sont acquis.

## Décision architecturale définitive

OWASYS crée exactement :

- `frontend` : client SCORE relié à un backend existant ;
- `backend` : API REST et services sécurisés sans interface SCORE ;
- `fullstack` : frontend SCORE + backend REST corrélés, formant une application client-serveur.

Aucun `shared` n'existe dans le profil, l'arborescence ou le runtime. Les capacités communes viennent du framework OPUS.

## Contrat utilisateurs, droits et ressources

Contrat canonique :

`CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`

Association obligatoire :

`identité SSO -> rôle dans un scope -> permissions -> ressource + action -> ACL backend`

Points fixes :

- identité `provider + subject`, sans mot de passe SSO stocké ;
- ressource stable `resource:<application_id>:<resource_type>:<resource_id>` ;
- permission `<resource_type>:<action>` ;
- portée application, type de ressource ou ressource précise ;
- refus par défaut et `deny` explicite prioritaire ;
- héritage seulement déclaré ;
- exceptions nominatives rares, motivées et auditées ;
- contrôle décisif backend ;
- aperçu, confirmation, écriture atomique et audit ;
- dernier administrateur protégé.

## Action active

Auditer l'implémentation OPUS/OWASYS au HEAD owner contre le nouveau contrat, puis spécifier le différentiel générique requis avant toute modification de code.

L'espace Sécurité cible comporte : Identités, Rôles, Permissions, Attributions, Ressources et ACL.

## Invariants

- toute mutation OWASYS traverse REST sécurisé puis Composer ;
- SCORE uniquement pour l'interface ;
- backend OWASYS sans JavaScript ;
- Singleton, FSM, I18n, SSO et ACL `deny-by-default` ;
- Logger/Profiler corrélés sans secret ;
- aucune solution locale à un besoin générique OPUS sans décision owner ;
- l'assistant ne committe ni ne pousse OPUS/OWASYS.
