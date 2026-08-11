# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-11

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
5. `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A18D_SECURITY_WORKFLOW_ATOMIC_CONTRACT_2026-08-11.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A19_LOCAL_PASSWORD_BREAK_GLASS_RECOVERY_2026-08-11.md`
8. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A19B_ACCOUNT_I18N_COMPLETENESS_2026-08-11.md`
9. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A19B_ACCOUNT_I18N_COMPLETENESS_2026-08-11.md`
10. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
6f82ea0ad46eadd11435e02bc2dd1ff703034c02  opus_p117w_r45d2a18d_security_workflow_atomic_contract
d7226d4e0696319876b1bde69dbcfa9aa3feff3e  opus_p117w_r45d2a18c_fresh_auth_runtime_secret_policy
9d3c4d5463483cc520d381f7f8de83cfd5e352c4  opus_p117w_r45d2a18b_rest_composer_catalog_integrity
98b0233bf85f33037f45adde916514c6f8305a16  opus_p117w_r45d2a18_security_mutation_fsm
```

## États acquis

- login local-password acquis ;
- Profiler intégré/repliable et corrélation login acquise ;
- logout généré acquis ;
- matrice ACL admin/developer/viewer acquise ;
- dev-server single-owner acquis ;
- catalogues REST synchronisés ;
- intégrité REST -> Composer acquise ;
- secret fresh-auth dérivé automatiquement en dev acquis ;
- Security Mutation FSM atomiquement raccordée ;
- R45D2A18D publié ;
- admin Security Preview acquis ;
- admin Security Commit observé dans logs : `security.mutation commit.succeeded` avec REST/Composer 200 ;
- R45D2A19 break-glass : reset local-password vers mot de passe temporaire et `must_change_password=true` ;
- reconnexion avec temporaire acquise : redirection vers `/account/password` effectivement déclenchée.

## Incident actif

`/fr-FR/account/password` échoue au rendu avec :

```text
OPUS_I18N_MESSAGE_MISSING
```

Le log front confirme `Opus\I18n\TranslationException` sur la route account/password.

Cause vérifiée : `application/account/templates/index.score` exige des clés absentes des catalogues base, notamment :

- `menu.account`
- `auth.password.show`
- `auth.password.hide`

Les overlays régionaux comme `fr-FR.json` sont volontairement vides et héritent du catalogue base ; aucun fallback silencieux ne doit être ajouté.

## Livrable actif — R45D2A19B

```text
ZIP     : opus_p117w_r45d2a19b_account_i18n_completeness.zip
SHA-256 : 972ad4c38ebc22dfd5fa51c745c18db1d9452006377cb6f87ecb92046a221e67
FILES   : 2
```

R45D2A19B complète les catalogues account des 25 langues base et son smoke extrait toutes les directives I18n du SCORE account pour bloquer toute publication incomplète.

## Gate immédiat

1. appliquer R45D2A19B ;
2. smoke obligatoire ;
3. redémarrer owasys-front ;
4. se reconnecter avec le mot de passe temporaire ;
5. `/account/password` doit rendre sans `OPUS_I18N_MESSAGE_MISSING` ;
6. saisir temporaire + nouveau mot de passe + confirmation ;
7. changement réussi -> `/applications` ;
8. vérifier que l'ancien temporaire ne permet plus la connexion ;
9. reprendre Security admin si nécessaire puis developer ;
10. viewer : lecture seule, aucune mutation, aucun Profiler.

## Matrice ACL cible obligatoire

Permissions effectives uniquement. Admin + developer peuvent muter Sécurité. Viewer lecture seule et sans Profiler. Aucun `primary_role` comme autorité.

NO SILENT I18N FALLBACK.
NO BROWSER LOCAL-PASSWORD RESET WITHOUT VERIFIED RECOVERY CHANNEL.
NO PASSWORD IN ARGV/LOG/PROFILER.
NO FRESH-AUTH BYPASS.
NO PARTIAL CONTRACT PUBLICATION.
NO SITE-SPECIFIC HACK.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO CROSS-PHASE PROOF.
NO REST REPLAY STORE.
NO PUSH OPUS/OWASYS BY ASSISTANT.
