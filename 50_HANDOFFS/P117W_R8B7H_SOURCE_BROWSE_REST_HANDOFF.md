# P117W R8B7H — Source Browse REST Handoff

Status: READY FOR OWNER APPLY/VALIDATE
Date: 2026-09-03
OPUS baseline: `f17c063671ff3387645b32d0149d84d4741d7cc8`

## Root cause

The front source workspace opens a selected source through `OwasysSourceModel::browse()`, which currently performs two REST requests: `source.list` followed by `source.read`.

The backend already owns the aggregate Composer operation `source.browse` / `owasys:source-browse`, returning `OWASYS_SOURCE_BROWSE_V1` with `listing` plus `selected`. The missing piece is its symmetric REST exposure and front use.

Direct execution `composer owasys:source-browse -- ...` is not a valid validation path: this provider requires an `OPUS_REST_API_COMPOSER_COMMAND_REQUEST_V1` request produced by the REST pipeline.

## Delivery scope

Exactly three complete OPUS files:

- `sites/owasys-front/application/source/models/SourceModel.php`
- `sites/owasys-front/config/rest.resources.json`
- `sites/owasys-back/config/backend.resources.json`

No backend business/provider change is required.

## Runtime validation after extraction

Owner validates one step at a time under the native ZIP workflow. Critical runtime evidence:

- no REST catalog mismatch;
- source page still opens and renders correctly;
- selected source opening produces `operation=source.browse` / `script=owasys:source-browse` instead of the former pair `source.list` + `source.read` for that browse;
- compare fresh front/back logs and Profiler JSONL against the pre-change run.

## Stop conditions

Stop on unexpected HEAD, dirty worktree before extraction, syntax/JSON failure, site validation failure, `OPUS_REST_API_CATALOG_MISMATCH`, source contract regression, or runtime regression.

The assistant does not commit or push OPUS/OWASYS. Owner applies, validates, commits and pushes only after acceptance.
