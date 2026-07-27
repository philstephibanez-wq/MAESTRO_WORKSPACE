# OPUS P117W R16 — RESTAURER LES ALIAS DES COMMANDES APPLICATIVES

Date : 2026-07-27  
État : ZIP différentiel produit ; validation runtime owner requise

## Lire

Lire `README-FIRST.md` et appliquer tous les contrats MAESTRO/OPUS actifs.

## Architecture

Conserver uniquement deux applications OPUS autonomes actives :

```text
sites/owasys-front
sites/owasys-back
```

Réaliser exclusivement :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
```

Ne partager aucun fichier. Ne livrer aucun `tools`, aucun `scripts/owasys`, aucun fichier runtime, aucun secret et aucune racine partagée.

## Cause

Le journal backend du trace `296ba2a1e87ba3e0` prouve :

```text
script = owasys:registry-sync
stdout = OPUS_CONSOLE_COMMAND_FAILED
exit_code = 1
```

Le registre de commandes déclare :

```text
alias     = owasys:registry-sync
canonique = owasys:registry:sync
```

P117W R14 a correctement ajouté le ciblage `application_id = owasys-back`, mais sa réécriture de `ApplicationCommandDispatcher` a conservé uniquement `providers[].commands` et a supprimé la lecture de `aliases`.

Conséquence :

```text
supports("owasys:registry-sync") = false
```

Le provider backend n’est jamais chargé et Composer retourne le code générique.

## Corriger la cause

Modifier uniquement :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
```

Pour chaque registre :

1. Lire et valider `aliases` via `StructuredFileLoader`.
2. Vérifier que chaque cible d’alias appartient aux commandes déclarées du même registre.
3. Associer chaque alias au descriptor du provider qui possède la commande canonique.
4. Faire reconnaître l’alias par `supports()`.
5. Filtrer d’abord par `application_id`.
6. Résoudre ensuite l’alias vers la commande canonique.
7. Charger uniquement le provider ciblé.
8. Transmettre uniquement la commande canonique au provider.
9. Conserver le rejet d’ambiguïté pour une commande directe non ciblée.

Ne pas modifier le frontend, SCORE, I18n, REST ou la FSM pour masquer cette erreur de dispatch Composer.

## Livrer

```text
ZIP : opus_p117w_r16_restore_application_command_aliases.zip
SHA-256 : 31448c0030d19ab7e0d0dd921ce5df20e9bb94ffa3d8c199048fc99b106cb3dd
Fichiers : 1
Octets ZIP : 2827
Octets non compressés : 11588
```

Inclure uniquement :

```text
Opus/Console/Application/ApplicationCommandDispatcher.php
```

## Valider avant livraison

Simulation avec deux applications déclarant le même alias :

```text
Alias reconnu                              : OK
Ciblage application_id = owasys-back      : OK
Résolution vers owasys:registry:sync       : OK
Provider backend chargé                    : OK
Provider historique non chargé             : OK
Commande directe non ciblée ambiguë refusée : OK
PHP lint                                    : OK
Chemins interdits dans le ZIP               : 0
```

Marqueur :

```text
P117W_R16_ALIAS_SCOPE_OK
```

Ne pas présenter cette validation isolée comme une validation runtime Windows owner.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
