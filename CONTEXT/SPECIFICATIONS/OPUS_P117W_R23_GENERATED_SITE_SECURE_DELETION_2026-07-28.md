# OPUS P117W R23 — SUPPRESSION SÉCURISÉE D’UN SITE GÉNÉRÉ

Date : 2026-07-28  
Statut : spécification contractuelle et livrable différentiel à valider côté owner

## Source de vérité

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base exacte : 4868780af4dd65bb7e28d95c981d1a1c5800a243
Racine owner : H:\OPUS
Pré-requis cumulatif : R22 inclus au livrable R23
```

## Objectif

Permettre la suppression définitive d’une application créée par OWASYS sans
exposer le système de fichiers au navigateur et sans permettre la suppression
d’OWASYS lui-même.

## Chaîne obligatoire

```text
owasys-front SCORE
-> FSM + ACL + SSO
-> REST bearer + HMAC
-> FSM owasys-back
-> opération allow-listée site.delete
-> Composer opus:delete-site
-> service générique OPUS
-> réconciliation Registry SQLite
-> ViewModel
-> SCORE
```

Le frontend ne reçoit et ne transmet qu’un identifiant d’application et sa
confirmation exacte. Aucun chemin, CWD, exécutable ou argument libre n’est
accepté.

## Commande publique

```text
composer opus:delete-site -- <application-id> --confirm=<application-id>
composer opus:delete-site -- <application-id> --confirm=<application-id> --write
```

Sans `--write`, la commande produit uniquement un aperçu. La suppression
effective exige simultanément `--write` et une confirmation identique à
l’identifiant.

## Protections obligatoires

La suppression échoue explicitement lorsque :

- l’identifiant est invalide ou absent ;
- l’identifiant est `owasys-front` ou `owasys-back` ;
- la confirmation ne correspond pas exactement ;
- la racine n’est pas exactement `H:\OPUS\sites\<application-id>` ;
- la cible est un lien symbolique ou contient un lien symbolique ;
- `config/site.json` est absent ou invalide ;
- le contrat n’est pas `OPUS_SITE_STANDARD_CONTRACT_CORE` ;
- `site_id` ne correspond pas au répertoire ;
- `generated_by` n’est pas `composer` ;
- `role` n’est pas `generated-opus-application`.

Les sites manuels, historiques, importés, OWASYS et toute cible hors de la
racine canonique sont donc non supprimables par cette commande.

## Cohérence Registry

Après suppression physique réussie, `registry.sync` R22 retire atomiquement la
ligne SQLite devenue obsolète et efface le contexte courant uniquement si
l’application supprimée était sélectionnée.

## Interface

Le bouton et le formulaire de confirmation sont rendus exclusivement par SCORE
pour les seules entrées supprimables. La suppression réussie produit
`application_deleted`, transition FSM retournant au Registry et effaçant le
contexte applicatif frontend.

## Observabilité

La corrélation existante Logger/Profiler couvre :

```text
requête frontend
REST
FSM backend
Composer
succès ou erreur
```

Aucun secret ni contenu de fichier supprimé n’est journalisé.

## Validation

Livrable :

```text
ZIP : opus_p117w_r23_generated_site_secure_deletion.zip
SHA-256 : b4f29bd657aaec2faf52a883f4bedd03cc09d5356ef67bb2de03970baa17763b
Fichiers : 15
```

```text
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:delete-site -- exemple --confirm=exemple
composer opus:delete-site -- owasys-front --confirm=owasys-front --write
composer opus:delete-site -- owasys-back --confirm=owasys-back --write
git diff --check
git status --short
```

Les deux commandes visant OWASYS doivent échouer avec
`OPUS_DELETE_SITE_PROTECTED`.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
