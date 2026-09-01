#!/usr/bin/env python3
from __future__ import annotations

import json
import re
import subprocess
import sys
from pathlib import Path

ROOT = Path(sys.argv[1] if len(sys.argv) > 1 else r"H:\OPUS").resolve()
OPUS = ROOT / "Opus"
FRONT = ROOT / "sites" / "owasys-front"
BACK = ROOT / "sites" / "owasys-back"

findings: list[tuple[str, str, str, str]] = []


def add(severity: str, code: str, path: Path | str, detail: str) -> None:
    p = Path(path) if not isinstance(path, Path) else path
    try:
        shown = p.resolve().relative_to(ROOT).as_posix()
    except Exception:
        shown = str(path).replace("\\", "/")
    findings.append((severity, code, shown, detail.replace("\n", " ")))


def run(*args: str) -> subprocess.CompletedProcess[str]:
    return subprocess.run(args, cwd=ROOT, text=True, capture_output=True, check=False)


def text(path: Path) -> str:
    return path.read_text(encoding="utf-8", errors="replace")


def data(path: Path):
    try:
        return json.loads(text(path))
    except Exception as exc:
        add("BLOCKER", "JSON_INVALID", path, str(exc))
        return None


# Gate 0: exact local baseline.
head = run("git", "rev-parse", "HEAD").stdout.strip()
status = run("git", "status", "--short").stdout.strip()
if not head:
    add("BLOCKER", "GIT_HEAD_UNAVAILABLE", ROOT, "git rev-parse HEAD failed")
if status:
    add("BLOCKER", "WORKTREE_DIRTY", ROOT, "audit requires a clean OPUS worktree")

# Gate 1: PHP syntax and legacy PHP syntax.
php_files = [
    p for base in (OPUS, ROOT / "sites", ROOT / "packages", ROOT / "tools")
    if base.exists()
    for p in base.rglob("*.php")
    if "vendor" not in p.parts
]
php_ok = run("php", "-v").returncode == 0
if not php_ok:
    add("BLOCKER", "PHP_UNAVAILABLE", ROOT, "php executable unavailable")
else:
    for p in php_files:
        result = run("php", "-l", str(p))
        if result.returncode != 0:
            add("BLOCKER", "PHP_SYNTAX_INVALID", p, (result.stdout + result.stderr).strip())
        s = text(p).lstrip()
        if s.startswith("<?") and not s.startswith("<?php") and not s.startswith("<?="):
            add("ERROR", "PHP_SHORT_OPEN_TAG", p, "legacy short open tag")

# Gate 2: OPUS concrete class / homonymous interface contract.
base_interfaces = {
    "OpusFrameworkComponentInterface",
    "OpusExceptionAwareInterface",
    "OpusProfilerAwareInterface",
    "OpusSelfDocumentingInterface",
}
class_re = re.compile(r"(?m)^\s*(?:final\s+)?(?:readonly\s+)?class\s+([A-Za-z_][A-Za-z0-9_]*)[^\{]*(?:implements\s+([^\{]+))?\{")
abstract_re = re.compile(r"(?m)^\s*abstract\s+class\s+")
framework_classes = 0
for p in OPUS.rglob("*.php") if OPUS.exists() else []:
    s = text(p)
    if abstract_re.search(s):
        continue
    for m in class_re.finditer(s):
        framework_classes += 1
        cls = m.group(1)
        expected = cls + "Interface"
        header = m.group(0)
        if re.search(r"\b" + re.escape(expected) + r"\b", header) is None:
            add("ERROR", "FRAMEWORK_HOMONYMOUS_INTERFACE_NOT_IMPLEMENTED", p, f"{cls} must implement {expected}")
            continue
        candidates = list(p.parent.glob(expected + ".php")) or list(OPUS.rglob(expected + ".php"))
        if len(candidates) != 1:
            add("ERROR", "FRAMEWORK_HOMONYMOUS_INTERFACE_FILE_INVALID", p, f"expected one {expected}.php, found {len(candidates)}")
            continue
        iface = text(candidates[0])
        missing = sorted(x for x in base_interfaces if x not in iface)
        if missing:
            add("ERROR", "FRAMEWORK_BASE_INTERFACES_MISSING", candidates[0], "missing: " + ", ".join(missing))

# Gate 3: repository / split deployment hygiene.
for forbidden in (ROOT / "sites" / "shared", ROOT / "sites" / "owasys-old"):
    if forbidden.exists():
        add("BLOCKER", "FORBIDDEN_SITE_PRESENT", forbidden, "forbidden OWASYS site")
for p in BACK.rglob("*") if BACK.exists() else []:
    if not p.is_file():
        continue
    if p.name.lower() in {"package.json", "package-lock.json", "yarn.lock", "pnpm-lock.yaml", "bun.lock", "bun.lockb"} or p.suffix.lower() in {".js", ".mjs", ".cjs", ".ts", ".tsx", ".jsx"}:
        add("BLOCKER", "OWASYS_BACK_JS_FORBIDDEN", p, "backend must remain PHP-only")
for p in FRONT.rglob("*.php") if FRONT.exists() else []:
    if "cli" in {x.lower() for x in p.parts}:
        continue
    s = text(p)
    if re.search(r"(?m)(^|[;{}]\s*)echo\b", s):
        add("ERROR", "OWASYS_FRONT_ECHO_FORBIDDEN", p, "HTTP UI must render through SCORE")
for ext in ("*.html", "*.htm", "*.phtml", "*.twig"):
    for p in FRONT.rglob(ext) if FRONT.exists() else []:
        add("ERROR", "OWASYS_FRONT_NON_SCORE_TEMPLATE", p, "frontend templates must use SCORE")

# Gate 4: site contracts.
def audit_site(site: Path, kind: str) -> dict:
    cfg_path = site / "config" / "site.json"
    cfg = data(cfg_path)
    if not isinstance(cfg, dict):
        return {}
    if cfg.get("kind") != kind:
        add("BLOCKER", "SITE_KIND_INVALID", cfg_path, f"expected {kind}")
    if cfg.get("dispatch_model") != "fsm-module-first":
        add("BLOCKER", "SITE_DISPATCH_INVALID", cfg_path, "dispatch_model must be fsm-module-first")
    runtime = cfg.get("runtime") if isinstance(cfg.get("runtime"), dict) else {}
    if runtime.get("architecture") != "singleton":
        add("BLOCKER", "SITE_SINGLETON_MISSING", cfg_path, "runtime.architecture must be singleton")
    acl_path = site / "config" / "acl.json"
    acl = data(acl_path)
    if not isinstance(acl, dict) or acl.get("default") != "deny":
        add("BLOCKER", "ACL_DENY_BY_DEFAULT_MISSING", acl_path, "ACL must declare default=deny")
    sso_path = site / "config" / "sso.json"
    if not sso_path.is_file():
        add("BLOCKER", "SSO_CONFIG_MISSING", sso_path, "SSO/Auth proxy config required")
    else:
        data(sso_path)
    return cfg

front_cfg = audit_site(FRONT, "frontend")
back_cfg = audit_site(BACK, "backend")

# Gate 5: strict NO-FALLBACK policy — configuration and runtime API.
if front_cfg:
    i18n = front_cfg.get("i18n") if isinstance(front_cfg.get("i18n"), dict) else {}
    forbidden_i18n_keys = {
        "fallback_locale",
        "regional_overlay_policy",
        "bare_language_policy",
        "language_defaults",
        "catalog_base_locales",
        "catalog_base_locales_visible",
    }
    for key in sorted(forbidden_i18n_keys & set(i18n)):
        add("BLOCKER", "I18N_FALLBACK_POLICY_FORBIDDEN", FRONT / "config" / "site.json", f"forbidden policy key: {key}")

locale_php = FRONT / "application" / "default" / "services" / "LocaleRegistry.php"
if locale_php.is_file():
    s = text(locale_php)
    for token in ("languageDefaults", "language_defaults", "$this->languageDefaults"):
        if token in s:
            add("BLOCKER", "I18N_LANGUAGE_SUBSTITUTION_API_FORBIDDEN", locale_php, f"forbidden locale substitution token: {token}")
            break

locale_core = OPUS / "I18n" / "Locale.php"
if locale_core.is_file():
    s = text(locale_core)
    for token in ("fallbackChain", "function parent"):
        if token in s:
            add("ERROR", "I18N_FALLBACK_API_REMAINS", locale_core, f"fallback-capable API remains: {token}")

catalog_loader = OPUS / "I18n" / "CatalogLoader.php"
if catalog_loader.is_file() and "fallbackChain" in text(catalog_loader):
    add("BLOCKER", "I18N_CATALOG_FALLBACK_LOOP_FORBIDDEN", catalog_loader, "catalog loading must target exact locale only")

# Gate 6: exact regional catalogs: file exists, no inheritance, exact messages.
locales = [x for x in front_cfg.get("locales", []) if isinstance(x, str)] if front_cfg else []
local_dir = FRONT / "application" / "default" / "local"
regional_catalogs: dict[str, dict] = {}
all_message_keys: set[str] = set()
for p in local_dir.glob("*.json") if local_dir.exists() else []:
    cat = data(p)
    if isinstance(cat, dict) and isinstance(cat.get("messages"), dict):
        all_message_keys.update(str(k) for k in cat["messages"])
        if p.stem in locales:
            regional_catalogs[p.stem] = cat
for locale in locales:
    p = local_dir / f"{locale}.json"
    cat = regional_catalogs.get(locale)
    if cat is None:
        add("BLOCKER", "I18N_EXACT_CATALOG_MISSING", p, locale)
        continue
    if "inherits" in cat:
        add("BLOCKER", "I18N_CATALOG_INHERITANCE_FORBIDDEN", p, f"inherits={cat.get('inherits')}")
    if cat.get("locale") != locale:
        add("ERROR", "I18N_CATALOG_LOCALE_MISMATCH", p, f"declared={cat.get('locale')!r}")
    messages = cat.get("messages") if isinstance(cat.get("messages"), dict) else {}
    missing = sorted(all_message_keys - set(str(k) for k in messages))
    if missing:
        preview = ", ".join(missing[:8])
        suffix = "" if len(missing) <= 8 else f" ... (+{len(missing)-8})"
        add("BLOCKER", "I18N_EXACT_MESSAGES_INCOMPLETE", p, f"missing {len(missing)} known UI keys: {preview}{suffix}")

# Gate 7: localized routes must be exact regional entries, never base-language inheritance.
routes_path = FRONT / "config" / "routes.localized.json"
routes = data(routes_path)
if isinstance(routes, dict):
    if "inherit" in str(routes.get("regional_policy", "")).lower():
        add("BLOCKER", "ROUTE_REGIONAL_FALLBACK_FORBIDDEN", routes_path, f"regional_policy={routes.get('regional_policy')}")
    route_map = routes.get("routes") if isinstance(routes.get("routes"), dict) else {}
    for route_id, spec in route_map.items():
        paths = spec.get("paths") if isinstance(spec, dict) and isinstance(spec.get("paths"), dict) else {}
        missing = [loc for loc in locales if loc not in paths]
        if missing:
            add("BLOCKER", "ROUTE_EXACT_LOCALES_INCOMPLETE", routes_path, f"{route_id}: missing {len(missing)}/{len(locales)} regional paths")

# Gate 8: EFSM ownership invariant for Application.
context_registry = FRONT / "application" / "default" / "services" / "ContextEfsmRegistry.php"
if context_registry.is_file():
    s = text(context_registry)
    host_block = re.search(r"HOST_EFSMS\s*=\s*\[(.*?)\];", s, re.S)
    if host_block and re.search(r"['\"]application['\"]", host_block.group(1)):
        add("BLOCKER", "EFSM_APPLICATION_HOST_FORBIDDEN", context_registry, "Application must belong to selected application, never OWASYS host")
    if "if ($module === 'application')" not in s or "return 'navigation';" not in s:
        add("BLOCKER", "EFSM_APPLICATION_OWNERSHIP_MAPPING_MISSING", context_registry, "Application must resolve to selected application's navigation EFSM")

# Gate 9: all JSON validity.
for p in ROOT.rglob("*.json"):
    if any(part in {".git", "vendor", "node_modules"} for part in p.parts):
        continue
    data(p)

# Output.
order = {"BLOCKER": 0, "ERROR": 1, "WARN": 2, "INFO": 3}
findings.sort(key=lambda x: (order.get(x[0], 9), x[1], x[2], x[3]))
counts = {k: 0 for k in order}
for sev, *_ in findings:
    counts[sev] = counts.get(sev, 0) + 1

print("OPUS_OWASYS_COMPLIANCE_AUDIT_V2")
print("HEAD=" + head)
print("WORKTREE=" + ("DIRTY" if status else "CLEAN"))
print("PHP_FILES=" + str(len(php_files)))
print("FRAMEWORK_CONCRETE_CLASSES=" + str(framework_classes))
print("SELECTABLE_LOCALES=" + str(len(locales)))
for sev in ("BLOCKER", "ERROR", "WARN", "INFO"):
    print(f"{sev}={counts.get(sev, 0)}")
print("FINDINGS_BEGIN")
for sev, code, path, detail in findings:
    print(f"{sev}|{code}|{path}|{detail}")
print("FINDINGS_END")

sys.exit(2 if counts.get("BLOCKER", 0) else (1 if counts.get("ERROR", 0) else 0))
