# OWASYS P117U HF2 — COMPOSER RESOLUTION AND REST ERROR BOUNDARY

Date: 2026-07-23
Status: binding supplement to `OWASYS_CANONICAL_REST_COMPOSER_BACKEND_SPEC_P117U.md`

## 1. Scope

HF2 corrects a generic OPUS runtime defect exposed by the owner Windows environment:

```text
OPUS_RCP_COMPOSER_PHAR_MISSING:composer.phar
```

The OPUS root contains no local `composer.phar`; Composer is globally installed. The correction belongs to the OPUS framework because Composer discovery and REST response validation are not OWASYS business concerns.

No local OWASYS command fallback is authorized.

## 2. Trusted Composer resolution

The REST server configuration uses:

```json
"composer_command": ["@composer"]
```

`@composer` is a framework-owned token. It is not supplied by the browser and cannot be overridden by an operation payload.

The resolver checks only these sources:

1. `OPUS_COMPOSER_PHAR`, when it is an absolute operator-controlled path;
2. `<OPUS_ROOT>/composer.phar`;
3. `composer.phar` in directories already declared in the server process `PATH`;
4. standard Windows Composer locations derived from `ProgramData`, `APPDATA`, `LOCALAPPDATA` and `USERPROFILE`.

A selected candidate must be an existing regular file. The resulting command is always:

```text
PHP_BINARY <absolute-composer.phar>
```

The framework must never:

- accept a Composer executable or PHAR path from the browser;
- accept executable names from REST operation parameters;
- execute a `.bat` or `.cmd` wrapper through an uncontrolled shell;
- interpolate an operation payload into a command string;
- change the configured OPUS working root;
- silently bypass Composer and call an OWASYS business service directly.

If no trusted PHAR is found, the backend returns:

```text
OPUS_RCP_COMPOSER_NOT_FOUND
```

## 3. REST HTTP response boundary

The generic REST client validates in this order:

1. connection success;
2. response size;
3. HTTP status line;
4. media type;
5. JSON syntax;
6. response contract;
7. execution identifier;
8. execution status.

An HTML or plain-text HTTP error is never sent to the JSON parser.

Required stable errors:

```text
OPUS_RCP_CONNECTION_FAILED
OPUS_RCP_HTTP_STATUS_MISSING
OPUS_RCP_BACKEND_HTTP_ERROR:<status>
OPUS_RCP_BACKEND_JSON_INVALID:<status>
OPUS_RCP_RESPONSE_CONTENT_TYPE_INVALID
OPUS_RCP_RESPONSE_JSON_INVALID
OPUS_RCP_RESPONSE_CONTRACT_INVALID
```

For a non-2xx JSON response, only an error code matching the strict uppercase OPUS code format may be propagated.

## 4. OWASYS API boundary

OWASYS remains an OPUS application. Its API controller may catch backend initialization failures only to serialize a controlled REST error response.

Required response:

```json
{
  "contract": "OPUS_RCP_REST_ERROR_V1",
  "status": "failed",
  "error_code": "<validated-code>"
}
```

HTTP status is `503` for initialization unavailability.

The controller must not:

- render an HTML fatal page;
- use `echo`;
- disclose stack traces, absolute paths, secrets or request parameters;
- execute a local business fallback.

## 5. Framework contracts

`RcpRestServer` and `RcpRestClient` remain concrete OPUS framework classes implementing their existing homonymous interfaces. Those interfaces extend the four mandatory markers:

- `OpusFrameworkComponentInterface`;
- `OpusExceptionAwareInterface`;
- `OpusProfilerAwareInterface`;
- `OpusSelfDocumentingInterface`.

No new concrete framework class is introduced by HF2.

## 6. Configuration boundary

`backend.rest.json` remains under:

```text
sites/owasys/config/
```

It is read through OPUS `File` and `StructuredFileLoader` with the OPUS JSON parser. No root configuration directory is added.

## 7. Differential

- ZIP: `opus_owasys_p117u_hf2_composer_resolution.zip`
- SHA-256: `c26d32f3b1446c8bb65c668ab8c7c785783162855f8b5b02e57dd61e8e97f980`
- Files: 4
- Bytes: 10,447

```text
Opus/Rcp/Rest/RcpRestServer.php
Opus/Rcp/Rest/RcpRestClient.php
sites/owasys/application/api/controllers/BackendApiController.php
sites/owasys/config/backend.rest.json
```

No new OPUS root entry is introduced.

## 8. Acceptance

HF2 is accepted only when:

1. PHP lint passes for all changed PHP files;
2. backend configuration parses through the OPUS JSON boundary;
3. local-root Composer PHAR resolution passes when present;
4. global Windows Composer PHAR discovery through `PATH` passes;
5. an absolute `OPUS_COMPOSER_PHAR` override is accepted;
6. a relative override is rejected;
7. execution works when the PHAR path contains spaces;
8. HTML HTTP 500 produces `OPUS_RCP_BACKEND_HTTP_ERROR:500`;
9. controlled JSON 503 propagates `OPUS_RCP_COMPOSER_NOT_FOUND`;
10. backend initialization failure is emitted as JSON 503;
11. no shell command or browser executable input is introduced;
12. the owner Windows backend status and Registry synchronization pass after extraction.
