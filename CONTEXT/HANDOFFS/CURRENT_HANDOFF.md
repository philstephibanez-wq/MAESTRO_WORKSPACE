# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-31

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R44_TRANSACTIONAL_CREATION_ACCEPTANCE_2026-07-30.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R44C_OPAQUE_SCORE_SOURCE_RENDERING_2026-07-31.md
CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## État acquis

- R44C a été poussé par l'owner avec `test2` et le résultat fonctionnel est déclaré satisfaisant.
- La création fullstack anonyme fonctionne.
- Le rendu opaque des sources SCORE fonctionne.
- Les modes sont exactement `frontend`, `backend` et `fullstack`.
- `fullstack = frontend SCORE + backend REST`, soit une application client-serveur corrélée.
- Tout concept, profil, dossier ou runtime `shared` est interdit.
- Le contrat de création et de sécurité des ressources est maintenant canonique.

## Contrat de sécurité acquis

Le modèle obligatoire est :

`identité SSO -> attribution de rôle avec scope -> permissions -> ressource + action -> décision ACL backend`

- identité unique : `provider + subject` ;
- ressource canonique : `resource:<application_id>:<resource_type>:<resource_id>` ;
- permissions : `<resource_type>:<action>` ;
- scopes : application, type de ressource ou ressource précise ;
- `deny-by-default` et `deny` explicite prioritaire ;
- héritage uniquement lorsqu'il est déclaré par le type de ressource ;
- aucune création ni conservation de mot de passe SSO ;
- toute mutation de sécurité est prévisualisée, confirmée, atomique et auditée.

## Action suivante

Confronter l'implémentation OWASYS/OPUS existante à ce contrat avant toute évolution.

La future évolution doit fournir dans OWASYS :

1. un assistant de création cohérent pour `frontend`, `backend` et `fullstack` ;
2. les étapes rôles, permissions, ressources/ACL et identités ;
3. l'espace Sécurité en cinq vues : Identités, Rôles, Permissions, Attributions, Ressources et ACL ;
4. le calcul de l'autorisation effective côté backend ;
5. les protections du dernier administrateur, de concurrence, de réauthentification et d'audit.

Aucun code OPUS/OWASYS ne doit être écrit avant audit du HEAD owner et identification des écarts réels. Tout besoin générique de sécurité doit être traité dans OPUS avant une adaptation OWASYS.

## Autorité

```text
Assistant : MAESTRO_WORKSPACE + ZIP différentiel
Owner : application, validation, commit et push OPUS/OWASYS
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
FRONTEND, BACKEND OU FULLSTACK — JAMAIS SHARED.
