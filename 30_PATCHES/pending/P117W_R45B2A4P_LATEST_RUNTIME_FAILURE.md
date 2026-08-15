# P117W R45B2A4P — Latest runtime failure resolver

State: OWNER DIAGNOSTIC REQUIRED

## Cause
R45B2A4O searched one browser trace ID only. The owner proved that this trace no longer exists in `sites/owasys-front/var`, while the current logger file is present and recent. OPUS Logger writes one JSON line per event with `trace_id`, `message` and structured `context`. OWASYS `request.failed` context already contains `error_code`, `exception_class`, `exception_file` and `exception_line`.

## Correction to diagnostic workflow
Do not depend on an old browser trace ID. Resolve the latest actual `owasys.front/request.failed` from the log path declared by `site.json`, print the real exception class/file/line and source context, then attest the process listening on port 8000.

## Artifact
`opus_p117w_r45b2a4p_latest_runtime_failure.zip`

SHA-256: `b1ccb2211decc3e9640935be0e46b3adad1551e0e8759b8052b3fabad1df92b8`

Contains only:
- `tools/diagnose_p117w_r45b2a4p_latest_runtime_failure.php`

## Base
OPUS HEAD `c5122e03b40f6f483e325e7f0192984dd089c093` (`opus_p117w_r45b2a4n_menu_fsm_runtime_fix`).

## Gate
No new FSM functional patch before the latest real `request.failed` yields `EXCEPTION_CLASS`, `EXCEPTION_FILE`, `EXCEPTION_LINE` or proves that the server process is not writing to the expected checkout.
