# OPUS CURRENT STATE

Dernière mise à jour : 2026-07-31.

## Dépôts

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
HEAD owner publié : 9572f4fa264e21205cd3e4a81f2d19db5a4cc0c6
Commit : opus_p117w_r46c1_profiler_score_iframe
Racine owner : H:/OPUS
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE
```

## État acquis

- R42 : serveur de développement générique appliqué.
- R43 : assistant transactionnel appliqué.
- R44C : transaction de création et rendu opaque SCORE acquis.
- R45A1 : appliqué et validé par l'owner.
- R46A1 : modèle de traces V2 validé et poussé.
- R46B1 : collecteur REST présent sur `master`.
- R46C1 : code iframe/SCORE appliqué et poussé ; recette fonctionnelle échouée sur ACL.
- Témoin guidé : `fullstack-test`, jamais corrigé directement.

## Architecture définitive

- `frontend` : client SCORE vers un backend existant ;
- `backend` : API REST/services sécurisés, sans SCORE ni JavaScript ;
- `fullstack` : frontend SCORE + backend REST dans le même site, même déploiement et même serveur par défaut, avec frontière REST obligatoire ;
- jamais de `shared`.

Le site profilé est le domaine observé. OPUS collecte les preuves et sert lui-même la représentation Profiler par SCORE dans une iframe same-origin hébergée par l'aside applicatif.

## Sécurité définitive

`identité SSO -> rôles effectifs -> ressource + action -> décision ACL deny-by-default`

- identité canonique de session : `subject + roles + provider` ;
- `profile` n'est pas une source ACL ;
- `admin` possède `*:*` ;
- `developer` possède `profiler:view` ;
- aucun contournement local de l'ACL pour le Profiler ;
- environnement développement/local obligatoire.

## État réel du Profiler

La recette R46C1 prouve :

- présence de `iframe.ow-profiler-frame` ;
- appel de la route OPUS same-origin ;
- disparition du simple panneau statique comme représentation détaillée ;
- échec `OPUS_ACL_DENIED` pour une session affichée `admin`.

La cause est la divergence de contrat dans `OwasysAuthSession` : la clé courante `owasys_sso_identity` était retournée sans normalisation. L'UI pouvait afficher `profile`, tandis que l'ACL ne recevait aucun `roles`.

## Livraison active — R46C2

ZIP : `opus_p117w_r46c2_session_identity_acl_normalization.zip`  
SHA-256 : `003c8d4d830fa64f1f136b1b86c045188052e9250c99b76daf198d8e2727fde5`

Le ZIP contient uniquement le fichier complet :

`sites/owasys-front/application/default/models/AuthSession.php`

R46C2 normalise et valide toute identité courante, historique, démarrée ou mise à jour. `profile` sert uniquement à migrer une identité dont le champ `roles` est absent. Une liste `roles` explicitement vide ou invalide échoue sans promotion.

L'archive est structurellement vérifiée. PHP/Composer étant indisponibles dans l'environnement de construction, le lint, les cas ACL et la recette HTTP/DOM owner restent obligatoires.

## Suite R46

1. appliquer et valider R46C2 ;
2. confirmer admin/developer autorisés et viewer/session absente refusés ;
3. compléter la barre compacte ;
4. compléter les douze rubriques SCORE contractuelles ;
5. reprendre les collecteurs R46B manquants ;
6. réaliser la corrélation distribuée R46D ;
7. intégrer les profils générés en R46E.

## Invariants

- aucune correction locale de `fullstack-test` ;
- toute mutation OWASYS traverse REST sécurisé puis Composer ;
- SCORE uniquement pour toute interface ;
- backend sans JavaScript ;
- Singleton, FSM, I18n, SSO, ACL deny-by-default ;
- Logger/Profiler corrélés sans secret ;
- Profiler uniquement dev/local via `?profiler=1`, indisponible en production ;
- aucune affirmation sans événement collecté ;
- toute classe concrète OPUS implémente son interface homonyme aux quatre marqueurs ;
- l'assistant livre OPUS/OWASYS en ZIP différentiel et ne les pousse pas ;
- aucun `shared`.

NO ACL BYPASS.  
NO EVENT, NO CLAIM.  
NO FALLBACK SILENCIEUX.
