# R8B6X — OPUS FTP PHP 8 + interface homonyme

## Baseline

OPUS master audité : `7dfb6206986cf1b7a738065df235fd04ab19fb3b` (`R8B6U`).

## Cause

L'audit général OPUS/OWASYS a isolé trois erreurs sur un seul composant : `Opus/Ftp/Ftp.class.php`.

- classe concrète `OPUS_Ftp` sans interface homonyme `OPUS_FtpInterface` ;
- short open tag `<?` ;
- syntaxe d'offset historique `{0}` supprimée en PHP 8.

Le dossier `Opus/Ftp` ne contenait que `Ftp.class.php` sur la baseline.

## Contrat du correctif

1. `OPUS_Ftp` implémente directement `OPUS_FtpInterface`.
2. `OPUS_FtpInterface` étend directement les quatre interfaces framework obligatoires :
   - `OpusFrameworkComponentInterface` ;
   - `OpusExceptionAwareInterface` ;
   - `OpusProfilerAwareInterface` ;
   - `OpusSelfDocumentingInterface`.
3. Le fichier FTP est du PHP 8 valide avec `<?php`.
4. Aucun offset `{...}` historique n'est conservé.
5. L'API publique historique FTP reste disponible : connect/login/cwd/get/put/raw/rawlist/ls/rename/rmdir/site/size/systype et alias historiques.
6. Aucun changement métier OWASYS dans ce lot.
7. Les trois artefacts racine détectés par R8B6W sont supprimés par l'owner avant application de ce ZIP.
8. L'avertissement `fallback_locale: fr-FR` est volontairement hors périmètre et sera traité dans un lot I18n séparé.

## Validation attendue

- `php -l Opus\Ftp\OPUS_FtpInterface.php` : OK ;
- `php -l Opus\Ftp\Ftp.class.php` : OK ;
- `composer dump-autoload -o` : OK ;
- `python tools\audit_opus_owasys.py` ne remonte plus les trois erreurs FTP ni les trois artefacts racine ;
- `git diff --check` : aucune erreur.

## Livraison

ZIP différentiel natif : `R8B6X.zip`.

Contenu :

- `Opus/Ftp/Ftp.class.php`
- `Opus/Ftp/OPUS_FtpInterface.php`

SHA-256 ZIP : `70fea2137ed5a8c8c899795193e993d5230e30dfe7780b6010a7667241c0c70d`.
