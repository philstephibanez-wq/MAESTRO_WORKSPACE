# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-06.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : fac5f8d94f29f8529ad9b99f72a0b83f9a74240f
Dernier acquis : E2B éditeur Sources frontend
Livrable actif : E3A Git workspace générique/backend
```

## Jalons acquis

- R45B2A2 : rétention/rotation bornée du Profiler JSONL.
- R45B2A3 : module `application/profiler` dans le scaffold générique.
- R45B2A4 : alignement de `profiler:view` dans le scaffold.
- E1 : `SiteSourceWorkspace`, publié à `60f45aae8ee6f3a10096069076900a41c33d9a19`.
- E2A : frontière Source REST/Composer, publiée à `1fc49e9e53efdd002513cc7b037a07cb2faacffc`.
- E2B : éditeur Sources frontend, publié à `d6548ec0fb1dc4bd376e730a943f45e502eed51e` et validé par édition réelle du site `test` depuis OWASYS.

R46 `dev-server --site=` est abandonné et ne doit jamais être appliqué.

## Contrat dev-server conservé

```text
composer opus:dev-server -- <application-id> [--host=<local-address>] [--port=<local-port>]
```

Le dépôt racine ne déclare pas de script `composer dev-server` sans préfixe `opus:`.

## État E2B

E2B fournit :

- éditeur Sources SCORE et fallback POST sans JavaScript ;
- CodeMirror en amélioration progressive ;
- preview distincte de write ;
- verrou optimiste SHA-256 et conflit HTTP 409 ;
- ACL viewer lecture seule, developer/admin édition ;
- CSRF OPUS générique ;
- catalogues I18n UE configurés et ukrainien.

Le test fonctionnel owner a confirmé la persistance d'une modification dans le site témoin.

Une anomalie d'affichage du rôle a ensuite été identifiée : l'ACL reconnaissait correctement `admin`, mais l'UI affichait le premier rôle reçu, éventuellement `viewer`. E3A corrige la projection sans modifier les droits.

## Livrable owner actif — E3A

```text
ZIP     : opus_p117w_e3a_git_workspace_backend.zip
SHA-256 : 18bfeca293b10d911c717e266823b10771d1899b81dd5ae3edd281ca242bfcdc
FILES   : 11
BASE    : fac5f8d94f29f8529ad9b99f72a0b83f9a74240f
STATUS  : livré, application, validation et push owner requis
```

Smoke owner :

```text
smoke_opus_p117w_e3a_git_workspace_backend_owner.php
SHA-256 : bb37d9e0fe75a4f516593968e79fc1d134ffdeab1c7c9ea6e7944f67c9634db7
OUTPUT  : OPUS_P117W_E3A_GIT_WORKSPACE_BACKEND_OK
```

E3A ajoute :

- `SiteGitWorkspace` générique et interface homonyme ;
- statut, diff, historique, stage, unstage, commit et restauration ;
- confinement au site OPUS sélectionné ;
- refus d'un commit si l'index contient un chemin extérieur au site ;
- aucune commande Git libre et aucun push ;
- REST sécurisé et Composer allow-listé dans OWASYS-back ;
- ACL viewer lecture, developer/admin mutation ;
- Logger/Profiler sans contenu Git sensible ;
- projection déterministe du rôle principal : `admin > developer > viewer`.

E3A ne contient aucune page Git frontend, aucun fichier de site généré et aucun JavaScript backend.

## Suite gouvernée

1. validation, commit et push owner de E3A ;
2. E3B : interface Git SCORE dans OWASYS-front avec FSM, I18n, ACL, CSRF et fallback sans JavaScript ;
3. R45B3 : client REST frontend générique et validateurs croisés ;
4. R45C : wizard OWASYS structuré ;
5. R45D : administration Sécurité.

NO ACL BYPASS.
NO CONTENT OR COMMIT MESSAGE IN ARGV.
NO DIRECT FRONTEND FILESYSTEM OR GIT ACCESS.
NO IMPLICIT GIT OPERATION.
NO FREE GIT COMMAND.
NO FOREIGN STAGED PATH.
NO BACKEND JAVASCRIPT.
NO LOCAL SITE FIX.
NO FALLBACK SILENCIEUX.
NO PUSH OPUS PAR L'ASSISTANT.
