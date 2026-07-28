# MAESTRO_WORKSPACE HANDOFF — OPUS P117W R23

Date : 2026-07-28  
État : livrable cumulatif R22 + R23 à appliquer et valider côté owner

## Source

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base exacte : 4868780af4dd65bb7e28d95c981d1a1c5800a243
Racine owner : H:\OPUS
```

## Évolution

R23 ajoute le cycle de suppression sécurisé d’un site généré :

```text
SCORE -> REST sécurisé -> owasys-back -> Composer -> OPUS
```

Commande :

```text
composer opus:delete-site -- <id> --confirm=<id> [--write]
```

Protections :

```text
owasys-front : suppression interdite
owasys-back  : suppression interdite
site non généré par Composer : suppression interdite
cible hors sites/<id> : suppression interdite
lien symbolique : suppression interdite
confirmation différente : suppression interdite
```

La suppression réelle exige `--write`. L’interface SCORE ne propose l’action
que pour `generated_by=composer` et
`role=generated-opus-application`. Après succès, la réconciliation R22 retire
l’entrée SQLite obsolète.

## Livrable

```text
ZIP : opus_p117w_r23_generated_site_secure_deletion.zip
SHA-256 : b4f29bd657aaec2faf52a883f4bedd03cc09d5356ef67bb2de03970baa17763b
Fichiers : 15
```

## Validation owner

```text
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r23_generated_site_secure_deletion.zip" -C H:\OPUS
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:delete-site -- owasys-front --confirm=owasys-front --write
composer opus:delete-site -- owasys-back --confirm=owasys-back --write
git diff --check
git status --short
```

Les deux essais OWASYS sont des tests négatifs obligatoires et doivent échouer
avec `OPUS_DELETE_SITE_PROTECTED`.

## Lancement

```text
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
