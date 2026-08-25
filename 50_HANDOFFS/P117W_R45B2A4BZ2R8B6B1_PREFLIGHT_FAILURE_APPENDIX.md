# P117W R45B2A4BZ2 R8B6B1 — PREFLIGHT FAILURE APPENDIX

State: FAILED BEFORE WRITE — SUPERSEDED BY R8B6B2

## Owner evidence

R8B6B1 was applied from a temporary directory against a clean OPUS worktree.

The ZIP SHA-256 matched the delivered artifact:

`2b30fc693ad737ff3f35cccb8e806d51b2dbd8fe704da502e4401c3c8d9a8fc4`

The runner stopped immediately after `P117W_R45B2A4BZ2R8B6B1_PREFLIGHT_BEGIN` with:

`P117W_R45B2A4BZ2R8B6B1_BASELINE_BLOB_INVALID:sites/owasys-back/application/fsm/services/OwasysFsmLayoutCommandProvider.php:5a9f7150867d783a9e92fb7a7d7c51b306d8c65e`

No `PREFLIGHT_OK` marker was emitted and the runner had not reached any write section.

External `composer opus:validate-site` remained PASS for owasys-front and owasys-back; the owner also started the essai validation sequence.

## Root cause established after failure

Inspection of the delivered B1 applicator shows the embedded expected blob was malformed:

`5a9f7150867d783a9e92fb7a7d7c51b306d8c65`

Length: 39 characters.

The canonical GitHub blob at the accepted OPUS HEAD is:

`5a9f7150867d783a9e92fb7a7d7c51b306d8c65e`

Length: 40 characters.

The same malformed metadata existed in both the `existingBlobs` table and the patch metadata for that path.

The B1 diagnostic printed only the actual SHA and therefore concealed the malformed expected value.

## Disposition

- R8B6B1 must not be retried.
- No OPUS source rollback is required because no write occurred.
- R8B6B2 repairs only the delivery verifier metadata/gate and preserves the functional R8B6B payload.
