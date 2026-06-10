# SERVER_LINUX — Remote access

## Priorité des accès

1. SSH
2. WinSCP / SFTP
3. xrdp + Xfce
4. RustDesk
5. AnyDesk en secours optionnel

## SSH

SSH est l'accès de secours principal.

Règles :

- mot de passe fort ou clé SSH ;
- pas d'exposition publique sans durcissement ;
- logs surveillés ;
- accès root direct désactivable après stabilisation.

## WinSCP / SFTP

WinSCP sert au transfert et à l'inspection de fichiers depuis Windows.

Usage :

- édition contrôlée ;
- transfert de patchs ;
- récupération de logs ;
- pas de modification sauvage des racines applicatives.

## xrdp + Xfce

xrdp permet un bureau accessible depuis Windows.

Rôle : confort d'administration LAN.

Règles :

- Xfce privilégié ;
- éviter GNOME/Wayland pour cette cible ;
- le bureau distant n'est pas le point unique de contrôle.

## RustDesk

RustDesk est recommandé comme solution pratique et cohérente avec une architecture privée.

Atouts :

- multiplateforme ;
- fonctionne bien sous Linux/Xfce ;
- auto-hébergement possible ;
- utile hors LAN.

## AnyDesk

Compatible Linux, mais option secondaire.

Rôle : secours ou confort, pas fondation serveur.
