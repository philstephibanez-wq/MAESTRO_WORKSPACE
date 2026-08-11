# OPUS P117W R45D2A18B — REST / Composer catalog integrity

Date : 2026-08-11  
Statut : livrable correctif actif, owner à appliquer/valider

## Base

OPUS master observé :

```text
98b0233bf85f33037f45adde916514c6f8305a16  opus_p117w_r45d2a18_security_mutation_fsm
8f0d6ba5a009fbd5c4348d1f4f6cc789ce813ee6  opus_p117w_r45d2a17_fresh_auth_phase_binding
af4016a642c5595304fadbbdab5990bd7e6f3ea9  opus_p117w_r45d2a16b_dev_server_single_owner_binding
```

## Symptôme owner

Dans OWASYS Sécurité, une demande de prévisualisation déclenche :

```text
OPUS_REST_API_COMPOSER_SCRIPT_UNDECLARED
```

Logs corrélés :

- front reçoit `POST /fr-FR/security` ;
- back reçoit `POST /api/v1/applications/essai2/security/fresh-auth-proofs` ;
- opération résolue : `security.fresh-auth-proof.issue` ;
- rejet dans `Opus/Api/Composer/ComposerCommandRegistry.php` avant exécution Composer ;
- `security.snapshot` reste sain et répond 200.

## Cause racine

Le registre REST `ComposerCommandRegistry` valide chaque `composer_script` d'une opération contre la section `scripts` du `composer.json` racine.

Trois niveaux étaient partiellement synchronisés :

1. `sites/owasys-back/config/backend.operations.json` référence `owasys:security-fresh-auth-proof` ;
2. `sites/owasys-back/config/composer.commands.json` possède l'alias vers `owasys:security:fresh-auth-proof` et la commande provider interne ;
3. `composer.json` ne déclare pas le script public `owasys:security-fresh-auth-proof`.

Le point 3 manque : le registre lève donc `OPUS_REST_API_COMPOSER_SCRIPT_UNDECLARED`.

## Correction R45D2A18B

Ajouter au `composer.json` racine :

```json
"owasys:security-fresh-auth-proof": "Opus\\Composer\\ComposerScripts::run"
```

La correction ne touche ni ACL, ni SSO, ni FSM, ni protocole fresh-auth, ni catalogues REST de ressources.

## Prévention systémique

Le smoke R45D2A18B audite la totalité de `backend.operations.json` : chaque `composer_script` doit exister dans `composer.json`.

Il exerce ensuite la même classe framework qui a échoué en production locale :

```text
ComposerCommandRegistry::fromRoot(...)->publicOperations()
```

Ainsi, une future opération REST dont le script Composer public n'est pas déclaré échoue pendant le smoke, avant le test navigateur.

Le smoke contrôle aussi l'alias et la commande provider fresh-auth dans `composer.commands.json`.

## Livrable

```text
ZIP     : opus_p117w_r45d2a18b_rest_composer_catalog_integrity.zip
SHA-256 : a4dc4e13778f96037c5f9e9470e6c673e1f58857572e99757c01304458642a27
FILES   : 2
```

Contenu :

```text
tools/r45d2a18b_apply_rest_composer_catalog_integrity.php
tools/smoke_r45d2a18b_rest_composer_catalog_integrity.php
```

## Gate owner

1. appliquer le ZIP ;
2. exécuter applicateur puis smoke ;
3. `composer dump-autoload -o` ;
4. relancer owasys-back puis owasys-front ;
5. Sécurité admin : demander Preview ;
6. vérifier que fresh-auth passe REST -> Composer sans `SCRIPT_UNDECLARED` ;
7. vérifier ensuite preview puis commit avec nouvelle fresh-auth ;
8. conserver la matrice admin/developer/viewer ;
9. aucun mot de passe ni preuve complète dans Logger/Profiler.

NO SITE-SPECIFIC PATCH.  
NO ACL BYPASS.  
NO VIEWER MUTATION.  
NO REST REPLAY STORE.  
NO PASSWORD/PROOF LOGGING.  
NO PUSH OPUS/OWASYS BY ASSISTANT.
