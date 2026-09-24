# Repository preparation

- Preserved the original concept, copy, styling, product images, and external links.
- Removed the duplicate archived page and placeholder export.
- Split the public web root from PHP helpers and local submissions.
- Corrected endpoint, favicon, manifest, and merchandise image paths.
- Made the missing Wojak image optional.
- Added a working empty state and accessible form labels/status.
- Disabled the original analytics property by default; added environment configuration.
- Added server-side input type, UTF-8, length, and control-character checks.
- Standardized keyword and input normalization and removed obsolete transformed examples and some overly broad fragments. Keyword screening remains imperfect.
- Added session CSRF protection, a basic session cooldown, locked append writes, and error responses on failed writes.
- Added setup documentation, ignored runtime data, and automated checks.

## Verification in the preparation environment

Passed frontend JavaScript syntax and behavior checks for the empty state, generation, text-only rendering, submission payload, success, and cooldown errors. Local asset references and manifest icons were checked.

PHP was unavailable and could not be installed in the environment. PHP syntax, backend validation, and real HTTP behavior have not been executed here. The included GitHub Actions workflow runs PHP syntax and validation checks once uploaded; manual HTTP checks are documented in tests/README.md. No live deployment was performed.
