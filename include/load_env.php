<?php
/**
 * Simple .env File Loader
 * Mirrors the html-solution helper so legacy app can read MongoDB creds.
 */

function loadEnv($filePath = null) {
    if ($filePath === null) {
        $filePath = dirname(__DIR__) . '/.env';
    }

    if (!file_exists($filePath)) {
        return false;
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        $trimmed = trim($line);
        if ($trimmed === '' || strpos($trimmed, '#') === 0) {
            continue;
        }

        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");

            putenv("$key=$value");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }

    return true;
}

function env($key, $default = null) {
    if (isset($_ENV[$key])) {
        return $_ENV[$key];
    }

    $value = getenv($key);
    if ($value !== false) {
        return $value;
    }

    if (isset($_SERVER[$key])) {
        return $_SERVER[$key];
    }

    return $default;
}

loadEnv();

