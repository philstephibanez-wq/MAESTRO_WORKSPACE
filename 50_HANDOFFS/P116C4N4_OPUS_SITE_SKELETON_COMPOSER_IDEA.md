# P116C4N4 OPUS Site Skeleton Composer Idea

Decision to preserve:
- Composer can be used by users to create a new OPUS site.
- Target command model is composer create-project.
- Future package candidate is logandplay/opus-site-skeleton.
- OPUS core remains logandplay/opus.
- Optional packages are installed with composer require.

Target architecture:
- logandplay/opus is the shared framework core.
- logandplay/opus-site-skeleton creates a clean user site.
- logandplay/opus-8.1.0-lysenko-reference-book remains an optional package.

Future site skeleton should contain:
- composer.json
- application
- config
- public
- resources
- var

Permanent constraint:
- Client installation remains Composer-managed and multiplatform.
- No xcopy, rmdir, mklink, cmd or PowerShell as client install mechanism.
- Any generation logic must be portable PHP invoked by Composer.
