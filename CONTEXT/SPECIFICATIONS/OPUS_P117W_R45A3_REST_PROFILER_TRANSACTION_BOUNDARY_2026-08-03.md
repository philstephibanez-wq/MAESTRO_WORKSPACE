# OPUS P117W R45A3 — Frontière transactionnelle REST / Profiler

Date : 2026-08-03  
Statut : contractuel  
Base OPUS : `ad33c64cb091711bcf98e7a1c9307cb4029e0ca6`

## Cause observée

Une opération `site.create` peut réussir matériellement et retourner un résultat Composer valide, puis être transformée en échec REST lorsque le serveur tente de lire la trace avant d'avoir finalisé et écrit son propre enregistrement Profiler.

La seconde tentative sur le même identifiant révèle aussi que `safeErrorCode()` remplace un message canonique avec détail, tel que `OPUS_SCAFFOLD_TARGET_ALREADY_EXISTS:sites/test`, par `OPUS_REST_API_REQUEST_FAILED`.

## Contrat

1. Le résultat métier et la télémétrie sont deux frontières distinctes.
2. Une défaillance du Profiler postérieure à une mutation réussie ne doit jamais annuler ni requalifier cette mutation.
3. Lorsque les données Profiler sont demandées, la trace REST est finalisée avant lecture.
4. Une indisponibilité de finalisation ou de lecture Profiler est journalisée avec classe, fichier et ligne, sans secret.
5. La réponse métier reste utilisable lorsque la télémétrie est indisponible.
6. Un message d'erreur composé de `CODE_CANONIQUE:détail` expose le code canonique et ne tombe pas sur un masque générique.
7. Le contrôle du scaffold `target already exists` reste bloquant ; aucun écrasement ni nettoyage automatique n'est ajouté.

## Livrable

```text
ZIP     : opus_p117w_r45a3_rest_profiler_transaction_boundary.zip
SHA-256 : 6ceb5e5a55ca0b501dffc9748190fdc62b4a862ca8767df48fc278843e57b96d
FILES   : 1
PATH    : Opus/Api/Rest/RestServer.php
BASE    : ad33c64cb091711bcf98e7a1c9307cb4029e0ca6
```

## Validation owner

- lint PHP ;
- autoload Composer ;
- validation des deux sites OWASYS ;
- création avec un nouvel identifiant ;
- réponse HTTP `201` conservée avec Profiler demandé ;
- trace lisible après finalisation ;
- nouvelle tentative sur le même identifiant : `OPUS_SCAFFOLD_TARGET_ALREADY_EXISTS` ;
- aucune régression de corrélation front → REST → back → Composer → front.

R45B reste le prochain développement après acquisition de R45A3.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.
