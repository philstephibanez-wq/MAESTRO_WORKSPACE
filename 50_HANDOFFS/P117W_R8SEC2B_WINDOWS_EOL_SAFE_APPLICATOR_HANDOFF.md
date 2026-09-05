# P117W R8SEC2B — Handoff

## État observé

R8SEC2A n'a écrit aucune cible. L'exécution s'est arrêtée sur `R8SEC2_RUNTIME_CONSTRUCTOR_PATTERN:0`. Les contrôles suivants ont montré aucun diff sur les cinq cibles. Seul `sites/essai/config/application.fsm.layout.json` est sale ; ce fichier de layout runtime est hors périmètre et doit être préservé.

## Cause racine

Le working tree Windows matérialise les fichiers texte avec des fins de ligne CRLF alors que les motifs embarqués dans l'applicateur sont LF. Git considère néanmoins les cibles propres et le blob `HEAD` est conforme. La recherche textuelle exacte échoue donc avant écriture.

## Correctif R8SEC2B

Normaliser les fins de ligne des contenus lus en mémoire vers LF avant les remplacements, tout en conservant :

- gate Git cible propre ;
- gate blob `HEAD:<path>` attendu ;
- fail-closed sur motif absent ou multiple ;
- aucune modification/RAZ du layout utilisateur/runtime ;
- même cible fonctionnelle R8SEC2.

## Validation owner attendue

1. SHA-256 du ZIP ;
2. listing ZIP ;
3. extraction ;
4. lint applicateur ;
5. exécution avec `R8SEC2B_OK` ;
6. lint PHP des cibles ;
7. validation JSON ;
8. `composer dump-autoload -o` ;
9. `git diff --check` ;
10. inspection `git status` et `git diff` ;
11. suppression de l'applicateur temporaire seulement.
