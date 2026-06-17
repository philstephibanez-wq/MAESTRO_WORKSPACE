# CURRENT HANDOFF — MAESTRO WORKSPACE

## Purpose

Canonical resume card for a fresh chat. A new chat must be able to restart from this file without relying on hidden conversation memory.

## Current priority

P117 — OPUS Linux preproduction delivery and server hardening are active.

Immediate next work:

```text
1. P117SEC2_FAIL2BAN — protect SSH, Webmin and Apache without locking out LAN/Tailscale admin.
2. P117L4B_LINUX_MULTISITE_REGISTRY_OVERLAY — remove Windows H:\UwAmp paths from Linux server view without breaking Windows dev.
3. P117AUTH1_ADMIN_GATE_CLOUDFLARE_READY — replace temporary LAN/loopback admin handling with real auth/ACL ready for Cloudflare Access.
4. P117CF1 / P117CF2 — Cloudflare Tunnel, then Cloudflare Access; no Freebox port opening by default.
```

## Current source-of-truth rule

OPUS is developed through the normal repository workflow and delivered cleanly to Linux:

```text
Development source : OPUS local/GitHub workflow as before
Source of truth    : philstephibanez-wq/OPUS
Linux server       : delivery/preprod target
No direct Linux code edits to framework/, public/, index.php, packages/, sites/
Linux direct edits  : server config, Apache, DNS, runtime permissions, services, firewall, certificates later
```

Commands must always be labeled by environment:

```text
[PC WINDOWS - DEV]
[PC WINDOWS - PowerShell Administrateur]
[PC WINDOWS - NAVIGATEUR]
[SERVEUR LINUX - PRÉPROD]
```

## Linux server baseline

Validated server:

```text
Server IP      : 192.168.1.135
Windows PC     : 192.168.1.176
Tailscale IP   : 100.83.101.117
Interface LAN  : eno1
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
P117L1 Linux preflight                         OK
P117L2 OPUS Linux install                      OK
P117L3 Apache public/ vhost                    OK
P117L4A renderer newline fix runtime           OK
P117M1 Local Postfix SMTP                      OK
P117N1 Chrony NTP client                       OK
P117DNS1_LOCAL_LAN_DNS_OK                      OK
P117_APACHE_LAN_HOST_OK                        OK
P117SEC1_UFW_FIREWALL_OK                       OK
P117SEC3_CLAMAV_TARGETED_OK                    OK
P117SEC3_TIMER_OK                              OK
P117SEC4_AWFFULL_PRIVATE_STATS_MANUAL_OK       OK
P117SEC4_AWFFULL_PRIVATE_STATS_TIMER_OK        OK
P117_SYSTEMD_HEALTH_OK                         OK
```

## Apache / DNS / admin access

Apache vhost:

```text
/etc/apache2/sites-available/opus-preprod.conf
ServerName   opus.logandplay.local
ServerAlias  opus.lan.logandplay.org admin.lan.logandplay.org mail.lan.logandplay.org
DocumentRoot /srv/opus/OPUS/public
```

LAN DNS is now served by dnsmasq:

```text
/etc/dnsmasq.d/opus-lan.conf
opus.lan.logandplay.org       -> 192.168.1.135
admin.lan.logandplay.org      -> 192.168.1.135
mail.lan.logandplay.org       -> 192.168.1.135
logandplay.lan.logandplay.org -> 192.168.1.135
```

Windows DNS was configured to use `192.168.1.135` and validated:

```text
Resolve-DnsName opus.lan.logandplay.org -> 192.168.1.135
Test-NetConnection opus.lan.logandplay.org -Port 80 -> True
```

Direct LAN browser access reaches Apache but OPUS admin intentionally answers `503 Site temporairement bloqué` until auth/ACL is implemented. This is expected and is not DNS, Apache or UFW failure.

## UFW firewall baseline

UFW is active:

```text
incoming : deny
outgoing : allow
logging  : low
```

Allowed:

```text
LAN 192.168.1.0/24 -> SSH 22, Webmin 10000, Apache 80, DNS 53 TCP/UDP
Tailscale tailscale0 -> SSH 22, Webmin 10000, Apache 80
Tailscale UDP 41641 allowed
```

Validated from Windows `192.168.1.176`:

```text
Port 80    True
Port 10000 True
Port 22    True
```

AnyDesk/RustDesk incoming ports are not opened by UFW unless explicitly requested later.

## ClamAV baseline

Validated:

```text
clamav / clamav-daemon 1.4.4 active
freshclam active and signatures up to date at validation
EICAR detected
Scan /srv/opus/OPUS + /tmp -> Infected files: 0
```

Paths:

```text
/srv/opus/security/clamav/logs
/srv/opus/security/clamav/quarantine
/usr/local/sbin/opus-clamav-targeted-scan.sh
/etc/systemd/system/opus-clamav-targeted-scan.service
/etc/systemd/system/opus-clamav-targeted-scan.timer
```

Timer: daily around 03:30 with randomized delay. No automatic deletion is configured.

## AWFFull private stats baseline

Webalizer package is not available in current Ubuntu 26.04 repositories; AWFFull was installed instead.

Validated:

```text
awffull 3.10.2
Generic awffull.timer disabled
Private OPUS report generated
```

Paths:

```text
Source log : /srv/opus/OPUS/var/logs/apache_opus_access.log
Output     : /srv/opus/security/awffull/opus
Index      : /srv/opus/security/awffull/opus/index.html
Script     : /usr/local/sbin/opus-awffull-private-stats.sh
Service    : /etc/systemd/system/opus-awffull-private-stats.service
Timer      : /etc/systemd/system/opus-awffull-private-stats.timer
```

Timer: daily around 04:10 with randomized delay. Report is private and not exposed through Apache.

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

## OPUS GitHub updates already delivered

P117L4A renderer newline fix was written to OPUS GitHub:

```text
b9e4f92 P117L4A_RENDERER_NEWLINE_FIX
b52ee2a P117L4A_RENDERER_NEWLINE_SMOKE
```

Purpose:

```text
Fix literal "\n" text visible in OPUS Server Control Plane HTML.
Add smoke assertion rejecting literal backslash-n in rendered dashboard body.
```

The Linux dashboard now renders without visible literal `\n` escapes.

## Known remaining issue

The Linux dashboard still reports `SERVER_DEGRADED` because the registry includes Windows paths for public/demo/maestro sites:

```text
H:\UwAmp\www\LogAndPlay.org
H:\UwAmp\www\LogAndPlay.org\demo
H:\UwAmp\www\LogAndPlay.org\maestro
```

This is expected until P117L4B. It is not an Apache, DNS, firewall or Linux installation failure.

## Active repositories

| Repository | Role | Current state |
|---|---|---|
| MAESTRO_WORKSPACE | Contracts, decisions, handoffs | Updated for OPUS Linux DNS/security/UFW baseline |
| OPUS | Framework core | Linux preprod installed; P117L4A visible newline fix validated; next P117L4B registry overlay |
| OPUS_REF_BOOK | Transitional RefBook repository | UI remains paused until OPUS runtime/Linux delivery stabilizes |
| MAESTRO_V5 | REAPER/Lua music assistant | Active, not current priority |
| MO_KB_DAEMON | Music KB backend/workers | Active, not current priority |
| MO_KB_FRONT | KB front/backoffice | To align later |

## Detailed handoffs

Read next if a fresh chat needs full detail:

```text
CONTEXT/HANDOFFS/P117_20260617_OPUS_LINUX_BASELINE_SMTP_NTP.md
CONTEXT/HANDOFFS/P117_20260617_OPUS_LINUX_DNS_SECURITY_UFW.md
```

## Fresh chat starter

On reprend depuis MAESTRO_WORKSPACE. Priorité : OPUS P117 Linux preprod/security. OPUS est installé sur Linux `/srv/opus/OPUS`; LAN DNS dnsmasq est validé ; Windows résout `opus.lan.logandplay.org` vers `192.168.1.135`; Apache a les alias LAN ; UFW est actif et validé depuis Windows ; ClamAV scan ciblé et AWFFull stats privées sont planifiés par systemd timers ; Postfix reste local-only ; Chrony est synchronisé ; systemd n’a aucune unité en échec. L’admin OPUS direct LAN renvoie encore 503 par gate applicatif, attendu jusqu’à P117AUTH1. Le dashboard reste `SERVER_DEGRADED` uniquement à cause des chemins Windows `H:\UwAmp` dans le registry. Prochaine action sûre : P117SEC2_FAIL2BAN, puis P117L4B registry overlay, puis auth admin compatible Cloudflare Access.
