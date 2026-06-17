# P117 — OPUS Linux DNS LAN, security baseline, ClamAV, AWFFull, UFW

Date: 2026-06-17

## Purpose

This handoff records the OPUS Linux preproduction state after LAN DNS, Apache LAN aliases, targeted antivirus, private web statistics and UFW firewall validation.

It complements the earlier baseline handoff:

```text
CONTEXT/HANDOFFS/P117_20260617_OPUS_LINUX_BASELINE_SMTP_NTP.md
```

## Operational rule: command location must be explicit

The session exposed a recurring operator risk: Linux commands and Linux command outputs were accidentally pasted into Windows PowerShell, and vice versa.

Going forward, every operational command block must be labeled clearly:

```text
[PC WINDOWS - DEV]
[PC WINDOWS - PowerShell Administrateur]
[PC WINDOWS - NAVIGATEUR]
[SERVEUR LINUX - PRÉPROD]
```

Do not mix expected output with commands in the same command block.

## Current Linux server identity

```text
Hostname            : logandplay
LAN interface       : eno1
LAN IP              : 192.168.1.135/24
Windows operator PC : 192.168.1.176
Tailscale IP        : 100.83.101.117
OPUS root           : /srv/opus/OPUS
Apache DocumentRoot : /srv/opus/OPUS/public
```

The server IP is still provided through DHCP on `eno1`. It must be reserved on the Freebox side to keep `192.168.1.135` stable.

Do not modify Linux network interfaces from Webmin while operating remotely unless a rollback path is ready.

## Validated LAN DNS

Milestone:

```text
P117DNS1_LOCAL_LAN_DNS_OK
```

DNS service:

```text
Service : dnsmasq
Config  : /etc/dnsmasq.d/opus-lan.conf
Listen  : 127.0.0.1:53 and 192.168.1.135:53
```

Local DNS names:

```text
opus.lan.logandplay.org      -> 192.168.1.135
admin.lan.logandplay.org     -> 192.168.1.135
mail.lan.logandplay.org      -> 192.168.1.135
logandplay.lan.logandplay.org -> 192.168.1.135
```

Windows DNS was configured to use `192.168.1.135` and validated from `192.168.1.176`:

```text
Resolve-DnsName opus.lan.logandplay.org  -> 192.168.1.135
Test-NetConnection opus.lan.logandplay.org -Port 80 -> True
```

## Apache LAN alias validation

Milestone:

```text
P117_APACHE_LAN_HOST_OK
```

Apache vhost:

```text
/etc/apache2/sites-available/opus-preprod.conf
ServerName   opus.logandplay.local
ServerAlias  opus.lan.logandplay.org admin.lan.logandplay.org mail.lan.logandplay.org
DocumentRoot /srv/opus/OPUS/public
```

Server-side validation:

```text
curl -i -H "Host: opus.lan.logandplay.org" http://127.0.0.1/admin/server-overview
HTTP/1.1 200 OK
```

Windows LAN browser currently reaches the server but OPUS admin returns the expected temporary gate page:

```text
http://opus.lan.logandplay.org/admin/server-overview
-> 503 Site temporairement bloqué
```

This is an OPUS application gate, not DNS or Apache failure. Direct LAN admin remains intentionally denied until P117AUTH1.

## OPUS dashboard state

The dashboard renders correctly without visible literal `\n` escapes after P117L4A.

Remaining issue:

```text
SERVER_DEGRADED
```

Confirmed cause: the multi-site registry still contains Windows development paths for public/demo/maestro sites, for example:

```text
H:\UwAmp\www/LogAndPlay.org
H:\UwAmp\www/LogAndPlay.org/demo
H:\UwAmp\www/LogAndPlay.org/maestro
```

This is not a Linux installation failure. Next OPUS task:

```text
P117L4B_LINUX_MULTISITE_REGISTRY_OVERLAY
```

## ClamAV targeted antivirus baseline

Milestones:

```text
P117SEC3_CLAMAV_TARGETED_OK
P117SEC3_TIMER_OK
```

Installed and validated:

```text
clamav          : 1.4.4
clamav-daemon   : active
freshclam       : active
signatures      : up to date at validation time
EICAR test      : Eicar-Signature FOUND
```

Security storage:

```text
/srv/opus/security/clamav/logs
/srv/opus/security/clamav/quarantine
owner : root:root
mode  : 750 directories, 640 logs
```

Manual scan validation:

```text
Scan targets       : /srv/opus/OPUS /tmp
Scanned directories: 257
Scanned files      : 367
Infected files     : 0
Log example        : /srv/opus/security/clamav/logs/opus_scan_20260617_100636.log
```

Timer:

```text
Service : /etc/systemd/system/opus-clamav-targeted-scan.service
Timer   : /etc/systemd/system/opus-clamav-targeted-scan.timer
Script  : /usr/local/sbin/opus-clamav-targeted-scan.sh
Schedule: daily around 03:30 with RandomizedDelaySec=15m
State   : active (waiting), enabled
```

No automatic deletion is configured. Any detection must be reviewed manually before action.

## Webalizer replacement: AWFFull private stats

Webalizer status:

```text
apt-cache policy webalizer -> package not found
universe enabled
available alternatives included awstats and awffull
```

Decision for this server baseline:

```text
Webalizer abandoned cleanly for Ubuntu 26.04 repository state.
AWFFull selected as Webalizer-like Apache log analyzer.
```

Milestones:

```text
P117SEC4_AWFFULL_PRIVATE_STATS_MANUAL_OK
P117SEC4_AWFFULL_PRIVATE_STATS_TIMER_OK
```

Installed:

```text
awffull 3.10.2
```

The generic AWFFull timer created by the package was disabled. OPUS uses a private dedicated report instead.

Private report:

```text
Source log : /srv/opus/OPUS/var/logs/apache_opus_access.log
Output     : /srv/opus/security/awffull/opus
Index      : /srv/opus/security/awffull/opus/index.html
Monthly    : /srv/opus/security/awffull/opus/usage_202606.html
Title      : OPUS Preprod Web Statistics opus.lan.logandplay.org
Owner/mode : root:root, 750 directories, 640 files
```

Timer:

```text
Service : /etc/systemd/system/opus-awffull-private-stats.service
Timer   : /etc/systemd/system/opus-awffull-private-stats.timer
Script  : /usr/local/sbin/opus-awffull-private-stats.sh
Schedule: daily around 04:10 with RandomizedDelaySec=15m
State   : active (waiting), enabled
```

The AWFFull report is not exposed through Apache. Future access must go through the protected OPUS admin surface.

## UFW firewall baseline

Milestone:

```text
P117SEC1_UFW_FIREWALL_OK
```

UFW was enabled with rollback safety, then rollback was cancelled after successful Windows tests.

Default policy:

```text
incoming : deny
outgoing : allow
routed   : disabled
logging  : low
```

Allowed rules:

```text
lo all
LAN eno1 192.168.1.0/24 -> tcp/22    SSH
LAN eno1 192.168.1.0/24 -> tcp/10000 Webmin
LAN eno1 192.168.1.0/24 -> tcp/80    Apache OPUS
LAN eno1 192.168.1.0/24 -> tcp/53    DNS TCP
LAN eno1 192.168.1.0/24 -> udp/53    DNS UDP
Tailscale tailscale0 -> tcp/22        SSH
Tailscale tailscale0 -> tcp/10000     Webmin
Tailscale tailscale0 -> tcp/80        Apache OPUS
UDP 41641 -> Tailscale WireGuard
```

Windows validation after UFW activation:

```text
Resolve-DnsName opus.lan.logandplay.org      -> 192.168.1.135
Test-NetConnection opus.lan.logandplay.org 80 -> True
Test-NetConnection 192.168.1.135 10000       -> True
Test-NetConnection 192.168.1.135 22          -> True
```

Effect:

```text
Apache, SSH, Webmin and DNS remain reachable from LAN.
Incoming AnyDesk/RustDesk, CUPS, MariaDB, Postfix and random ports are filtered unless explicitly allowed later.
```

Do not open AnyDesk/RustDesk through UFW unless explicitly requested. Prefer LAN/Tailscale restricted access if needed.

## System health

Milestone:

```text
P117_SYSTEMD_HEALTH_OK
```

Validated:

```text
systemctl --failed -> 0 loaded units listed
opus-clamav-targeted-scan.timer  -> active/waiting/enabled
opus-awffull-private-stats.timer -> active/waiting/enabled
```

Non-blocking warnings observed:

```text
AnyDesk unit references /var/run PIDFile; systemd maps it to /run.
ClamAV generated socket references /var/run/clamav; systemd maps it to /run/clamav.
xfs_scrub CPUAccounting option ignored by new systemd.
```

These are not OPUS blockers.

## SMTP and NTP baseline carried forward

Already validated in the previous handoff:

```text
P117M1_LOCAL_SMTP_POSTFIX_OK
P117N1_NTP_CHRONY_CLIENT_OK
```

Postfix remains local-only:

```text
127.0.0.1:25 and ::1:25 only
no LAN/public SMTP exposure
```

Chrony remains active and synchronized.

## Cloudflare target still planned

Cloudflare remains the intended public-access architecture:

```text
P117CF1_CLOUDFLARE_TUNNEL
-> outbound tunnel from Linux, no Freebox port opening by default

P117CF2_CLOUDFLARE_ACCESS
-> SSO/policy before public admin exposure
```

Exact Cloudflare installation commands must be checked against official current Cloudflare documentation before execution.

## Next safe steps

Recommended order:

```text
1. P117SEC2_FAIL2BAN
   -> protect SSH, Webmin and Apache logs
   -> ignore LAN operator IP 192.168.1.176 and Tailscale admin path

2. P117L4B_LINUX_MULTISITE_REGISTRY_OVERLAY
   -> replace Linux registry view paths without breaking Windows dev registry
   -> expected result: SERVER_READY instead of SERVER_DEGRADED

3. P117AUTH1_ADMIN_GATE_CLOUDFLARE_READY
   -> no LAN admin bypass by IP alone
   -> accept explicit admin identity now and Cloudflare Access identity later

4. P117CF1 / P117CF2
   -> Cloudflare Tunnel then Cloudflare Access
```

## Fresh chat starter

On reprend depuis MAESTRO_WORKSPACE. OPUS Linux preprod is installed at `/srv/opus/OPUS`; LAN DNS via dnsmasq is validated; Windows resolves `opus.lan.logandplay.org` to `192.168.1.135`; Apache vhost aliases for LAN are active; UFW is active and validated; ClamAV targeted scans and AWFFull private stats are installed as systemd timers; Postfix remains local-only; Chrony is synchronized; systemd has zero failed units. OPUS admin still returns 503 from direct LAN browser until auth/ACL is implemented. Dashboard still shows `SERVER_DEGRADED` only because the registry contains Windows `H:\UwAmp` paths. Next safe step: Fail2ban, then P117L4B registry overlay, then admin auth gate and Cloudflare Tunnel/Access.
