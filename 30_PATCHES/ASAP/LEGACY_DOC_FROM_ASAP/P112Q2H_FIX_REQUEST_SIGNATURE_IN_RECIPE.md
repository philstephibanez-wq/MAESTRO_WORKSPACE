# P112Q2H Fix — Request Signature In Recipe

## Cause

The P112Q2H recipe called `ASAP\Http\Request` with reversed arguments.

The `Request` constructor contract is:

```php
new Request(string $path, string $method = 'GET')
```

The recipe used:

```php
new Request('GET', '/demo/page')
```

## Fix

The recipe now uses:

```php
new Request('/demo/page', 'GET')
```

## Contract

This fix does not change the Database provider foundation itself.

It resumes the partially applied P112Q2H state, reruns the full recipe chain, and commits the already applied framework/database files.
