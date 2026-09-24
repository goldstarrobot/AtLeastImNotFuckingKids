# At Least I'm Not Fucking Kids

A participatory satire site by Shane Lessa about the low bar of moral self-justification. Visitors submit a confession, then cycle through contributions paired with the same refrain: “...but at least I'm not fucking kids.”

Originally built in 2025 with PHP, vanilla JavaScript, HTML, and CSS. No framework, database, or build step. Includes links to the project's merchandise and social accounts.

Project URL: https://atleastimnotfuckingkids.com/

## Run locally

Install PHP 8.1 or newer, open a terminal in this directory, and run:

```sh
php -S localhost:8000 -t public
```

Open http://localhost:8000. The initial empty state is intentional. Accepted submissions are stored in `data/sins.txt`, which is created on the first successful submission and excluded from Git. Confessions become visible to other visitors after a page load.

## Structure

- `public/`: website, submission endpoint, favicons, and merchandise images.
- `src/`: shared validation, storage paths, session setup, and keyword screening.
- `data/`: local submissions. The PHP process needs write permission here.
- `tests/`: validation checks and HTTP smoke test instructions.

## Hosting

Use a PHP-capable web server with its document root set to **`public/`**. Keep `src/` and `data/` outside the document root. Do not upload the whole repository into a publicly served folder. For shared hosting, place the contents of `public/` in the public directory and keep `src/` and `data/` beside that directory; the PHP entry points expect them one level above.

Serve production traffic over HTTPS, disable PHP error display, and configure server request-size and traffic limits. The PHP development server is for local use only. This application needs PHP execution; a static host cannot run its submission endpoint.

The repository contains no production submissions. To migrate an existing installation, back up the old `sins.txt`, review its contents, and place it at `data/sins.txt` with appropriate permissions.

## Analytics and external resources

Google Analytics is disabled by default. To enable it, supply `GA_MEASUREMENT_ID` through the server environment. A `.env` file is not automatically loaded. Local shell example:

```sh
GA_MEASUREMENT_ID=G-YOURID php -S localhost:8000 -t public
```

Google Fonts and Font Awesome load from external services. Merchandise and social links retain the original project destinations.

## Moderation and limitations

The endpoint validates input type, UTF-8, length (11–150 Unicode code points), and punctuation; strips HTML; and applies basic keyword screening. The input and keyword list now use the same normalization. Submissions require a session CSRF token and have a 60-second per-session cooldown. Failed writes return an error instead of claiming success.

This is a small participatory experiment, not a production moderation platform. Screening can miss harmful content or reject innocent text. Accepted submissions appear immediately; there is no review queue or admin UI. Review stored submissions manually and add stronger moderation before opening a heavily trafficked instance. The session cooldown can be bypassed by starting another session and is not a robust spam defense. Flat-file storage and sending all submissions to the page are intended for small collections.

The keyword list includes offensive terms solely to screen submissions.

## Missing original asset

The supplied archive did not include `doomer-wojak.png`. Its image is shown only when that file exists in `public/`; otherwise the layout omits it. No replacement artwork was invented.

## Checks

```sh
php tests/validation.php
```

Optional frontend checks (Node.js 18+): `node tests/frontend.cjs`.

See `tests/README.md` for endpoint smoke checks. GitHub Actions also runs PHP syntax checks and the validation tests.

## Rights

No open-source license has been selected. Publication does not grant a reuse license. Included artwork and third-party assets may carry separate rights.
