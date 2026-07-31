# MAESTRO WORKSPACE — handoff OPUS P117W R45A1

Date : 2026-07-31  
Base OPUS : `7dbceea`  
Livrable : `opus_p117w_r45a1_acl_deny_priority_and_structured_loading.zip`

## Objet

Premier incrément du socle générique de sécurité R45A. Aucun fichier OWASYS ni `sites/test2` n'est modifié.

Fichiers complets :

- `Opus/Security/Access/ConfigAclPolicy.php`
- `Opus/Security/Access/Engine/HierarchicalAclEngine.php`

## Corrections

- tout deny applicable prévaut désormais sur tout allow applicable, indépendamment de l'ordre des règles ;
- l'absence d'allow reste un refus par défaut ;
- la trace de décision expose séparément les règles allow et deny correspondantes ;
- `ConfigAclPolicy` lit la configuration par `StructuredFileLoader`, donc File + Json, sans `file_get_contents` ni `json_decode` local.

## Validation owner obligatoire

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45a1_acl_deny_priority_and_structured_loading.zip" -C H:\OPUS
php -l Opus\Security\Access\ConfigAclPolicy.php
php -l Opus\Security\Access\Engine\HierarchicalAclEngine.php
composer dump-autoload -o
git diff --check
git status --short
```

L'owner doit en plus exécuter les smokes ACL existants et prouver les deux ordres `allow puis deny` et `deny puis allow`, tous deux refusés.

## Suite

Après acceptation R45A1 : R45A2 introduira les objets contractuels typés et les tests génériques pour rôle, permission, ressource, scope, attribution SSO et décision effective.

R45B/C/D restent bloqués. `test2` reste intact.
