# P117W R45B2A4K — Verified signal FSM reissue

Status: READY FOR OWNER APPLICATION
Date: 2026-08-15
Attested OPUS base: `11e62f9d84622b08729b03a2f679f2fffd8e7e96` (`opus_p117w_r45b2a4e_fsm_signal_preview`)
Supersedes failed artifact: R45B2A4J

## Root cause of A4J failure

A4J correctly failed closed before modifying OPUS because the generated `Opus/Fsm/Diagram.class.php` did not lint.

The defect was in the A4J apply runner itself: the nowdoc opened for the `diagram.raw_transition_id` replacement used `<<<'NEW'` but was terminated by `OLD,` instead of `NEW,`. PHP therefore kept the nowdoc open until the next `NEW,` terminator and injected the following replacement-program source into the generated Diagram class. This produced the owner-observed parse error `unexpected token ","` around generated line 848.

Static audit of the whole runner found 58 nowdoc/heredoc blocks and exactly one suspicious nested/mis-terminated block: this one.

## A4K correction

A4K is a clean reissue from the exact A4E source attested by A4I. It keeps the functional contract of A4J unchanged and corrects only the faulty runner construction.

Before packaging, the A4K runner was validated by:

- `php -l` on the apply runner: no syntax errors;
- static nowdoc scan: `58` blocks, `0` suspicious/nested blocks;
- ZIP content verification;
- SHA-256 calculation.

The runner remains fail-closed:

- exact Git HEAD A4E required;
- exact A4I SHA-256 source fingerprints required;
- CWD/root equality required;
- every patched PHP result is linted before any write;
- no source/config write happens until all patched PHP results lint;
- rollback remains active after the write phase;
- success requires all mandatory tracked diffs and a dirty worktree.

## Functional contract retained

- finite declared FSM states only;
- normal `from:"*"` forbidden;
- explicit `interrupt:"nmi"` is the sole global-source exception;
- OWASYS normal navigation uses finite explicit source relations;
- target state boxes passive;
- current state is command context;
- outgoing route-backed GET signals are clickable controls;
- SVG signal labels may link to the same localized route;
- NMI stays out-of-band;
- generated application FSMs already present locally are migrated to finite sources;
- future scaffolds generate finite source relations;
- visible revision/cache marker becomes A4K.

## Delivery

Artifact: `opus_p117w_r45b2a4k_verified_signal_fsm.zip`
SHA-256: `3e485c28f93adaf20d1071ba9ea65e08917089a23fab3d3b3fb01fb2b1b56662`

ZIP entries:

- `tools/apply_p117w_r45b2a4k_verified_signal_fsm.php`
- `tools/VERIFY_P117W_R45B2A4K_APPLIED.cmd`
