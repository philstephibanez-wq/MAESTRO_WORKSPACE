# OPUS P117W R45D2A28A — Security View Isolation / Fragment Elimination

Date: 2026-08-14

## Cause

R45D2A28 localise les cinq sous-vues Security dans le chemin public, mais le contrôleur rend encore les cinq sections simultanément (`view_* = true`) et le KPI `À classifier` utilise toujours le fragment `#ow-security-unclassified`.

Conséquence observée: une URL canonique telle que `/fr-FR/sécurité/attributions` peut rester associée au fragment historique et amener visuellement l’utilisateur dans la section Identités.

## Contrat correctif

- une route Security canonique correspond à une seule vue rendue;
- `security/identities` -> `view_identities` uniquement;
- `security/roles` -> `view_roles` uniquement;
- `security/permissions` -> `view_permissions` uniquement;
- `security/assignments` -> `view_assignments` uniquement;
- `security/resources` -> `view_resources` uniquement;
- le KPI `À classifier` navigue vers `security_urls.identities`;
- aucun lien, identifiant HTML ou CSS OWASYS ne doit encore produire/utiliser `#ow-security-unclassified`;
- aucune query publique `?view=...` n’est générée; la lecture legacy reste uniquement une compatibilité d’entrée;
- les chemins localisés conservent les accents Unicode dans le catalogue NFC; leur sérialisation URI peut être percent-encodée par `UrlBuilder`;
- aucun JavaScript ajouté;
- aucune modification REST, ACL, SSO ou FSM métier.

## Gate navigateur

En français:
- `/fr-FR/sécurité/identités` rend uniquement la vue Identités;
- `/fr-FR/sécurité/attributions` rend uniquement la vue Attributions;
- cliquer `À classifier` navigue vers Identités sans fragment;
- la navigation entre sous-vues ne contient aucun `#ow-security-unclassified`.

R45D2A28A corrige R45D2A28 avant publication; R45D2A28 ne doit pas être publié seul.
