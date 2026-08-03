# OPUS P117W R45B1 — Profile conformance gate

Date: 2026-08-03
Status: owner delivery
Base OPUS: `07756d41d171fec1758722874adaa889a931026e`

## Purpose

R45B1 is the first atomic gate of the profile-aware scaffold. It prevents OPUS
from writing or validating a generated `backend` that still contains a SCORE
surface, JavaScript/TypeScript, JavaScript package metadata, presentation
templates/layouts or a forbidden `shared` layer.

It also corrects the generated backend capability declaration to
`presentation=false`.

## Behaviour

- the plan is inspected before `ScaffoldWriter::writePlan()`;
- a non-conforming backend fails without creating its target directory;
- `opus:validate-site` applies the same profile rules to an existing site;
- any application path segment named `shared` is forbidden;
- frontend and fullstack generation are not reclassified by this gate.

R45B1 deliberately does not invent a local backend runtime. R45B2 must generate
the generic REST runtime and client/server correlation manifest before backend
and fullstack can be declared complete. R45B3 then supplies the frontend REST
client contract and profile validators.

## Delivery

```text
ZIP     : opus_p117w_r45b1_profile_conformance_gate.zip
SHA-256 : 38fb6a3832e14bfea4ecc3bb10f3b1450ef20833698805386c29d3f4fe30ba5d
FILES   : 2
BASE    : 07756d41d171fec1758722874adaa889a931026e
```

Files:

- `Opus/Console/Service/SiteCommandService.php`
- `Opus/Scaffold/SiteScaffoldPlan.php`

NO FALSE PROFILE CLAIM.  
NO SHARED.  
NO FALLBACK SILENCIEUX.
