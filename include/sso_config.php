<?php
/**
 * SSO Configuration
 * SECURITY: Store sensitive values in environment variables in production
 *
 * Mirrors html-solution configuration so the legacy PHP site issues the same JWT.
 */

// ============================================
// ENVIRONMENT DETECTION
// ============================================
if (isset($_SERVER['HTTP_HOST'])) {
    $currentHost = $_SERVER['HTTP_HOST'];
    if (strpos($currentHost, 'staging.hrdeedu.co.kr') !== false) {
        $SSO_ENVIRONMENT = 'staging';
    } elseif (strpos($currentHost, 'localhost') !== false || strpos($currentHost, '127.0.0.1') !== false) {
        $SSO_ENVIRONMENT = 'dev';
    } else {
        $SSO_ENVIRONMENT = 'production';
    }
} else {
    $SSO_ENVIRONMENT = getenv('SSO_ENV') ?: 'production';
}

// ============================================
// JWT CONFIGURATION
// ============================================
$SSO_JWT_SECRET = getenv('JWT_SECRET_KEY') ?: '2d99971c43e590501f81c5760eacc4cc351e590072791006a9ee3dbc064c62cf8949f2a9978f5605d1f3136f94b90356065b509a7d478e6b554a119671cfce4a';

if (isset($_SERVER['HTTP_HOST'])) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $SSO_JWT_ISSUER = $protocol . $_SERVER['HTTP_HOST'];
} else {
    $SSO_JWT_ISSUER = 'https://www.hrdeedu.co.kr';
}

$MY_DOMAIN = getenv('MY_DOMAIN') ?: 'https://live.hrdeedu.co.kr';

if (strpos($MY_DOMAIN, 'http://') === 0 || strpos($MY_DOMAIN, 'https://') === 0) {
    $SSO_JWT_AUDIENCE = $MY_DOMAIN;
} else {
    $audienceProtocol = ($SSO_ENVIRONMENT === 'production') ? 'https://' : 'http://';
    $SSO_JWT_AUDIENCE = $audienceProtocol . $MY_DOMAIN;
}

// ============================================
// REACT APP URLs (Redirect Target)
// ============================================
$SSO_REACT_APP_URL = $SSO_JWT_AUDIENCE;

// ============================================
// SECURITY SETTINGS
// ============================================
$myDomainHost = parse_url($MY_DOMAIN, PHP_URL_HOST) ?: $MY_DOMAIN;
$SSO_ALLOWED_DOMAINS = [
    'localhost:3000',
    'staging.hrdeedu.co.kr',
    'app.hrdeedu.co.kr',
    'ai.hrdeedu.co.kr',
    'live.hrdeedu.co.kr',
    'www.hrdeedu.co.kr',
    'hrdeedu.co.kr',
    $myDomainHost,
];

$SSO_DEBUG_MODE = ($SSO_ENVIRONMENT !== 'production' && getenv('SSO_DEBUG') === 'true');

// ============================================
// GRAPHQL MUTATION NAME / EXPECTED FIELDS
// ============================================
$SSO_MUTATION_NAME = 'ssoLogin';
$SSO_EXPECTED_FIELDS = [
    'user_id',
    'name',
    'email',
    'member_type',
    'platform',
    'iss',
    'aud',
    'iat',
    'exp',
];

// ============================================
// TRANSPORT SECURITY
// ============================================
$SSO_REQUIRE_HTTPS = ($SSO_ENVIRONMENT === 'production');
$SSO_SAMESITE_COOKIE = 'Lax';

// ============================================
// LOGGING
// ============================================
$SSO_ENABLE_LOGGING = true;
$SSO_LOG_TABLE = 'SSOLoginLog';

if ($SSO_REQUIRE_HTTPS && empty($_SERVER['HTTPS']) && !in_array($SSO_ENVIRONMENT, ['dev', 'staging'], true)) {
    die('SSO Error: HTTPS required in production environment');
}

if (empty($SSO_JWT_SECRET)) {
    die('SSO Error: JWT_SECRET_KEY not configured');
}

/**
 * Validate redirect URL is in allowed domains
 */
function sso_validate_redirect_url($url)
{
    global $SSO_ALLOWED_DOMAINS;

    $parsed = parse_url($url);
    if (!$parsed || !isset($parsed['host'])) {
        return false;
    }

    $host = $parsed['host'];
    if (isset($parsed['port'])) {
        $host .= ':' . $parsed['port'];
    }

    return in_array($host, $SSO_ALLOWED_DOMAINS, true);
}

/**
 * Log SSO event
 */
function sso_log_event($connect, $userID, $userType, $ip, $status, $error = null)
{
    global $SSO_ENABLE_LOGGING, $SSO_LOG_TABLE;

    if (!$SSO_ENABLE_LOGGING) {
        return;
    }

    $userID = mysqli_real_escape_string($connect, $userID);
    $userType = mysqli_real_escape_string($connect, $userType);
    $ip = mysqli_real_escape_string($connect, $ip);
    $status = mysqli_real_escape_string($connect, $status);
    $error = $error ? mysqli_real_escape_string($connect, $error) : null;

    $sql = "INSERT INTO {$SSO_LOG_TABLE} (UserID, UserType, IP, Status, ErrorMessage, LoginDate)
            VALUES ('{$userID}', '{$userType}', '{$ip}', '{$status}', " . ($error ? "'{$error}'" : 'NULL') . ", NOW())";

    @mysqli_query($connect, $sql);
}

if ($SSO_DEBUG_MODE) {
    error_log("SSO Config Loaded:");
    error_log("  Environment: {$SSO_ENVIRONMENT}");
    error_log("  React App URL: {$SSO_REACT_APP_URL}");
    error_log("  Audience: {$SSO_JWT_AUDIENCE}");
    error_log("  Debug Mode: " . ($SSO_DEBUG_MODE ? 'ON' : 'OFF'));
}

