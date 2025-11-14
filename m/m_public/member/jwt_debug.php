<?php
include $_SERVER['DOCUMENT_ROOT'] . "/m_include/include_function.php";
include $HomeDirectory . "/include/sso_config.php";
include $HomeDirectory . "/include/sso_jwt_generator.php";

header('Content-Type: text/html; charset=utf-8');

$sessionState = [
    'LoginMemberID' => $_SESSION['LoginMemberID'] ?? null,
    'LoginAdminID'  => $_SESSION['LoginAdminID'] ?? null,
];

$result = [
    'stage'   => 'init',
    'success' => false,
    'message' => '',
    'error'   => null,
];

try {
    if (empty($sessionState['LoginMemberID']) && empty($sessionState['LoginAdminID'])) {
        throw new RuntimeException('세션에 로그인 정보가 없습니다.');
    }

    $result['stage'] = 'generateToken';
    $tokenResult     = SSOJWTGenerator::generateToken($connect, $_SESSION, $DB_Enc_Key);

    if (!$tokenResult['success']) {
        throw new RuntimeException('JWT 생성 실패: ' . $tokenResult['error']);
    }

    $result['stage']   = 'setCookie';
    $cookieSuccessful  = SSOJWTGenerator::setJWTCookie($connect, $_SESSION, $DB_Enc_Key);
    $result['success'] = $cookieSuccessful;
    $result['message'] = $cookieSuccessful ? 'JWT 쿠키 설정 성공' : 'JWT 생성 성공, 쿠키 설정 실패';
    $result['token']   = $tokenResult['token'];
} catch (Throwable $e) {
    $result['success'] = false;
    $result['error']   = $e->getMessage();
    error_log('[jwt_debug] ' . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>JWT Debug</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        pre { background: #f5f5f5; padding: 15px; border-radius: 8px; }
    </style>
</head>
<body>
    <h1>모바일 JWT 디버그</h1>
    <p>세션 상태:</p>
    <pre><?=htmlspecialchars(print_r($sessionState, true), ENT_QUOTES, 'UTF-8');?></pre>

    <p>결과:</p>
    <pre><?=htmlspecialchars(print_r($result, true), ENT_QUOTES, 'UTF-8');?></pre>

    <p>브라우저 쿠키:</p>
    <pre><?=htmlspecialchars(print_r($_COOKIE, true), ENT_QUOTES, 'UTF-8');?></pre>
</body>
</html>

