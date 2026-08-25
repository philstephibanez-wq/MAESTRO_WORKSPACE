# P117W R45B2A4BZ2 R8B6I — Finite-global source-node EFSM — HANDOFF

State: DELIVERED — OWNER APPLY/RUNTIME ACCEPTANCE PENDING

## Baseline

- OPUS HEAD: `1f94204116ad4ea26df6a040ad9a37b8134fb745`.
- Expected current working file after R8B6H: blob `85e37727b76c4dcd9b5258009ad53c355d7841b9`.
- R8B6H is rejected. R8B6I replaces it; do not restore R8B6H first.

## Correction

The shared horizontal OPUS renderer now creates one explicit finite-global source-set node per distinct `from_states` set. Every canonical global transition starts at its own port on that node, carries its signal card, and terminates with an arrow on its real target.

Navigation therefore renders one seven-state source node and seven named transitions. Canonical `navigation.open.*` IDs remain the only persistence keys. NMI behavior, local transitions, self-loops, EFSM configuration and state-position persistence are unchanged.

## Artifact

- `opus_p117w_r45b2a4bz2r8b6i_finite_global_source_node_efsm.zip`
- SHA-256: `cbd3619d314996ba36619e94fe1eea4a75f001e149b6131c2fa99fcb5374f991`
- size: `30968` bytes
- contains exactly `Opus/Fsm/Diagram.class.php`
- file SHA-256: `0da0884eb2658567f868e4768c439494f313ab389f46395fddb3016b0761d6ba`
- delivered Git blob: `d7ebe8d4b31a062d8afcee43e5f1177d95432002`
- ZIP byte round-trip: PASS
- `git diff --check`: PASS

PHP is unavailable in the delivery environment; owner PHP lint and runtime validation are mandatory and are not claimed as executed.

## Owner commands

```cmd
cd /d H:\OPUS
git rev-parse HEAD
git status --short
tar -xf "%USERPROFILE%\Downloads\opus_p117w_r45b2a4bz2r8b6i_finite_global_source_node_efsm.zip"
php -l Opus\Fsm\Diagram.class.php
git diff --check
composer dump-autoload -o
composer opus:validate-site -- owasys-front
composer opus:validate-site -- owasys-back
composer opus:validate-site -- essai
git status --short
```

## Runtime gate

The diagram must show:

- one clearly readable `FINITE GLOBAL SOURCE SET` node listing the seven Navigation states;
- seven distinct paths from that node;
- one readable canonical `open_*` signal on each path;
- arrows terminating on the seven real target states;
- the seven existing context-ready self-loops;
- unchanged state positions after View/Conception switching and reload.

Do not commit/push OPUS until this visual and persistence gate passes.
