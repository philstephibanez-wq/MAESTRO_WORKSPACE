# OPENAI_ASSISTANT launchers

Ces lanceurs `.cmd` évitent de retaper la commande longue :

```text
python H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\ask_maestro.py ...
```

Ils ne contiennent aucune clé API.

## Contrat P111

```text
READ ONLY
aucun patch automatique
aucun git add / commit / push
aucun checkout / reset / clean
aucune suppression
aucune clé API dans les fichiers
```

## Usage générique

```powershell
H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\maestro_ask.cmd --repo H:\MO_KB_DAEMON --status --question "Résume ce dépôt"
```

## Tests rapides

```powershell
H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\maestro_ask_dry_run.cmd
H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\maestro_ask_daemon_status.cmd
H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\maestro_ask_front_status.cmd
H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\maestro_ask_maestro_v5_status.cmd
```

`maestro_ask_all_status.cmd` lance 3 appels API, donc il consomme plus.
