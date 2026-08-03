# OPUS P117W R45A2 — modèle typé de contrôle d'accès

Date : 2026-08-03  
Statut : contrat et ZIP différentiel produits  
Base OPUS : `e5878b367146a37c8f0c27a103491dc59a7a21db`

## Objet

R45A2 complète R45A1 avant le scaffold profilé R45B. Le framework reçoit des objets immuables et validés pour représenter sans listes ambiguës :

- rôle et permissions associées, avec héritage explicite ;
- permission liée à un type de ressource et une action connue ;
- type de ressource et allow-list d'actions ;
- ressource canonique appartenant à une application ;
- scope `application|resource_type|resource` ;
- attribution `provider + subject -> role_id + scope` ;
- règle `allow|deny` liée à un rôle, une permission et un scope ;
- requête d'autorisation typée et cohérente avec la ressource.

La décision effective reste `Opus\Security\Access\AccessDecision`, déjà contractuelle. R45A1 conserve la priorité absolue de tout deny applicable.

## Contrats

Chaque classe concrète possède une interface homonyme étendant directement les quatre marqueurs OPUS. Les identifiants, effets, niveaux de scope et compatibilités permission/ressource échouent explicitement lorsqu'ils sont invalides.

Aucun secret n'est accepté ni produit par ces objets. Le sujet SSO est traité comme identifiant opaque borné ; aucune donnée d'authentification n'entre dans le modèle.

## Livrable

```text
ZIP     : opus_p117w_r45a2_typed_access_control_model.zip
SHA-256 : 05bd036c90d53cbcd51cf49c3d0a582c3dcf92b79f00caf50ead671274270140
FILES   : 16
BASE    : e5878b367146a37c8f0c27a103491dc59a7a21db
```

Le ZIP crée uniquement `Opus/Security/Access/Model/`.

## Validation

- analyse syntaxique indépendante des 16 fichiers : OK ;
- interfaces homonymes et quatre marqueurs : OK ;
- `git diff --check` : OK ;
- archive et chemins finaux : OK ;
- lint PHP, autoload et tests d'instanciation : gate owner.

## Suite

Après validation et push owner, R45B rendra les profils réellement distincts : frontend SCORE/client REST, backend REST sans SCORE ni JavaScript, fullstack mono-site avec frontière REST obligatoire et corrélation explicite.

NO CONTRACT, NO PATCH.  
NO FALLBACK SILENCIEUX.  
DENY OVERRIDES ALLOW.
