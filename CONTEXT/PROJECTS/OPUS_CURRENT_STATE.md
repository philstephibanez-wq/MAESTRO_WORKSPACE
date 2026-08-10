# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-10.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : dfab7d0ae9fe8456887ff3f1f0280c0141f27b26
Commit : opus_p117w_r45d2a3_generated_login_observability
```

Historique immédiat :

```text
dfab7d0ae9fe8456887ff3f1f0280c0141f27b26  opus_p117w_r45d2a3_generated_login_observability
f634e337ec0b5df0020bfba6eb240da0395a05bd  cleanup essai
052cc6e177875f9606051bf0f34a2a1f16865329  opus_p117w_r45d2a2_generated_local_password_runtime
01b146876fd96282dfd0f618dc84341b49d6eec6  essai2 !
d39b66d05e4cfe5207b9f0063cb1574fc6f52726  opus_p117w_r45d2a1_creation_security_input_canonicalization
```

## États acquis / publiés

- R45C3R1 : workflow OWASYS structuré acquis.
- R45D1 : workspace Sécurité réel acquis.
- R45D2 : mutations additives publiées ; preview/commit complète reste à valider.
- R45D2A1 : création sécurité canonicalisée.
- R45D2A2 : redirection login + provisioning local-password runtime.
- R45D2A3 : observabilité login publiée sous `dfab7d0...`.

## Site essai2

Le store runtime local-password contient :

```text
subject  = steve
provider = local-password
status   = active
roles    = admin
source   = runtime.local-password
```

Le login navigateur échoue encore. R45D2A3 fournit le code corrélé `security.sso/authentication.failed`; aucune nouvelle correction SSO ne doit être inventée avant lecture de ce code pour le POST de connexion.

La dernière capture du Web Profiler montre une trace avec `1` erreur mais `Security / ACL / SSO = 0`. Cette capture ne suffit donc pas à attribuer l'échec à un sous-composant SSO précis.

La déclaration owner « Prévisualiser casse OWASYS » a été retirée explicitement et n'est pas un défaut courant.

## Profiler

Les `.lock` persistants sont des sidecars de synchronisation et restent normaux.

Le Web Profiler fonctionne. Le défaut confirmé est désormais l'intégration de sa surface : la navigation directe vers `/_opus/profiler/trace/<trace_id>` remplace la page applicative. Le contrat attendu est page conservée + trace courante dans un iframe SCORE same-origin.

La capture montre également `SCORE = 0` malgré le rendu d'une page SCORE ; `GeneratedSiteRuntime` construisait les `ScoreTemplateRenderer` principaux sans leur transmettre le Profiler actif.

R45D2A4 a rendu la surface Profiler disponible en dev ; sa présentation par lien direct est supersédée par R45D2A5.

## Livrable actif — R45D2A5

```text
ZIP     : opus_p117w_r45d2a5_generated_profiler_iframe_integration.zip
SHA-256 : 08072a4a09963ce1f0e6dc61fece6be769cb43d54fb7bda3163a62acb757c1a5
BASE    : dfab7d0ae9fe8456887ff3f1f0280c0141f27b26
FILES   : 3
```

Fichiers :

```text
Opus/Application/Runtime/GeneratedSiteRuntime.php
Opus/Application/Runtime/templates/profiler-iframe.score
Opus/Profiler/ProfilerConfiguration.php
```

Fonctions :

1. compatibilité dev pour les sites générés existants lancés avec `OPUS_ENV=dev`, sans fichier site-specific ;
2. URL de trace issue de `ProfilerLinkProvider` ;
3. rendu de l'iframe via SCORE ;
4. iframe inséré dans le contenu de la page courante ;
5. neutralisation du lien direct hérité après composition ;
6. `ScoreTemplateRenderer` page/erreur/iframe alimentés par le Profiler actif ;
7. intégration également disponible sur erreur SCORE tant que la trace est active ;
8. route Web Profiler autonome conservée comme source de l'iframe ;
9. ACL/SSO/FSM inchangés ;
10. `.lock` inchangés.

Validation assistant : PHP lint OK sur les deux PHP ; SCORE iframe présent ; interfaces homonymes existantes conformes aux quatre marqueurs ; ZIP direct 3 fichiers.

## Suite

1. owner applique R45D2A5 sur `dfab7d0...` ;
2. relance `essai2` et vérifie que `/fr/login` reste visible avec le Profiler dans l'iframe ;
3. vérifie que le panneau SCORE est alimenté ;
4. retente login `steve` avec exactement le password provisionné pour `essai2/steve` ;
5. sur l'échec, relève l'`error_code` de `security.sso/authentication.failed` dans l'iframe de la même réponse ; à défaut dans `sites/essai2/var/logs/essai2.log` ;
6. corriger uniquement la cause SSO prouvée ;
7. reprendre ensuite la validation R45D2 preview/commit avec la fresh-auth OWASYS.

NO SITE-SPECIFIC PATCH.
NO VALIDATOR RELAXATION.
NO SILENT FALLBACK.
NO ACL/SSO RELAXATION.
NO PROFILER NAVIGATION-AWAY.
NO PROFILER LOCK PURGE.
NO PUSH OPUS BY ASSISTANT.
