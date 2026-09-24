# Manual HTTP checks

Start `php -S localhost:8000 -t public` from the project root, then check:

1. With no `data/sins.txt`, the page says there are no confessions and has no JavaScript exception.
2. Submit “I ate the last slice”. The page acknowledges it, reloads, and displays it with the refrain. Confirm one line was saved in `data/sins.txt`.
3. Submit another valid confession immediately. Expect HTTP 429 and the wait message.
4. `curl -i http://localhost:8000/submit_sin.php` returns 405 with `Allow: POST`.
5. `curl -i -d 'sin=I ate the last slice' http://localhost:8000/submit_sin.php` returns 403 because there is no CSRF token.
6. From browser developer tools, replay a valid request with `sin` replaced by an array, invalid UTF-8, or more than 150 characters; expect 400 and no new stored line.
7. Make `data/` unwritable for the server process and, after the cooldown, submit valid text. Expect 500, not success. Restore permissions afterward.
8. Request `/data/sins.txt` and `/src/bootstrap.php`; neither must expose files when `public/` is the document root.
9. Confirm the merchandise image and favicons load and the absent Wojak image makes no broken request.

Use a disposable checkout for these checks. Do not commit generated submissions.
