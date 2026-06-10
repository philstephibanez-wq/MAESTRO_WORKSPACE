# SERVER_LINUX — Installation plan

## Phase 1 — Préparation

- Télécharger Debian stable netinst.
- Préparer une clé USB bootable.
- Préparer éventuellement une clé Debian Live Xfce pour test matériel.
- Relever les disques présents.
- Décider du disque système.
- Vérifier sauvegardes avant toute installation.

## Phase 2 — Installation Debian

Sélections minimales :

- SSH server ;
- standard system utilities ;
- Xfce si bureau graphique voulu.

À ne pas installer pendant cette phase :

- serveur web ;
- base de données ;
- outils applicatifs ;
- services publics.

## Phase 3 — Premier boot

- Vérifier connexion réseau.
- Vérifier accès local.
- Vérifier SSH depuis Windows.
- Vérifier WinSCP/SFTP.
- Mettre à jour le système.
- Activer le pare-feu.

## Phase 4 — Accès distant confortable

- Installer xrdp.
- Tester Bureau à distance Windows.
- Installer RustDesk si souhaité.
- Garder SSH comme accès de secours principal.

## Phase 5 — Structure serveur

Créer les racines cibles :

```text
/opt/asap
/srv/asap_ref_book
/srv/maestro_workspace
/srv/sites
/var/log
```

## Phase 6 — Web stack

- Installer Apache.
- Installer PHP via paquets Debian.
- Tester PHP local.
- Créer virtual host RefBook.
- Ne jamais exposer directement `/opt/asap`.

## Phase 7 — Déploiement applicatif

- Déployer ASAP dans `/opt/asap`.
- Déployer ASAP_REF_BOOK dans `/srv/asap_ref_book`.
- Configurer `ASAP_ROOT=/opt/asap`.
- Tester RefBook en local.
- Tester RefBook depuis le LAN.

## Phase 8 — Publication publique

Seulement après validation locale :

- DNS ;
- HTTPS ;
- reverse proxy ou Cloudflare Tunnel ;
- durcissement accès admin ;
- sauvegardes ;
- monitoring.
