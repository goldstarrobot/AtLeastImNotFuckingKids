<?php
require __DIR__ . '/../src/bootstrap.php';
header('Content-Type: text/plain; charset=utf-8');

function respond(int $status, string $message): void
{
    http_response_code($status);
    echo $message;
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Allow: POST');
    respond(405, 'method_not_allowed');
}
startSession();
$token = $_POST['csrf'] ?? null;
if (!is_string($token) || !hash_equals($_SESSION['csrf'], $token)) {
    respond(403, 'invalid_token');
}
$input = $_POST['sin'] ?? null;
// Bound work before normalization. UTF-8 can use up to four bytes per character.
if (!is_string($input) || strlen($input) > 600) {
    respond(400, 'invalid_or_banned');
}
$safe = cleanConfession($input);
if ($safe === null) {
    respond(400, 'invalid_or_banned');
}
if (isset($_SESSION['last_submission']) && time() - $_SESSION['last_submission'] < 60) {
    header('Retry-After: 60');
    respond(429, 'please_wait');
}
$entry = $safe . "\n";
$written = @file_put_contents(confessionsPath(), $entry, FILE_APPEND | LOCK_EX);
if ($written !== strlen($entry)) {
    error_log('Could not save confession. Check data directory permissions.');
    respond(500, 'storage_error');
}
$_SESSION['last_submission'] = time();
respond(200, 'ok');
