# OPUS — P117SITE14 status

Date: 2026-06-20
Status: VALIDATED_RUNTIME

P117SITE14 formalizes the generated-site workflow so an OPUS user can modify a generated site without opening framework internals.

The visible page path is:

```text
route -> module -> template -> i18n -> assets
```

Validated OPUS runner:

```text
P117SITE14_GENERATED_SITE_WORKFLOW_DOCS_RUNNER
```

Runtime validation markers observed from the user run:

```text
CHECK_START_HERE_WORKFLOW=OK
CHECK_MODULE_README_WORKFLOW=OK
CHECK_PUBLIC_SCORE_RENDERER=OK
CHECK_CLEANUP=OK
P117SITE14_GENERATED_SITE_WORKFLOW_SMOKE_OK
P117SITE14_GENERATED_SITE_WORKFLOW_DOCS_OK
```

Validated scope:

- generated `START_HERE.md` documents the route -> module -> template -> i18n -> assets workflow;
- generated module README files document the module edit path;
- `DOC/P117SITE14_GENERATED_SITE_WORKFLOW.md` is added to OPUS;
- `tools/smoke_p117site14_generated_site_workflow.py` is added to OPUS;
- the smoke generates `sites/skeleton`, validates it, verifies workflow markers, verifies `ScoreTemplateRenderer`, then removes `sites/skeleton`.

Source policy: `sites/skeleton/` remains a generated artifact and must not be committed.

Current OPUS local expected changes after validation:

```text
 M framework/Opus/Scaffold/SiteScaffoldPlan.php
?? DOC/
?? tools/smoke_p117site14_generated_site_workflow.py
```

Next milestone: add Composer introspection commands for generated sites: `opus:list-routes`, `opus:list-modules`, then module/page/rubric creation commands.
