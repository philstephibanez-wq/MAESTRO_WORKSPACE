#!/usr/bin/env python3
from __future__ import annotations

import json
import sys
from pathlib import Path

ROOT = Path(sys.argv[1] if len(sys.argv) > 1 else r"H:\OPUS").resolve()


def load(path: Path):
    return json.loads(path.read_text(encoding="utf-8"))


def site_locales(site: Path) -> list[str]:
    cfg = load(site / "config" / "site.json")
    return [x for x in cfg.get("locales", []) if isinstance(x, str)]


def efsm_id(path: Path, data: dict) -> str:
    explicit = str(data.get("efsm_id", "")).strip()
    if explicit:
        return explicit
    name = path.name
    return name[:-9] if name.endswith(".fsm.json") else path.stem


def label_key(kind: str, efsm: str, item: dict) -> tuple[str, str]:
    item_id = str(item.get("id", "")).strip()
    explicit = str(item.get("label_key", "")).strip()
    if explicit:
        return item_id, explicit
    return item_id, f"fsm.{efsm}.{kind}.{item_id}.label"


def catalogs(site: Path, locales: list[str]) -> dict[str, dict]:
    result = {}
    base = site / "application" / "default" / "local"
    for locale in locales:
        p = base / f"{locale}.json"
        if not p.is_file():
            result[locale] = {"missing_file": True, "inherits": None, "messages": {}}
            continue
        try:
            d = load(p)
        except Exception as exc:
            result[locale] = {"invalid": str(exc), "inherits": None, "messages": {}}
            continue
        result[locale] = {
            "missing_file": False,
            "inherits": d.get("inherits"),
            "messages": d.get("messages") if isinstance(d.get("messages"), dict) else {},
        }
    return result


print("R8B7G_EFSM_I18N_INVENTORY_V1")
print("ROOT=" + str(ROOT))

all_keys: dict[str, list[tuple[str, str, str, str]]] = {}

for side in ("owasys-front", "owasys-back"):
    site = ROOT / "sites" / side
    locales = site_locales(site)
    print(f"SITE={side}")
    print(f"LOCALES={len(locales)}|" + ",".join(locales))

    entries: list[tuple[str, str, str, str]] = []
    fsm_files = sorted(
        p for p in (site / "config").glob("*.fsm.json")
        if not p.name.endswith(".layout.json")
    )
    print(f"FSM_FILES={len(fsm_files)}")

    for path in fsm_files:
        data = load(path)
        efsm = efsm_id(path, data)
        states = [x for x in data.get("states", []) if isinstance(x, dict)]
        transitions = [x for x in data.get("transitions", []) if isinstance(x, dict)]
        print(f"EFSM={side}|{efsm}|{path.relative_to(ROOT).as_posix()}|states={len(states)}|transitions={len(transitions)}")
        for state in states:
            item_id, key = label_key("state", efsm, state)
            entries.append((efsm, "state", item_id, key))
            print(f"LABEL={side}|{efsm}|state|{item_id}|{key}")
        for transition in transitions:
            item_id, key = label_key("transition", efsm, transition)
            entries.append((efsm, "transition", item_id, key))
            print(f"LABEL={side}|{efsm}|transition|{item_id}|{key}")

    all_keys[side] = entries
    cats = catalogs(site, locales)
    required = {key for _, _, _, key in entries}
    for locale in locales:
        cat = cats[locale]
        messages = cat.get("messages", {})
        missing = sorted(required - set(messages))
        inherited = cat.get("inherits")
        status = "MISSING_FILE" if cat.get("missing_file") else ("INVALID" if cat.get("invalid") else "OK")
        print(
            f"COVERAGE={side}|{locale}|status={status}|inherits={inherited or ''}|"
            f"required={len(required)}|present={len(required)-len(missing)}|missing={len(missing)}"
        )
        for key in missing:
            print(f"MISSING={side}|{locale}|{key}")

print("SUMMARY")
for side in ("owasys-front", "owasys-back"):
    entries = all_keys.get(side, [])
    states = sum(1 for _, kind, _, _ in entries if kind == "state")
    transitions = sum(1 for _, kind, _, _ in entries if kind == "transition")
    print(f"{side}|states={states}|transitions={transitions}|labels={len(entries)}")
print("END")
