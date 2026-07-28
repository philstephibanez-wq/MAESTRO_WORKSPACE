# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-28

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_P117W_R20_RESTORE_OWASYS_FUNCTIONAL_OPERATION_PARITY_2026-07-28.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R20_RESTORE_OWASYS_FUNCTIONAL_OPERATION_PARITY_2026-07-28.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Ancien OWASYS audité : e1055468213ae62806c039ca0231a49a98d844fe
État actuel audité   : dc47342006f7f6a5fc0b6d18fe06d12ac2b82bb5
Racine owner         : H:\OPUS
```

## Architecture

Conserver uniquement :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne restaurer aucun site monolithique, aucun partage filesystem et aucun vestige `owasys_old*`.

## État runtime confirmé

```text
owasys-front : 127.0.0.1:8000
owasys-back  : 127.0.0.1:8080
registry.sync : succès
frontend /fr-FR/applications : succès
```

## Audit fonctionnel P117W R20

Parité confirmée pour :

```text
connexion / SSO
compte et changement de mot de passe
session et application courante
registre SQLite
synchronisation, sélection et effacement du registre
création d’application
routes et FSM
ACL deny-by-default
I18n UE + ukrainien
rendu SCORE
Logger et Profiler
REST backend
Composer allow-listé
```

Les modules suivants étaient déjà des surfaces `OWASYS_MODULE_PENDING` dans l’ancien site :

```text
structure
data
workflows
security
source
build
```

## Écart réel identifié

L’ancien catalogue backend contenait 11 opérations. Le catalogue actuel n’en contient que 7.

Restaurer :

```text
site.language.add -> opus:add-language
site.page.create  -> opus:create-page
site.rubric.create -> opus:create-rubric
site.export       -> opus:export-site
```

## Livrable actif

```text
ZIP : opus_p117w_r20_restore_owasys_functional_operation_parity.zip
SHA-256 : 14c9f5cd4fa0e6228926aec8fe78821ec68d7de600c872657dfebfb70e2e48c5
Fichiers : 1
```

Contenu exclusif :

```text
sites/owasys-back/config/backend.operations.json
```

## Appliquer et valider

```text
cd /d H:\OPUS
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r20_restore_owasys_functional_operation_parity.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r20_restore_owasys_functional_operation_parity.zip" -C H:\OPUS
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
php -r "$j=json_decode(file_get_contents('sites/owasys-back/config/backend.operations.json'),true,512,JSON_THROW_ON_ERROR); foreach(['site.language.add','site.page.create','site.rubric.create','site.export'] as $id){echo (isset($j['operations'][$id])?'OK ':'MISSING ').$id.PHP_EOL;} echo 'TOTAL='.count($j['operations']).PHP_EOL;"
git status --short
```

## Statut

```text
P117W R6 à R19 : présents/appliqués
P117W R20 : livrable actif
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
