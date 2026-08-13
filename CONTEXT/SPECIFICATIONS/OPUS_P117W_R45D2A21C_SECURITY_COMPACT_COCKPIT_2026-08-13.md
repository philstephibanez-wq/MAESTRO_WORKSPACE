# OPUS P117W — R45D2A21C Security Compact Cockpit

Date : 2026-08-13  
Statut : spécification active  
Prérequis owner : R45D2A21B appliqué  
Base Git publiée : `50d68b724a1f32201bd068e0cb23c9f925780093`

## Retour owner déclencheur

Après R45D2A21B, le retour owner est : **« C'est un peu mieux »**.

La direction dashboard est donc conservée, mais le premier viewport reste trop dominé par le formulaire d’ajout ouvert :

- le formulaire occupe presque tout l’écran ;
- Utilisateurs / Agents réels passent sous la ligne de flottaison ;
- les métriques affichent `0 Utilisateurs / 0 Agents` alors que des identités legacy existent ;
- le fournisseur reste un détail technique trop présent dans le parcours principal ;
- l’écran doit davantage ressembler à un cockpit qu’à un formulaire.

## Objectif

R45D2A21C compacte la page Sécurité sans modifier le modèle ni le backend.

Premier viewport attendu :

1. dashboard application ;
2. métriques compactes ;
3. flow d’autorisation ;
4. deux actions compactes **Utilisateur** et **Agent** ;
5. deux panneaux toujours visibles Utilisateurs / Agents ;
6. `À classifier` visible comme dette de migration, mais secondaire ;
7. formulaires complets seulement après ouverture volontaire.

## Métriques

Lorsque des identités legacy existent, la métrique **À classifier** est affichée avec leur nombre.

Il est interdit de transformer silencieusement ces identités en user ou agent. Le compteur évite que `0 / 0` donne l’impression qu’aucune identité n’existe.

## Ajouter utilisateur / agent

Le grand formulaire unique ouvert par défaut est supprimé.

Deux `<details>` SCORE/HTML natifs sont proposés :

- action **Utilisateur** avec `identity_type=user` fixé explicitement ;
- action **Agent** avec `identity_type=agent` fixé explicitement.

Chaque action reste fermée par défaut. À l’ouverture, le formulaire est compact :

- identifiant ;
- motif ;
- réauthentification OWASYS ;
- Prévisualiser ;
- fournisseur dans **Détails techniques**, prérempli avec le provider par défaut de l’application et toujours modifiable.

Le provider n’est donc pas supprimé du contrat ; il est simplement déplacé au bon niveau d’abstraction.

## Panneaux principaux

Utilisateurs et Agents deviennent des panneaux visibles, non des accordéons principaux.

Chaque carte affiche :

- identifiant ;
- état ;
- rôles ;
- provider/source sous **Détails techniques**.

Les états connus peuvent être distingués visuellement par CSS, sans modifier la valeur métier.

## À classifier

Le bloc legacy reste un accordéon compact. Son compteur est également visible dans le dashboard.

Aucune mutation de classification n’est ajoutée dans R45D2A21C ; ce livrable est exclusivement UX front.

## Contraintes

- SCORE + CSS uniquement ;
- aucun JavaScript/Mermaid/Node runtime ;
- aucun changement backend ;
- aucune inférence user/agent ;
- aucune suppression de fresh-auth/FSM/ACL ;
- aucun faux bouton Modifier/Supprimer ;
- viewer reste lecture seule ;
- les formulaires postent toujours sur la vue `identities` ;
- `identity_type` reste explicite et inclus dans Preview/Commit.

## Livrable

```text
ZIP     : opus_p117w_r45d2a21c_security_compact_cockpit.zip
SHA-256 : 5072d4f5b0e9f2b6ffdbda00f6a16c07df225747ac2b7cc6a3c08bbbc4bd3cd2
PREREQ  : R45D2A21B appliqué
FILES   : 2 scripts PHP dans le ZIP
```

## Gate owner

Exiger :

```text
OPUS_R45D2A21C_APPLIED
OPUS_R45D2A21C_SMOKE_OK
```

Puis ouvrir Sécurité avec `developer` et juger le premier viewport avant toute nouvelle fonction.
