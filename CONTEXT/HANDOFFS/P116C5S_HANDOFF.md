# P116C5S HANDOFF

Status: IN PROGRESS

Scope:
- OPUS: router-based breadcrumb foundation.
- OPUS_REF_BOOK: consume OPUS breadcrumb, restore global navigation, separate menu bar from header, keep sidebar complementary, enrich detail pages.
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

Applied UI corrections:
- Main menu moved below the header as a dedicated horizontal menu bar.
- Sidebar remains complementary and no longer owns the global menu role.
- Sidebar domain list is no longer capped by an internal max-height; it follows the page flow.
- Domain page no longer renders generated/fallback domain descriptions.
- Symbol detail page now exposes a Mermaid trace generated from real symbol/domain/source/method data.

Remaining:
- Replace remaining public symbol/symbole wording in i18n catalogs.
- Remove inactive domain description fallback code from ReferenceContentService and ReferenceCatalogService.
- Populate responsibility and contract from OPUS source metadata instead of leaving absent sections.
- Run local browser smoke after pulling OPUS then OPUS_REF_BOOK.

Rule:
- No fallback text.
- Breadcrumb must remain router/ViewModel based.
- Pull OPUS before OPUS_REF_BOOK because RefBook consumes OPUS breadcrumb classes.
