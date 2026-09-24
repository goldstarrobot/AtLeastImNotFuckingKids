<?php
require_once __DIR__ . '/moderation.php';

function startSession(): void
{
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    ]);
    session_start();
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    header('Cache-Control: no-store');
    header('X-Content-Type-Options: nosniff');
}

function confessionsPath(): string
{
    return __DIR__ . '/../data/sins.txt';
}

function loadConfessions(): array
{
    $path = confessionsPath();
    if (!is_file($path)) {
        return [];
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return $lines === false ? [] : array_values($lines);
}

function cleanConfession(string $text): ?string
{
    if (!preg_match('//u', $text)) {
        return null;
    }
    $text = trim(preg_replace('/\s+/u', ' ', strip_tags($text)));
    $text = preg_replace('/\.\s*$/u', '', $text);
    $length = preg_match_all('/./us', $text);
    if ($length < 11 || $length > 150 || substr_count($text, '.') > 1
        || preg_match('/[\x00-\x1F\x7F]/', $text) || isBanned($text)) {
        return null;
    }
    return $text;
}
