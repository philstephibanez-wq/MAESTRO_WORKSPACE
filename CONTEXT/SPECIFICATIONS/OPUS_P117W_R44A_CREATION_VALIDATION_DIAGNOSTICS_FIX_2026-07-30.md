# OPUS P117W R44A — correction des validations du wizard OWASYS

Date : 2026-07-30  
Base OPUS owner : `63470fb43c4b692eea2d7db2c0be5f6086008d1a`  
Statut : ZIP différentiel livré, application et validation owner requises.

## Cause constatée pendant R44

Le test réel de l’étape `security` échoue dans `owasys-front` avant REST et Composer.

Le contrôleur R43 :

- recharge l’ancien brouillon dans le `catch` et perd les valeurs soumises ;
- mappe les codes de validation de sécurité inconnus vers `creation.error.backend` ;
- ne produit aucune trace Logger/Profiler pour les validations pré-REST.

Le message « backend REST + Composer a refusé la création » est donc faux dans ce parcours.

## Correction R44A

Le différentiel :

- conserve toutes les valeurs soumises à l’étape Application ou Sécurité ;
- classe chaque erreur de sécurité sur son champ : fournisseur, login, rôles, rôles d’accueil, permissions, utilisateurs ou rôle initial ;
- affiche un message I18n précis dans les 24 langues officielles de l’UE plus l’ukrainien ;
- journalise `creation.validation_failed` avec uniquement `stage`, `error_code` et `trace_id` ;
- instrumente la même erreur dans Profiler ;
- n’envoie aucune donnée de formulaire brute dans les diagnostics ;
- n’appelle ni REST ni Composer lors d’un échec de validation ;
- ne modifie ni OPUS framework, ni `owasys-back`, ni un site généré.

## Livrable

`opus_p117w_r44_validation_diagnostics_fix.zip`

SHA-256 :

`880ec41d556058fb8b51fe16174b5ce3cf8c76d9d4558f3d1151d9550c46bcb2`

Le ZIP contient 28 fichiers complets : le contrôleur, le template SCORE et 26 catalogues présents (`fr-FR` compris), sans cache, log, profiler, outil, script ou dépendance.

## Acceptation owner

Après application, répéter l’étape Sécurité ayant échoué et vérifier :

- valeurs conservées ;
- message au champ concerné ;
- code et trace affichés ;
- événement Logger/Profiler corrélé ;
- absence de POST vers `owasys-back` tant que le récapitulatif n’est pas confirmé ;
- absence de nouveau répertoire sous `sites`.

Puis reprendre la recette R44 complète.

NO FALLBACK SILENCIEUX.  
TOUJOURS TRAITER LA CAUSE.  
NO PARTIAL SITE.
