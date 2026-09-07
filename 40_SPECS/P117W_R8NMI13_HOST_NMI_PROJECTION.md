# P117W R8NMI13 — Host NMI projection

Status: delivery candidate
Date: 2026-09-07

## Source authority

GitHub OPUS master was re-read. The authoritative `sites/owasys-front/application/default/services/FsmDiagramBuilder.php` blob is `dc23e0303bf95e8315a401058343798b83356706` before this owner-applied delivery.

`sites/owasys-front/config/fsm.json` already defines NMI transitions to `fault` and `security_quarantine`. `sites/owasys-back/config/fsm.json` already defines NMI transitions to `fault` and `security_quarantine` as well.

## Root cause

The OWASYS host diagram projection explicitly discarded every transition with `interrupt: nmi` before rendering. In addition, the projection only kept menu-visible states, so pure EFSM control states such as `fault` and `security_quarantine` were absent from the projected state set.

This contradicted the security baseline contract: pure control states must remain visible/addressable by the EFSM diagram without becoming application modules.

## Required behavior

- Do not filter NMI transitions from the OWASYS host diagram.
- Project each canonical NMI target state even when it is not a navigation/menu state.
- Keep ordinary menu/global transition projection unchanged.
- Reject malformed NMI projection inputs fail-closed (`from != *`, unknown signal, unknown target).
- Preserve OWASYS-back as PHP/REST only; no JavaScript or UI is added to the backend.
- The graphical rendering remains in owasys-front.

## Delivery

Native differential ZIP `R8NMI13.zip` containing only the complete final file:

`sites/owasys-front/application/default/services/FsmDiagramBuilder.php`

No OPUS/OWASYS commit or push is performed by the assistant.
