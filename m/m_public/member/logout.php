<?php
include $_SERVER['DOCUMENT_ROOT'] . "/m_include/include_function.php"; //DB연결 및 각종 함수 정의
include $_SERVER['DOCUMENT_ROOT'] . "/include/sso_config.php";
include $_SERVER['DOCUMENT_ROOT'] . "/include/sso_jwt_generator.php";

// Block logout on mobile if post-evaluation not completed and study time >= 15h
$LoginMemberID = isset($_SESSION['LoginMemberID']) ? $_SESSION['LoginMemberID'] : '';
if ($LoginMemberID) {
    $safeId = mysqli_real_escape_string($connect, $LoginMemberID);
    $sql = "SELECT AbilityYN, AbilityAfterYN FROM Member WHERE ID='{$safeId}' LIMIT 1";
    $res = mysqli_query($connect, $sql);
    $row = $res ? mysqli_fetch_assoc($res) : null;
    if ($row && $row['AbilityAfterYN'] !== 'Y') {
        $sqlTime = "SELECT COALESCE(SUM(StudyTime),0) AS TotalStudySeconds FROM Progress WHERE ID='{$safeId}'";
        $resTime = mysqli_query($connect, $sqlTime);
        $rowTime = $resTime ? mysqli_fetch_assoc($resTime) : null;
        $totalSeconds = $rowTime ? (int)$rowTime['TotalStudySeconds'] : 0;
        if ($totalSeconds >= 54000) {
            echo "<script>alert('사후역량진단을 실시해야합니다.');location.href='/m_archive/post/post_test01.html';</script>";
            exit;
        }
    }
}

unset($_SESSION["LoginMemberID"]);
unset($_SESSION["LoginName"]);
unset($_SESSION["LoginEduManager"]);
unset($_SESSION["LoginMemberType"]);
unset($_SESSION["LoginTestID"]);

unset($_SESSION["IsPlaying"]); // Brad (2021.11.27)

// Clear SSO cookie for mobile clients
SSOJWTGenerator::clearJWTCookie();

$url="/m_archive/main/main.html";

//Session_destroy();
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	location.href="<?=$url?>";
//-->
</SCRIPT>