# MAESTRO WORKSPACE

Workspace global de coordination pour les sous-projets MAESTRO, OPUS, OPUS RefBook, MO_KB et LOGANDPLAY.

Ce dépôt sert à garder les contrats, décisions, handoffs et cartes de reprise. Il ne remplace pas les dépôts sources des sous-projets.

## Reprise immédiate dans un chat neuf

Lire dans cet ordre :

1. `README.md` ;
2. `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md` ;
3. `CONTEXT/PROJECTS/PROJECT_INDEX.md` ;
4. les ADRs liées.

Aucune livraison n'est complète si le workspace/handoff n'a pas été mis à jour quand l'état projet change.

## Vue rapide

| Projet | Rôle | État |
|---|---|---|
| LOGANDPLAY | Identité publique, carte d'entrée `logandplay.org` et présentation de l'écosystème | Nouveau projet workspace : page OPUS-generated prévue, liens OPUS/MAESTRO/KB en `PROCHAINEMENT`, aucune exposition publique active |
| OPUS | Framework PHP OPUS 8.1.0 "Lysenko" | Windows dev P6D8 : RefBook docblocks classe/interface 100% OK, prochain palier = migration contrôlée du contrat namespace runtime `OPUS_Application` |
| OPUS RefBook | Site officiel de documentation OPUS, package optionnel | Gate PHPDoc ouvert : 79/79 classes/interfaces documentées, prêt pour suite P6D application namespace |
| OPUS_USER_GUIDE | Guide utilisateur optionnel futur | À cadrer |
| OPUS_REF_BOOK | Dépôt transitoire du RefBook actuel | Revert P116C5M appliqué après régressions UI P116C5I/J/K/L |
| MAESTRO_V5 | Assistant musical REAPER/Lua | Actif, non exposé publiquement |
| MO_KB_DAEMON | Backend KB musicale, workers master/slaves | Actif privé, non exposé publiquement |
| MO_KB_FRONT | Front/backoffice KB | À aligner, non exposé publiquement |
| MAESTRO_WORKSPACE | Contexte global et décisions | Source de contexte |

## OPUS runtime contract immédiat

```text
H:\OPUS\index.php                         unique point d'entrée produit Windows dev
H:\OPUS\Opus\Runtime\Bootstrap.php       bootstrap runtime stable
H:\OPUS\Opus\Runtime\Application.php     application runtime active depuis P6A ; global OPUS_Application à migrer sous contrat P6D
H:\OPUS\framework\Opus\Autoload\...      autoloader framework
H:\OPUS\var\cache                         caches runtime OPUS Windows dev
H:\OPUS\var\logs                          logs runtime OPUS Windows dev
/srv/opus/OPUS                              OPUS Linux préprod
/srv/opus/OPUS/public                       Apache DocumentRoot Linux
/srv/opus/OPUS/var/cache                    cache runtime Linux
/srv/opus/OPUS/var/logs                     logs runtime Linux
```

`Opus/Legacy` ne doit pas réapparaître dans le runtime produit. Toute recréation de `H:\OPUS\Opus\Legacy` est une régression P6.

`H:\OPUS\var` et `/srv/opus/OPUS/var` ne doivent contenir que `cache` et `logs`.

Tout ce qui est développement, audit, generated, recipes, tmp, refbook transitoire ou diagnostic va dans MAESTRO_WORKSPACE si nécessaire, pas dans OPUS product runtime.

## OPUS RefBook autodoc contract immédiat

```text
P6D audit source : tools/audits/audit_p6d_runtime_application_namespace_readiness.py
Class total      : 79
Namespaced       : 35
Global           : 44
With docblock    : 79
Missing docblock : 0
Status           : PHPDoc class/interface coverage 100% OK
Decision         : P6D_READY_FOR_RUNTIME_APPLICATION_NAMESPACE_MIGRATION
Next safe step   : P6D_APPLY_RUNTIME_APPLICATION_NAMESPACE_CONTRACT
```

Le RefBook ne doit pas être alimenté par des classes non documentées ou par un parseur approximatif. La couverture classe/interface est désormais complète, mais la migration `OPUS_Application` reste à faire sous contrat runtime explicite.

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
Aucune duplication du framework par site.
Aucun dossier Opus/Legacy dans le runtime produit.
```

Le RefBook et le futur site LOGANDPLAY peuvent être livrés séparément comme packages/sites optionnels, mais ils doivent dépendre d'un OPUS core partagé et déclaré explicitement.

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
- Handoff OPUS P6D8 : CONTEXT/HANDOFFS/P6D8_20260624_OPUS_ALL_REMAINING_REFBOOK_DOCBLOCKS.md
- Handoff OPUS P6D6 : CONTEXT/HANDOFFS/P6D6_20260624_OPUS_BREADCRUMB_SECURITY_LEGACY_COMPONENTS_DOCBLOCK_BATCH3.md
- Handoff OPUS P6D5 : CONTEXT/HANDOFFS/P6D5_20260624_OPUS_HTTP_APPLICATION_FOUNDATION_DOCBLOCK_BATCH2.md
- Handoff OPUS P6D4 : CONTEXT/HANDOFFS/P6D4_20260624_OPUS_RUNTIME_CORE_DOCBLOCK_BATCH1.md
- Handoff OPUS P6D : CONTEXT/HANDOFFS/P6D_20260624_OPUS_RUNTIME_APPLICATION_REFBOOK_DOC_AUDIT.md
- Handoff OPUS P6C : CONTEXT/HANDOFFS/P6C_20260624_OPUS_RUNTIME_CLEANUP_TARGET_SELECTED.md
- Handoff OPUS P6B : CONTEXT/HANDOFFS/P6B_20260624_OPUS_LEGACY_REMOVED.md
- Index projets : CONTEXT/PROJECTS/PROJECT_INDEX.md
- Projet LOGANDPLAY : CONTEXT/PROJECTS/LOGANDPLAY.md
- Décisions : CONTEXT/DECISIONS/
- Handoffs : CONTEXT/HANDOFFS/
- Versions : CONTEXT/VERSIONS/
- Workspace VS Code : MAESTRO_WORKSPACE.code-workspace

## Règles immédiates

- OPUS P6D8 : RefBook docblocks classe/interface 100% OK ; prochain palier = `P6D_APPLY_RUNTIME_APPLICATION_NAMESPACE_CONTRACT`.
- OPUS runtime : `OPUS_Application` global reste actif ; 11 références runtime doivent être migrées sous contrôle, sans fallback silencieux.
- OPUS P6B : `Opus/Legacy` supprimé ; ne pas le recréer.
- LOGANDPLAY P117SITE1 : créer la page identité `logandplay.org` générée par OPUS, avec liens OPUS/MAESTRO/KB en `PROCHAINEMENT`.
- OPUS P117 Linux préprod et sécurité restent la base active côté serveur.
- Pas de nouveau patch UI RefBook tant que OPUS Linux/P6 runtime n'est pas stabilisé.
- Pas de fallback silencieux.
- Les caches vont dans `OPUS/var/cache`.
- Les logs vont dans `OPUS/var/logs`.
- Les commandes doivent préciser l'environnement : Windows dev, Windows navigateur, PowerShell admin ou serveur Linux préprod.
