# EZScore OPUS R1 — Migration Spec

Date: 2026-09-11
Status: DELIVERY READY

Start EZScore migration into OPUS while preserving the validated EZScore V50 presentation baseline.

Scope: create sites/ezscore as a read-only OPUS application using SCORE, Singleton runtime, FSM-module-first routing, deny-by-default ACL configuration, browser locale negotiation, Logger and Profiler through GeneratedSiteRuntime, and direct read-only access to the existing EZScore musical database.

Routes:
- / : catalog
- /song?song=<sha256> : song partition

Visual baseline to preserve: compact song heading, five metrics, four measures per row, named blocks, large lyric/chord typography, historical versions, A4-friendly four-measure layout, and no cover in print.

Deferred: SSO backed by EZScore_users.sqlite3, owner/editor/reader ACL mapping, Brouillon/Préparation/Version mutations, cover management, synchronized player and Publish.
