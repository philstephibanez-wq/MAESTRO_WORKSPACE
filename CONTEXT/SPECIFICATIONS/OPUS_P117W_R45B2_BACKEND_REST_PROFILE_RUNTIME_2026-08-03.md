# OPUS P117W R45B2 — Backend REST profile runtime

Date: 2026-08-03
Status: owner delivery
Base OPUS: `4a4193094f1ea33270909008a0a1a0c8eac61c3e`

## Purpose

R45B2 makes the OWASYS `backend` profile generate a real autonomous OPUS
backend instead of the common SCORE scaffold rejected by R45B1. The generated
backend is PHP-only and exposes the generic secured REST-to-Composer boundary.

R45B1 is acquired in OPUS commit `c585ceb`; the subsequent `cleanup` commit
removes only the generated witness site and is not a product correction.

## Generated backend contract

- autonomous Singleton composition root;
- homonymous application and controller interfaces extending the four OPUS markers;
- FSM module-first dispatch;
- deny-by-default ACL and SSO configuration;
- environment-HMAC REST authentication;
- allow-listed Composer operation catalog;
- Logger and Profiler storage owned by the generated backend;
- I18n catalogs for EU languages plus Ukrainian;
- no SCORE, template, layout, JavaScript, TypeScript, Node metadata or `shared`.

The initial REST resource is the application's validation resource. Business
resources remain explicit later additions; R45B2 does not invent application
business semantics.

## Fullstack boundary

A fullstack scaffold receives
`config/fullstack.correlation.json`, contract
`OPUS_FULLSTACK_REST_CORRELATION_V1`, recording the mandatory
front → REST → back → Composer → back → REST → front flow and its trace/request
headers. This is a correlation contract, not a replacement for the R45B3
frontend REST client.

## Validation

`opus:validate-site` now validates backend REST configuration, controller and
Profiler directories and no longer requires SCORE template/view files on
backend routes. The R45B1 forbidden-artifact gate remains active.

## Delivery

```text
ZIP     : opus_p117w_r45b2_backend_rest_profile_runtime.zip
SHA-256 : 39bf3866f4a1c02f5b0a2bbb826223117a7bd8a5dbaf5b4accf5ca5fcf2c489f
FILES   : 2
BASE    : 4a4193094f1ea33270909008a0a1a0c8eac61c3e
```

Files:

- `Opus/Console/Service/SiteCommandService.php`
- `Opus/Scaffold/SiteScaffoldPlan.php`

NO LOCAL WITNESS FIX.  
NO SHARED.  
NO JAVASCRIPT BACKEND.  
NO FALLBACK SILENCIEUX.
