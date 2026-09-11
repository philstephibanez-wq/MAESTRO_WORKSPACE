# EZScore OPUS R1 — Handoff

Date: 2026-09-11
Delivery: EZS_OPUS_R1.zip
SHA-256: b62e506fd264ce7826535a874c01b0ee016e3af52da84cd4e646570f36147721

The delivery is a differential native ZIP targeting H:\\OPUS only. It creates sites/ezscore with complete final files.

R1 is read-only and migrates the current EZScore catalog/song presentation to OPUS + SCORE while preserving EZScore V50 as the visual baseline.

Validated characteristics preserved: compact song header, Tempo/Signature/Tonalité/Capo/Mesures metrics, four measures per row, named blocks, chord cells around 1.9rem, lyric chords around 2.15rem, lyric text around 2.35rem, historical versions, A4-friendly four-measure print layout, and no cover in print.

Security boundary: no hidden login bridge. SSO and owner/editor/reader ACL backed by EZScore_users.sqlite3 are deferred to the next bounded step.

Next owner gate: clean OPUS worktree, apply ZIP, run PHP lint, opus:validate-site, opus:list-routes, opus:dev-server, then return full outputs and runtime evidence before any next migration step.
