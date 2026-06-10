# SERVER_LINUX — DNS / HTTPS / publication

## Statut

À préparer après validation locale complète.

## Règles

- Aucun accès admin public direct.
- HTTPS obligatoire avant exposition publique.
- Reverse proxy ou Cloudflare Tunnel à décider.
- DNS documenté.
- Ports ouverts explicitement.
- Logs activés.
- Sauvegarde avant publication.

## Étapes futures

1. Choisir le ou les noms de domaine.
2. Définir les sous-domaines.
3. Configurer DNS.
4. Configurer Apache virtual hosts.
5. Installer certificat HTTPS.
6. Tester depuis LAN.
7. Tester depuis extérieur.
8. Durcir SSH.
9. Documenter les ports et flux.
10. Ajouter monitoring minimal.

## Points à compléter

- Certbot direct ou Cloudflare.
- Cloudflare Tunnel ou NAT Freebox.
- Règles pare-feu.
- Stratégie de renouvellement certificat.
- Procédure rollback publication.
