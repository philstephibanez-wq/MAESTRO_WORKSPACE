# MAESTRO_WORKSPACE — AMENDEMENT P112C — DOCUMENTATION DOXYGEN-LIKE / REFERENCE BOOKS

---

## 18. Documentation contractuelle obligatoire et Reference Books

Tout fichier maintenu dans MAESTRO_WORKSPACE doit être documenté par des commentaires clairs, structurés et exploitables pour générer des Reference Books.

Cette règle s’applique aux scripts PHP, Lua, Python, JavaScript, PowerShell, CSS, configurations actives, engines, services, modules, composants, renderers, widgets et utilitaires.

La documentation doit être conçue dans l’esprit de Doxygen, phpDocumentor, JSDoc, LuaDoc ou PowerShell comment-based help.

### 18.1 Règle obligatoire

NO DOC CONTRACT, NO PATCH.

Aucune fonction publique, classe publique, API publique, composant public, section CSS publique ou script maintenu ne doit être ajouté sans documentation contractuelle.

### 18.2 Informations minimales à documenter

Chaque bloc public doit préciser :

- visibilité : PUBLIC, INTERNAL ou PRIVATE
- rôle
- responsabilité métier
- arguments ou paramètres
- retours
- erreurs ou exceptions possibles
- effets de bord
- contrat métier
- invariants si applicables
- version ou palier d’introduction si utile

### 18.3 CSS

Chaque section CSS publique ou structurante doit préciser :

- rôle visuel
- portée : PUBLIC, INTERNAL ou PRIVATE
- classes publiques utilisables
- classes internes réservées au composant
- dépendances éventuelles
- règles d’override
- interdictions métier

Le CSS représente. Il ne décide jamais un droit, une route, un état métier ou une action.

### 18.4 Scripts d’audit, installation, migration et cleanup

Chaque script maintenu doit préciser :

- ce qu’il lit
- ce qu’il écrit
- ce qu’il supprime
- ce qui est temporaire
- ce qui est conservé
- comment vérifier
- comment rollback si applicable

### 18.5 Reference Books

Chaque dépôt doit pouvoir produire à terme un Reference Book :

- ASAP Reference Book
- MAESTRO_V5 Reference Book
- MO_KB_DAEMON Reference Book
- MO_KB_FRONT Reference Book

Les commentaires publics doivent donc être structurés, stables et exploitables par un générateur documentaire.

### 18.6 Phrase canonique

Tout code maintenu doit être lisible par contrat.
Le commentaire ne décore pas : il déclare la responsabilité, la frontière et l’usage.
Les Reference Books doivent pouvoir être générés depuis le code documenté.

