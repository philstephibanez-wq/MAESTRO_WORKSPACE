# P112Q2J2 — ASAP Global Evolutive HTTP/Mail Life Recipe

## Contract

This step replaces the rejected minimal HTTP witness with an evolutive, anti-regression recipe layer.

It keeps the validated P112Q2J global suite and adds real life coverage:

- existing ASAP feature inventory through a manifest;
- HTTP dashboard visible in the browser;
- real local HTTP GET/POST requests;
- multi-role ACL checks;
- FR/EN/ES route checks;
- valid and invalid form submissions;
- sandbox mailbox / MailRobot send and receive validation;
- LSTSAR scheduling through HTTP, then background runner execution;
- reports and evidence paths under ignored `var/recipes/` runtime;
- no controller or HTTP route performs heavy LSTSAR work directly.

## Visible dashboard

The visible browser page is no longer a blank marker page. It is a robot dashboard showing:

- active run id;
- scenario checklist;
- actor / role matrix;
- HTTP transcript;
- mailbox evidence;
- LSTSAR evidence;
- report links / runtime evidence paths.

Required marker:

```text
ASAP_RECIPE_DASHBOARD_RICH_OK
```

## Required final markers

```text
ASAP_FEATURE_MANIFEST_OK
ASAP_ANTI_REGRESSION_MANIFEST_OK
ASAP_MAIL_OK
ASAP_HTTP_DASHBOARD_VISIBLE_OK
ASAP_HTTP_PUBLIC_ROUTES_OK
ASAP_HTTP_ACL_OK
ASAP_HTTP_FORM_OK
ASAP_MAIL_ROBOT_OK
ASAP_LIFE_HTTP_LSTSAR_OK
ASAP_LIFE_HTTP_MAIL_ROBOT_OK
ASAP_GLOBAL_RECIPE_OK
```

## Future rule

Any new ASAP feature must add or update:

1. documentation;
2. technical recipe;
3. life recipe when it touches user/runtime flow;
4. feature manifest entry;
5. global recipe markers.

Missing manifest coverage is a recipe failure, not a warning.
