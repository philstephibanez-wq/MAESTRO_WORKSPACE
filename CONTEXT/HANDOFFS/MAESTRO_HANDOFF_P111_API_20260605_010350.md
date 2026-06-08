# MAESTRO HANDOFF P111/API

Date: 2026-06-05 01:03:50

## État validé

- GitHub source distante de vérité active.
- Repos privés configurés et clean :
  - MAESTRO_V5 -> https://github.com/philstephibanez-wq/Maestro.git
  - MO_KB_DAEMON -> https://github.com/philstephibanez-wq/Maestro_KB_Engine.git
  - MO_KB_FRONT -> https://github.com/philstephibanez-wq/Maestro_KB_Extranet.git

## État Git

MAESTRO_V5:
## master...origin/master

MO_KB_DAEMON:
## master...origin/master

MO_KB_FRONT:
## master...origin/master

## Décisions actives

- MO_KB et applis KB = at home, privé, non distribuable public.
- MAESTRO et futurs VSTi = distribuables.
- UwAmp = hôte web local / junction uniquement.
- Source réelle front = H:\MO_KB_FRONT.
- MO_KB_STORE, MO_KB_VENDOR, UwAmp = hors dépôt code.
- Workgroup Windows abandonné pour la découverte réseau.
- Découverte future slaves = ARP / voisins réseau / ping / REST / SSH / enrôlement explicite.
- OPENAI_ASSISTANT_READONLY installé et testé.
- Clé API OpenAI stockée uniquement en variable d’environnement utilisateur.
- Aucun dossier *_EXTRACT temporaire conservé.

## Outils installés

- H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\ask_maestro.py
- H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\maestro_ask.cmd
- H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\maestro_ask_dry_run.cmd
- H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\maestro_ask_daemon_status.cmd
- H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\maestro_ask_front_status.cmd
- H:\MAESTRO_WORKSPACE\TOOLS\OPENAI_ASSISTANT\maestro_ask_maestro_v5_status.cmd

## Règle permanente

Travail propre par défaut :
- pas de scories,
- pas de dossiers d’extraction inutiles,
- pas de patch sans source de vérité,
- pas de fallback silencieux,
- pas de clé API dans Git/log/ZIP/chat.
