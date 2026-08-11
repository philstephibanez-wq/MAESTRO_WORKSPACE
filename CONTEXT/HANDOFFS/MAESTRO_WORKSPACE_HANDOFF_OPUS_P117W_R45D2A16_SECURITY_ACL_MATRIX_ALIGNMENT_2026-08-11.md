# HANDOFF — OPUS P117W R45D2A16 SECURITY ACL MATRIX ALIGNMENT

Date : 2026-08-11

## Base OPUS publiée

`8b70be74bb83da3f528a0d0e3e2bf74663205fa0` — `opus_p117w_r45d2a15b_rest_catalog_atomic_sync`

## État acquis

- R45D2A15 fresh-auth backend non forgeable publié ;
- R45D2A15B synchronisation atomique des catalogues REST publiée et validée owner ;
- `/fr-FR/applications` fonctionne à nouveau ;
- matrice ACL contractuelle conservée dans `OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`.

## Défaut traité

La page Sécurité cible une capacité complète pour `admin` et `developer`, avec `viewer` lecture seule. Le master courant ne permet pourtant au developer que `security:open` côté front, `security:read` côté back et le bloque encore dans les allow-lists REST sensibles.

## Livrable R45D2A16

`opus_p117w_r45d2a16_security_acl_matrix_alignment.zip`

SHA-256 : `e60f750bc8e744a3f027240a37c5344cf563c6455e13de0b8d6ee2e094e9817f`

Contenu :

- `tools/r45d2a16_apply_security_acl_matrix_alignment.php`
- `tools/smoke_r45d2a16_security_acl_matrix_alignment.php`

Correction appliquée par l'applicateur :

- owasys-front developer -> `security:*` ;
- owasys-back developer -> `security:*` ;
- `security.fresh-auth-proof.issue`, `security.mutation.preview`, `security.mutation.commit` -> rôles `[admin, developer]` ;
- viewer inchangé et lecture seule.

## Gate owner

1. extraire ZIP dans `H:\OPUS` ;
2. exécuter applicateur ;
3. exécuter smoke ;
4. vérifier `git status --short` ;
5. redémarrer back puis front ;
6. tester Sécurité avec admin puis developer ;
7. vérifier viewer lecture seule + Profiler absent ;
8. reprendre fresh-auth -> preview -> commit.

NO ACL BYPASS.
NO PRIMARY_ROLE AUTHORIZATION.
NO VIEWER MUTATION.
NO PROFILER FOR VIEWER.
NO PASSWORD IN LOG/PROFILER/ARGV.
NO PUSH OPUS/OWASYS BY ASSISTANT.
