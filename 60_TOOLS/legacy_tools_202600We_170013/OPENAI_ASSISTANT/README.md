# OPENAI_ASSISTANT_READONLY

Assistant API local pour `H:\MAESTRO_WORKSPACE`.

## Objectif

Créer un pont local contrôlé entre :

```text
MAESTRO_WORKSPACE
GitHub source of truth
dépôts locaux
API OpenAI
```

## Contrat P111

```text
READ ONLY par défaut.
Aucun patch automatique.
Aucun git add / commit / push.
Aucun checkout / reset / clean.
Aucune suppression.
Aucune clé API dans Git.
```

## Fichiers

```text
H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\ask_maestro.py
H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\README.md
```

## Pré-requis

Variable d’environnement utilisateur Windows :

```text
OPENAI_API_KEY
```

Optionnel :

```text
OPENAI_MODEL
```

Par défaut, le script utilise :

```text
gpt-5.5
```

## Vérifier la clé

```powershell
Get-ChildItem Env:OPENAI_API_KEY
```

Si elle manque, la définir en remplaçant `sk-...` par ta clé réelle :

```powershell
[Environment]::SetEnvironmentVariable("OPENAI_API_KEY", "sk-...", "User")
```

Puis fermer/réouvrir PowerShell.

## Test sans API

```powershell
python H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\ask_maestro.py --dry-run --repo H:\MO_KB_DAEMON --status --question "Test lecture seule du contexte P111"
```

## Test API minimal

```powershell
python H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\ask_maestro.py --repo H:\MO_KB_DAEMON --status --question "Résume l'état de ce dépôt en mode P111 lecture seule"
```

## Analyse d’un diff

```powershell
python H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\ask_maestro.py --repo H:\MO_KB_DAEMON --status --diff --question "Analyse ce diff sans patcher. Donne les risques et les vérifications."
```

## Lire un fichier précis

```powershell
python H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\ask_maestro.py --file H:\MO_KB_DAEMON\app\core\paths.py --question "Explique le rôle de ce fichier et les risques P111."
```

## Sorties

Les réponses sont sauvegardées dans :

```text
H:\MAESTRO_WORKSPACE\OUTBOX\OPENAI_ASSISTANT
```
