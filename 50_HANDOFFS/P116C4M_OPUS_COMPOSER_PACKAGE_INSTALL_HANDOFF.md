# P116C4M OPUS Composer Package Install Handoff

Status validated before this handoff:
- OPUS commit baa2085 P116C4L_INSTALL_VERSIONED_REFBOOK_SITE pushed.
- MAESTRO_WORKSPACE commit d926b09 P116C4L_ADD_WORKSPACE_LAYOUT_GUARD pushed.
- OPUS_REF_BOOK legacy layout cleaned locally and repository clean.
- Workspace layout guard is now called first by RUN_OPUS_GLOBAL_RECIPE.cmd.

Permanent rule:
- OPUS packages install through Composer only.
- Package installation must be multiplatform.
- No xcopy, rmdir, mklink, cmd, PowerShell or OS-specific system commands in the package installation contract.
- Workspace CMD recipes are allowed only as local QA guards, not as OPUS package install mechanisms.
- Deliverable sites and packages must not contain DOC, tools, var, patch notes, TODO files, smoke scripts or runtime cache.
- Archives live under 90_ARCHIVES only. 99_ARCHIVES is forbidden.

Next implementation target:
- Define the Composer based OPUS package installer contract.
- Replace any package install copy workflow with Composer scripts or Composer installer logic.
- Keep OPUS core shared and required.
- Preserve zero silent fallback.
- Keep all generated docs and tools in MAESTRO_WORKSPACE, never in deliverable packages.

Clarification:
- The Composer-only, multiplatform rule applies to client deliverables and package installation contracts.
- Development tooling may use local workspace commands, CMD recipes, smoke tests and generators, but only from MAESTRO_WORKSPACE.
- Product and deliverable roots must stay clean.
- Anything that is not deliverable must execute from the workspace, not from OPUS, OPUS_REF_BOOK, packages or public site roots.
