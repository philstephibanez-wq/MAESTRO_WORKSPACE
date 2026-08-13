# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-13.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 2e17008ad0cf23e70195ee2c0f6c947ecb5333be
Commit : opus_p117w_r45d2a22d_account_canonical_route_alias
```

## États acquis récents

- R45D2A21C : cockpit Sécurité compact validé ;
- R45D2A22 : matrice de capacités admin/developer/viewer validée ;
- rôle viewer validé en navigateur sur Sécurité, Sources/Git, Build, Profiler et Compte ;
- R45D2A22B : Profiler piloté par ACL ;
- R45D2A22C1 : page 403 ACL graphique validée ;
- R45D2A22D : alias Compte canonique publié.

## Gate actif — R45D2A23

Localiser les routes publiques owasys-front sans traduire les routes internes.

Évolution générique : `Opus\Http\LocalizedRouteResolver` et interface homonyme.

Le catalogue couvre les 25 langues de base. Les variantes régionales héritent de leur langue de base. Les accents, diacritiques, grec et cyrillique sont conservés.

Exemples français :

```text
/fr-FR/sécurité
/fr-FR/compte/mot-de-passe
/fr-FR/sources-de-données
/fr-FR/sources-et-git/...
/fr-FR/construction-et-validation
```

Le préfixe Sources/Git est localisé mais le chemin réel du fichier reste opaque. La navigation et le changement de langue génèrent le slug de la langue cible. Les anciennes routes techniques restent compatibles en entrée. Le backend n'est pas concerné par cette localisation.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a23_localized_public_routes.zip
SHA-256 : f1b6cd0ef27512e425dcfda61254f253559b4b606d0b69ed1a7951687eda3e99
BASE    : 2e17008ad0cf23e70195ee2c0f6c947ecb5333be
FILES   : 4
```

Après validation owner de R45D2A23, reprendre la prochaine évolution fonctionnelle Sécurité prévue au handoff.
