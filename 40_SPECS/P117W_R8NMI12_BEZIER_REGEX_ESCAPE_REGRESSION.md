# P117W R8NMI12 — Bézier regex escape regression

## Scope
Restore the generic OPUS Bézier drag behavior that worked before the NMI series, without removing the accepted NMI geometry, marker, color, anchoring or persistence behavior.

## Authoritative evidence
GitHub OPUS commit `a253ca4f615e040b32c0847aaefd8b5b90417eed` (`R8NMI3`) changed the JavaScript `simpleCubicPath()` regex inside `Opus/Fsm/Diagram.class.php` from single-regex escapes (`\d`, `\s` in JavaScript source) to doubled escapes (`\\d`, `\\s` in JavaScript source).

Because `layoutInteractionScript()` is emitted through a PHP nowdoc, backslashes are already literal. Doubling them changes JavaScript regex semantics: the numeric matcher no longer recognizes ordinary digits and the command cleanup no longer removes whitespace. `simpleCubicPath()` therefore returns `null` for normal cubic SVG paths such as `M... C...`.

The generic pointerdown handler depends on `simpleCubicPath(edge)` before creating a Bézier drag. A `null` parse therefore makes every C1/C2 handle visible but inoperative, regardless of NMI status.

## Required correction
- Restore the two JavaScript regex literals in `simpleCubicPath()` to their pre-R8NMI3 semantics.
- Do not alter the generic pointerdown/pointermove/pointerup drag algorithm.
- Do not alter accepted NMI behavior.
- Do not alter OWASYS designer JavaScript.

## Acceptance
1. PHP syntax valid.
2. Embedded JavaScript syntax valid.
3. `simpleCubicPath()` regex accepts a representative `M x y C x y, x y, x y` path and leaves command string `MC`.
4. Normal transition C1/C2 handles move.
5. NMI transition C1/C2 handles move.
6. NMI marker/anchoring/color/persistence remain unchanged.
