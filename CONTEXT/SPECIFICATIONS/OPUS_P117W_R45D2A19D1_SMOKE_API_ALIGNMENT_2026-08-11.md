# OPUS P117W R45D2A19D1 — Smoke API alignment

Date : 2026-08-11
Statut : correctif de validation de R45D2A19D, aucune modification fonctionnelle OPUS/OWASYS

## Constat owner

Après application de R45D2A19D, le smoke échoue avec :

`Call to undefined method Opus\Security\Acl\AclPolicy::isAllowed()`

Le `git status --short` owner matérialise bien les fichiers fonctionnels attendus de R45D2A19D : composer.json, OwasysCommandProvider.php, acl/back, backend.operations/resources/rest, composer.commands et rest.resources front.

## Cause

Le smoke R45D2A19D utilisait une API inexistante : `AclPolicy::isAllowed()`.

L'API canonique OPUS est :

`AclPolicy::decide(array $roles, string $resource, string $action): AclDecision`

et la décision se lit via `AclDecision::$allowed`.

Un second défaut latent était présent : `ComposerCommandRegistry::publicOperations()` retourne une liste d'entrées et non un tableau associatif indexé par nom d'opération.

## Correction

R45D2A19D1 remplace uniquement :

`tools/smoke_r45d2a19d_credential_ownership_atomic_cleanup.php`

Le smoke corrigé :

- utilise `AclPolicy::decide(...)->allowed` pour admin/developer/viewer ;
- itère réellement sur la liste retournée par `publicOperations()` ;
- conserve les contrôles d'absence de l'ancien flux `admin-password` ;
- conserve la comparaison des trois fingerprints REST ;
- conserve le contrôle que chaque opération REST référence un script Composer déclaré.

## Livrable

```text
ZIP     : opus_p117w_r45d2a19d1_smoke_api_alignment.zip
SHA-256 : 9bc4e07453f936bea8cea968ff6833c30bf9032a7211922b49e67d0f182599aa
FILES   : 1
```

## Gate owner

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45d2a19d1_smoke_api_alignment.zip"
php -l tools\smoke_r45d2a19d_credential_ownership_atomic_cleanup.php
php tools\smoke_r45d2a19d_credential_ownership_atomic_cleanup.php
git status --short
```

Attendu :

`OPUS_R45D2A19D_SMOKE_OK fingerprint=... operations=...`

Aucun nouveau changement fonctionnel ne doit apparaître en dehors du remplacement du smoke. Ne pas poursuivre vers developer/viewer avant succès de ce gate.
