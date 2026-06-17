# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat. A new chat must be able to restart from this file without relying on hidden conversation memory.

## Current priority

P117 — OPUS Linux preproduction delivery is now active.

Immediate next work:

```text
1. P117L4A_RENDERER_NEWLINE_FIX — pull and validate on Linux.
2. P117L4B_LINUX_MULTISITE_REGISTRY_OVERLAY — remove Windows H:\UwAmp paths from Linux server view without breaking Windows dev.
3. P117L5_AUTH_SSO_FSM_ACL_GATE — replace temporary loopback admin access with real auth/ACL.
```

## Current source-of-truth rule

OPUS is developed through the normal repository workflow and delivered cleanly to Linux:

```text
Development source : OPUS local/GitHub workflow as before
Source of truth    : philstephibanez-wq/OPUS
Linux server       : delivery/preprod target
No direct Linux code edits to framework/, public/, index.php, packages/, sites/
Linux direct edits  : server config, Apache, DNS/hosts, runtime permissions, services, certificates later
```

## Linux server baseline

Validated server:

```text
Server IP      : 192.168.1.135
Hostname       : logandplay
OS             : Ubuntu 26.04 LTS
PHP CLI        : 8.5.4
Apache         : 2.4.66 active
Git            : 2.53.0
OPUS path      : /srv/opus/OPUS
DocumentRoot   : /srv/opus/OPUS/public
Runtime cache  : /srv/opus/OPUS/var/cache
Runtime logs   : /srv/opus/OPUS/var/logs
```

Validated milestones:

```text
P117L1 Linux preflight          OK
P117L2 OPUS Linux install       OK
P117L3 Apache public/ vhost     OK
P117L3 dashboard via SSH tunnel OK
P117M1 Local Postfix SMTP       OK
P117N1 Chrony NTP client        OK
```

## Apache / admin access

Apache vhost:

```text
/etc/apache2/sites-available/opus-preprod.conf
ServerName   opus.logandplay.local
DocumentRoot /srv/opus/OPUS/public
```

Admin access from Windows is currently through SSH tunnel only:

```text
ssh -L 8780:127.0.0.1:80 steph@192.168.1.135
```

Temporary Windows hosts entry while tunnel is used:

```text
127.0.0.1 opus.logandplay.local
```

URL:

```text
http://opus.logandplay.local:8780/admin/server-overview
```

Direct LAN browser access is intentionally denied by OPUS admin gate until Auth/SSO/FSM/ACL is implemented.

## Postfix local SMTP baseline

Validated:

```text
Postfix active
mailq empty
SMTP listens only on 127.0.0.1:25 and ::1:25
Local delivery to /var/mail/steph OK
Open relay LAN/Internet impossible at this stage
```

Key config:

```text
inet_interfaces = loopback-only
myhostname = mail.logandplay.local
myorigin = logandplay.local
mynetworks = 127.0.0.0/8 [::1]/128
smtpd_relay_restrictions = permit_mynetworks, reject_unauth_destination
```

No public SMTP policy yet: no LAN/public port 25, no 587, no DKIM/SPF/DMARC until explicit decision.

## NTP baseline

Validated:

```text
Chrony active
System clock synchronized: yes
Leap status: Normal
```

## OPUS GitHub updates pending Linux pull

P117L4A renderer newline fix has been written to OPUS GitHub:

```text
b9e4f92 P117L4A_RENDERER_NEWLINE_FIX
b52ee2a P117L4A_RENDERER_NEWLINE_SMOKE
```

Purpose:

```text
Fix literal "\n" text visible in OPUS Server Control Plane HTML.
Add smoke assertion rejecting literal backslash-n in rendered dashboard body.
```

Required Linux delivery command:

```text
cd /srv/opus/OPUS
git pull --ff-only
php -r '$boot=require "/srv/opus/OPUS/index.php"; $r=\Opus\Runtime\NativeServerOverviewDashboardSmoke::run(); foreach (["ok","gate","allowed_status","has_no_literal_newline_escape"] as $k) { echo $k."=".(is_bool($r[$k]) ? ($r[$k] ? "true" : "false") : $r[$k]).PHP_EOL; }'
sudo systemctl reload apache2
curl -i -H "Host: opus.logandplay.local" http://127.0.0.1/admin/server-overview
```

Expected:

```text
ok=true
gate=P117L4A_RENDERER_NEWLINE_FIX_SMOKE
allowed_status=200
has_no_literal_newline_escape=true
HTTP/1.1 200 OK
```

## Known remaining issue

The Linux dashboard still reports `SERVER_DEGRADED` because the registry includes Windows paths for public/demo/maestro sites:

```text
H:\UwAmp\www\LogAndPlay.org
H:\UwAmp\www\LogAndPlay.org\demo
H:\UwAmp\www\LogAndPlay.org\maestro
```

This is expected until P117L4B. It is not an Apache or Linux installation failure.

## Active repositories

| Repository | Role | Current state |
|---|---|---|
| MAESTRO_WORKSPACE | Contracts, decisions, handoffs | Updated for OPUS Linux baseline and P117L4A delivery |
| OPUS | Framework core | Linux preprod installed; P117L4A pushed; pull and validate on Linux next |
| OPUS_REF_BOOK | Transitional RefBook repository | UI remains paused until OPUS runtime/Linux delivery stabilizes |
| MAESTRO_V5 | REAPER/Lua music assistant | Active, not current priority |
| MO_KB_DAEMON | Music KB backend/workers | Active, not current priority |
| MO_KB_FRONT | KB front/backoffice | To align later |

## Detailed handoff

Read next if a fresh chat needs full detail:

```text
CONTEXT/HANDOFFS/P117_20260617_OPUS_LINUX_BASELINE_SMTP_NTP.md
```

## Fresh chat starter

On reprend depuis MAESTRO_WORKSPACE. Priorité : OPUS P117 Linux preprod. OPUS est installé sur Linux `/srv/opus/OPUS`, Apache pointe uniquement sur `public/`, l'admin fonctionne via tunnel SSH, Postfix local loopback-only et Chrony sont validés. P117L4A a été poussé sur OPUS GitHub pour corriger les `\n` visibles dans le dashboard ; prochaine action : `git pull --ff-only` sur Linux, smoke `NativeServerOverviewDashboardSmoke`, puis P117L4B registry overlay Linux pour supprimer les chemins `H:\UwAmp` du serveur.
