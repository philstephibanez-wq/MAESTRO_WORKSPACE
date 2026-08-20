# P117W R45B2A4BS — OWASYS Source/Git lazy runtime — HANDOFF

## Current status

DELIVERABLE READY / OWNER APPLY + RUNTIME VALIDATION REQUIRED

## Why this package exists

Owner feedback identifies the latency as an OWASYS problem. The current Source/Git controller performs Git status, Git history and selected-file diff during every ordinary source render, even when Git information was not requested.

A4BS removes that mandatory work from the Source request path and makes Git loading explicit.

## Baseline

OPUS `master` observed before preparation:

`7038d0264e90b4bb83f124fa752f834ae5ee792d`

Canonical source blobs:

- SourceController: `8b0af1a1c01fc324d079ded5bfad3d85a766136f`
- source SCORE template: `26b91eab1da0bec20b135276416dd63e116afc07`

A4BR fresh-generation acceptance remains pending. A4BS is a requested blocker correction and does not close or supersede A4BR.

## Delivered files

- `sites/owasys-front/application/source/controllers/SourceController.php`
- `sites/owasys-front/application/source/templates/index.score`

No backend, framework, JavaScript, FSM, REST contract, generated-site or translation-catalogue file changes.

## Runtime contract after A4BS

### Ordinary Source page

Without `git=1`, OWASYS loads source data only. Git REST calls are not executed.

### Explicit Git load

The SCORE page exposes a Git load action. It requests the same Source route with `git=1`, after which the existing Git status/history/diff calls execute through the canonical secured path.

### Git mutation

Existing mutation semantics remain unchanged. Successful Git mutation redirects add both `git=1` and `git_status=<result>` so the Git workspace stays loaded after mutation.

### Invalid option

Any supplied `git` value other than exactly `1` is rejected explicitly with `OWASYS_GIT_WORKSPACE_OPTION_INVALID` and HTTP 400.

## Owner validation

From `H:\OPUS`, after direct ZIP extraction:

```cmd
php -l sites\owasys-front\application\source\controllers\SourceController.php
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
```

Then run the normal OWASYS front/back development servers and validate in browser:

- Source page opens and files remain browseable/editable without loading Git;
- profiler for that ordinary request contains no Git status/history/diff work;
- Git action loads the Git workspace through `?git=1`;
- status, history and selected-file diff remain functional after explicit load;
- a Git mutation returns to a URL preserving `git=1`;
- `?git=0` is explicitly rejected with HTTP 400.

The performance acceptance criterion is profiler evidence that the ordinary Source request no longer includes the formerly mandatory Git work.

## Do not do

- Do not patch owasys-back for this latency issue.
- Do not add client-side hiding to mask server latency.
- Do not bypass REST or invoke Git directly from owasys-front.
- Do not change timeouts as a substitute for removing unnecessary work.
- Do not mix the separate application-deletion workflow correction into this package.
- Do not commit/push OPUS from the assistant side.

## Next decision

If A4BS runtime evidence passes, preserve the evidence and return to the highest-priority gate. A4BR remains pending until its fresh-generation acceptance is actually executed. The deletion-menu issue remains a separate root-cause package if still reproducible and prioritized by the owner.