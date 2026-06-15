from pathlib import Path
import sys

if len(sys.argv) != 5:
    print("WORKSPACE_LAYOUT_GUARD_USAGE_ERROR")
    sys.exit(2)
if sys.argv[1] != "--workspace-root":
    print("WORKSPACE_LAYOUT_GUARD_WORKSPACE_ARG_MISSING")
    sys.exit(2)
if sys.argv[3] != "--opus-refbook-root":
    print("WORKSPACE_LAYOUT_GUARD_REFBOOK_ARG_MISSING")
    sys.exit(2)

workspace_root = Path(sys.argv[2])
opus_refbook_root = Path(sys.argv[4])
errors = []

if not workspace_root.exists():
    errors.append("WORKSPACE_ROOT_MISSING")
if not opus_refbook_root.exists():
    errors.append("OPUS_REF_BOOK_ROOT_MISSING")

if (workspace_root / "90_ARCHIVES").exists() is False:
    errors.append("WORKSPACE_90_ARCHIVES_MISSING")
if (workspace_root / "99_ARCHIVES").exists():
    errors.append("WORKSPACE_99_ARCHIVES_FORBIDDEN")

forbidden_dirs = ["DOC", "tools", "var"]
forbidden_files = ["PATCH.md", "TODO.md", "CHANGELOG.md", "cd", "tar"]

for name in forbidden_dirs:
    if (opus_refbook_root / name).exists():
        errors.append("OPUS_REF_BOOK_FORBIDDEN_DIR:" + name)
for name in forbidden_files:
    if (opus_refbook_root / name).exists():
        errors.append("OPUS_REF_BOOK_FORBIDDEN_FILE:" + name)

if opus_refbook_root.exists():
    for child in opus_refbook_root.iterdir():
        lower_name = child.name.lower()
        if child.is_file() and lower_name.startswith("smoke"):
            errors.append("OPUS_REF_BOOK_FORBIDDEN_ROOT_SCRIPT:" + child.name)
        if child.is_file() and lower_name.startswith("run_"):
            errors.append("OPUS_REF_BOOK_FORBIDDEN_ROOT_SCRIPT:" + child.name)

if errors:
    print("WORKSPACE_LAYOUT_GUARD_FAIL")
    for error in errors:
        print(error)
    sys.exit(1)

print("WORKSPACE_LAYOUT_GUARD_OK")
sys.exit(0)
