# Handoff R8B6R — Renommage de transition

Date: 2026-08-31

State: DELIVERED — OWNER APPLY/VALIDATE REQUIRED

## Delivery

- Native differential ZIP: `R8B6R.zip`
- Required OPUS baseline: `b4be25e73ad388bb1f9286f8100292f5bd20ec55`
- SHA-256: `7b6afae3925ee5e462a394d4f64c0212219fce1d2f7e2b4bb0beeb7d8064960c`
- Files: 7 complete final files only.

## Expected behavior

Select a transition, choose TRANSITION → Renommer, replace its identifier and
validate. The semantic definition and layout write together. On reload the
renamed transition retains its Bézier controls, label and leader geometry.

## Owner gate

Apply the conversation ZIP, run the supplied CMD block, then test one existing
transition whose controls and label have been manually positioned. Return:

- full validation output;
- runtime result and visible response time;
- fresh front/back Profiler logs or JSONL for timing analysis;
- pushed OPUS SHA after acceptance.

No Codex VS Code or Codex CLI action is part of this handoff. The owner uses
VS Code/CMD and Git review only.
