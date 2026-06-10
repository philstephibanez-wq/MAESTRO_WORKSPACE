# SERVER_LINUX — Maintenance runbook

## Objectif

Documenter les gestes récurrents de maintenance du serveur Linux.

## À maintenir

- mises à jour Debian ;
- état Apache ;
- état PHP ;
- logs système ;
- espace disque ;
- sauvegardes ;
- certificats HTTPS ;
- accès SSH ;
- disponibilité RefBook ;
- disponibilité sites.

## Règles

- Pas de correction sauvage.
- Pas de paquet ajouté sans justification.
- Pas de service activé sans documentation.
- Toute modification serveur doit être notée.
- Toute erreur doit être conservée dans l'historique.

## Journal recommandé

Créer plus tard :

```text
/srv/maestro_workspace/server_linux_logs
```

ou, côté workspace :

```text
H:\MAESTRO_WORKSPACE\20_TECHNICAL_FOUNDATIONS\SERVER_LINUX\maintenance
```

## Checklist périodique

- Vérifier mises à jour de sécurité.
- Vérifier espace disque.
- Vérifier logs Apache.
- Vérifier logs SSH.
- Vérifier certificats.
- Vérifier sauvegardes.
- Vérifier redémarrage propre.
