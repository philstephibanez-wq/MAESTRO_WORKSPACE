# P117W R45B2A4H — Source-attested signal-driven FSM

Status: READY FOR OWNER APPLICATION
Date: 2026-08-15
Committed OPUS base: `11e62f9d84622b08729b03a2f679f2fffd8e7e96` (R45B2A4E)
Compatible local bases: R45B2A4E, locally-applied R45B2A4F, or locally-applied R45B2A4G

## Trigger

The owner reports no visible change after two cumulative FSM deliveries, including the signal-driven interaction delivery.

This is now treated as a source-attestation problem in addition to the FSM UI problem. R45B2A4G rewrites `sites/owasys-front/application/default/templates/partials/fsm-diagram.score` itself. Therefore, if the rendered page remains byte-for-byte/visually equivalent, the served application cannot be assumed to originate from the patched source tree.

## Required semantic contract

The FSM interaction remains signal-driven:

- finite state boxes are representation only;
- current state is context;
- outgoing route-backed signals from the current state are the clickable controls;
- destination state boxes are passive;
- normal `from:"*"` is forbidden;
- only explicit `interrupt:"nmi"` may retain a global source;
- NMI stays out-of-band and is never a normal navigation control;
- no JavaScript is introduced.

## New source-attestation contract

A delivery must prove both sides of the execution boundary.

### Apply-time proof

The runner:

1. resolves its OPUS root from its own path;
2. resolves the current working directory;
3. fails if CWD and OPUS root differ;
4. writes the cumulative FSM/UI correction;
5. rereads the actual files after write;
6. proves that `fsm-diagram.score` contains `data-fsm-ui-revision="P117W_R45B2A4H"`;
7. proves that `ScorePageRenderer.php` references `fsm-native.css?v=p117w-r45b2a4h`;
8. prints SHA-256 for the written partial, CSS and renderer.

### Serve-time proof

Generic `SiteCommandService::devServer()` is extended to print:

- `OPUS_DEV_SERVER_ROOT`;
- `OPUS_DEV_SERVER_SITE_ROOT`;
- `OPUS_DEV_SERVER_PUBLIC_ROOT`;
- `OPUS_DEV_SERVER_ROUTER`;
- `OPUS_DEV_SERVER_SOURCE_FINGERPRINT`.

The fingerprint is non-secret and is derived from the resolved site root plus the router content. It is passed to the child PHP development server through the environment.

`owasys-front/application/default/bootstrap.php` emits development-only response headers:

- `X-Opus-Source-Fingerprint`;
- `X-Owasys-Fsm-Ui-Contract: signal-driven-a4h`.

This makes it possible to prove that the HTTP response comes from the same checkout announced by Composer.

## Visible acceptance

The FSM SCORE partial always contains a visible current-state command surface. It is no longer hidden when no projected GET control exists.

The surface shows:

- current translated state;
- outgoing clickable signals when available;
- otherwise an explicit `Aucun signal GET sortant projetable depuis cet état.` message;
- a small `signal-driven · A4H` revision badge.

The badge is an intentional temporary acceptance marker for this delivery. It eliminates browser-cache/source-root ambiguity during validation.

## Artifact

`opus_p117w_r45b2a4h_source_attested_signal_fsm.zip`

SHA-256: `a35a2c229d12820a3c5246271fbca51caeb852165469e52b625f4c7df253520a`

ZIP entry:

- `tools/apply_p117w_r45b2a4h_source_attested_signal_fsm.php`

The assistant does not commit or push OPUS/OWASYS.