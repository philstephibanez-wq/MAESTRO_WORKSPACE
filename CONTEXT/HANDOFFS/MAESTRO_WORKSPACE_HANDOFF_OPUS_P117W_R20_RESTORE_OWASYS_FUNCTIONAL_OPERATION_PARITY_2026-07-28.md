# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R20

Date : 2026-07-28  
État : livrable actif à appliquer et valider côté owner

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

## Audit de parité fonctionnelle

Parité confirmée pour :

```text
connexion / SSO
compte et changement de mot de passe
session et application courante
registre SQLite
synchronisation, sélection et effacement du registre
création d’application
routes et FSM
ACL
I18n UE + ukrainien
SCORE
Logger / Profiler
REST backend
Composer allow-listé
```

Les modules `structure`, `data`, `workflows`, `security`, `source` et `build` étaient déjà rendus par `pending.score` dans l’ancien site. Leur état actuel n’est pas une perte de migration.

## Écart réel

L’ancien `backend.operations.json` exposait 11 opérations. Le fichier actuel n’en expose que 7.

Restaurer :

```text
site.language.add
site.page.create
site.rubric.create
site.export
```

Les scripts Composer correspondants existent toujours :

```text
opus:add-language
opus:create-page
opus:create-rubric
opus:export-site
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

Ne livrer aucun `tools`, aucun script, aucun fichier runtime, aucun journal, aucun secret et aucune racine partagée.

## Appliquer

```text
cd /d H:\OPUS
certutil -hashfile "%USERPROFILE%\Downloads\opus_p117w_r20_restore_owasys_functional_operation_parity.zip" SHA256
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r20_restore_owasys_functional_operation_parity.zip" -C H:\OPUS
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
git status --short
```

## Contrôler le catalogue

```text
php -r "$j=json_decode(file_get_contents('sites/owasys-back/config/backend.operations.json'),true,512,JSON_THROW_ON_ERROR); foreach(['site.language.add','site.page.create','site.rubric.create','site.export'] as $id){echo (isset($j['operations'][$id])?'OK ':'MISSING ').$id.PHP_EOL;} echo 'TOTAL='.count($j['operations']).PHP_EOL;"
```

Résultat attendu :

```text
OK site.language.add
OK site.page.create
OK site.rubric.create
OK site.export
TOTAL=11
```

## Relancer

```text
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
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
