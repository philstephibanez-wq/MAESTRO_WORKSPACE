# SERVER_LINUX — Project contract

## Rôle

Le serveur Linux est une fondation technique destinée à héberger des services web et de documentation autour de Maestro, ASAP et MO_KB.

## Contrats permanents

- Debian stable privilégiée.
- Installation minimale et documentée.
- SSH comme accès de secours principal.
- Interface graphique légère uniquement pour confort d'administration.
- Frameworks séparés des sites exposés.
- Aucun framework exposé directement par le serveur web.
- Chemins explicites.
- Zéro fallback silencieux.
- Erreurs claires.
- Aucune ouverture publique d'administration.
- HTTPS obligatoire avant exposition publique.

## Séparation des responsabilités

- `/opt/asap` : framework mutualisé.
- `/srv/asap_ref_book` : site RefBook exposé.
- `/srv/maestro_workspace` : documentation, rapports, patchs et historique workspace.
- `/srv/sites` : autres sites applicatifs.
- `/var/log` : logs système et applicatifs.
- `/home/steph` : espace utilisateur, jamais source canonique projet.
