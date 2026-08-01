# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-02

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_DEVELOPER_PROFILER_CONTRACT_2026-07-31.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Base exacte

- OPUS GitHub : `f01f891a24dffd00daba4bf230ca3a771165efea`.
- Commit owner : `opus_p117w_r46b2_http_root_span`.
- R46A1 validé et poussé.
- R46B1 REST présent sur `master`.
- R46B2 span HTTP racine validé sur le parcours nominal et poussé.
- R46C1 iframe/SCORE poussé.
- R46C3 session centralisée, HTTP 200, ACL et SCORE validés puis poussés.
- R46C2 rejeté et jamais intégré.
- Site témoin : `fullstack-test`; ne jamais le corriger directement.

## Preuve R46B2 acquise

Le Profiler affiche sur une requête GET nominale :

- un span racine `http.http.request` ;
- statut `success` ;
- réponse HTTP 200 ;
- dix événements rattachés ;
- aucun faux span REST ou Composer.

La branche d'exception HTTP reste une recette séparée ; elle n'invalide pas la preuve nominale et ne doit pas être déclarée testée sans événement réel.

## Livraison active — R46B3

ZIP : `opus_p117w_r46b3_acl_decision_collector.zip`  
SHA-256 : `b21c39e009c09a0601d4a9d7b110475195713ec7f658120afcd8eb3927b2ccde`

Base : OPUS `f01f891a24dffd00daba4bf230ca3a771165efea`.

Fichiers complets :

```text
Opus/Security/Acl/AclPolicy.php
sites/owasys-front/application/default/Application.php
sites/owasys-front/application/default/services/RuntimeSecurity.php
```

R46B3 n'altère aucune permission. Il collecte au point de décision ACL :

- `acl.decision.evaluated` pour toute décision ;
- `acl.decision.denied` uniquement pour un refus ;
- rôles effectifs, ressource, action, scope, décision, code et règle décisive ;
- rattachement au span HTTP actif.

## Action owner immédiate

1. Appliquer le ZIP R46B3 sur un arbre propre au HEAD indiqué.
2. Linter les trois fichiers, régénérer l'autoload et exécuter `git diff --check`.
3. Tester une autorisation réelle : événement `acl.decision.evaluated` en succès, sans `acl.decision.denied`.
4. Tester un refus réel : événements `acl.decision.evaluated` et `acl.decision.denied` en erreur, avec `default:deny`.
5. Vérifier que l'ACL reste deny-by-default et que la permission refusée le reste.
6. Commit/push OPUS uniquement après ces preuves.

## État à ne pas falsifier

- archive et structure vérifiées ;
- `git diff --check` propre ;
- PHP/Composer indisponibles dans l'environnement de construction ;
- R46B3 livré mais non accepté tant que la recette owner n'est pas réussie ;
- aucune modification OPUS/OWASYS poussée par l'assistant.

## Autorité

```text
Assistant : MAESTRO_WORKSPACE + ZIP différentiel
Owner : application, validation, commit et push OPUS/OWASYS
```

NO ACL BYPASS.  
NO EVENT, NO CLAIM.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
