# P117A13 â€” OPUS UwAmp Apache public front controller handoff

## Validated previous point

P117A12 validated the native OPUS admin dashboard through the PHP development server:

```text
php -S 127.0.0.1:8765 index.php
http://127.0.0.1:8765/admin/blocked-states
```

The user confirmed the visual result was good enough to move to UwAmp.

## Current gate

P117A13 adds the Apache/UwAmp public-front-controller contract:

```text
UwAmp / Apache
â†’ opus.localhost
â†’ H:\OPUS\public only
â†’ public/index.php
â†’ sovereign OPUS root index.php
â†’ NativeHttpKernel / dashboard route
```

## Security constraint

This gate does not implement authentication, ACL, FSM or SSO.

It only prevents the critical Apache mistake: exposing the OPUS repository root.

The next gate is P117A14:

```text
Authentication
â†’ SSO token/session intake
â†’ FSM central state gate
â†’ ACL authorization gate
â†’ neutral public denial
â†’ admin-only internal diagnostics
```

## Public denial rule

A non-admin, suspicious, invalid or blocked public response must remain neutral:

```text
Site temporairement bloquÃ©.
Contactez le support.
```

Detailed causes must be visible only to admins through internal logs/dashboard.

## Files introduced in OPUS

```text
public/index.php
public/.htaccess
framework/Opus/Runtime/UwAmpPublicFrontControllerSmoke.php
```

## Manual local operation still required

Apache/UwAmp configuration is local machine state and is not committed into OPUS.

The vhost snippet is documented in:

```text
H:\OPUS\DOC\P117A13_UWAMP_APACHE_PUBLIC_FRONT_CONTROLLER.md
```