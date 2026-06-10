P114O_REFBOOK_LOCALIZE_DISPLAY_FIELDS_WORKSPACE_APPLY

Fix:
- Localizes only RefBook display documentation fields in ReferenceCatalogService:
  role, responsibility, contract, methods.role, methods.behavior,
  methods.preconditions, methods.postconditions, methods.side_effects.
- Does not localize technical manifest fields such as PHP Reflection, schema,
  producer, runtime, source paths or API metadata.
- Uses ASAP shared I18N catalog from H:\ASAP through the existing mutualized autoload.

Workspace rule:
- Runner, backups and reports stay under:
  H:\MAESTRO_WORKSPACE\patches\P114O_REFBOOK_LOCALIZE_DISPLAY_FIELDS
- No patch/report/tool files are written into H:\ASAP or H:\ASAP_REF_BOOK.
