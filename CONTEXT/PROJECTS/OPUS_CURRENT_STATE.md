# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-08.

## Dépôt

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 058984bfb0229bf5f27c74cd2b59c6614bf74b4e
Commit HEAD : opus_p117w_r45c2_dev_preview_runtime_fix
R45C2 acquis : 058984bfb0229bf5f27c74cd2b59c6614bf74b4e
Livrable actif : R45C3 structured OWASYS workflow sequence
```

## Acquisition R45C2

R45C2 est publié par l'owner au commit :

```text
058984bfb0229bf5f27c74cd2b59c6614bf74b4e
opus_p117w_r45c2_dev_preview_runtime_fix
```

Retour owner : le bouton `Visualiser le site` fonctionne et la prévisualisation attendue s'ouvre correctement.

R45C2 est donc acquis.

## Contrat FSM / workflow

Contrat :

`CONTEXT/SPECIFICATIONS/OWASYS_VS_GENERATED_SITE_FSM_WORKFLOW_CONTRACT_2026-08-08.md`

Séparation obligatoire :

```text
FSM OWASYS = navigation + sécurité + workflow de construction des sites
FSM SITE = pages/navigation + sécurité + métier propre au site
```

OWASYS ne fusionne jamais sa FSM, ses rôles ou son ACL avec ceux du site généré.

Workflow cible :

```text
1 login
2 ouvrir/définir application + mode frontend/backend/fullstack
3 définir rôles/utilisateurs de la cible
4 matérialiser/générer
5 BDD éventuelle
6 pages/routes/API
7 ACL CRUD par ressource
8 workflows métier du site
9 contenu SCORE + données
10 validation / Git / build / preview / export
```

## Cause active avant R45C3

La FSM OWASYS publiée conserve encore l'ancien ordre :

```text
Applications
-> Structure
-> Sources de données
-> Workflows
-> Sécurité
-> Sources et Git
-> Construction et validation
```

et :

- `select_app` entre dans `structure` ;
- `application_created` entre dans `build` ;
- `CreationController` redirige explicitement vers `build` après création réussie.

Cette séquence n'est plus conforme au contrat acquis.

## Livrable actif R45C3

```text
ZIP     : opus_p117w_r45c3_structured_workflow_sequence.zip
SHA-256 : dfed4919c19c95fa055f01576369de621a35757290003629f753c997f2659399
SCRIPT  : apply_opus_p117w_r45c3_structured_workflow_sequence.php
SHA-256 : 690a5588462859142cce828b6a26d982ab016df867b69d4935c2b40b2893b982
BASE    : 058984bfb0229bf5f27c74cd2b59c6614bf74b4e
TARGETS : 2
OUTPUT  : OPUS_P117W_R45C3_APPLIED / FILES=2
```

Smoke séparé :

```text
smoke_opus_p117w_r45c3_structured_workflow_sequence_owner.php
SHA-256 : 6b8cec5f07f1526ed3f676d014c6eef11af3d7a60fdafc86e9c854f0672accbf
OUTPUT  : OPUS_P117W_R45C3_SMOKE_OK / FILES=2
```

## R45C3 — comportement cible

Navigation et projection FSM OWASYS :

```text
Applications
-> Sources de données
-> Structure
-> Sécurité
-> Workflows
-> Sources et Git
-> Construction et validation
```

Après sélection d'une application existante ou matérialisation d'une nouvelle application, OWASYS entre dans `Sources de données`.

`Sources de données` est une étape éventuelle ; aucune BDD n'est imposée.

Les transitions wildcard d'accès direct restent soumises à l'ACL et au contexte d'application.

R45C3 ne modifie aucune classe `Opus/**/*.php`, aucune FSM de site généré et aucun fichier `owasys-back`.

## Prévalidation assistant R45C3

- base distante exacte identifiée ;
- script d'application exige le HEAD exact et des cibles propres ;
- chaque transformation est ancrée sur la source R45C2 et doit correspondre exactement une fois ;
- JSON final validé avant écriture ;
- script d'application PHP lint OK ;
- smoke PHP lint OK ;
- smoke vérifie l'ordre de navigation, les transitions FSM, la redirection de création et l'absence de JavaScript interdit dans `owasys-back` ;
- aucune classe concrète OPUS n'est ajoutée ou modifiée.

## Suite gouvernée

1. acquisition owner R45C3 ;
2. R45D administration Sécurité/RBAC OWASYS réservée à admin ;
3. séparation stricte entre sécurité OWASYS et sécurité des sites générés ;
4. poursuite pages/API/BDD/CRUD/workflows métier selon profil du site.

NO SITE-SPECIFIC PATCH.
NO SILENT FALLBACK.
NO FSM MERGE.
NO ROLE MERGE.
NO ACL BYPASS.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS BY ASSISTANT.
