# HANDOFF — OPUS P117W R45D2A27 Assignment Revoke UI

Date : 2026-08-14

## Base OPUS publiée

`9256f6dd4837a5465f801018368113fa0a740499` — `opus_p117w_r45d2a26_assignment_revoke_backend`.

## Acquis

R45D2A26 rend le backend Attributions symétrique pour `assignment.grant` / `assignment.revoke`. La révocation calcule `access_delta.lost`, écrit atomiquement dans le store local et bloque la perte du dernier administrateur effectif.

## Gate actif

R45D2A27 expose cette capacité dans le front Security :

- `assignment_revoke_supported` sous `$canMutate` ;
- bouton SCORE `Révoquer` seulement pour une attribution issue du runtime local réellement modifiable ;
- motif + réauthentification ;
- Preview puis Commit via le pipeline existant ;
- affichage des accès perdus ;
- messages métier localisés pour attribution/identité absente et dernière attribution administrative ;
- 25 locales UE + ukrainien ;
- aucune mutation viewer ;
- zéro JavaScript ;
- REST et FSM inchangés.

## Livrable

```text
ZIP     : opus_p117w_r45d2a27_assignment_revoke_ui.zip
SHA-256 : 828836dea799d75296463fa676dcf52a80b37c816f22bfb4cab883e42f662611
BASE    : 9256f6dd4837a5465f801018368113fa0a740499
FILES   : 3
```

## Validation attendue

1. smoke applicateur vert ;
2. `composer opus:validate-site -- owasys-front` et `owasys-back` verts ;
3. en admin/developer, `Attributions` montre `Révoquer` sur l’attribution `steve -> admin` si elle provient du runtime local ;
4. sa Preview doit être refusée avant écriture car elle retirerait la dernière attribution administrative ;
5. en viewer, aucun bouton `Révoquer` ni formulaire de mutation.

NO VIEWER MUTATION.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
