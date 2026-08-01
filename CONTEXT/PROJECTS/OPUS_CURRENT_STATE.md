# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-01.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 7e07e43c1aa148bd198918cb5d8051d06c428620
Commit : opus_p117w_r46c3_centralized_session_runtime
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R46A1 : modèle de traces V2 validé et poussé.
- R46B1 : collecteur REST présent sur `master`.
- R46C1 : iframe/SCORE poussé.
- R46C3 : session centralisée, iframe HTTP 200, ACL et SCORE validés par l'owner puis poussés.
- R46C2 : diagnostic rejeté, jamais intégré.
- Témoin guidé : `fullstack-test`, jamais corrigé directement.

## État réel du Profiler

La preuve owner après R46C3 montre l'iframe SCORE fonctionnelle et une trace frontend terminée proprement avec cinq événements. Elle montre également `Spans: 0`. Pour une page sans REST, zéro span REST est exact ; l'absence de span HTTP racine est la lacune contractuelle restante.

## Livraison active — R46B2

ZIP : `opus_p117w_r46b2_http_root_span.zip`  
SHA-256 : `f2435b8451d4ca64bb0353868445dcbc1464be2c1a256efde79337ffee5fb991`

Fichier complet : `sites/owasys-front/application/default/Application.php`.

R46B2 crée le span HTTP racine et les événements HTTP contractuels observés. Il ne fabrique aucun span REST/Composer et ne modifie ni ACL, ni SSO, ni backend, ni site témoin. Archive et diff structurel vérifiés ; lint et recette owner requis.

## Suite R46

1. valider et pousser R46B2 ;
2. compléter les collecteurs R46B manquants à partir des événements réellement observables ;
3. compléter la barre compacte et les douze rubriques SCORE R46C ;
4. réaliser la corrélation distribuée R46D ;
5. intégrer les profils générés en R46E.

## Invariants

- aucune correction locale de `fullstack-test` ;
- SCORE uniquement ; Singleton, FSM, I18n, SSO et ACL deny-by-default ;
- backend sans JavaScript ; aucun `shared` ;
- Logger/Profiler corrélés sans secret ;
- Profiler uniquement dev/local via `?profiler=1` ;
- aucune affirmation sans événement collecté ;
- assistant : ZIP différentiel seulement pour OPUS/OWASYS ; owner : validation et push.

NO ACL BYPASS.  
NO EVENT, NO CLAIM.  
NO FALLBACK SILENCIEUX.
