# SERVER_LINUX — Installation decisions

## Machine cible

HP Elite 800 G3 ou machine équivalente dédiée au rôle serveur.

## Distribution recommandée

Choix recommandé : Debian stable officielle du moment.

La fiche initiale recommande Debian stable, avec une installation légère et stable pour héberger HTTP, ASAP_REF_BOOK, PHP/ASAP et accès distant.

## Live USB ou netinst ?

### Live USB Debian Xfce

Statut : utile pour test matériel.

Usage recommandé :

- démarrer sans modifier le disque ;
- vérifier le boot UEFI/BIOS ;
- vérifier réseau, affichage, clavier/souris ;
- vérifier que Xfce est confortable ;
- vérifier compatibilité générale de la machine.

Un Live USB Debian peut généralement lancer une installation ensuite, mais ce n'est pas le chemin préféré pour le serveur final.

### Debian netinst

Statut : choix recommandé pour installation définitive.

Pourquoi :

- base plus propre ;
- moins de paquets inutiles ;
- choix explicites pendant l'installation ;
- meilleure maîtrise serveur ;
- plus cohérent avec le contrat 0 fallback / 0 bazar.

## Décision actuelle

1. Utiliser Debian Live Xfce seulement pour tester le matériel si nécessaire.
2. Installer définitivement avec Debian netinst.
3. Sélectionner seulement :
   - SSH server ;
   - standard system utilities ;
   - Xfce si bureau léger souhaité.
4. Installer ensuite les services serveur explicitement :
   - xrdp ;
   - Apache ;
   - PHP ;
   - MariaDB/PostgreSQL si nécessaire ;
   - Certbot/Cloudflare Tunnel plus tard.

## À éviter au départ

- GNOME ;
- KDE Plasma ;
- suites bureautiques ;
- services non nécessaires ;
- base desktop lourde ;
- exposition publique avant durcissement.
