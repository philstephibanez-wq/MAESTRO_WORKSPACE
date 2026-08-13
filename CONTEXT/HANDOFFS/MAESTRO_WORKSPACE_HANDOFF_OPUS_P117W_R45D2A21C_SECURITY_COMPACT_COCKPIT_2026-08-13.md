# HANDOFF — OPUS P117W R45D2A21C Security Compact Cockpit

Date : 2026-08-13

## Prérequis

R45D2A21 puis R45D2A21B ont été appliqués localement par l’owner. La base Git publiée OPUS reste :

```text
50d68b724a1f32201bd068e0cb23c9f925780093
opus_p117w_r45d2a20_standard_local_password_role_provisioning
```

Ne pas considérer R45D2A21/B/C comme publiés tant que l’owner ne les a pas commit/push.

## Retour owner

R45D2A21 : « pas terrible ».

R45D2A21B : « C'est un peu mieux ».

Le modèle sécurité est validé ; le problème restant est la hiérarchie du premier viewport.

## Livrable actif

```text
ZIP     : opus_p117w_r45d2a21c_security_compact_cockpit.zip
SHA-256 : 5072d4f5b0e9f2b6ffdbda00f6a16c07df225747ac2b7cc6a3c08bbbc4bd3cd2
PREREQ  : R45D2A21B appliqué
FILES   : 2 scripts PHP
```

R45D2A21C ne modifie que le front SCORE/CSS par applicator différentiel.

## Changements attendus

- dashboard plus compact ;
- métrique `À classifier` lorsqu’elle existe ;
- deux quick-actions repliées : Utilisateur / Agent ;
- aucun formulaire ouvert par défaut ;
- provider déplacé dans Détails techniques et prérempli avec le provider par défaut ;
- panneaux Utilisateurs / Agents toujours visibles ;
- empty states compacts ;
- cartes d’identité plus denses ;
- bloc legacy secondaire ;
- aucune dépendance JS/Mermaid runtime ;
- aucun changement backend.

## Commandes owner

```cmd
cd /d H:\OPUS
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45d2a21c_security_compact_cockpit.zip"
php tools\r45d2a21c_apply_security_compact_cockpit.php
php tools\smoke_r45d2a21c_security_compact_cockpit.php
composer dump-autoload -o
git status --short
```

## Gate

Exiger :

```text
OPUS_R45D2A21C_APPLIED
OPUS_R45D2A21C_SMOKE_OK
```

Puis redémarrer front/back et envoyer une capture de Sécurité avec `developer`.

Ne pas poursuivre Modifier/Supprimer avant validation visuelle owner.

NO PUSH OPUS/OWASYS BY ASSISTANT.
NO JS/MERMAID RUNTIME.
NO IDENTITY TYPE INFERENCE.
NO FAKE MODIFY/DELETE BUTTON.
