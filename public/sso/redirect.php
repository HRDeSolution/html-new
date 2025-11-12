<?php
/**
 * SSO Redirect Endpoint
 * Generates JWT token and redirects authenticated users to React/NestJS app (live.hrdeedu.co.kr).
 */
include $_SERVER['DOCUMENT_ROOT'] . "/include/include_function.php";
include $_SERVER['DOCUMENT_ROOT'] . "/include/sso_config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/include/sso_jwt_generator.php";

function sso_error($message, $statusCode = 400, $redirect = null)
{
    http_response_code($statusCode);
    ?>
    <!DOCTYPE html>
    <html>
    <head><title>SSO Error</title></head>
    <body>
        <script type="text/javascript">
            alert("<?= addslashes($message) ?>");
            <?php if ($redirect): ?>
            location.href = "<?= addslashes($redirect) ?>";
            <?php else: ?>
            history.back();
            <?php endif; ?>
        </script>
    </body>
    </html>
    <?php
    exit;
}

if ($SSO_REQUIRE_HTTPS && (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off')) {
    sso_error("SSO requires HTTPS connection", 403);
}

if (empty($_SESSION['LoginMemberID']) && empty($_SESSION['LoginAdminID'])) {
    global $UserIP;
    sso_log_event($connect, 'anonymous', 'unknown', $UserIP, 'FAILED', 'Not logged in');
    sso_error("로그인 후 이용 가능합니다.\n\nPlease login first to access the application.", 401, "/public/member/login.html");
}

$userID = !empty($_SESSION['LoginMemberID']) ? $_SESSION['LoginMemberID'] : $_SESSION['LoginAdminID'];
$userType = !empty($_SESSION['LoginMemberID']) ? 'Member' : 'Admin';

try {
    $result = SSOJWTGenerator::generateToken($connect, $_SESSION, $DB_Enc_Key);

    if (!$result['success']) {
        sso_log_event($connect, $userID, $userType, $UserIP, 'FAILED', $result['error']);
        sso_error("SSO 토큰 생성에 실패했습니다.\n\n오류: " . htmlspecialchars($result['error']), 500);
    }

    $token = $result['token'];
} catch (Exception $e) {
    sso_log_event($connect, $userID, $userType, $UserIP, 'FAILED', $e->getMessage());
    sso_error("시스템 오류가 발생했습니다. 잠시 후 다시 시도해주세요.", 500);
}

$redirectURL = $SSO_REACT_APP_URL . "?token=" . urlencode($token);

if (!sso_validate_redirect_url($redirectURL)) {
    sso_log_event($connect, $userID, $userType, $UserIP, 'FAILED', 'Invalid redirect URL');
    sso_error("잘못된 리다이렉트 URL입니다.", 403);
}

sso_log_event($connect, $userID, $userType, $UserIP, 'SUCCESS', null);

if ($SSO_DEBUG_MODE && isset($_GET['debug'])) {
    ?>
    <!DOCTYPE html>
    <html lang="ko">
    <head>
        <meta charset="UTF-8">
        <title>SSO Debug Information</title>
        <style>
            body { font-family: monospace; padding: 20px; background: #f5f5f5; }
            .container { background: white; padding: 20px; border-radius: 8px; max-width: 1200px; margin: 0 auto; }
            h2 { color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; }
            .info { background: #e3f2fd; padding: 15px; margin: 10px 0; border-left: 4px solid #2196F3; }
            textarea { width: 100%; min-height: 100px; font-family: monospace; font-size: 12px; }
            pre { background: #2d2d2d; color: #f8f8f2; padding: 15px; border-radius: 4px; overflow-x: auto; }
            .warning { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 10px 0; }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>🔍 SSO Debug Information</h2>
            <div class="warning">
                <strong>⚠️ WARNING:</strong> This debug mode is only available in dev/staging environments.
            </div>
            <div class="info">
                <strong>User ID:</strong> <?= htmlspecialchars($userID) ?><br>
                <strong>User Type:</strong> <?= htmlspecialchars($userType) ?><br>
                <strong>Environment:</strong> <?= htmlspecialchars($SSO_ENVIRONMENT) ?><br>
                <strong>React App URL:</strong> <?= htmlspecialchars($SSO_REACT_APP_URL) ?>
            </div>
            <h3>JWT Token:</h3>
            <textarea readonly><?= htmlspecialchars($token) ?></textarea>
            <h3>Decoded Payload:</h3>
            <pre><?= json_encode($result['payload'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?></pre>
            <h3>Redirect URL:</h3>
            <textarea readonly><?= htmlspecialchars($redirectURL) ?></textarea>
            <p><a href="<?= htmlspecialchars($redirectURL) ?>" style="display:inline-block; padding:10px 20px; background:#4CAF50; color:white; text-decoration:none; border-radius:4px; margin-top:10px;">Continue to React App</a></p>
        </div>
    </body>
    </html>
    <?php
    exit;
}

header("Location: " . $redirectURL, true, 302);
exit;

