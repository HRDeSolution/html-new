<?php
// Support compatibility when composer vendor is only present in html-solution.
$autoloadCandidates = [
    __DIR__ . '/../vendor/autoload.php',
];

$autoloadLoaded = false;
foreach ($autoloadCandidates as $autoloadPath) {
    if (file_exists($autoloadPath)) {
        require_once $autoloadPath;
        $autoloadLoaded = true;
        break;
    }
}

if (!$autoloadLoaded) {
    throw new RuntimeException('Composer autoload file not found for JWT library.');
}

use Firebase\JWT\JWT;

/**
 * SSO JWT Token Generator
 * Generates JWT tokens identical to html-solution so the legacy site can SSO into live.hrdeedu.co.kr
 */
class SSOJWTGenerator
{
    private const JWT_ALGORITHM = 'HS256';
    private const TOKEN_EXPIRATION = 7 * 24 * 60 * 60;

    private static function getJWTSecret()
    {
        global $SSO_JWT_SECRET;

        return $SSO_JWT_SECRET;
    }

    /**
     * Generate JWT token for authenticated user
     *
     * @param mysqli $connect
     * @param array $sessionData
     * @param string $DB_Enc_Key
     * @return array
     */
    public static function generateToken($connect, $sessionData, $DB_Enc_Key)
    {
        try {
            if (empty($sessionData['LoginMemberID']) && empty($sessionData['LoginAdminID'])) {
                $errorMsg = 'JWT Generation Failed: User not logged in';
                self::logError($errorMsg, $sessionData);
                return [
                    'success' => false,
                    'token'   => null,
                    'error'   => 'User not logged in',
                ];
            }

            if (!empty($sessionData['LoginAdminID'])) {
                $userData = self::getAdminUserData($connect, $sessionData, $DB_Enc_Key);
                $userType = 'Admin';
            } else {
                $userData = self::getMemberUserData($connect, $sessionData, $DB_Enc_Key);
                $userType = 'Member';
            }

            if (!$userData['success']) {
                $errorMsg = 'JWT Generation Failed for ' . $userType . ': ' . $userData['error'];
                self::logError($errorMsg, $sessionData);
                return [
                    'success' => false,
                    'token'   => null,
                    'error'   => $userData['error'],
                ];
            }

            global $SSO_JWT_ISSUER, $SSO_JWT_AUDIENCE;

            $payload = [
                'user_id'     => $userData['user_id'],
                'name'        => $userData['name'],
                'email'       => $userData['email'],
                'member_type' => $userData['member_type'],
                'platform'    => 'php_website',
                'iss'         => $SSO_JWT_ISSUER,
                'aud'         => $SSO_JWT_AUDIENCE,
                'iat'         => time(),
                'exp'         => time() + self::TOKEN_EXPIRATION,
            ];

            $token = JWT::encode($payload, self::getJWTSecret(), self::JWT_ALGORITHM);

            self::logSuccess($userData['user_id'], $userType);

            return [
                'success' => true,
                'token'   => $token,
                'error'   => null,
                'payload' => $payload,
            ];
        } catch (Exception $e) {
            $errorMsg = 'Token generation exception: ' . $e->getMessage();
            self::logError($errorMsg, $sessionData);
            return [
                'success' => false,
                'token'   => null,
                'error'   => 'Token generation failed: ' . $e->getMessage(),
            ];
        }
    }

    private static function logError($errorMessage, $sessionData)
    {
        $logFile = $_SERVER['DOCUMENT_ROOT'] . '/logs/jwt_generation_errors.log';
        $logDir  = dirname($logFile);

        if (!file_exists($logDir)) {
            @mkdir($logDir, 0755, true);
        }

        $timestamp = date('Y-m-d H:i:s');
        $userID    = $sessionData['LoginMemberID'] ?? $sessionData['LoginAdminID'] ?? 'unknown';
        $ip        = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

        $logMessage = "[{$timestamp}] ERROR - User: {$userID}, IP: {$ip}, Error: {$errorMessage}\n";
        @file_put_contents($logFile, $logMessage, FILE_APPEND);
        error_log($logMessage);
    }

    private static function logSuccess($userID, $userType)
    {
        $logFile = $_SERVER['DOCUMENT_ROOT'] . '/logs/jwt_generation_success.log';
        $logDir  = dirname($logFile);

        if (!file_exists($logDir)) {
            @mkdir($logDir, 0755, true);
        }

        $timestamp = date('Y-m-d H:i:s');
        $ip        = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

        $logMessage = "[{$timestamp}] SUCCESS - User: {$userID}, Type: {$userType}, IP: {$ip}\n";
        @file_put_contents($logFile, $logMessage, FILE_APPEND);
    }

    private static function getCookieDomain()
    {
        if (!isset($_SERVER['HTTP_HOST'])) {
            return '';
        }

        $host = $_SERVER['HTTP_HOST'];

        // Strip port, if provided (e.g., example.com:8080)
        if (strpos($host, ':') !== false) {
            $host = explode(':', $host)[0];
        }

        // IP addresses and localhost should remain host-only
        if (filter_var($host, FILTER_VALIDATE_IP) || $host === 'localhost') {
            return '';
        }

        $parts = explode('.', $host);
        $count = count($parts);

        if ($count <= 1) {
            return '';
        }

        if ($count === 2) {
            return '.' . $host;
        }

        $twoLevelSuffixes = [
            'co.kr', 'or.kr', 'go.kr', 'ac.kr', 'ne.kr', 're.kr', 'pe.kr',
            'co.uk', 'org.uk', 'gov.uk', 'ac.uk', 'net.uk',
            'com.au', 'net.au', 'org.au',
            'com.br', 'net.br', 'org.br',
        ];

        $lastTwo = implode('.', array_slice($parts, -2));
        if (in_array($lastTwo, $twoLevelSuffixes, true) && $count >= 3) {
            return '.' . implode('.', array_slice($parts, -3));
        }

        return '.' . $lastTwo;
    }

    /**
     * Set JWT cookie on login
     */
    public static function setJWTCookie($connect, $sessionData, $DB_Enc_Key)
    {
        $jwtResult = self::generateToken($connect, $sessionData, $DB_Enc_Key);

        if ($jwtResult['success']) {
            $cookieExpiration = time() + self::TOKEN_EXPIRATION;
            $isSecure         = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
            $cookieDomain     = self::getCookieDomain();

            $cookieSet = setcookie(
                'jwt',
                $jwtResult['token'],
                [
                    'expires'  => $cookieExpiration,
                    'path'     => '/',
                    'domain'   => $cookieDomain,
                    'secure'   => $isSecure,
                    'httponly' => true,
                    'samesite' => 'Lax',
                ]
            );

            if ($cookieSet) {
                return true;
            }

            self::logError('Failed to set JWT cookie', $sessionData);
            return false;
        }

        self::logError('JWT generation failed: ' . $jwtResult['error'], $sessionData);
        return false;
    }

    /**
     * Clear JWT cookies on logout
     */
    public static function clearJWTCookie()
    {
        $secure       = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
        $cookieDomain = self::getCookieDomain();

        setcookie('jwt', '', [
            'expires'  => time() - 3600,
            'path'     => '/',
            'domain'   => $cookieDomain,
            'secure'   => $secure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        setcookie('sso_token', '', [
            'expires'  => time() - 3600,
            'path'     => '/',
            'domain'   => $cookieDomain,
            'secure'   => $secure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        setcookie('sso_token_accessible', '', [
            'expires'  => time() - 3600,
            'path'     => '/',
            'domain'   => $cookieDomain,
            'secure'   => $secure,
            'httponly' => false,
            'samesite' => 'Lax',
        ]);
    }

    private static function getMemberUserData($connect, $sessionData, $DB_Enc_Key)
    {
        $userID = mysqli_real_escape_string($connect, $sessionData['LoginMemberID']);

        $sql = "SELECT 
                    ID,
                    Name,
                    CAST(AES_DECRYPT(UNHEX(Email), '{$DB_Enc_Key}') AS CHAR) AS Email,
                    MemberType,
                    EduManager
                FROM Member
                WHERE ID='{$userID}' AND UseYN='Y'";

        $result = mysqli_query($connect, $sql);
        $row    = mysqli_fetch_array($result);

        if (!$row) {
            return [
                'success' => false,
                'error'   => 'User not found in database',
            ];
        }

        $member_type = 'M';
        if ($row['EduManager'] === 'Y') {
            $member_type = 'M';
        }

        return [
            'success'     => true,
            'user_id'     => $row['ID'],
            'name'        => $row['Name'],
            'email'       => $row['Email'] ?: 'no-email@hrde.com',
            'member_type' => $member_type,
        ];
    }

    private static function getAdminUserData($connect, $sessionData, $DB_Enc_Key)
    {
        $userID = mysqli_real_escape_string($connect, $sessionData['LoginAdminID']);

        $sql = "SELECT 
                    a.ID,
                    a.Name,
                    a.Email,
                    b.Dept
                FROM StaffInfo AS a
                LEFT OUTER JOIN DeptStructure AS b ON a.Dept_idx=b.idx
                WHERE a.ID='{$userID}' AND a.UseYN='Y' AND a.Del='N'";

        $result = mysqli_query($connect, $sql);
        $row    = mysqli_fetch_array($result);

        if (!$row) {
            return [
                'success' => false,
                'error'   => 'Admin user not found in database',
            ];
        }

        $member_type = 'M';
        if ($row['Dept'] === 'A') {
            $member_type = 'A';
        } elseif ($row['Dept'] === 'C') {
            $member_type = 'T';
        } elseif ($row['Dept'] === 'B') {
            $member_type = 'M';
        }

        return [
            'success'     => true,
            'user_id'     => $row['ID'],
            'name'        => $row['Name'],
            'email'       => $row['Email'] ?: 'admin@hrde.com',
            'member_type' => $member_type,
        ];
    }
}

