# MAESTRO_WORKSPACE HANDOFF — OWASYS P117U HF2 COMPOSER RESOLUTION

Date: 2026-07-23
Status: differential prepared; isolated runtime gates green; owner Windows/browser retest pending
Applies after: P117U base differential and mandatory HF1 FSM correction

## Owner runtime incident

With frontend `127.0.0.1:8000` and backend `127.0.0.1:8792` both running, the backend failed during REST server construction:

```text
OPUS_RCP_COMPOSER_PHAR_MISSING:composer.phar
```

The frontend then received the backend PHP fatal page as HTML and attempted to parse it as JSON, producing:

```text
OPUS_JSON_PARSE_FAILED:http://127.0.0.1:8792/api/v1/executions:Syntax error
```

## Root cause

`sites/owasys/config/backend.rest.json` hardcoded:

```json
["@php", "composer.phar"]
```

The owner-confirmed OPUS root does not contain `composer.phar`. Composer is installed globally on the owner machine. `RcpRestServer` incorrectly required the local PHAR and the generic REST client did not validate HTTP status/content type before JSON parsing.

## HF2 differential

- ZIP: `opus_owasys_p117u_hf2_composer_resolution.zip`
- SHA-256: `c26d32f3b1446c8bb65c668ab8c7c785783162855f8b5b02e57dd61e8e97f980`
- Files: 4
- Bytes: 10,447

Files:

```text
Opus/Rcp/Rest/RcpRestServer.php
Opus/Rcp/Rest/RcpRestClient.php
sites/owasys/application/api/controllers/BackendApiController.php
sites/owasys/config/backend.rest.json
```

No root path is introduced.

## Framework correction

The need is generic and is therefore corrected in OPUS, not by an OWASYS-local executable workaround.

`RcpRestServer` now resolves the trusted Composer PHAR in this order:

1. explicit absolute `OPUS_COMPOSER_PHAR` operator override;
2. `<OPUS_ROOT>/composer.phar`;
3. `composer.phar` beside directories declared in `PATH`;
4. standard Windows Composer locations derived from `ProgramData`, `APPDATA`, `LOCALAPPDATA` and `USERPROFILE`.

The resolved command always remains:

```text
PHP_BINARY <absolute-composer.phar>
```

No browser value, operation parameter, executable name, shell fragment or working-directory override participates in resolution. Composer execution continues through an argument array with shell bypass.

`backend.rest.json` now declares the generic trusted token:

```json
"composer_command": ["@composer"]
```

## HTTP error boundary

`RcpRestClient` now validates:

1. HTTP status line;
2. JSON media type;
3. JSON syntax;
4. response contract;
5. execution identifier and command status.

An HTML backend fatal is no longer passed to the JSON parser. It becomes the stable code:

```text
OPUS_RCP_BACKEND_HTTP_ERROR:<status>
```

A JSON backend error propagates only a validated uppercase error code.

`OwasysBackendApiController` catches initialization failures and returns a controlled JSON 503 response with contract `OPUS_RCP_REST_ERROR_V1`. It produces no HTML and no `echo`.

## Isolated validation completed

- PHP lint for all three PHP files;
- JSON parse for backend configuration;
- Composer PHAR discovery through `PATH`;
- Composer PHAR execution from a path containing spaces;
- HTML HTTP 500 mapped to `OPUS_RCP_BACKEND_HTTP_ERROR:500`;
- JSON HTTP 503 mapped to `OPUS_RCP_COMPOSER_NOT_FOUND`;
- backend initialization failure emitted as JSON 503;
- ZIP integrity.

## Mandatory application order

1. Apply P117U.
2. Apply HF1.
3. Apply HF2.
4. Restart backend and frontend with the same secret environment file.
5. Verify backend status before opening the frontend.

## Windows retest

After HF2 extraction, restart the backend first:

```cmd
cd /d H:\OPUS
call runtime\owasys\backend-env.cmd
php -S 127.0.0.1:8792 -t sites\owasys\www sites\owasys\www\index.php
```

Then verify:

```cmd
curl.exe --fail --silent --show-error http://127.0.0.1:8792/api/v1/status
```

Then restart the frontend in a second terminal:

```cmd
cd /d H:\OPUS
call runtime\owasys\backend-env.cmd
php -S 127.0.0.1:8000 -t sites\owasys\www sites\owasys\www\index.php
```

If Composer still cannot be discovered, identify the installed wrapper:

```cmd
where composer
```

When that wrapper directory contains `composer.phar`, HF2 discovers it automatically. Otherwise set `OPUS_COMPOSER_PHAR` to the absolute PHAR path in both terminals before starting the servers.

## Permanent rules reinforced

OPUS is the framework.
OWASYS is an OPUS application.
REST plus Composer is the OWASYS backend.
No direct OWASYS business fallback is authorized.
No arbitrary executable or shell input is accepted.
Backend failures cross a typed JSON boundary, never an HTML fatal page.
