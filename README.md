# MAESTRO WORKSPACE

Workspace global de coordination pour les sous-projets MAESTRO, OPUS, OPUS RefBook, MO_KB et Log&Play.

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
| OPUS | Framework PHP OPUS 8.1.0 "Lysenko" | Priorité P117 : Linux préprod installé et durci ; DNS LAN, Apache LAN, UFW, ClamAV ciblé et AWFFull privé validés ; prochain : Fail2ban puis registry overlay Linux |
| OPUS RefBook | Site officiel de documentation OPUS, package optionnel | UI en pause jusqu'à stabilisation OPUS P117 |
| OPUS_USER_GUIDE | Guide utilisateur optionnel futur | À cadrer |
| OPUS_REF_BOOK | Dépôt transitoire du RefBook actuel | Revert P116C5M appliqué après régressions UI P116C5I/J/K/L |
| MAESTRO_V5 | Assistant musical REAPER/Lua | Actif |
| MO_KB_DAEMON | Backend KB musicale, workers master/slaves | Actif |
| MO_KB_FRONT | Front/backoffice KB | À aligner |
| Log&Play | Publication web, domaines, bastion/gateway | Cible : Cloudflare Tunnel + Cloudflare Access, pas d'ouverture Freebox par défaut |
| MAESTRO_WORKSPACE | Contexte global et décisions | Source de contexte |

## OPUS runtime contract immédiat

```text
H:\OPUS\index.php                         unique point d'entrée produit Windows dev
H:\OPUS\framework\Opus\Autoload\...      autoloader framework
H:\OPUS\var\cache                         caches runtime OPUS Windows dev
H:\OPUS\var\logs                          logs runtime OPUS Windows dev
/srv/opus/OPUS                              OPUS Linux préprod
/srv/opus/OPUS/public                       Apache DocumentRoot Linux
/srv/opus/OPUS/var/cache                    cache runtime Linux
/srv/opus/OPUS/var/logs                     logs runtime Linux
```

`H:\OPUS\var` et `/srv/opus/OPUS/var` ne doivent contenir que `cache` et `logs`.

Tout ce qui est développement, audit, generated, recipes, tmp, refbook transitoire ou diagnostic va dans MAESTRO_WORKSPACE si nécessaire, pas dans OPUS product runtime.

## OPUS Linux P117 état court

```text
Serveur Linux       : logandplay
LAN                 : 192.168.1.135 / eno1
PC opérateur        : 192.168.1.176
Tailscale           : 100.83.101.117
DNS LAN             : dnsmasq, opus.lan.logandplay.org -> 192.168.1.135
Apache              : /etc/apache2/sites-available/opus-preprod.conf
UFW                 : actif, incoming deny, LAN/Tailscale autorisés seulement
ClamAV              : scan ciblé quotidien OPUS + /tmp, pas de suppression automatique
Stats web privées   : AWFFull vers /srv/opus/security/awffull/opus
Systemd             : zéro unité failed après validation P117SEC
```

L'admin direct LAN peut encore afficher `503 Site temporairement bloqué`. C'est attendu jusqu'au gate auth/ACL P117AUTH1.

Le dashboard peut encore afficher `SERVER_DEGRADED` tant que P117L4B n'a pas remplacé les chemins Windows `H:\UwAmp` dans la vue registry Linux.

## Packaging OPUS cible

| Package | Statut | Contrat |
|---|---|---|
| OPUS | Obligatoire | Core clean, livrable, runtime strict, sans résidus RefBook/Twig/dev |
| OPUS_REF_BOOK | Optionnel officiel | Site OPUS offline-first et publiable online |
| OPUS_USER_GUIDE | Optionnel futur | Guide utilisateur séparé du RefBook technique |

## Topologie OPUS cible

```text
Un seul framework OPUS partagé.
Plusieurs sites/packages OPUS optionnels.
Aucune duplication du framework par site.
```

Le RefBook peut être livré séparément comme package/site optionnel, mais il doit dépendre d'un OPUS core partagé et déclaré explicitement.

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
- Index projets : CONTEXT/PROJECTS/PROJECT_INDEX.md
- Décisions : CONTEXT/DECISIONS/
- Handoffs : CONTEXT/HANDOFFS/
- Versions : CONTEXT/VERSIONS/
- Workspace VS Code : MAESTRO_WORKSPACE.code-workspace

## Règles immédiates

- OPUS P117 Linux préprod et sécurité d'abord, RefBook UI ensuite.
- Pas de nouveau patch UI RefBook tant que OPUS Linux P117 n'est pas stabilisé.
- Pas de fallback silencieux.
- Les caches vont dans `OPUS/var/cache`.
- Les logs vont dans `OPUS/var/logs`.
- Les commandes doivent préciser l'environnement : Windows dev, Windows navigateur, PowerShell admin ou serveur Linux préprod.
