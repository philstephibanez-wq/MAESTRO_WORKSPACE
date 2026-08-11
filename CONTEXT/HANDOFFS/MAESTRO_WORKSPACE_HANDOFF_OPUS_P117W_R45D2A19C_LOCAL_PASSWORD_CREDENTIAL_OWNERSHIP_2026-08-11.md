# HANDOFF — OPUS P117W R45D2A19C

Date : 2026-08-11

## État acquis

- R45D2A18D : Security Preview + Commit admin fonctionnels ;
- R45D2A19 : break-glass local-password publié sous `ddd71ee3b0554b685156cfbc22994aba5d35989d` ;
- R45D2A19B : rendu `/account/password` réparé localement, non encore publié ;
- le login temporaire déclenche correctement `must_change_password` et ouvre `/account/password`.

## Défaut actif

POST `/account/password` -> REST `PATCH /api/v1/security/admin-password` -> `owasys:admin-password-change` -> `OWASYS_SECURITY_PROVIDER_UNSUPPORTED`.

Cause : le backend lit son propre `config/sso.json`, dont le default provider est légitimement `auth0-proxy`, alors que le credential `local-password` appartient au runtime frontend.

## R45D2A19C

Corrige l'ownership du credential :

- `OwasysRuntimeSecurity::changePassword()` utilise le `SsoManager` local du front ;
- aucun password ne traverse REST ;
- suppression de la fausse API back `/api/v1/security/admin-password` ;
- suppression de l'opération/script/alias/handler backend correspondant ;
- resynchronisation des catalogues REST.

```text
ZIP     : opus_p117w_r45d2a19c_local_password_credential_ownership.zip
SHA-256 : 4a10ea20368e259b6a70548893c806a476aa0dde79a07455b9c6cf780180970d
BASE    : ddd71ee3b0554b685156cfbc22994aba5d35989d + R45D2A19B local
FILES   : 2
```

## Gate immédiat

`temp password login -> /account/password -> current=temp -> new+confirm -> password_changed FSM -> /applications`

Puis vérifier :

- nouveau mot de passe accepté ;
- temporaire refusé ;
- `must_change_password=false` ;
- aucune requête backend `/api/v1/security/admin-password` ;
- aucun secret en log/profiler.

Après ce gate, reprendre la matrice ACL : developer même workflow Security ; viewer lecture seule et sans Profiler.

NO BACKEND ACCESS TO FRONT CREDENTIAL STORE.
NO PASSWORD OVER REST.
NO PASSWORD IN ARGV/LOG/PROFILER.
NO FRESH-AUTH BYPASS.
NO SITE-SPECIFIC HACK.
NO SILENT FALLBACK.
NO PUSH OPUS/OWASYS BY ASSISTANT.
