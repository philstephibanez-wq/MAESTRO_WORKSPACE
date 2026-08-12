# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-13

## Lire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
5. `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A18D_SECURITY_WORKFLOW_ATOMIC_CONTRACT_2026-08-11.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A19D_CREDENTIAL_OWNERSHIP_ATOMIC_CLEANUP_2026-08-11.md`
8. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A20_STANDARD_LOCAL_PASSWORD_ROLE_PROVISIONING_2026-08-11.md`
9. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A21_SECURITY_VISUAL_WORKSPACE_2026-08-12.md`
10. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A21B_SECURITY_VISUAL_DASHBOARD_2026-08-13.md`
11. `CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45D2A21B_SECURITY_VISUAL_DASHBOARD_2026-08-13.md`
12. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## OPUS GitHub courant

```text
50d68b724a1f32201bd068e0cb23c9f925780093  opus_p117w_r45d2a20_standard_local_password_role_provisioning
38a053d585bfd0b154183a5ad7b043504634c043  opus_p117w_r45d2a19d_credential_ownership_atomic_cleanup
1908e9ae4e28d599855b5e8d1e424a6c335d0507  opus_p117w_r45d2a19c_local_password_credential_ownership
```

## États owner acquis

- login local-password acquis ;
- Profiler intégré/repliable et corrélé ;
- logout généré acquis ;
- matrice ACL admin/developer/viewer contractuelle ;
- dev-server single-owner acquis ;
- catalogues REST/fresh-auth/Security Mutation FSM acquis ;
- admin Security Preview + Commit acquis ;
- break-glass local-password et changement forcé de mot de passe acquis ;
- aucun mot de passe local ne traverse REST ;
- R45D2A19D publié : ancien flux backend password supprimé atomiquement ;
- R45D2A20 publié : provisioning local-password par rôle pour application OPUS standard ;
- compte `developer` opérationnel ;
- developer Security Preview + Commit acquis ;
- R45D2A21 appliqué localement : typage explicite `user|agent` et accordéons fonctionnels.

## Retour owner R45D2A21

Le résultat visuel R45D2A21 est **refusé comme insuffisant** (« pas terrible »).

Défauts observés :

- trop de cadres/accordéons imbriqués ;
- trop d’espace vide ;
- `À classifier` trop dominant ;
- action Ajouter trop basse ;
- détails provider/status/source trop présents ;
- message FSM technique trop dominant ;
- manque de vraie hiérarchie de cockpit graphique.

Le modèle sécurité reste valide. Ne pas revenir sur `identity_type` ni sur le flow ressource.

## Livrable actif — R45D2A21B

```text
ZIP     : opus_p117w_r45d2a21b_security_visual_dashboard.zip
SHA-256 : 0ccf2e5d71260dc3917bbc79aab39f817cb4a4bbd5266d3a02707b2de616cca6
PREREQ  : R45D2A21 appliqué
FILES   : 3
```

R45D2A21B apporte :

- dashboard compact de sécurité ;
- compteurs Utilisateurs / Agents / Rôles / Ressources ;
- schéma compact `Utilisateur/Agent -> Attribution -> Rôle -> Permission -> Ressource/ACL` ;
- CTA « Ajouter un utilisateur ou un agent » en premier niveau ;
- sélecteur visuel Utilisateur/Agent sans JS ;
- panneaux Utilisateurs et Agents séparés ;
- détails techniques repliés ;
- `À classifier` compact et secondaire ;
- compteurs sur accordéons techniques ;
- explication utilisateur de `OWASYS_SECURITY_MUTATION_WORKFLOW_STATE_INVALID` sans supprimer la garde FSM ;
- I18n UE + ukrainien.

## Gate immédiat

1. extraire R45D2A21B après R45D2A21 ;
2. lancer l’applicator ;
3. exiger `OPUS_R45D2A21B_APPLIED locales=25` ;
4. lancer le smoke ;
5. exiger `OPUS_R45D2A21B_SMOKE_OK locales=25` ;
6. linter `SecurityController.php` ;
7. `composer dump-autoload -o` ;
8. vérifier `git status --short` ;
9. redémarrer front/back ;
10. ouvrir Sécurité comme developer ;
11. juger d’abord la qualité visuelle avant toute nouvelle fonction.

## Suite seulement après validation visuelle

1. gate viewer de la matrice ACL ;
2. smoke exécutable admin/developer/viewer front+back ;
3. mutations backend Modifier/Supprimer utilisateur ou agent ;
4. seulement ensuite exposer les boutons correspondants.

NO HARDCODED ACCOUNT.
NO MANUAL STORE EDIT.
NO PASSWORD IN ARGV/GIT/LOG/PROFILER.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PRIMARY_ROLE AUTHORIZATION.
NO IDENTITY TYPE INFERENCE.
NO MERMAID/JS RUNTIME IN OWASYS.
NO FAKE MODIFY/DELETE BUTTON.
NO PUSH OPUS/OWASYS BY ASSISTANT.
