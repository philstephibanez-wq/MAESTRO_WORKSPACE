# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-11.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 98b0233bf85f33037f45adde916514c6f8305a16
Commit : opus_p117w_r45d2a18_security_mutation_fsm
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
- `GET /fr-FR/security` et `security.snapshot` sont fonctionnels ; corrélation front -> REST -> back -> Composer observée.

## Matrice ACL à préserver

Voir `CONTEXT/SPECIFICATIONS/OWASYS_ROLE_CAPABILITY_MATRIX_2026-08-11.md`.

Admin + developer peuvent muter Sécurité ; viewer reste lecture seule et sans Profiler. Autorisation via permissions ACL effectives, jamais `primary_role`.

## Incident courant

Lors d'une Preview Sécurité, le front demande correctement une preuve fresh-auth. Le back reçoit :

```text
POST /api/v1/applications/essai2/security/fresh-auth-proofs
operation=security.fresh-auth-proof.issue
```

mais renvoie :

```text
OPUS_REST_API_COMPOSER_SCRIPT_UNDECLARED
```

Cause : `backend.operations.json` référence `owasys:security-fresh-auth-proof` et `composer.commands.json` possède alias/provider interne, mais le script public manque dans la section `scripts` du `composer.json` racine. `ComposerCommandRegistry` valide directement contre cette section.

## Livrable actif — R45D2A18B

```text
ZIP     : opus_p117w_r45d2a18b_rest_composer_catalog_integrity.zip
SHA-256 : a4dc4e13778f96037c5f9e9470e6c673e1f58857572e99757c01304458642a27
BASE    : 98b0233bf85f33037f45adde916514c6f8305a16
FILES   : 2
```

R45D2A18B ajoute le script public manquant et introduit un smoke global de cohérence `backend.operations.json -> composer.json`, en exerçant `ComposerCommandRegistry::publicOperations()`.

## Gate owner

1. appliquer R45D2A18B ;
2. applicateur + smoke ;
3. dump-autoload ;
4. relancer back/front ;
5. admin : Preview Sécurité ;
6. fresh-auth REST -> Composer doit réussir ;
7. Preview doit réussir ;
8. nouvelle réauthentification ;
9. Commit doit réussir ;
10. contrôler Profiler/Logger ;
11. répéter developer ;
12. viewer reste lecture seule.

NO SITE-SPECIFIC PATCH.
NO ACL BYPASS.
NO VIEWER MUTATION.
NO PASSWORD/PROOF LOGGING.
NO CROSS-PHASE PROOF.
NO REST REPLAY STORE.
NO PUSH OPUS/OWASYS BY ASSISTANT.
