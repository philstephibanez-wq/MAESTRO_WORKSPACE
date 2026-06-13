# P112Q3E4C PATCH

## Modified

- `tools/smoke/p112q3e4_refbook_http_metadata_smoke.php`

## Reason

The unit and strict HTTP RefBook checks validate the canonical P112Q3E4 metadata. The smoke still expected the intermediate P112Q3E4A marker, causing a false delivery failure.
