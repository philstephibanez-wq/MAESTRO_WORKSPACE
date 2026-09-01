# R8B6W — Raffinement de l'audit général OPUS + OWASYS

## Baseline
- OPUS master audité : `7dfb6206986cf1b7a738065df235fd04ab19fb3b` (`R8B6U`).
- Premier run utilisateur : 643 fichiers PHP, 248 classes concrètes framework, 16 fichiers SCORE, 0 blocker, 12 errors, 4 warnings.

## Corrections du runner d'audit
Le premier runner a produit plusieurs faux positifs. R8B6W corrige l'auditeur avant toute correction applicative :
- wildcard FSM `*` accepté comme source contractuelle ;
- stdout/stderr des scripts CLI exclus de l'interdiction SCORE/echo qui vise l'UI HTTP ;
- `json_decode`/`file_get_contents` ne sont signalés comme violation de configuration que lorsqu'ils ciblent explicitement un chemin `config` ; les payloads SQLite et stores mutables ne sont pas des configurations ;
- les répertoires de catalogues I18n avec uniquement des catalogues vides ne sont pas obligés de dupliquer tous les catalogues de base ;
- `.vscode` est autorisé à la racine du dépôt ;
- l'audit framework détecte explicitement les short open tags PHP historiques et la syntaxe d'offset par accolades supprimée en PHP 8.

## Constats réels déjà confirmés
- fichiers parasites à la racine OPUS : `cd`, `composer`, `er opusdev-server -- owasys-front` ;
- `sites/owasys-front/config/site.json` déclare encore `fallback_locale: fr-FR`, à réconcilier avec le contrat visible R8B6S+ (`⚠` sans fallback français) ;
- `Opus/Ftp/Ftp.class.php` est une dette framework réelle : classe concrète sans interface homonyme, short open tag historique et code legacy à qualifier avant correction/suppression.

## Gate
R8B6W ne corrige pas encore OPUS/OWASYS. Il remplace uniquement `tools/audit_opus_owasys.py` puis exige un second run complet. Le prochain livrable correctif sera construit uniquement à partir des findings nettoyés.
