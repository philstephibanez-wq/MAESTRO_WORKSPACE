# Patch Delivery Contract

## Workspace-only patching

Patch runners, reports, temporary files, backups and handoffs belong in MAESTRO_WORKSPACE.

## Project roots

Source roots must remain clean.

Examples:

- H:\ASAP = ASAP framework source.
- H:\ASAP_REF_BOOK = RefBook source.
- H:\MO_KB_DAEMON = MO_KB daemon source.
- H:\MAESTRO_WORKSPACE = control, patches, audits, reports, handoffs, backups.

## Historical preservation

Failed patches, wrong attempts and error reports are kept for traceability.
Cleanup means archive and classify, not erase.

## Native differential delivery

Every OPUS/OWASYS correction or evolution is delivered in the conversation as a native downloadable ZIP attachment.

The delivery contract is:

- use a short stable filename such as `R8B6M.zip`;
- the ZIP contains only complete changed files at their final repository paths;
- present the native conversation attachment directly;
- never replace that attachment with a ChatGPT Library URI, a GitHub/raw link, an external-site link or instructions to retrieve the artifact from a repository;
- after the attachment, provide a separate CMD block;
- extraction is explicit and rooted: `tar -xf "%USERPROFILE%\Downloads\<ZIP>" -C H:\OPUS`;
- CMD blocks contain executable commands only, without prompt, output, comments or diagnostics;
- verify archive contents and SHA-256 before delivery;
- announce delivery only after the attachment is available.

A successful historical delivery mechanism must not be changed unless the owner explicitly requests the change.
