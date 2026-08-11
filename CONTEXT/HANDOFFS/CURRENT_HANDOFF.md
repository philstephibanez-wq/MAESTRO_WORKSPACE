# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-11

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
5. `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A14B_LOGOUT_ATOMIC_MIGRATION_2026-08-11.md`
7. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A14B_LOGOUT_ATOMIC_MIGRATION_2026-08-11.md`
8. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
a3f5b2257628d5b6ea0c98ba92178b4fe51030b2  opus_p117w_r45d2a14b_logout_atomic_migration
f195471557727d23d0be036b80382f3ba3ad9787  opus_p117w_r45d2a14_generated_logout
186517fd37c14047e33308500d0699b8ac36ab44  opus_p117w_r45d2a12_source_acl_ui_truth
```

## États owner acquis

- `essai2/steve` : connexion réussie ;
- reset local-password : acquis ;
- message login I18n : acquis ;
- Profiler intégré/repliable + corrélation login : acquis ;
- R45D2A12 : UI Sources/Git alignée sur ACL `source/write` et publiée ;
- R45D2A14B : `/fr` authentifié fonctionne et `Déconnexion` est visible ;
- capture owner du 2026-08-11 valide le rendu sain après migration logout atomique.

## Matrice ACL cible obligatoire

La progression suivante est désormais contractuelle et doit être validée à chaque évolution ACL/UI :

| Page / action | admin | developer | viewer |
| --- | ---: | ---: | ---: |
| Applications : ouvrir | ✅ | ✅ | ✅ |
| Sélectionner une application | ✅ | ✅ | ✅ |
| Changer d'application | ✅ | ✅ | ✅ |
| Créer une application | ✅ | ✅ | ❌ bouton absent |
| Supprimer une application générée | ✅ | ✅ | ❌ bouton absent |
| Structure | ✅ | ✅ | ✅ lecture |
| Sources de données | ✅ | ✅ | ✅ lecture |
| Workflows | ✅ | ✅ | ✅ lecture |
| Sécurité | ✅ | ✅ | ✅ lecture |
| Sources et Git : ouvrir/lire fichiers | ✅ | ✅ | ✅ |
| Modifier une source | ✅ | ✅ | ❌ |
| Preview source | ✅ | ✅ | ❌ |
| Stage fichier | ✅ | ✅ | ❌ |
| Stage all | ✅ | ✅ | ❌ |
| Unstage | ✅ | ✅ | ❌ |
| Commit | ✅ | ✅ | ❌ |
| Restore | ✅ | ✅ | ❌ |
| Construction / validation | ✅ | ✅ | ✅ lecture |
| Compte : changer son mot de passe local | ✅ | ✅ | ✅ |
| Profiler | ✅ | ✅ | ❌ |

Règle : capacités fondées sur permissions ACL effectives, jamais sur `primary_role` seul. Backend décisif, UI alignée, deny-by-default.

## Prochain bloc actif

Reprendre le workflow Sécurité OWASYS :

`requested -> authenticated -> authorized -> validated -> previewed -> confirmed -> committed|rejected|rolled_back`

Défaut de fond à traiter : la preuve `fresh-auth` doit être non forgeable et corrélée au backend. Le frontend ne doit pas pouvoir faire foi avec un simple timestamp déclaratif. Toute mutation sensible doit conserver : ACL, CSRF, réauthentification réelle, aperçu, confirmation, ETag/version, transaction/rollback et audit Logger/Profiler corrélé.

## Gate immédiat suivant

1. auditer le flux `owasys-front -> REST -> owasys-back` de preview/commit sécurité ;
2. vérifier l'autorité effective de la preuve fresh-auth côté backend ;
3. introduire une preuve courte durée émise/validée côté backend, liée à l'acteur et à l'opération ;
4. ne jamais transporter ni journaliser le mot de passe de réauthentification ;
5. ajouter tests de refus : preuve absente, expirée, altérée, acteur différent, opération différente ;
6. préserver la matrice ACL ci-dessus.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO GET LOGOUT.
NO SSO/ACL RELAXATION.
NO PRIMARY_ROLE AUTHORIZATION.
NO PUSH OPUS/OWASYS BY ASSISTANT.
