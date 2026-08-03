# OPUS P117W R46B15 — Contrat d'idempotence du rejeu Profiler distant

Date : 2026-08-03

## Cause

Une même corrélation distribuée peut effectuer plusieurs appels REST. Le backend conserve alors plusieurs enregistrements `OPUS_PROFILER_TRACE_V2` sous le même `trace_id`. À chaque réponse, `readTrace()` restitue l'ensemble de ces enregistrements : un enregistrement déjà importé par le front peut donc être rejoué lors de l'appel suivant.

Ce rejeu d'un même `record_id` n'est pas une collision de span. Le traiter comme tel produit à tort `OPUS_PROFILER_REMOTE_SPAN_DUPLICATE`.

## Contrat

- l'identité d'un enregistrement distant est `trace_id + record_id` ;
- le rejeu du même enregistrement dans la même trace est idempotent et n'ajoute ni span ni événement ;
- deux enregistrements distincts portant le même `span_id` restent une collision bloquante ;
- un `record_id` absent ou invalide reste une violation du contrat distant ;
- aucun événement ni identifiant n'est inventé pour masquer une collision réelle.

## Livrable

R46B15 remplace R46B14 et en reprend intégralement les trois fichiers. Il ajoute le correctif générique dans `Opus/Profiler/Trace.php`.

NO SILENT COLLISION.  
NO FALLBACK SILENCIEUX.
