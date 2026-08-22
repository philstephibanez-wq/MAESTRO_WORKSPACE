# P117W R45B2A4BZ2R8A2 — Runtime boot ACL repair handoff

State: SUPERSEDED BY R8B1

## Historical purpose

R8A2 repaired the duplicate dynamic ACL guard collision while assuming OPUS HEAD remained `9fdf45ae0ec9d8ce90db0a204b9e3330f9037cae` and R8A/R8B were uncommitted.

## Current reality

OPUS is now committed/pushed at:

`8c7f254ad9080c46bb4da4af272a5c7cd2d4a129`

`opus_p117w_r45b2a4bz2r8b_graphical_php_handler_authoring`

That exact commit contains the original duplicate ACL collision branch. The subsequent R8A2V validation artifact also failed immediately because it required the obsolete `9fdf45ae...` HEAD.

## Current recovery

Use only:

`P117W_R45B2A4BZ2R8B1_ACTUAL_R8B_BOOT_REPAIR`

R8B1 is bound to the actual pushed R8B baseline, applies or accepts the canonical guard repair idempotently, then forces a fresh-process runtime validation.
