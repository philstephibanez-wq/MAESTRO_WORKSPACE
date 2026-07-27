# OPUS P117W R18 — CONSERVER LA CAUSE RACINE DES ERREURS CONSOLE

Date : 2026-07-27  
État : ZIP différentiel produit ; validation runtime owner requise

## Lire

Lire `README-FIRST.md` et appliquer tous les contrats MAESTRO/OPUS actifs.

## Constater

Le trace actif `96902adf1f9fd87c` prouve :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer owasys:registry-sync
```

Le processus Composer retourne le code `20`, mais `OpusConsoleApplication::safeErrorCode()` remplace toute exception dont le message contient une valeur dynamique ou un message PHP par :

```text
OPUS_CONSOLE_COMMAND_FAILED
```

La cause interne, son fichier et sa ligne sont donc supprimés avant que `ComposerCommandExecutor` puisse les enregistrer dans l’unique Logger backend.

## Corriger génériquement OPUS

Modifier uniquement :

```text
Opus/Console/OpusConsoleApplication.php
```

Conserver le code d’erreur complet lorsqu’il respecte déjà le contrat.

Lorsque le message commence par un code OPUS/OWASYS stable suivi d’un contexte dynamique, conserver le préfixe stable.

Pour les réponses JSON internes Composer/RCP, ajouter un bloc `diagnostic` contenant :

```text
error_code
exception_class
exception_file relatif à la racine OPUS
exception_line
exception_message nettoyé et tronqué
fingerprint
```

Remplacer les secrets usuels par `<redacted>` et ne jamais exposer un chemin absolu extérieur à la racine OPUS.

Conserver la réponse texte publique limitée au code d’erreur.

Ne modifier ni le frontend, ni REST, ni ComposerCommandExecutor, ni Logger, ni Profiler dans R18.

## Livrer

```text
ZIP : opus_p117w_r18_preserve_console_root_cause_diagnostics.zip
SHA-256 : 597137c99d95cb89bfcd262e0f6a465062432f43ce60826027cf72e31f731962
Fichiers : 1
Octets ZIP : 4014
Octets non compressés : 19261
```

Inclure uniquement :

```text
Opus/Console/OpusConsoleApplication.php
```

Ne livrer aucun `tools`, aucun script, aucun fichier runtime, aucun journal, aucun secret et aucune racine partagée.

## Valider

```text
PHP lint                                    : OK
Code stable avec suffixe dynamique          : conservé
Message PHP non contractuel                  : code générique + diagnostic
Chemin OPUS                                  : relatif
Chemin extérieur                             : masqué
Token, HMAC, secret, mot de passe, bearer    : caviardés
ZIP directement superposable                 : OK
```

Marqueur :

```text
P117W_R18_CONSOLE_DIAGNOSTIC_OK
```

R18 ne prétend pas corriger encore l’erreur métier masquée. Il supprimer le mécanisme qui détruit sa cause avant journalisation, afin que le prochain appel fournisse le fichier, la ligne et le message réellement fautifs dans `owasys-back.log`.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
