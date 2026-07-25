# MAESTRO_WORKSPACE HANDOFF — OPUS P117V HF10A DIRECT DIFFERENTIAL

Date : 2026-07-25  
Statut : ZIP différentiel direct produit ; installation owner en attente

## Base

```text
OPUS HEAD : 41f77ad7187c0facb125a5737b62d10928809e66
Target    : H:\OPUS
```

## Livrable actif

```text
opus_p117v_hf10a_shared_front_back_direct_differential.zip
SHA-256: a775f25bd71588d77079f3bc7c430f71ea0ad1a511abc50a720c3c0e7ee165ca
```

Le ZIP contient 12 fichiers complets à leurs chemins finaux. Il ne contient ni installateur, ni patch, ni payload, ni rapport, ni log.

## Installation contractuelle

```text
tar -xf <ZIP> -C H:\OPUS
```

Puis Composer, lint PHP et audit contractuel depuis `H:\OPUS`.

## Architecture livrée

```text
frontend  = shared + front
backend   = shared + back
fullstack = shared + front + back
```

Aucun `application/full`.

## Runtime local

```text
composer opus:serve-site -- owasys --mode=back --host=127.0.0.1 --port=8792
composer opus:serve-site -- owasys --mode=front --host=127.0.0.1 --port=8000
```

Les ports sont configurables. Le rôle dépend de `--mode`.

## Observabilité

OWASYS journalise `request.received`, `request.completed` et `request.failed`, avec corrélation Profiler par `trace_id`. Les routes front et back sont refusées par le processus opposé.

## Prochaine preuve owner

1. vérifier HEAD et worktree propres ;
2. extraire le ZIP directement dans `H:\OPUS` ;
3. exécuter Composer, lint et audit ;
4. lancer back puis front ;
5. reproduire `/fr-FR/applications` ;
6. fournir la ligne `request.failed` et le `trace_id` si le HTTP 500 persiste.

## Préservation

Ne supprimer ni `sites/owasys_old`, ni les logs, ni le profiler, ni le Registry.
