# HANDOFF — OPUS P117W R45D2A17 Fresh-auth phase binding

Date : 2026-08-11

## État acquis avant R45D2A17

- R45D2A14B logout généré acquis.
- R45D2A15 fresh-auth backend HMAC publié.
- R45D2A15B catalogues REST synchronisés et publié.
- R45D2A16 matrice Sécurité admin/developer/viewer publiée sous `9330511436d2e3c40728d1d1bbc93ce15598aa8f`.
- R45D2A16B appliqué/validé localement : un second `owasys-back` est refusé avec `OPUS_DEV_SERVER_PORT_ALREADY_IN_USE`; pas encore visible sur GitHub lors du handoff.

## Défaut actif

La preuve fresh-auth signée est liée à l'acteur, au site et au hash de mutation mais son claim `operation` reste générique `security.mutation`. Elle ne sépare donc pas cryptographiquement `preview` et `commit`.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a17_fresh_auth_phase_binding.zip
SHA-256 : a216a0619d69eab274aaca54bc21ea7a4ff7a92b35fc891c2e6fecf590abbcb7
BASE    : 9330511436d2e3c40728d1d1bbc93ce15598aa8f + R45D2A16B local validé
FILES   : 2
```

Correction : phase `preview|commit` introduite dans émission et validation fresh-auth, avec claims HMAC `operation=security.mutation.<phase>` et `phase=<phase>`. Le front transmet la phase déjà validée. Le backend exige la phase dans l'opération REST d'émission.

## Gate owner

1. appliquer ZIP ;
2. `php tools\r45d2a17_apply_fresh_auth_phase_binding.php` ;
3. `php tools\smoke_r45d2a17_fresh_auth_phase_binding.php` ;
4. lint des fichiers fresh-auth/mutation/front ;
5. `composer dump-autoload -o` ;
6. démarrer back/front ;
7. admin : preview puis commit avec réauthentification réelle pour chaque phase ;
8. developer : idem ;
9. viewer : lecture Sécurité uniquement, aucune mutation ;
10. confirmer absence de secret dans logs/profiler.

## Invariants

- permissions ACL effectives uniquement ; jamais `primary_role` comme autorité ;
- admin + developer gestion Sécurité ; viewer lecture seule ;
- viewer sans Profiler ;
- pas de timestamp fresh-auth déclaratif ;
- pas de preuve preview utilisable pour commit ;
- pas de stockage `var/rest` ;
- pas de mot de passe dans log/profiler/ARGV ;
- aucun push OPUS/OWASYS par l'assistant.
