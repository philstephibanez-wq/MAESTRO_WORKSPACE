# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-30.

## Dépôt

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
HEAD relu : 98842dba015402af7e8b3421e62032236c2d8f30
Racine owner : H:/OPUS
```

## État acquis

- R38 : création layered supprimée.
- R39 : stockage REST replay fichier supprimé.
- R40 : ancien `sites/demo-opus` supprimé.
- R42 : serveur de développement générique appliqué.
- `sites/opus-demo` supprimé par l’owner.
- `owasys-front` et `owasys-back` sont les deux seules applications OWASYS.

## Action active — R43

Livrable différentiel prêt :

```text
opus_p117w_r43_transactional_creation_wizard.zip
39 fichiers
SHA-256 : 7571c469a16cc0d14245534d0da05505465764e6171dd955ae987a2ce66f0b51
```

R43 introduit l’assistant FSM basics/security/review, le blueprint non sensible, la collecte auth/login/SSO/utilisateurs/rôles/permissions/ACL, la création minimale, les langues UE + ukrainien, le login local optionnel et le rollback explicite.

## Suite

L’owner applique le ZIP sur `H:\OPUS`, exécute les validations PHP/Composer/OWASYS, recrée un site depuis OWASYS et vérifie qu’il ne contient que l’accueil plus le login éventuellement demandé.

Les pages ultérieures devront être ajoutées par un workflow atomique corrélant page, route, FSM, contrôleur/ViewModel, SCORE, navigation, ACL et I18n.

## Invariants

- toute mutation OWASYS traverse REST sécurisé puis Composer ;
- SCORE uniquement, sans mélange HTML/PHP ;
- ACL deny-by-default, SSO, FSM, I18n, Logger et Profiler ;
- backend OWASYS exclusivement PHP ;
- l’assistant ne committe ni ne pousse OPUS/OWASYS.
