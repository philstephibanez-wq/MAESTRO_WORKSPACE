# MAESTRO_WORKSPACE — Development Contract

## Purpose

This contract is the shared baseline for every project controlled from MAESTRO_WORKSPACE.

## Rules

- Keep product goals, technical foundations, patches, audits, reports, backups and handoffs separated.
- Do not place temporary patch files, runners, debug reports, extracted ZIPs or ad-hoc notes in project source roots.
- Keep source repositories in their official roots.
- Use MAESTRO_WORKSPACE as the control center, not as a replacement for source repositories.
- Every change must have a clear target, a clear reason, and a clear validation path.
- No broad refactor unless explicitly requested.
- No silent fallback.
- No hidden alternate path.
- No automatic deletion of historical material.

## Systematic response-time verification

- Every runtime-validated delivery must inspect fresh front and back Profiler
  JSONL plus correlated application logs when those artifacts are available.
- Measurements must remain separated by request class; page loads, successful
  mutations, rejected mutations and presentation/layout writes are never
  collapsed into one misleading average.
- For every populated class, record sample count, minimum, median (p50), p95
  and maximum duration from the measured traces.
- Correlate the same trace identifier through front, REST, back and
  BDD/Composer before assigning latency to a layer.
- Compare the new figures with the latest owner-accepted baseline and flag any
  material regression. Never invent missing timing data or infer browser time
  from server timestamps with insufficient precision.
