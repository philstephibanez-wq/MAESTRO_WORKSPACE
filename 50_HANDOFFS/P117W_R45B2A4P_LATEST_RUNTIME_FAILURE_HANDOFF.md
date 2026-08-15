# P117W R45B2A4P — Latest runtime failure handoff

State: OWNER DIAGNOSTIC REQUIRED

The previous A4O trace-specific resolver returned `TRACE_NOT_FOUND` for browser trace `dcd84950c19c44c62bf834a4cb47034f`. This does not clear A4N; it proves that the browser trace is no longer present in the current `var` tree.

Use R45B2A4P instead. It reads the diagnostic log path from OWASYS `site.json`, parses the Logger JSONL contract, selects the latest real `owasys.front/request.failed`, prints its trace, error code, exception class/file/line and ±15 source lines when the file is inside OPUS. It also checks the process listening on port 8000 using a non-reserved PowerShell variable.

Owner command:

`php tools\diagnose_p117w_r45b2a4p_latest_runtime_failure.php`

Required output for next correction:
- `OPUS_P117W_R45B2A4P_LATEST_FAILURE_FOUND`
- `EXCEPTION_CLASS=...`
- `EXCEPTION_FILE=...`
- `EXCEPTION_LINE=...`
- `SOURCE_CONTEXT_BEGIN ... SOURCE_CONTEXT_END`
- `PORT_8000_*`

If there is no `request.failed`, use the emitted recent event list and listener information; do not guess a functional correction.

Artifact: `opus_p117w_r45b2a4p_latest_runtime_failure.zip`
SHA-256: `b1ccb2211decc3e9640935be0e46b3adad1551e0e8759b8052b3fabad1df92b8`
