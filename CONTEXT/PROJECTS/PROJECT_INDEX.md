# Project Index — MAESTRO WORKSPACE

Ce fichier donne une lecture immédiate des sous-projets du workspace. Il doit rester court, opérationnel et maintenable.

## Carte des sous-projets

### OPUS

- Rôle : framework PHP principal.
- Identité : OPUS Framework 8.1.0 "Lysenko".
- Dépôt cible : OPUS.
- Priorité : critique immédiate, livraison Linux préprod + durcissement serveur P117.
- État Linux : installé dans `/srv/opus/OPUS`, Apache `public/`, DNS LAN, UFW, ClamAV ciblé et AWFFull privé validés.
- Prochaines étapes : `P117SEC2_FAIL2BAN`, puis `P117L4B_LINUX_MULTISITE_REGISTRY_OVERLAY`, puis `P117AUTH1_ADMIN_GATE_CLOUDFLARE_READY`.
- Règle : OPUS n'est pas ASAP. ASAP est historique uniquement.
- Entrée runtime : `index.php` à la racine OPUS, unique point d'entrée produit.
- Autoload : classe framework `Opus\Autoload\...`, appelée par `index.php`; aucun script racine `autoload.php`.
- Cache Windows dev : `H:\OPUS\var\cache` uniquement.
- Logs Windows dev : `H:\OPUS\var\logs` uniquement.
- Cache/logs Linux préprod : `/srv/opus/OPUS/var/cache` et `/srv/opus/OPUS/var/logs`.
- Règle `var/` : seulement `cache` et `logs`; tout dev/audit/generated/tmp/recipes/refbook va dans MAESTRO_WORKSPACE si nécessaire.
- Livraison : package principal obligatoire, clean, sans résidus RefBook/Twig/legacy/dev.
- Topologie : core framework unique partagé, jamais copié dans chaque site.

### OPUS RefBook

- Rôle : site officiel de documentation OPUS.
- Cible : package optionnel officiel livré avec OPUS.
- Emplacement cible : OPUS/packages/opus-refbook.
- Mode local : offline-first.
- Mode publié : online public, sans debug ni chemins locaux.
- Règle : fonctionne grâce à OPUS, mais ne pollue pas le cœur framework.
- Règle runtime : dépend d'un OPUS core partagé déclaré par manifest/config, sans duplication du framework.
- Livrable propre : zéro Twig actif, zéro legacy, zéro backup, zéro CSS mort.
- État : revenu au baseline P116C5H après revert des régressions P116C5I/J/K/L.
- Blocage : ne pas reprendre l'UI RefBook tant que le runtime OPUS Linux/P117 n'est pas stabilisé.

### OPUS_USER_GUIDE

- Rôle : guide utilisateur optionnel futur.
- Différence : guide humain, installation, workflows, exemples et prise en main.
- Règle : ne pas le mélanger au RefBook technique sans ADR dédiée.
- Règle runtime : même modèle package optionnel OPUS, sans framework dupliqué.
- Statut : option de livraison envisagée, à cadrer.

### OPUS_REF_BOOK

- Rôle : dépôt transitoire actuel du RefBook.
- Statut : runtime assaini puis rollback au baseline P116C5H après régressions UI.
- Validé avant pause : ScoreTemplate actif, zéro Twig attendu, Composer purgé de `twig/twig`, `lang=cs` OK, branding `OPUS FRAMEWORK / Reference Book`, sidebar/thèmes P116C5H.
- Dernier commit stable actuel : `b5f00c6 P116C5M_REVERT_REFBOOK_UI_REGRESSIONS_TO_P116C5H`.
- Destination : migration contrôlée vers OPUS/packages/opus-refbook puis package optionnel OPUS_REF_BOOK.
- Règle : ne pas le considérer comme source officielle long terme.

### MAESTRO_V5

- Rôle : assistant musical REAPER/Lua.
- Objectif : aider le musicien à composer, analyser, humaniser, orchestrer et enrichir.
- Règle : la finalité reste faire de la musique, pas maintenir l'infrastructure.

### MO_KB_DAEMON

- Rôle : backend KB musicale, workers, master/slaves, ingestion et analyses.
- Mode : service Python/headless + contrôle local.
- Règle : la KB canonique reste sous contrôle master ; slaves sans écriture directe concurrente.

### MO_KB_FRONT

- Rôle : front/backoffice PHP/UwAmp pour la KB.
- Statut : à aligner progressivement avec OPUS.
- Règle : UI web séparée du backend Python, consommation par API/versionnement.

### Log&Play / publication

- Rôle : exposition publique, domaines, publication des sites.
- Cible : publication RefBook et autres sites via architecture sécurisée.
- Règle : public -> Cloudflare Tunnel/Access -> gateway/service OPUS -> data.
- Décision opérationnelle P117 : pas d'ouverture Freebox par défaut ; Cloudflare Tunnel + Cloudflare Access avant exposition publique.

### MAESTRO_WORKSPACE

- Rôle : contexte global, décisions, handoffs, contrats transverses.
- Règle : documenter et cadrer, pas remplacer les dépôts sources.
- Règle livraison : chaque livraison significative met à jour le workspace et `CONTEXT/HANDOFFS/CURRENT_HANDOFF.md`.
- Stockage dev OPUS : `H:\MAESTRO_WORKSPACE\var\opus\...` et `H:\MAESTRO_WORKSPACE\tools\opus\...` si nécessaire.

## Packaging OPUS cible

| Package | Type | Inclusion |
|---|---|---|
| OPUS | Core obligatoire | Toujours livré |
| OPUS_REF_BOOK | Site officiel optionnel | Profil documenté/offline/online |
| OPUS_USER_GUIDE | Guide utilisateur optionnel | Profil futur à cadrer |

## Topologie OPUS cible

```text
OPUS core est unique et partagé.
Les sites/packages optionnels déclarent leur dépendance OPUS.
Aucun site ne copie framework/Opus dans son propre arbre.
OPUS product runtime écrit uniquement dans OPUS/var/cache et OPUS/var/logs.
Les états de développement, audits, generated, recipes, tmp et refbook transitoire vont dans MAESTRO_WORKSPACE.
```

## Handoff de reprise obligatoire

Le fichier canonique de reprise est :

```text
CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
```

Il doit être mis à jour à chaque livraison qui change l'état réel d'un sous-projet, une décision, une priorité ou une prochaine étape.

## Priorité de reprise

1. P117SEC2 : installer Fail2ban sans bloquer l'IP LAN opérateur `192.168.1.176` ni l'accès Tailscale.
2. P117L4B : ajouter un overlay registry Linux pour supprimer `SERVER_DEGRADED` causé par les chemins Windows `H:\UwAmp`.
3. P117AUTH1 : poser un gate admin explicite compatible LAN préprod et Cloudflare Access.
4. P117CF1/P117CF2 : Cloudflare Tunnel puis Cloudflare Access, sans ouverture Freebox par défaut.
5. Reprendre ensuite la migration RefBook contrôlée quand OPUS P117 est stable.

## Contrats associés

- CONTEXT/HANDOFFS/CURRENT_HANDOFF.md
- CONTEXT/HANDOFFS/P117_20260617_OPUS_LINUX_BASELINE_SMTP_NTP.md
- CONTEXT/HANDOFFS/P117_20260617_OPUS_LINUX_DNS_SECURITY_UFW.md
- CONTEXT/DECISIONS/ADR_20260616_OPUS_STRICT_RUNTIME_ENTRYPOINT_VAR_AUTOLOADER.md
- CONTEXT/DECISIONS/ADR_20260614_WORKSPACE_ALWAYS_UPDATED_DELIVERY_HANDOFF.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_DELIVERY_PACKAGING_PROFILE.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_REFBOOK_PACKAGED_OFFLINE_ONLINE_SITE.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_SHARED_CORE_PACKAGES_NO_DUPLICATION.md
- CONTEXT/DECISIONS/ADR_20260614_OPUS_FRAMEWORK_IDENTITY.md
- CONTEXT/DECISIONS/ADR_20260615_OPUS_REFBOOK_PRO_DOC_SIDEBAR_SEASONS_THEMES.md
- CONTEXT/VERSIONS/OPUS_VERSION.md
