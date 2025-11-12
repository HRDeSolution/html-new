<?php
/**
 * Legacy site SSO token generator matching html-solution behaviour.
 */
include $_SERVER['DOCUMENT_ROOT'] . "/include/include_function.php";
include $_SERVER['DOCUMENT_ROOT'] . "/include/sso_config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/include/sso_jwt_generator.php";

if (empty($_SESSION['LoginMemberID']) && empty($_SESSION['LoginAdminID'])) {
    echo json_encode([
        'success' => false,
        'error'   => 'Not logged in',
    ]);
    exit;
}

$result = SSOJWTGenerator::generateToken($connect, $_SESSION, $DB_Enc_Key);

if ($result['success']) {
    echo json_encode([
        'success'    => true,
        'token'      => $result['token'],
        'payload'    => $result['payload'],
        'expires_at' => date('Y-m-d H:i:s', $result['payload']['exp']),
    ]);
} else {
    echo json_encode([
        'success' => false,
        'error'   => $result['error'],
    ]);
}

