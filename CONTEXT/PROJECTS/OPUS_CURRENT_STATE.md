# OPUS CURRENT STATE

Last updated: 2026-07-23.

## Repository

- Remote: `philstephibanez-wq/OPUS`
- Branch: `master`
- Current remote head: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- Owner local development repo: `H:/OPUS` only as a local detail

## Active milestone

P117R — make OWASYS exclusively the interactive graphical surface and move every executable or mutating operation behind an allow-listed Composer command invoked through RCP.

Binding specification:

`CONTEXT/SPECIFICATIONS/OWASYS_COMPOSER_RCP_COMMAND_BOUNDARY_SPEC_P117R.md`

## Current committed OWASYS baseline

P117Q is committed on OPUS `master` and provides browser/regional locale policy, synchronized menu and Mermaid-FSM navigation, OWASYS Singleton composition root, canonical Registry discovery, explicit duplicate diagnostics, current-context reconciliation, readable Applications cards, SCORE rendering and the FSM + ACL + SSO pipeline.

## P117R authoritative differential

- ZIP: `opus_owasys_p117r_composer_rcp_differential.zip`
- SHA-256: `587638d2b436a74b41c0ecb3efe5d28468ab9806a7aefbe5051bdd541d491d8d`
- Files: 11
- Base: `36a8570088fb6084abdc694fd3ab8bf0bffa5d17`
- Only root entry: `composer.json`

The previous 16-file bootstrap ZIP with SHA-256 `ea7edbfca0e9df871ac7521cd9f8dd3f55811fc75bca7108259719d9ae884350` is rejected and must not be used because it polluted the OPUS root with delivery-only README, manifest and CMD files.

No OPUS code was pushed directly by the assistant.

## P117R bootstrap contents

- generic OPUS RCP command catalog;
- generic Composer RCP client;
- homonymous interfaces with the four framework markers;
- complete target command catalog;
- administrator-password change through Composer/RCP;
- command-side ACL revalidation;
- secret transfer through standard input rather than process arguments;
- structured result without secrets;
- OPUS `File` + `Json` password-store access and atomic write;
- bootstrap and exhaustive audits.

## Explicit incompleteness

Only `security.admin-password.change` is implemented. All remaining commands are declared but marked `implemented=false`; they fail explicitly and have no direct OWASYS fallback.

The exhaustive gate must remain red until every operation is migrated:

```cmd
composer opus:audit-owasys-rcp
```

## Mandatory command boundary

```text
OWASYS SCORE form
-> authenticated request
-> SSO identity
-> deny-by-default ACL
-> FSM signal and guards
-> immutable command intent
-> RCP request
-> allow-listed Composer command
-> typed OPUS command handler
-> structured result
-> OWASYS ViewModel
-> SCORE
```

Generic command and RCP implementation belongs to OPUS. OWASYS owns presentation adapters only.

## Configuration and framework contracts

- configuration files are read through `Opus\File\File`;
- JSON/YAML/YML/XML parsing is selected through OPUS structured parsers;
- no silent format fallback;
- every concrete OPUS class implements a homonymous interface;
- every homonymous interface extends the four standard markers;
- P117M-R1 remains a release gate;
- no delivery README, report, manifest or helper CMD belongs at OPUS root.

## Security rules

- no free-form command;
- no browser-supplied executable or absolute path;
- no shell fallback;
- no direct OWASYS process execution;
- no password in URL, process arguments, logs, profiler or raw output;
- command handlers revalidate ACL and identity;
- destructive commands require preview and explicit confirmation;
- Auth0 proxy and bastion remain behind OPUS SSO/RCP boundaries.

## Current exact gap

Apply and validate the clean P117R differential on the owner Windows installation. Then migrate site create/validate/build/export, structure, source, Registry writes, Git stage/commit, bootstrap, password reset, SSO/Auth0/bastion configuration and cleanup.

## `owasys_old`

Do not delete `sites/owasys_old` yet. P117Q uses it as a rejected duplicate for canonical Registry integrity. Delete it only after the exhaustive RCP audit, reference scan, backend-first/no-JavaScript/browser acceptance and explicit owner confirmation.

## Locked roadmap

1. Apply and validate the clean P117R differential.
2. Migrate every remaining OWASYS command to Composer/RCP.
3. Make the exhaustive RCP audit green.
4. Complete backend-first and no-JavaScript acceptance.
5. Complete owner browser acceptance.
6. Decide `owasys_old` deletion.
7. Generate the official OPUS demo through compliant OWASYS.
8. User Book.
9. Reference Book.
10. LSTSAR.
11. KB.
