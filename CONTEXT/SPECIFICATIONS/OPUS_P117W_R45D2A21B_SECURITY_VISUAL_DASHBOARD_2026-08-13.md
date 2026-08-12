# OPUS P117W — R45D2A21B Security Visual Dashboard

Date : 2026-08-13
Statut : spécification active
Prérequis owner : R45D2A21 appliqué
Base Git publiée : `50d68b724a1f32201bd068e0cb23c9f925780093`

## Retour owner déclencheur

R45D2A21 est fonctionnel mais la présentation a été rejetée comme « pas terrible ».

La capture owner montre les défauts UX suivants :

- hiérarchie visuelle trop faible ;
- cadres et accordéons trop imbriqués ;
- espace vide important pour Utilisateurs / Agents ;
- bloc « À classifier » beaucoup trop dominant ;
- informations techniques `provider/status/source` trop visibles au premier niveau ;
- action « Ajouter un utilisateur ou un agent » repoussée sous les listes ;
- erreur technique `OWASYS_SECURITY_MUTATION_WORKFLOW_STATE_INVALID` trop dominante ;
- impression générale de formulaire d’administration plutôt que de cockpit graphique.

## Contrat UX corrigé

OWASYS Sécurité doit se présenter comme un tableau de bord graphique et non comme une succession de formulaires.

Ordre visuel :

1. **Vue d’ensemble de la sécurité** de l’application courante ;
2. compteurs Utilisateurs / Agents / Rôles / Ressources ;
3. schéma compact `Utilisateur/Agent -> Attribution -> Rôle -> Permission -> Ressource/ACL` ;
4. action principale **Ajouter un utilisateur ou un agent** ;
5. deux panneaux principaux Utilisateurs et Agents ;
6. identités historiques « À classifier » en zone secondaire compacte ;
7. accordéons techniques Rôles / Permissions / Attributions / Ressources et ACL.

## Utilisateurs / Agents

Le type reste explicite et non inféré :

- `identity_type=user` ;
- `identity_type=agent` ;
- legacy sans type : `unknown` / « À classifier ».

Le formulaire d’ajout utilise un sélecteur visuel Utilisateur/Agent sans JavaScript.

Les cartes d’identité affichent en premier niveau :

- identifiant ;
- état ;
- rôles.

Les détails techniques `provider` et `source` sont repliés sous **Détails techniques**.

## Erreur FSM

`OWASYS_SECURITY_MUTATION_WORKFLOW_STATE_INVALID` reste une garde backend légitime : aucun contournement de FSM.

L’UI doit cependant afficher un message compréhensible :

> La prévisualisation précédente n’est plus active. Relancez « Prévisualiser » avant de confirmer.

Le code technique reste accessible sous un détail replié.

## Contraintes

- SCORE + CSS uniquement ;
- aucun Mermaid/Node/JS runtime ;
- backend toujours décisif ;
- aucun faux bouton Modifier/Supprimer tant que les mutations backend ne sont pas implémentées ;
- I18n 24 langues UE + ukrainien ;
- aucune inférence user/agent ;
- aucun affaiblissement FSM/fresh-auth/ACL ;
- viewer reste lecture seule.

## Livrable

```text
ZIP     : opus_p117w_r45d2a21b_security_visual_dashboard.zip
SHA-256 : 0ccf2e5d71260dc3917bbc79aab39f817cb4a4bbd5266d3a02707b2de616cca6
PREREQ  : R45D2A21 appliqué
FILES   : 3
```

## Gate owner

Exiger :

```text
OPUS_R45D2A21B_APPLIED locales=25
OPUS_R45D2A21B_SMOKE_OK locales=25
```

Puis ouvrir Sécurité avec `developer` et vérifier :

- dashboard compact ;
- compteurs visibles ;
- flow graphique visible ;
- action Ajouter visible immédiatement ;
- Utilisateurs et Agents en deux panneaux ;
- `À classifier` compact et secondaire ;
- détails techniques repliés ;
- accordéons techniques compacts ;
- aucune dépendance JS/Mermaid runtime.
