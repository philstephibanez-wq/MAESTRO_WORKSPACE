# P117W R45B2A4V — FSM fan-out readability + functional change_app, corrected baseline gate

State: INVALID — SUPERSEDED BY R45B2A4W

## Validation failure

A4V did not modify tracked OPUS files. It failed before writes on:

`OPUS_P117W_R45B2A4V_ANCHOR_INVALID:transition-label-box:0`

The baseline HEAD/EOL/semantic gates had passed. The failure is therefore in the A4V delivery mechanism itself, not in OPUS runtime state.

## Root cause of invalid delivery

A4V still used exact text-body replacement anchors inside `Opus/Fsm/Diagram.class.php`. The `transitionSvg()` anchor embedded representation escaping that was not present in the actual A4T PHP source, so the expected block count was zero.

Exact body-text anchoring is now forbidden for this continuation. A4W supersedes A4V with PHP-token structural method replacement using `token_get_all()` and method identity, not serialized body text.

## Retained functional intent

The intended functional correction remains valid and is moved unchanged to A4W:

- generic compact fan-out layout for high-outdegree current states;
- distinct source/target signal lanes;
- bounded signal label hitboxes;
- `change_app` performs existing canonical FSM action `clear_current_app` on all ten transitions;
- Menu = FSM remains unchanged;
- no direct state commands, JavaScript, GraphViz or external process.

## Historical artifact

`opus_p117w_r45b2a4v_fsm_fanout_change_app.zip`

Historical SHA-256:

`03770fff665477276808b6542b55db9107c654208ee1c42683a4c63927fc7895`

Do not apply A4V again.

The assistant does not commit or push OPUS/OWASYS.