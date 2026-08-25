# P117W R45B2A4BZ2 R8B6C — Dedicated Navigation EFSM / Structure extraction — SPEC

State: SUPERSEDED BEFORE DELIVERY — PUBLIC CONCEPT RENAMED TO NAVIGATION

This draft is retained for traceability only.

Owner decision after reviewing the Structure view: the public and architectural concept must be named **Navigation**, not Structure. `Routes` is a technical projection inside Navigation, not the EFSM name.

No OPUS/OWASYS delivery was built from this draft.

The active replacement specification is:

`40_SPECS/P117W_R45B2A4BZ2R8B6C_DEDICATED_NAVIGATION_EFSM_AND_ROUTE_PROJECTION_SPEC.md`

The replacement preserves the legacy internal `structure` dispatcher identifier only as an explicit temporary compatibility detail while `config/fsm.json` remains the host dispatch FSM. It removes Structure from the visible concept, uses Navigation as the dedicated EFSM/domain name, and projects the public localized URL as Navigation.