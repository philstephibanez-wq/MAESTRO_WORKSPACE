# P117W R45B2A4BZ2 R8B6B2 — Expected blob gate repair — SPEC

State: ACTIVE — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Source gate

- README-FIRST blob: `1d7c00ade6521a5fe3fcb83139ce18d98033e810`.
- OPUS baseline/master: `56d4293f21f0a049cfe7cbe968916896de47dc41`.
- R8B6B failed before write on a baseline verifier defect.
- R8B6B1 also failed before write on the same generated expected-blob defect.
- Functional target remains R8B6B multi-state host EFSM runtime.

## Exact cause

The generated R8B6B/R8B6B1 runner embedded the expected blob for:

`sites/owasys-back/application/fsm/services/OwasysFsmLayoutCommandProvider.php`

as:

`5a9f7150867d783a9e92fb7a7d7c51b306d8c65`

which is only 39 hexadecimal characters.

Fresh GitHub source inspection at the exact accepted OPUS HEAD gives the canonical blob:

`5a9f7150867d783a9e92fb7a7d7c51b306d8c65e`

which is the valid 40-character Git object id.

The prior failure diagnostic printed only the actual value, which hid the malformed expected value.

## Repair

R8B6B2 changes only the applicator delivery gate:

1. repair the expected blob in both embedded metadata structures (`existingBlobs` and the patch metadata `blob`);
2. require every expected baseline blob to match `^[a-f0-9]{40}$` before reading the actual Git tree object;
3. keep canonical source verification through `git rev-parse --verify HEAD:<path>`;
4. when a mismatch exists, report both `expected=<sha>` and `actual=<sha>`;
5. add marker `expected_blob_shape=40hex` after successful preflight.

## Functional payload identity

R8B6B2 must not change the intended OPUS functional payload.

Compared with R8B6B1:

- `expectedModified`: byte-equivalent decoded content;
- `expectedNew`: byte-equivalent decoded content;
- `specialCounts`: byte-equivalent decoded content;
- `newFiles`: byte-equivalent decoded content;
- PHP replacement transformations: byte-equivalent decoded content;
- only expected blob metadata and delivery-gate diagnostics differ.

The intended OPUS mutation remains exactly 20 paths: 11 modified + 9 new, implementing the six multi-state host EFSMs `registry`, `application`, `data`, `source`, `git`, `build`, their COMMAND/EVENT communication, persisted runtime-state projection, and system-EFSM mutation ACL reinforcement.

## All baseline blobs revalidated

All eleven expected existing target blobs were freshly compared against GitHub source metadata at OPUS HEAD `56d4293f21f0a049cfe7cbe968916896de47dc41` and are exact 40-hex values.

## Safety

The applicator must still:

- require exact HEAD;
- require clean worktree/index;
- require all nine new targets absent;
- validate every baseline object from the HEAD tree;
- reject malformed expected object ids before any source mutation;
- lint all candidate PHP before writes;
- parse all candidate JSON before writes;
- write atomically;
- verify exact 20-path inventory;
- run `git diff --check`;
- rollback only its own writes on post-write failure;
- never invoke Composer internally.

## Owner gate

Do not retry R8B6B or R8B6B1.

Apply only R8B6B2 from a temporary directory outside `H:\OPUS`, then validate owasys-front, owasys-back and essai externally. Do not commit/push until the complete R8B6B runtime acceptance matrix passes.
