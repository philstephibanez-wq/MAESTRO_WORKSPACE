# P117W R8B7H — Source Browse REST

Status: DELIVERY CANDIDATE
Baseline OPUS: `f17c063671ff3387645b32d0149d84d4741d7cc8`
Date: 2026-09-03

## Problem

The OWASYS Sources et Git file-opening path currently composes a browse operation in `OwasysSourceModel::browse()` by issuing two secured REST calls in sequence: `source.list`, then `source.read`.

Fresh runtime evidence shows `source.list` typically costs about 155–201 ms in the backend Composer execution path, while `source.read` costs about 23–69 ms. These calls are repeated for each file opening and account for a material share of the latency hidden outside the visible front Profiler spans.

## Existing generic capability

`owasys-back` already declares and implements `source.browse` / `owasys:source-browse` through `OwasysSourceCommandProvider`. Its result contract is `OWASYS_SOURCE_BROWSE_V1` and contains both `listing` and `selected`.

This capability is REST-owned and requires the `OPUS_REST_API_COMPOSER_COMMAND_REQUEST_V1` request contract. It is not a standalone Composer CLI command for direct owner testing.

## Required evolution

1. Expose one symmetric REST resource in both peer catalogs:
   - method: `GET`
   - path: `/api/v1/applications/{site_id}/source-browse/{*path}`
   - operation: `source.browse`
   - success status: `200`
2. Keep `source.list` and `source.read` unchanged as unit resources.
3. Change only `OwasysSourceModel::browse()` to call the aggregate REST resource once.
4. Validate the aggregate response strictly:
   - contract `OWASYS_SOURCE_BROWSE_V1`;
   - `listing` is an OPUS source list V1/V2 with `files` array;
   - `selected` is an OPUS source file V1/V2 with string content and 64-hex SHA-256.
5. Do not add local cache, source-stat endpoint, direct filesystem shortcut, RPC naming, or bypass of the secured front → REST → back → Composer flow.

## Acceptance

- front/back REST resource catalogs remain byte-identical after the same route insertion;
- no `OPUS_REST_API_CATALOG_MISMATCH`;
- opening a source file yields one backend `source.browse` request rather than sequential `source.list` + `source.read` for the selection path;
- source tree and selected file content remain functionally unchanged;
- SCORE, FSM, ACL, SSO and Git behavior remain unchanged;
- compare fresh Profiler/log evidence against the pre-change baseline.
