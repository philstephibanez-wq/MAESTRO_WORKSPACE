# HANDOFF — OPUS P117W R45D2A18 Security Mutation FSM

Date : 2026-08-11

## Acquis

- R45D2A14B logout généré acquis.
- R45D2A15 fresh-auth backend non forgeable publié.
- R45D2A15B catalogues REST synchronisés, mismatch supprimé.
- R45D2A16 matrice admin/developer/viewer publiée.
- R45D2A16B single-owner dev-server validé localement : second lancement refusé.
- R45D2A17 fresh-auth lié à `preview|commit` préparé/appliqué localement ; logs reçus ensuite montrent `GET /fr-FR/security` et backend `security.snapshot` REST->Composer 200 corrélé.

## Défaut traité par R45D2A18

La mutation Sécurité restait pilotée procéduralement dans `SecurityController`; la FSM principale ne connaît que l'ouverture de la page Sécurité.

## R45D2A18

Ajoute une FSM dédiée de mutation Sécurité :

`idle -> requested -> authenticated -> authorized -> validated -> previewed -> confirmed -> committed`

Branches : `rejected` et `rolled_back`.

Persistence entre preview et commit : `FsmSessionStore` côté front. Binding : site, mutation+reason, vue. Aucun secret ni preuve fresh-auth stocké.

## Gate immédiat

1. appliquer R45D2A18 ;
2. smoke + lint + autoload ;
3. admin : preview puis commit ;
4. contrôler Logger/Profiler : transitions FSM réelles, corrélation front/back, aucun secret ;
5. developer : même workflow ;
6. viewer : lecture Sécurité seulement ;
7. owner commit/push OPUS uniquement après validation.

NO SITE-SPECIFIC PATCH.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PASSWORD/PROOF IN FSM MEMORY OR LOGS.
NO REST REPLAY STORE.
NO PUSH OPUS/OWASYS BY ASSISTANT.
