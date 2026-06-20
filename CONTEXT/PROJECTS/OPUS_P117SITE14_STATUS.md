# OPUS — P117SITE14 status

Date: 2026-06-20
Status: RUNNER_DELIVERED_PENDING_RUNTIME

P117SITE14 formalizes the generated-site workflow so an OPUS user can modify a generated site without opening framework internals.

The visible page path is:

```text
route -> module -> template -> i18n -> assets
```

Delivered runner scope:

- patch generated START_HERE content in SiteScaffoldPlan.php;
- patch generated module README content in SiteScaffoldPlan.php;
- add DOC/P117SITE14_GENERATED_SITE_WORKFLOW.md to OPUS;
- add a cleanup smoke tool to OPUS;
- generate sites/skeleton, validate it, inspect generated docs/rendering contracts, then remove sites/skeleton.

Required validation markers:

```text
CHECK_START_HERE_WORKFLOW=OK
CHECK_MODULE_README_WORKFLOW=OK
CHECK_PUBLIC_SCORE_RENDERER=OK
CHECK_CLEANUP=OK
P117SITE14_GENERATED_SITE_WORKFLOW_SMOKE_OK
P117SITE14_GENERATED_SITE_WORKFLOW_DOCS_OK
```

Source policy: sites/skeleton remains a generated artifact and must not be committed.

Next after validation: add Composer introspection commands for routes and modules.
