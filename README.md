# MAESTRO WORKSPACE

Workspace global de coordination pour les sous-projets MAESTRO, OPUS, OPUS RefBook, MO_KB et LOGANDPLAY.

Ce dépôt sert à garder les contrats, décisions, handoffs et cartes de reprise. Il ne remplace pas les dépôts sources des sous-projets.

## Reprise immédiate dans un chat neuf

Lire dans cet ordre :

1. `README.md` ;
2. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md` ;
3. `CONTEXT/HANDOFFS/P7B2_20260628_OPUS_LSTSAR_CONTRACT_CORE.md` ;
4. `CONTEXT/HANDOFFS/P7B1_20260628_OPUS_REST_SSO_SECURITY_CORE.md` ;
5. `CONTEXT/PROJECTS/PROJECT_INDEX.md` ;
6. les ADRs liées.

Aucune livraison n'est complète si le workspace/handoff n'a pas été mis à jour quand l'état projet change.

## Vue rapide

| Projet | Rôle | État |
|---|---|---|
| LOGANDPLAY | Identité publique, carte d'entrée `logandplay.org` et présentation de l'écosystème | Projet workspace/site OPUS à aligner contractuellement ; aucune exposition publique active |
| OPUS | Framework PHP OPUS 8.1.0 "Lysenko" | P7B2 LSTSAR Contract Core validé et poussé, commit OPUS `af2576f`; prochaine étape `P7_LSTSAR_CONTRACT_ENGINE_SKELETON` |
| OPUS RefBook | Site officiel de documentation OPUS, package optionnel | Intégré sous OPUS comme site optionnel ; doit rester `.score`, sans polluer le core |
| OPUS_USER_GUIDE | Guide utilisateur optionnel futur | À cadrer |
| OPUS_REF_BOOK | Ancien dépôt transitoire RefBook | Ne plus utiliser comme source long terme |
| MAESTRO_V5 | Assistant musical REAPER/Lua | Actif, non exposé publiquement |
| MO_KB_DAEMON | Backend KB musicale, workers master/slaves | Actif privé, non exposé publiquement |
| MO_KB_FRONT | Front/backoffice KB historique | À réévaluer vers KB_FRONT_OFFICE / KB_BACK_OFFICE OPUS |
| MAESTRO_WORKSPACE | Contexte global et décisions | Source de contexte, handoffs et TODOs |

## OPUS état immédiat

```text
OPUS root      : H:\OPUS
OPUS GitHub    : philstephibanez-wq/OPUS
Workspace root : H:\MAESTRO_WORKSPACE
Workspace repo : philstephibanez-wq/MAESTRO_WORKSPACE
OPUS branch    : master
OPUS commit    : af2576f
OPUS message   : P7 add LSTSAR contract core
```

P7B2 a ajouté le socle contractuel LSTSAR sous `Opus\Lstsar`.

LSTSAR signifie Load / Secure / Transform / Store / Audit / Report.

REST reste généraliste : les endpoints LSTSAR exposent de la découverte de contrats via `ApiEndpointInterface`, mais le core REST ne contient pas de logique métier LSTSAR.

Endpoints smoke validés :

```text
GET /api/v1/status
GET /api/v1/me
GET /api/v1/security/policies
GET /api/v1/lstsar/contracts
GET /api/v1/lstsar/pipelines/default
```

Validation P7B2 : lint PHP OK, JSON configs OK, autoload OK, smoke API LSTSAR OK, profiler temp nettoyé, commit et push OK.

## OPUS runtime contract immédiat

```text
H:\OPUS\index.php                         unique point d'entrée produit Windows dev
H:\OPUS\Opus\Runtime\Bootstrap.php       bootstrap runtime stable
H:\OPUS\Opus\Runtime\Application.php     application runtime active
H:\OPUS\var\cache                         caches runtime OPUS Windows dev
H:\OPUS\var\logs                          logs runtime OPUS Windows dev
/srv/opus/OPUS                              OPUS Linux préprod
/srv/opus/OPUS/public                       Apache DocumentRoot Linux
/srv/opus/OPUS/var/cache                    cache runtime Linux
/srv/opus/OPUS/var/logs                     logs runtime Linux
```

`Opus/Legacy` ne doit pas réapparaître dans le runtime produit. Toute recréation de `H:\OPUS\Opus\Legacy` est une régression.

`H:\OPUS\var` et `/srv/opus/OPUS/var` ne doivent contenir que `cache` et `logs`.

Tout ce qui est développement, audit, generated, recipes, tmp, refbook transitoire ou diagnostic va dans MAESTRO_WORKSPACE si nécessaire, pas dans OPUS product runtime.

## OPUS REST / Security / LSTSAR contract immédiat

```text
Opus\Api
  ApiEndpointInterface
  ApiDispatcher
  ApiRouteRegistry
  ApiErrorResponseFactory

Opus\Security\Sso
  SsoAuthenticatorInterface

Opus\Security\Identity
  IdentityContextInterface

Opus\Security\Access
  AclPolicyInterface
  AccessDecisionInterface

Opus\Security\Fsm
  FsmGuardInterface

Opus\Lstsar
  LstsarPipelineInterface
  LstsarJobInterface
  LstsarReportInterface
  LstsarStageInterface
  LoadStageInterface
  SecureStageInterface
  TransformStageInterface
  StoreStageInterface
  AuditStageInterface
  ReportStageInterface
```

Runtime API flow :

```text
Request
  -> ApiRouteRegistry
  -> SSO
  -> IdentityContext
  -> ACL policy
  -> optional FSM guard
  -> ApiEndpointInterface
  -> Response::json()
```

## LOGANDPLAY public identity contract immédiat

```text
Projet workspace : LOGANDPLAY
Hôte cible       : logandplay.org
Rôle             : carte d'identité publique de l'écosystème
Rendu            : page/site généré par OPUS
Statut actuel    : pas encore exposé publiquement
Liens projets    : OPUS / MAESTRO / KB affichés en PROCHAINEMENT
```

La page publique ne doit exposer aucun chemin serveur, Webmin, admin, LAN, diagnostic runtime ou détail de préproduction.

## OPUS Linux P117 état court

```text
Serveur Linux       : logandplay
LAN                 : 192.168.1.135 / eno1
PC opérateur        : 192.168.1.176
Tailscale           : 100.83.101.117
DNS LAN             : dnsmasq, opus.lan.logandplay.org -> 192.168.1.135
Apache              : /etc/apache2/sites-available/opus-preprod.conf
UFW                 : actif, incoming deny, LAN/Tailscale autorisés seulement
Fail2ban            : sshd + opus-webmin actifs, LAN/Tailscale ignorés
ClamAV              : scan ciblé quotidien OPUS + /tmp, pas de suppression automatique
Stats web privées   : AWFFull vers /srv/opus/security/awffull/opus
Webmin tempdir      : /var/lib/webmin/tmp hors /tmp tmpfs
Systemd             : zéro unité failed après validation P117SEC
```

L'admin direct LAN peut encore afficher `503 Site temporairement bloqué`. C'est attendu jusqu'au gate auth/ACL P117AUTH1.

Le dashboard peut encore afficher `SERVER_DEGRADED` tant que P117L4B n'a pas remplacé les chemins Windows `H:\UwAmp` dans la vue registry Linux.

## Packaging OPUS cible

| Package | Statut | Contrat |
|---|---|---|
| OPUS | Obligatoire | Core clean, livrable, runtime strict, sans résidus RefBook/Twig/legacy/dev |
| OPUS_REF_BOOK | Optionnel officiel | Site OPUS offline-first et publiable online |
| OPUS_USER_GUIDE | Optionnel futur | Guide utilisateur séparé du RefBook technique |
| LOGANDPLAY_SITE | Futur site public | Site/package consommant OPUS core, sans polluer le framework |

## Topologie OPUS cible

```text
Un seul framework OPUS partagé.
Plusieurs sites/packages OPUS optionnels.
REST est une brique framework générique et data-driven.
SSO / Identity / ACL / FSM sont des contrats réutilisables par REST, LSTSAR et autres.
LSTSAR a ses propres contrats sous Opus\Lstsar.
Aucune duplication du framework par site.
Aucun dossier Opus/Legacy dans le runtime produit.
```

## Licence OPUS cible

| Sujet | Décision |
|---|---|
| Copyright | Philippe Stéphane Ibanez |
| Modèle | Source-available, libre d'utilisation non commerciale |
| Commercial | Licence commerciale payante avec royalties obligatoires |
| Open source OSI | Non, sauf décision future contraire |

## Handoff obligatoire à chaque livraison

À chaque livraison qui change l'état projet, mettre à jour le workspace, notamment :

- `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md` pour la reprise immédiate ;
- `CONTEXT/PROJECTS/PROJECT_INDEX.md` si les priorités changent ;
- `CONTEXT/DECISIONS/*.md` si une décision d'architecture/licence/packaging est prise ;
- `README.md` si la vue 10 secondes change.

Le but est de pouvoir ouvrir un chat neuf à tout moment sans dépendre d'une mémoire implicite.

## Raccourcis

- Handoff courant : CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
- Handoff OPUS P7B2 : CONTEXT/HANDOFFS/P7B2_20260628_OPUS_LSTSAR_CONTRACT_CORE.md
- Handoff OPUS P7B1 : CONTEXT/HANDOFFS/P7B1_20260628_OPUS_REST_SSO_SECURITY_CORE.md
- ADR OPUS REST Security Core : CONTEXT/DECISIONS/ADR_20260628_OPUS_REST_API_GENERIC_SECURITY_CORE.md
- OPUS current state : CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
- Index projets : CONTEXT/PROJECTS/PROJECT_INDEX.md
- Projet LOGANDPLAY : CONTEXT/PROJECTS/LOGANDPLAY.md
- Décisions : CONTEXT/DECISIONS/
- Handoffs : CONTEXT/HANDOFFS/
- Versions : CONTEXT/VERSIONS/
- Workspace VS Code : MAESTRO_WORKSPACE.code-workspace

## Règles immédiates

- OPUS P7B2 : LSTSAR Contract Core validé et poussé.
- OPUS REST : générique, data-driven, contractuel, sans hardcode LSTSAR.
- OPUS LSTSAR : contrats séparés sous `Opus\Lstsar`, pipeline non exécuté à ce stade.
- OPUS Security : SSO / Identity / ACL / FSM sous interfaces.
- Prochaine étape : `P7_LSTSAR_CONTRACT_ENGINE_SKELETON`.
- Profiler dev : i18n fr/en/es à reprendre ensuite.
- OPUS P6B : `Opus/Legacy` supprimé ; ne pas le recréer.
- LOGANDPLAY : créer/aligner la page identité `logandplay.org` générée par OPUS, avec liens OPUS/MAESTRO/KB en `PROCHAINEMENT`.
- OPUS P117 Linux préprod et sécurité restent la base active côté serveur.
- Pas de fallback silencieux.
- Les caches vont dans `OPUS/var/cache`.
- Les logs vont dans `OPUS/var/logs`.
- Les commandes doivent préciser l'environnement : Windows dev, Windows navigateur, PowerShell admin ou serveur Linux préprod.
