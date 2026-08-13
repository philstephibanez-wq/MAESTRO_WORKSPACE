# OPUS P117W R45D2A22D — Account Route Alias

Date : 2026-08-13

Owner gate: the authenticated viewer account page is accessible and self-service only. A direct request to `/account/` still returns `OWASYS_ROUTE_NOT_FOUND:account`.

Cause: the FSM already owns state `account` and its canonical detailed route. The controller lacks the natural `/account` alias.

Deliverable: `opus_p117w_r45d2a22d_account_canonical_route_alias.zip`
SHA-256: `0211101c5bb250555a9498ade7cfea8f60013be4331de17f53be17215a431478`

Contract: GET `/account` emits `open_account`, the FSM remains authoritative, and existing redirect machinery resolves the canonical account route. No ACL, SSO, role, or account-store semantics change.

Gate: `OPUS_R45D2A22D_APPLIED`, then `OPUS_R45D2A22D_ACCOUNT_CANONICAL_ROUTE_ALIAS_OK`, then the existing role capability matrix must remain green. Browser `/fr-FR/account/` must resolve to the canonical account page.
