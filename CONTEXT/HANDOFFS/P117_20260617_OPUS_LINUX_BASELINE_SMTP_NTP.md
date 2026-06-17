# P117 — OPUS Linux baseline, SMTP local, NTP, Apache preprod

Date: 2026-06-17

## Purpose

This handoff records the new OPUS delivery rule: OPUS is developed through the source repository, then delivered cleanly to the Linux preproduction server. No product code is patched directly on Linux.

## Rule confirmed by user

```text
Development source : OPUS local/GitHub workflow as before
Source of truth    : philstephibanez-wq/OPUS
Linux server       : clean delivery/preprod target
Direct Linux edits : allowed only for server config, Apache, DNS/hosts, runtime permissions, services, certificates later
Forbidden on Linux : manual edits to framework/, public/, index.php, packages/, sites/ or versioned config outside git pull
```

## Linux server baseline

```text
Server IP      : 192.168.1.135
Hostname       : logandplay
OS             : Ubuntu 26.04 LTS
Kernel         : Linux 7.0.0-22-generic
PHP CLI        : 8.5.4
Apache         : 2.4.66 active
Git            : 2.53.0
Composer       : absent, not blocking current OPUS runtime
OPUS path      : /srv/opus/OPUS
DocumentRoot   : /srv/opus/OPUS/public
Runtime cache  : /srv/opus/OPUS/var/cache
Runtime logs   : /srv/opus/OPUS/var/logs
```

## OPUS Linux validation

Validated:

```text
P117L1 Linux preflight          OK
P117L2 OPUS Linux install       OK
P117L3 Apache public/ vhost     OK
P117L3 dashboard via SSH tunnel OK
```

Apache vhost:

```text
/etc/apache2/sites-available/opus-preprod.conf
ServerName   opus.logandplay.local
DocumentRoot /srv/opus/OPUS/public
```

Runtime permissions fixed for Apache:

```text
cd /srv/opus/OPUS
sudo chown -R steph:www-data var/cache var/logs
sudo find var/cache var/logs -type d -exec chmod 2775 {} \;
sudo find var/cache var/logs -type f -exec chmod 664 {} \;
```

Admin access rule for current preprod:

```text
Direct LAN browser access is intentionally denied by OPUS admin gate.
Admin dashboard is viewed through SSH tunnel only until proper Auth/SSO/FSM/ACL is implemented.
```

Tunnel command from Windows:

```text
ssh -L 8780:127.0.0.1:80 steph@192.168.1.135
```

Temporary Windows hosts entry while tunnel is open:

```text
127.0.0.1 opus.logandplay.local
```

URL:

```text
http://opus.logandplay.local:8780/admin/server-overview
```

## Postfix local SMTP baseline

Validated:

```text
P117M1_LOCAL_SMTP_POSTFIX_OK
Postfix active
Queue empty
SMTP listens only on 127.0.0.1:25 and ::1:25
Local delivery to /var/mail/steph OK
Open relay LAN/Internet impossible at this stage
```

Postfix key config:

```text
inet_interfaces = loopback-only
mydestination = localhost, localhost.localdomain, logandplay, logandplay.local
myhostname = mail.logandplay.local
mynetworks = 127.0.0.0/8 [::1]/128
mynetworks_style = host
myorigin = logandplay.local
smtpd_relay_restrictions = permit_mynetworks, reject_unauth_destination
```

Important: no public SMTP yet; no LAN port 25, no 587, no DKIM/SPF/DMARC until public mail policy is explicit.

## NTP baseline

Validated:

```text
P117N1_NTP_CHRONY_CLIENT_OK
Chrony active
System clock synchronized: yes
Leap status: Normal
No visible UDP :123 LAN/public exposure in inspection
```

## OPUS GitHub updates after Linux baseline

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

## Required Linux delivery after P117L4A

Run on Linux, not by manual editing:

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

The dashboard currently reports `SERVER_DEGRADED` on Linux because the multi-site registry still contains Windows paths for public/demo/maestro sites:

```text
H:\UwAmp\www\LogAndPlay.org
H:\UwAmp\www\LogAndPlay.org\demo
H:\UwAmp\www\LogAndPlay.org\maestro
```

This is not an Apache failure. It is the next planned OPUS task.

## Next steps

```text
1. Pull P117L4A on Linux and validate dashboard no longer displays literal "\n".
2. P117L4B_LINUX_MULTISITE_REGISTRY_OVERLAY: add a clean Linux registry overlay without breaking Windows dev.
3. P117L5_AUTH_SSO_FSM_ACL_GATE: replace loopback admin bypass with real authentication/authorization.
4. Later: OPUS mail engine using local Postfix localhost:25.
```
