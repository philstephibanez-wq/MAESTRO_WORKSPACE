# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-11.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 9d3c4d5463483cc520d381f7f8de83cfd5e352c4
Commit : opus_p117w_r45d2a18b_rest_composer_catalog_integrity
```

## États acquis

- R45C3R1 : workflow OWASYS structuré acquis.
- R45D1 : workspace Sécurité réel acquis.
- R45D2A2 : provisioning local-password runtime acquis.
- R45D2A3 : observabilité login acquise.
- R45D2A6 : Profiler repliable validé owner.
- R45D2A7 : projection hiérarchique Profiler acquise.
- R45D2A8 : diagnostic local-password détaillé acquis.
- R45D2A9B : message utilisateur login I18n + PRG acquis.
- R45D2A10 : corrélation trace POST login à travers PRG acquise.
- R45D2A11 : reset administrateur local-password acquis ; `essai2/steve` se connecte avec succès.
- R45D2A12 : UI Sources/Git alignée sur décision ACL `source/write`.
- R45D2A14B : logout généré atomiquement migré et validé.
- R45D2A15 : preuve fresh-auth backend non forgeable.
- R45D2A15B : catalogues REST front/back/server synchronisés.
- R45D2A16 : matrice Sécurité admin/developer/viewer alignée.
- R45D2A16B : dev-server single-owner binding publié sous `af4016a...`.
- R45D2A17 : fresh-auth lié cryptographiquement à `preview|commit`, publié sous `8f0d6ba...`.
- R45D2A18 : FSM dédiée aux mutations Sécurité, publiée sous `98b0233...`.
- R45D2A18B : intégrité `backend.operations.json -> composer.json` publiée sous `9d3c4d5...`; le script fresh-auth est réellement lancé.
- `GET /fr-FR/security` et `security.snapshot` sont fonctionnels ; corrélation front -> REST -> back -> Composer observée.

## Matrice ACL à préserver

Voir `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`.

Admin + developer peuvent muter Sécurité ; viewer reste lecture seule et sans Profiler. Autorisation via permissions ACL effectives, jamais `primary_role`.

## Incident courant

Lors d'une Preview Sécurité, le script `owasys:security-fresh-auth-proof` est maintenant résolu et démarré, mais échoue avec :

```text
OWASYS_FRESH_AUTH_PROOF_SECRET_INVALID
```

Cause : `OwasysFreshAuthProofService` attend `OPUS_OWASYS_FRESH_AUTH_PROOF_SECRET`, mais cette variable n'est pas déclarée dans la politique `OPUS_APPLICATION_ENVIRONMENTS_V1` de `sites/owasys-back/config/site.json`.

Les secrets REST existants utilisent déjà `OPUS_DEVELOPMENT_DERIVED_SECRET_V1`. Le fresh-auth doit rejoindre cette autorité canonique plutôt que dépendre d'un `set` manuel.

## Livrable actif — R45D2A18C

```text
ZIP     : opus_p117w_r45d2a18c_fresh_auth_runtime_secret_policy.zip
SHA-256 : 253b0aba17d839c728ac1a3f602baf2e8b471f27b64314105cef47647c71ec85
BASE    : 9d3c4d5463483cc520d381f7f8de83cfd5e352c4
FILES   : 2
```

R45D2A18C déclare le secret fresh-auth dans la politique d'environnement : dérivation OPUS automatique en dev, variables externes obligatoires en test/prod, `secret: true`, aucun secret versionné.

## Gate owner

1. appliquer R45D2A18C ;
2. applicateur + smoke ;
3. valider `site.json` ;
4. démarrer `owasys-back` sans `set` manuel du secret ;
5. démarrer `owasys-front` ;
6. admin : Preview Sécurité ;
7. fresh-auth doit réussir ;
8. Preview doit réussir ;
9. nouvelle réauthentification ;
10. Commit doit réussir ;
11. contrôler Profiler/Logger ;
12. répéter developer ;
13. viewer reste lecture seule.

NO MANUAL DEV SECRET.
NO SECRET IN GIT.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PASSWORD/PROOF LOGGING.
NO CROSS-PHASE PROOF.
NO REST REPLAY STORE.
NO PUSH OPUS/OWASYS BY ASSISTANT.
