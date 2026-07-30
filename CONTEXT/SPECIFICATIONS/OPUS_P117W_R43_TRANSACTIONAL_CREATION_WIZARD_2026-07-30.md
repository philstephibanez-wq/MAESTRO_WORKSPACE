# OPUS P117W R43 — assistant transactionnel de création OWASYS

Date : 2026-07-30  
Base OPUS owner : `98842dba015402af7e8b3421e62032236c2d8f30`  
Statut : ZIP différentiel à appliquer, valider, committer et pousser exclusivement par l’owner.

## Cause

L’action OWASYS `new` déclenche immédiatement `site.create` avec seulement `site_id` et `profile`. Le scaffold génère plusieurs pages/modules techniques et ne collecte ni authentification, login, fournisseur SSO, utilisateurs, rôles, permissions ou ACL. L’écriture du scaffold ne garantit pas le rollback.

## Contrat R43

Le parcours reste strictement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer
```

L’assistant est piloté par une FSM dédiée en trois états :

```text
basics -> security -> review -> mutation
```

Aucune mutation n’est envoyée avant la confirmation du récapitulatif. Le blueprint `OPUS_SITE_CREATION_BLUEPRINT_V1` ne contient aucun mot de passe, token ou secret.

Le résultat de `new` contient uniquement :

- une page d’accueil ;
- une page de connexion seulement si explicitement demandée avec le fournisseur local ;
- les 24 langues officielles de l’Union européenne plus l’ukrainien ;
- Singleton, FSM, I18n, ACL deny-by-default, SSO, SCORE, Logger et Profiler ;
- un journal nommé `<site-id>.log` ;
- aucun module/page technique préfabriqué et aucun JavaScript obligatoire.

Les identifiants utilisateurs initiaux sont non sensibles et placés dans un contrat d’onboarding. Les mots de passe restent exclusivement dans le store runtime non versionné.

## Atomicité

- `ScaffoldWriter` supprime les fichiers et répertoires créés si une écriture échoue.
- Si création Composer réussit mais synchronisation Registry échoue, OWASYS exécute la suppression compensatoire par REST puis Composer.
- Un rollback incomplet produit une erreur explicite ; aucun fallback silencieux.

## Livrable

```text
opus_p117w_r43_transactional_creation_wizard.zip
Base : OPUS master 98842dba015402af7e8b3421e62032236c2d8f30
Fichiers complets : 39
SHA-256 : 7571c469a16cc0d14245534d0da05505465764e6171dd955ae987a2ce66f0b51
```

Les vérifications statiques ont validé le parsing PHP, les JSON, les clés SCORE/I18n des 26 catalogues présents, `git diff --check`, l’inventaire exact et l’intégrité ZIP. Le lint et la recette runtime PHP restent à exécuter par l’owner sur Windows.

L’assistant ne committe et ne pousse jamais OPUS/OWASYS.

NO FALLBACK SILENCIEUX.  
TOUJOURS TRAITER LA CAUSE.  
AUCUNE MUTATION AVANT RÉCAPITULATIF.
