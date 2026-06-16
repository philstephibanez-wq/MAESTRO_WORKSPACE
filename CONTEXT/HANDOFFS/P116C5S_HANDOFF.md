# P116C5S / P116C5T HANDOFF

Status: IN PROGRESS

Scope:
- OPUS: router-based breadcrumb foundation.
- OPUS_REF_BOOK: consume OPUS breadcrumb, restore global navigation, separate menu bar from header, keep sidebar complementary, enrich detail pages.
- P116C5T: map class responsibility / contract from live OPUS source documentation into the RefBook symbol ViewModel.
- MAESTRO_WORKSPACE: track this handoff systematically.

Created commits:
- OPUS 6319e598 P116C5S_ADD_ROUTER_BREADCRUMB_FOUNDATION
- OPUS ecec857d P116C5S_ADD_ROUTER_BREADCRUMB_BUILDER
- OPUS_REF_BOOK 9ce10848 P116C5S_ADD_REFBOOK_ROUTER_BREADCRUMB_SERVICE
- OPUS_REF_BOOK 4168604a P116C5S_USE_ROUTER_BREADCRUMB_SERVICE_IN_REFBOOK
- OPUS_REF_BOOK 73738d57 P116C5S_RESTORE_MAIN_MENU_AND_ROUTER_BREADCRUMB_TEMPLATE
- OPUS_REF_BOOK 7d2a85e P116C5S_MOVE_MAIN_MENU_BELOW_HEADER
- OPUS_REF_BOOK c1b8129 P116C5S_ADD_MENU_BAR_AND_FULL_SIDEBAR_CSS
- OPUS_REF_BOOK 1cd87f0 P116C5S_REMOVE_DOMAIN_DESCRIPTION_FALLBACK_FROM_DOMAIN_PAGE
- OPUS_REF_BOOK 6bbf603 P116C5S_ENRICH_SYMBOL_PAGE_WITH_MERMAID_TRACE
- OPUS_REF_BOOK 00de193 P116C5S_ENABLE_MERMAID_RENDERING
- OPUS_REF_BOOK dc603fe P116C5T_MAP_CLASS_RESPONSIBILITY_AND_CONTRACT
- MAESTRO_WORKSPACE dc603fe context note: OPUS_REF_BOOK commit maps class Responsibility / Contract from live source doc comments; missing fields remain absent, not filled by fallback text.

Applied UI corrections:
- Main menu moved below the header as a dedicated horizontal menu bar.
- Sidebar remains complementary and no longer owns the global menu role.
- Sidebar domain list is no longer capped by an internal max-height; it follows the page flow.
- Domain page no longer renders generated/fallback domain descriptions.
- Symbol detail page now exposes a Mermaid trace generated from real symbol/domain/source/method data.

Applied metadata corrections:
- ReferenceRuntimeSnapshotRepository no longer forces empty responsibility / contract on every class.
- Class Responsibility is parsed from the official source doc section `Responsibility:`.
- Class Contract is parsed from the official source doc section `Contract:`.
- If a class has no source section, the key is omitted; the public UI must not invent fallback text.

Remaining:
- Fix app shell scrolling so header/menu/breadcrumb stay visible while central content scrolls.
- Replace remaining public symbol/symbole wording in i18n catalogs.
- Remove inactive domain description fallback code from ReferenceContentService and ReferenceCatalogService.
- Consider exposing OpusRefBookClass attribute payload directly through RuntimeClassCatalog in a later OPUS-side refinement.
- Run local browser smoke after pulling OPUS_REF_BOOK.

Rule:
- No fallback text.
- Breadcrumb must remain router/ViewModel based.
- Pull OPUS before OPUS_REF_BOOK when OPUS-side breadcrumb classes change.
