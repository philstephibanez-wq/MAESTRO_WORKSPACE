# P116C5S HANDOFF

Status: IN PROGRESS

Scope:
- OPUS: router-based breadcrumb foundation.
- OPUS_REF_BOOK: consume OPUS breadcrumb and restore global menu in layout.
- MAESTRO_WORKSPACE: track this handoff.

Created commits:
- OPUS 6319e598 P116C5S_ADD_ROUTER_BREADCRUMB_FOUNDATION
- OPUS ecec857d P116C5S_ADD_ROUTER_BREADCRUMB_BUILDER
- OPUS_REF_BOOK 9ce10848 P116C5S_ADD_REFBOOK_ROUTER_BREADCRUMB_SERVICE
- OPUS_REF_BOOK 4168604a P116C5S_USE_ROUTER_BREADCRUMB_SERVICE_IN_REFBOOK
- OPUS_REF_BOOK 73738d57 P116C5S_RESTORE_MAIN_MENU_AND_ROUTER_BREADCRUMB_TEMPLATE

Remaining:
- Style main menu.
- Remove sidebar domain truncation.
- Enrich symbol detail page.
- Render Mermaid assets when present.
- Replace remaining public symbol/symbole wording.
- Populate responsibility and contract from OPUS source metadata.

Rule:
- No fallback text.
- Pull OPUS before OPUS_REF_BOOK because RefBook now consumes OPUS breadcrumb classes.
