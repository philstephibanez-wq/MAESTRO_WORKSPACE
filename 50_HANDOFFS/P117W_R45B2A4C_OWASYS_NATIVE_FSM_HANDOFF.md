# Handoff — P117W R45B2A4C OWASYS native FSM

Date: 2026-08-14
State: OWNER VALIDATION REQUIRED

## Current point

Owner applied R45B2A4B and OPUS master now contains commit `87c4ec39d3dd331e1d507187fb15c181cde046ec`. The unchanged OWASYS screenshot is explained by a separate OWASYS-specific Mermaid projection still active in `owasys-front`, not by failure to commit R45B2A4B.

The audit also found that R45B2A4B itself was only partially applied: its patch-program text is present inside `OPUS_FSM_Diagram::svgDefinitions()` and the generated runtime call site still lacks the `$acl` argument required by the new `renderPage()` signature.

## Delivery

`opus_p117w_r45b2a4c_owasys_native_fsm.zip`

SHA-256: `599cf01e4f3649cc1397298e7e60d81579c190085150496def6778e3635d91de`

This delivery repairs the native framework renderer first, then changes OWASYS to consume it directly from the canonical FSM and removes the Mermaid-only OWASYS FSM projection.

## Owner sequence

From `H:\OPUS`:

1. extract the differential ZIP;
2. run `php tools\apply_p117w_r45b2a4c_native_fsm.php`;
3. run `composer dump-autoload -o`;
4. lint the repaired framework/runtime and the new OWASYS builder;
5. verify the obsolete Mermaid FSM files are gone;
6. restart `owasys-front`;
7. validate the native semantic FSM surface, real wildcard transitions, current-state highlight, ACL filtering and localized state links;
8. delete the one-shot apply script before owner commit;
9. owner commits/pushes OPUS only after validation.

## Expected visible change

The former card headed `Navigation principale · FSM` may remain as the SCORE shell, but its content must no longer be a Mermaid linearized graph. It must contain OPUS's server-rendered semantic SVG and identify `OPUS_FSM_Diagram · OWASYS_NAVIGATION_FSM_V1`.

The source `*` wildcard semantics are authoritative. Legacy `visual=true` / `visual_from` presentation metadata is removed and must not drive the graph.

## Stop conditions

Stop without local workaround if the apply script reports any `OPUS_P117W_R45B2A4C_*_INVALID`, `..._MISSING`, `..._LINT_FAILED` or `..._APPLY_FAILED` error. These mean OPUS master differs from the audited `87c4ec39` state or a required contract cannot be proven.