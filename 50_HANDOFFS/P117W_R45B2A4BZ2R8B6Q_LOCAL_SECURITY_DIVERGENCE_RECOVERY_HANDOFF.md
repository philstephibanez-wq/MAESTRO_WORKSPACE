# P117W R45B2A4BZ2 R8B6Q — Local security divergence recovery — HANDOFF

State: RECOVERY PROCEDURE READY — OWNER RUNTIME CONFIRMATION PENDING

## Canonical authority

- README-FIRST blob: `1d54edc60150766f21a47bdecc051f7ad6267f22`.
- Canonical OPUS `origin/master`: `994881f664a185c12e83e2a4b8a1a76decc1b068`.
- Owner worktree is clean but detached at `09357b9dfaecfb4938270514f2d90adfc4e94ab2`.
- Divergent local commits:
  - `88412449` — `sécurisation`;
  - `f12ceab0` — `Revert "R8B6Q"`;
  - `09357b9d` — `owasys hs !`.
- Local `master` is intact at canonical R8B6Q.

## Root cause evidence

Fresh 2026-08-31 application logs correlate OWASYS front failures with
`ArgumentCountError` in
`sites/owasys-back/application/source/services/OwasysSourceCommandProvider.php:38`.
The divergent security work introduced `ControlledSiteSourceWorkspace` with an
incompatible construction contract. Source list/read Composer commands fail
before any source operation, producing front REST failures (422/500/501).
Site validation still reports valid because it validates static application
contracts, not this runtime constructor path.

The later MAESTRO architecture analysis was also found factually invalid and
was marked REJECTED/NON-AUTHORITATIVE in commit
`6b9fb42ab2a21a185cd09ff568d1d334a0c1fd13`.

## Failed-command timing evidence

Only correlated failed backend command durations are available; no fresh
Profiler JSONL was supplied, so no end-to-end response time is inferred.

| Failed command class | n | min ms | p50 ms | p95 ms | max ms |
|---|---:|---:|---:|---:|---:|
| `owasys:source-list` | 4 | 13.090 | 14.320 | 17.928 | 17.928 |
| `owasys:source-read` | 5 | 13.127 | 16.259 | 113.107 | 113.107 |

These short durations are failures, not performance successes.

## Non-destructive recovery

Create an explicit archive branch at detached HEAD, then switch to the intact
`master`. No reset, commit deletion or source overwrite is required. After
autoload regeneration, restart both OWASYS development servers and validate
the source list/read runtime. Fresh front/back Profiler JSONL and logs are
required before toolbar development resumes.

## Boundary

The three divergent commits are preserved for later security-design audit but
must not be merged or cherry-picked into OPUS until their interface, constructor,
ACL, profiler and REST contracts are redesigned against the canonical source.
