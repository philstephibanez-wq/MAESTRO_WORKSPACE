# P112Q3E4A Changelog

- Added RefBook class metadata to `ASAP\Http\Response`.
- Added RefBook method metadata to `Response::__construct`, `Response::html`, `Response::json`, and `Response::send`.
- Updated the HTTP metadata contract test to expect the real live HTTP surface: 2 classes and 7 public methods.
- Updated the HTTP smoke test to verify the `Response` metadata marker.
