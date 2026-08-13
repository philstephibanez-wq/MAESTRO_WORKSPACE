# OPUS P117W — R45D2A22 Role Capability Matrix Executable Contract

Date : 2026-08-13  
Statut : spécification active  
Prérequis owner : R45D2A21C appliqué et gate visuel accepté  
Base Git publiée : `50d68b724a1f32201bd068e0cb23c9f925780093`

## Déclencheur

La capture owner R45D2A21C valide la direction cockpit : dashboard, métriques, flow, quick-actions Utilisateur/Agent, panneaux principaux et dette legacy « À classifier » tiennent dans le premier viewport. Le gate visuel est donc fermé.

La suite contractuelle est la preuve exécutable de la matrice `admin / developer / viewer` avant toute implémentation de Modifier/Supprimer utilisateur ou agent.

## Objectif

R45D2A22 ajoute un smoke non destructif qui vérifie :

1. les décisions ACL front pour admin/developer/viewer ;
2. les décisions ACL back pour admin/developer/viewer ;
3. le `deny-by-default` pour un rôle inconnu ;
4. la liaison entre capacités SCORE et contrôles ACL côté contrôleurs ;
5. le refus direct du Profiler pour viewer ;
6. la présence du cockpit R45D2A21C comme prérequis.

## Matrice front couverte

Le smoke couvre notamment :

- registry open/select ;
- creation open ;
- registry delete ;
- structure/data/workflows/security open ;
- security manage ;
- source open/preview/write ;
- git read/stage/unstage/commit/restore ;
- build open/preview ;
- account open/change ;
- profiler view.

Viewer doit pouvoir lire les zones contractuelles et changer son propre mot de passe, mais doit être refusé pour toutes les mutations et pour le Profiler.

## Matrice back couverte

Le smoke vérifie :

- registry open/select ;
- creation execute ;
- security read/manage ;
- source read/write ;
- git read/stage/unstage/commit/restore ;
- site validate/routes:list.

Viewer est accepté en lecture et refusé en mutation.

## Contrôles UI / backend

Le smoke vérifie structurellement que :

- création/suppression d’application sont pilotées par `registry.can_create` / `registry.can_delete` et gardées côté contrôleur ;
- preview/write source sont pilotés par capacités ACL et gardés côté contrôleur ;
- stage/unstage/commit/restore Git sont pilotés par capacités ACL et gardés côté contrôleur ;
- `profiler=1` exige réellement `profiler:view` ;
- toutes les mutations Sécurité sont sous capacités `security:*_supported` et `security:manage`.

Aucun contrôle ne dépend de `primary_role` seul.

## Livrable

```text
ZIP     : opus_p117w_r45d2a22_role_capability_matrix_contract.zip
SHA-256 : e3f127d709b860a359fd8982806f4097fad5c9d22ed8f33ace3b7ffe1a729793
PREREQ  : R45D2A21C appliqué
FILES   : 1
```

Fichier :

```text
tools/smoke_r45d2a22_role_capability_matrix.php
```

## Gate owner

Exiger :

```text
OPUS_R45D2A22_ROLE_CAPABILITY_MATRIX_OK front_cases=66 back_cases=42
```

Puis browser gate viewer :

- login `viewer · viewer` ;
- Applications lisibles, aucun bouton création/suppression ;
- Sécurité lisible, aucune mutation ;
- Sources/Git lisibles, aucun write/preview/stage/unstage/commit/restore effectif ;
- Build en lecture ;
- Compte/password disponible ;
- Profiler absent et refusé en URL directe.

Aucun patch métier supplémentaire avant résultat de ce gate.

NO ACL BYPASS.  
NO VIEWER MUTATION.  
NO PRIMARY_ROLE AUTHORIZATION.  
NO FAKE UI-ONLY SECURITY.  
NO PUSH OPUS/OWASYS BY ASSISTANT.
