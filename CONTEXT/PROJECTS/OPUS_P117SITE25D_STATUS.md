# OPUS P117SITE25D — Physical boundary migration real

Status: DELIVERED

Target tree:

```text
framework/Opus/
  FRONT/
  MIDDLE/
  BACK/
  COMMON/
  BOUNDARY_MAP.json
  ARCHITECTURE_BOUNDARIES.md
  README.md
```

The runner delivered in OPUS is:

```text
tools/refactor_p117site25d_physical_boundary_migration_real.py
```

The runner must move known legacy root directories into one explicit boundary and refuse unknown root directories before mutation.

`COMMON` remains strict shared language only and is not a catch-all.

Mermaid UML diagrams and FSM transition diagrams are mandatory in architecture documentation.

Test command:

```cmd
cd /d H:\OPUS
git pull --ff-only
python tools\refactor_p117site25d_physical_boundary_migration_real.py --write
dir /b framework\Opus
python tools\smoke_p117site25c_front_middle_back_common_physical_tree.py
git status --short
```

Expected root after migration:

```text
ARCHITECTURE_BOUNDARIES.md
BACK
BOUNDARY_MAP.json
COMMON
FRONT
MIDDLE
README.md
```
