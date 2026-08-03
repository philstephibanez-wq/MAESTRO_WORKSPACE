# MAESTRO WORKSPACE — Handoff OPUS P117W R46B14

Date : 2026-08-03

## Base owner

- Dépôt : `philstephibanez-wq/OPUS`
- Branche : `master`
- Base exacte : `f5809c58c847a9137aa81f716d368d6f0da74832`
- R46B13 est poussé et acquis.
- Archive : `opus_p117w_r46b14_registry_clear_idempotency.zip`
- SHA-256 : `b6dfd73e87aaaf708ee44c3b0de9da9a5b9cd745dfc184fe7b1d7038357d6e73`
- Fichiers complets : 3.

## Cause

`clearCurrentApplication()` tentait toujours d'enregistrer `clear_app_context`, même lorsque le contexte courant était déjà absent. L'événement était alors rattaché au faux identifiant système historique `owasys`, qui n'existe plus depuis la séparation en deux applications autonomes. Le backend levait `OWASYS_RUNTIME_EVENT_SYSTEM_APPLICATION_MISSING`, puis le front reclassait toute exception d'action sous le faux diagnostic `OWASYS_FSM_RUNTIME_REJECTED`.

## Correctif

- `registry.clear` devient idempotent ;
- aucun événement n'est inventé lorsque le contexte est déjà vide ;
- le résultat V2 expose `cleared` et `already_empty` ;
- les événements techniques nécessitant une application système utilisent l'application autonome réelle `owasys-back` ;
- le front réserve `OWASYS_FSM_RUNTIME_REJECTED` aux erreurs `OPUS_FSM_*` et restitue les autres erreurs sans falsifier leur domaine.

## Portée

```text
sites/owasys-back/application/registry/repositories/RegistryRepository.php
sites/owasys-back/application/registry/services/OwasysCommandProvider.php
sites/owasys-front/application/default/controllers/RuntimeController.php
```

## Contrôles assistant

- source relue au HEAD owner exact ;
- trois fichiers analysés avec un parseur PHP indépendant ;
- `git diff --check` propre ;
- aucun JavaScript ajouté au backend ;
- ZIP intègre, contenant uniquement les trois fichiers complets à leurs chemins finaux ;
- runtime PHP/SQLite/REST/Composer à valider côté owner.

## Validation owner

Appliquer le ZIP sur le HEAD exact. Vérifier le lint, l'autoload et la validation des deux sites. Avec aucun contexte courant, exécuter deux fois l'effacement : les deux requêtes doivent réussir et la seconde doit retourner `already_empty=true`. Vérifier ensuite qu'une véritable erreur non-FSM n'est plus libellée comme refus FSM.

NO ACL BYPASS.  
NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
