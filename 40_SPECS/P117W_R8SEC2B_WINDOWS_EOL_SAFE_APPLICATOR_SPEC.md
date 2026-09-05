# P117W R8SEC2B — Windows EOL-safe applicator

## Objet

Corriger la gate d'application de R8SEC2A sans modifier la cible fonctionnelle de R8SEC2.

## Constat

Sur Windows, les fichiers suivis par Git peuvent être matérialisés en CRLF dans le working tree tout en restant propres selon Git. R8SEC2A valide correctement le blob canonique de `HEAD`, mais son moteur de transformation recherche ensuite des fragments LF exacts dans les octets CRLF du working tree. La conséquence observée est `R8SEC2_RUNTIME_CONSTRUCTOR_PATTERN:0` avant toute écriture.

## Règle

L'applicateur doit :

1. vérifier que chacune de ses cibles est propre via Git ;
2. vérifier le blob canonique `HEAD:<path>` attendu ;
3. normaliser en mémoire les fins de ligne `CRLF` et `CR` vers `LF` avant toute transformation textuelle ;
4. appliquer les transformations uniquement sur cette représentation canonique ;
5. écrire les fichiers complets transformés ;
6. rester fail-closed sur toute cible sale, tout blob inattendu ou tout motif absent/multiple.

Le fichier runtime `sites/essai/config/application.fsm.layout.json` n'est pas une cible et ne doit être ni modifié ni nettoyé par ce livrable.

## Cible fonctionnelle inchangée

- `security_violation / NMI -> security_quarantine` ;
- `critical_error / NMI -> fault` ;
- contrôle de quarantaine durable avant le dispatch métier dans `GeneratedSiteRuntime` ;
- aucun recovery automatique.
