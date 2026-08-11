# HANDOFF — OPUS P117W R45D2A16B DEV-SERVER SINGLE-OWNER BINDING

Date : 2026-08-11

## Base OPUS

`9330511436d2e3c40728d1d1bbc93ce15598aa8f` — `opus_p117w_r45d2a16_security_acl_matrix_alignment`

## Owner validation before this handoff

- R45D2A15B REST catalog sync : acquis ;
- R45D2A16 ACL matrix alignment : publié ;
- OWASYS-front 8000 : HTTP 200 ;
- OWASYS-back 8080 : deux listeners observés simultanément, connexion TCP acceptée mais aucun HTTP ;
- owner a supprimé les processus dupliqués avec Task Manager et souhaite continuer.

## Livrable R45D2A16B

`opus_p117w_r45d2a16b_dev_server_single_owner_binding.zip`

SHA-256 : `83f58506c632e901ff927bd1936ce639f6d6e36821bd0ccf9918f2ff27469717`

Contenu : applicateur + smoke. Correction générique dans `Opus/Console/Service/SiteCommandService.php` : refus d'un host/port déjà occupé avant RAZ diagnostics, log starting et `proc_open()`.

Erreur contractuelle :

`OPUS_DEV_SERVER_PORT_ALREADY_IN_USE:<host>:<port>`

## Gate owner

1. appliquer applicateur ;
2. smoke OK ;
3. démarrer `owasys-back` une fois ;
4. tenter un second `composer opus:dev-server -- owasys-back` ;
5. second démarrage refusé immédiatement ;
6. premier backend continue de répondre ;
7. redémarrer `owasys-front` ;
8. reprendre Sécurité `fresh-auth -> preview -> commit` avec matrice ACL : admin+developer mutation, viewer lecture seule, viewer sans Profiler.

NO SITE-SPECIFIC PATCH.
NO AUTO-KILL EXISTING PROCESS.
NO SILENT PORT FALLBACK.
NO ACL/FRESH-AUTH CHANGE IN R45D2A16B.
NO PUSH OPUS/OWASYS BY ASSISTANT.
