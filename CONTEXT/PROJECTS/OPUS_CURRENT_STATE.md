# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-31.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner audité : 7dbceea
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R42 : serveur de développement générique appliqué.
- R43 : assistant transactionnel appliqué.
- R44C : poussé avec `test2` ; transaction de création et rendu opaque SCORE acquis.
- `test2` est déclaré `frontend` et reste un témoin non modifiable.
- Audit canonique R45 publié.

## Architecture définitive

- `frontend` : client SCORE vers un backend existant ;
- `backend` : API REST/services sécurisés, sans SCORE ni JavaScript ;
- `fullstack` : frontend SCORE + backend REST dans le même site, même déploiement et même serveur par défaut, avec frontière REST obligatoire ;
- jamais de `shared`.

## Sécurité définitive

`identité SSO -> attribution de rôle scopée -> permissions CRUD/métier -> ressource + action -> décision ACL backend`

- identité : `provider + subject` ;
- ressource : `resource:<application_id>:<resource_type>:<resource_id>` ;
- permission : `<resource_type>:<action>` ;
- scopes : application, type de ressource, ressource ;
- deny-by-default et tout deny explicite prioritaire ;
- héritage seulement déclaré ;
- dernier administrateur protégé ;
- aperçu, confirmation, atomicité, concurrence et audit.

## Audit R45

Non-conformités confirmées au HEAD `7dbceea` :

- profils insuffisamment différenciés par `SiteScaffoldPlan` ;
- backend généré avec présentation SCORE ;
- frontend sans backend cible contractuel ;
- fullstack sans corrélation REST ;
- ACL générée simplifiée, non compatible avec le moteur riche ;
- permissions non reliées aux rôles/ressources/scopes ;
- moteur ACL « dernière règle gagnante », contraire à la priorité du deny ;
- lecture directe de configuration dans `ConfigAclPolicy`.

Audit : `CONTEXT/AUDITS/OPUS_P117W_R45_GENERATION_AND_RESOURCE_SECURITY_AUDIT_2026-07-31.md`.

## Action active

GO R45A : évolution générique du moteur et des contrats de sécurité OPUS uniquement.

R45B (scaffold), R45C (wizard) et R45D (administration Sécurité) attendent l'acceptation owner de R45A.

## Invariants

- aucune correction de `sites/test2` ;
- toute mutation OWASYS traverse REST sécurisé puis Composer ;
- SCORE uniquement pour toute interface ;
- backend sans JavaScript ;
- Singleton, FSM, I18n, SSO, ACL deny-by-default ;
- Logger/Profiler corrélés sans secret ;
- toute classe concrète OPUS implémente son interface homonyme aux quatre marqueurs ;
- l'assistant livre OPUS/OWASYS en ZIP différentiel et ne les pousse pas.
