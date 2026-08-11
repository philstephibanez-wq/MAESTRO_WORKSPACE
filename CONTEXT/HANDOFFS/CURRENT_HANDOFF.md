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
8. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A19_LOCAL_PASSWORD_BREAK_GLASS_RECOVERY_2026-08-11.md`
9. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
6f82ea0ad46eadd11435e02bc2dd1ff703034c02  opus_p117w_r45d2a18d_security_workflow_atomic_contract
d7226d4e0696319876b1bde69dbcfa9aa3feff3e  opus_p117w_r45d2a18c_fresh_auth_runtime_secret_policy
9d3c4d5463483cc520d381f7f8de83cfd5e352c4  opus_p117w_r45d2a18b_rest_composer_catalog_integrity
98b0233bf85f33037f45adde916514c6f8305a16  opus_p117w_r45d2a18_security_mutation_fsm
```

## États acquis

- login local-password acquis ;
- reset local-password historique pour sites générés acquis ;
- Profiler intégré/repliable et corrélation login acquise ;
- logout généré acquis ;
- matrice ACL admin/developer/viewer acquise ;
- dev-server single-owner acquis ;
- catalogues REST synchronisés ;
- intégrité REST -> Composer acquise ;
- secret fresh-auth dérivé automatiquement en dev acquis ;
- Security Mutation FSM atomiquement raccordée ;
- `security.snapshot` passe front -> REST -> back -> Composer en HTTP 200 ;
- R45D2A18D publié ;
- admin Security Preview acquis : l'aperçu de mutation est visible, aucune écriture n'a encore été effectuée.

## Question traitée

Si le mot de passe OWASYS `local-password` est oublié, la fresh-auth ne doit jamais être contournée. Il n'existe pas de canal browser recovery vérifié dans le contrat actuel.

Décision :

- `local-password` : récupération break-glass opérateur via console serveur ;
- mot de passe temporaire uniquement par STDIN ;
- `must_change_password=true` ;
- prochaine connexion -> FSM `password_change_required` -> `/account/password` ;
- remplacement obligatoire du temporaire ;
- `auth0-proxy` : récupération chez l'IdP/Auth0.

## Livrable actif — R45D2A19

```text
ZIP     : opus_p117w_r45d2a19_local_password_break_glass_recovery.zip
SHA-256 : 59614da089f0b8736823dc1159c3f793424538de0b866c231a06168b6333ecab
BASE    : 6f82ea0ad46eadd11435e02bc2dd1ff703034c02
FILES   : 4
```

R45D2A19 généralise `opus:local-password-reset` aux applications OPUS standard à provider local-password et ajoute `--must-change`, tout en conservant la compatibilité avec les sites générés.

## Gate immédiat

1. appliquer R45D2A19 ;
2. lints + smoke obligatoire ;
3. dump-autoload/status ;
4. test recovery uniquement si souhaité ;
5. revenir à l'aperçu R45D2A18D ;
6. saisir de nouveau le mot de passe OWASYS ;
7. `Confirmer et écrire` doit effectuer Commit ;
8. contrôler FSM + REST + Composer corrélés sans secret ;
9. developer : même workflow ;
10. viewer : lecture seule, aucune mutation, aucun Profiler.

## Matrice ACL cible obligatoire

Permissions effectives uniquement. Admin + developer peuvent muter Sécurité. Viewer lecture seule et sans Profiler. Aucun `primary_role` comme autorité.

NO BROWSER LOCAL-PASSWORD RESET WITHOUT VERIFIED RECOVERY CHANNEL.
NO PASSWORD IN ARGV/LOG/PROFILER.
NO FRESH-AUTH BYPASS.
NO PARTIAL CONTRACT PUBLICATION.
NO SITE-SPECIFIC HACK.
NO SILENT FALLBACK.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO CROSS-PHASE PROOF.
NO REST REPLAY STORE.
NO PUSH OPUS/OWASYS BY ASSISTANT.
