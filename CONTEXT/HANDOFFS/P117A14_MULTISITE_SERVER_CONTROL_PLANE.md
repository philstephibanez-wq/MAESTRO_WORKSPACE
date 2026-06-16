# P117A14B MULTISITE SERVER CONTROL PLANE KERNEL FIX

## Status

Implemented as the next read-only OPUS control-plane foundation after the PHP devserver dashboard. P117A14B fixes the kernel import/route injection by replacing the bootstrap NativeHttpKernel with the explicit server-overview-aware version.

## Goal

Transform the native OPUS dashboard direction from a single runtime page into a server-level supervision surface for a multi-site OPUS server.

## Contract

- OPUS contains only runtime/configuration code for this step.
- No P117 handoff or patch documentation is stored in OPUS.
- Handoff and continuation notes are stored in MAESTRO_WORKSPACE only.
- The new server overview is read-only.
- The server overview is admin-only.
- Denied public callers receive only the neutral blocked response.
- Detailed denial reasons remain internal/admin-only.

## OPUS runtime paths added or modified

- config/opus_server_sites.php
- framework/Opus/Runtime/NativeHttpKernel.php
- framework/Opus/Runtime/NativeServerOverviewDashboardSmoke.php
- framework/Opus/Server/ServerSiteDefinition.php
- framework/Opus/Server/ServerSiteRegistry.php
- framework/Opus/Server/ServerOverviewSnapshot.php
- framework/Opus/Server/ServerSiteSupervisor.php
- framework/Opus/Admin/AdminServerOverviewAccessDecision.php
- framework/Opus/Admin/AdminServerOverviewAccessControlPlane.php
- framework/Opus/Admin/AdminServerOverviewDashboardRoute.php
- framework/Opus/Admin/AdminServerOverviewDashboardResponseRenderer.php

## New route

/admin/server-overview

This route displays the OPUS Server Control Plane with every declared site from config/opus_server_sites.php.

## Local validation

Run:

```cmd
cd /d H:\OPUS
php -r "$boot=require 'index.php'; $r=\Opus\Runtime\NativeServerOverviewDashboardSmoke::run(); foreach (['ok','gate','registry_count','allowed_status','allowed_content_type','has_server_overview','has_sites_region','has_logandplay_site','has_demo_site','has_maestro_site','denied_status','denied_is_public_response'] as $k) { echo $k.'='.(is_bool($r[$k]) ? ($r[$k] ? 'true' : 'false') : $r[$k]).PHP_EOL; } echo 'denied_public_body='.str_replace(chr(10), ' | ', $r['denied_public_body']).PHP_EOL;"
```

Expected gate:

P117A14_MULTISITE_SERVER_CONTROL_PLANE_SMOKE

## Browser validation through PHP devserver

```cmd
cd /d H:\OPUS
php -S 127.0.0.1:8765 index.php
```

Open:

http://127.0.0.1:8765/admin/server-overview

## Next step

P117A15 should wire the same route through Apache/UwAmp vhost once P117A13 local vhost is clean and verified.

P117A16 then adds real authentication / API SSO and replaces the current loopback-local preview identity.

P117A17 then tightens FSM + ACL gates at server and site level.