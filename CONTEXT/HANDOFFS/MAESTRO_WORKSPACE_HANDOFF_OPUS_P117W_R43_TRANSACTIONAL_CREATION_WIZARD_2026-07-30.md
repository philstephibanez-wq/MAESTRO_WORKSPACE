# MAESTRO WORKSPACE — Handoff OPUS P117W R43

Date : 2026-07-30

## Source

```text
OPUS : philstephibanez-wq/OPUS master
Base owner : 98842dba015402af7e8b3421e62032236c2d8f30
Racine owner : H:\OPUS
```

## Livrable actif

```text
ZIP : opus_p117w_r43_transactional_creation_wizard.zip
Fichiers : 39 fichiers complets aux chemins finaux
SHA-256 : 7571c469a16cc0d14245534d0da05505465764e6171dd955ae987a2ce66f0b51
```

## Résultat attendu

OWASYS présente un assistant FSM basics/security/review. Il collecte le profil, l’authentification, la page de connexion, le fournisseur SSO, les rôles, permissions, ACL d’accueil et identifiants utilisateurs initiaux. Aucune mutation ne part avant confirmation.

Le site créé contient une page d’accueil unique, plus une page de connexion seulement si demandée, et les langues UE + ukrainien. Le scaffold et la synchronisation Registry disposent d’un rollback explicite.

## Validation owner

Après extraction du ZIP à la racine `H:\OPUS` :

1. lint des PHP modifiés ;
2. validation JSON ;
3. `composer dump-autoload -o` ;
4. validation de `owasys-front` et `owasys-back` ;
5. lancement développement des deux applications ;
6. création d’un nouveau site depuis `/fr-FR/applications/new` ;
7. vérification du site minimal, des langues, de la configuration ACL/SSO et du Registry ;
8. validation du site généré ;
9. commit/push exclusivement par l’owner.

Aucune écriture directe OPUS/OWASYS n’a été effectuée par l’assistant.
