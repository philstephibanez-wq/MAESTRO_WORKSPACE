# MAESTRO WORKSPACE — Handoff OPUS P117W R44

Date : 2026-07-30

## Source

```text
OPUS : philstephibanez-wq/OPUS master
HEAD owner : 63470fb43c4b692eea2d7db2c0be5f6086008d1a
Racine owner : H:\OPUS
```

## État acquis

R43 est appliqué et poussé. Le commit owner contient exactement les 39 fichiers du différentiel `opus_p117w_r43_transactional_creation_wizard.zip`.

## Action active

Exécuter l’acceptation R44 depuis OWASYS :

1. lancer `owasys-front` et `owasys-back` en développement ;
2. ouvrir `/fr-FR/applications/new` ;
3. parcourir les trois étapes et vérifier qu’aucune mutation ne précède la confirmation ;
4. créer un site fullstack avec un identifiant neuf ;
5. contrôler accueil unique, login optionnel, langues UE + ukrainien, ACL/SSO/FSM/SCORE, diagnostics et Registry ;
6. valider le site généré par Composer.

Toute anomalie doit être corrigée à la source dans OWASYS/OPUS, jamais dans le site généré.

## Autorité

```text
Assistant : MAESTRO_WORKSPACE + ZIP différentiel si défaut
Owner : recette runtime, application, validation, commit et push OPUS/OWASYS
```
