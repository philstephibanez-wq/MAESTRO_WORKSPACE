P115A1_WORKSPACE_LEGACY_FINALIZE

Finalizes the MAESTRO_WORKSPACE baseline organization after P115A.

Contract:
- Does not touch project source roots such as H:\ASAP or H:\ASAP_REF_BOOK.
- Does not delete history.
- Moves remaining legacy workspace root folders into H:\MAESTRO_WORKSPACE\99_ARCHIVES\history_preserved.
- Creates/updates INDEX_HISTORY_PRESERVED.md.
- Normalizes the known malformed P115A archive timestamp when present.

Run:
H:\MAESTRO_WORKSPACE\80_DOWNLOAD_INBOX\P115A1_WORKSPACE_LEGACY_FINALIZE\apply_P115A1_WORKSPACE_LEGACY_FINALIZE.cmd
