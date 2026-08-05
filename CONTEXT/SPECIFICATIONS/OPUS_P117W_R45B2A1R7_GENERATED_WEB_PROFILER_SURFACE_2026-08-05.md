# OPUS P117W R45B2A1R7 — SURFACE WEB PROFILER DES APPLICATIONS GÉNÉRÉES

Date : 2026-08-05  
Statut : livrable owner actif  
Base OPUS : `381de7d4a6ca145c7a572630cb84d97a0741da6c`

## Acquis

R45B2A1R6 est acquis. Le runtime généré reçoit le Profiler actif et mesure réellement la FSM. Le site témoin créé avant la correction ne présente toutefois aucune route ni aucun lien permettant d'ouvrir une trace.

## Cause

Le scaffold génère le stockage et l'instrumentation Profiler, mais ne déclare ni route, ni état FSM, ni politique ACL, ni composant SCORE d'accès à `WebProfilerController`.

## Correction générique

R45B2A1R7 :

- déclare `/_opus/profiler/trace/{trace_id}` dans le registre de routes ;
- ajoute l'état et la transition FSM `profiler` ;
- ajoute la politique deny-by-default `profiler:view` ;
- résout uniquement les identifiants de trace hexadécimaux de 16 à 64 caractères ;
- réutilise `WebProfilerController` et `WebProfilerView` ;
- conserve la restriction aux environnements `dev`, `local` et `development` ;
- rend le lien par SCORE uniquement lorsque l'environnement et la même décision ACL l'autorisent ;
- masque le lien à l'utilisateur anonyme ;
- n'invente aucune mesure et ne modifie aucun site témoin.

Le pipeline reste `AUTH -> ACL -> FSM -> ACTION -> SCORE -> HTML`.

## Livrable

```text
ZIP     : opus_p117w_r45b2a1r7_generated_web_profiler_surface.zip
SHA-256 : 21b70a957df89954814d7e19610a38014734012a6a1841dca72ba6e1f29f2359
FILES   : 2
BASE    : 381de7d4a6ca145c7a572630cb84d97a0741da6c
```

Chemins :

- `Opus/Application/Runtime/GeneratedSiteRuntime.php` ;
- `Opus/Scaffold/SiteScaffoldPlan.php`.

## Gates owner

- lint PHP des deux sources ;
- Composer autoload optimisé ;
- validation d'`owasys-front` et d'`owasys-back` ;
- audit des interfaces homonymes ;
- `git diff --check` ;
- suppression contractuelle puis recréation du site témoin ;
- test anonyme : aucun lien Profiler et accès refusé ;
- test rôle déclaré : lien visible en environnement de développement ;
- ouverture de la trace terminée via la route contractuelle ;
- test production : surface interdite.

NO ACL BYPASS.  
NO LOCAL SITE FIX.  
NO PROFILER DATA INVENTION.  
NO FALLBACK SILENCIEUX.
