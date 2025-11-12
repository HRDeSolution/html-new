<?
include "../m_include/include_function.php"; //DB연결 및 각종 함수 정의
include "../m_include/login_check.php"; //로그인 여부 체크
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="/include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/include/jquery-ui.js"></script>
<script type="text/javascript" src="/include/function.js"></script>
</head>
<body>
<?
$LectureCode = Replace_Check_XSS2($LectureCode); //과정코드
$StarPoint = Replace_Check_XSS2($StarPoint); //과정 평점
$Title = Replace_Check_XSS2($Title); //제목
$Contents = Replace_Check2($Contents); //내용


////필수 입력사항 체크
if(!$StarPoint || !$Title || !$Contents) {
?>
<script type="text/javascript">
	alert("입력하지 않은 정보가 존재합니다.");
</script>
<?
    exit;
}

$maxno = max_number("idx","Review");

$Sql = "INSERT INTO Review(idx, LectureCode, ID, StarPoint, Title, Contents, IP, RegDate, UseYN, Del)
        VALUES($maxno, '$LectureCode', '$LoginMemberID', '$StarPoint', '$Title', '$Contents', '$UserIP', NOW(), 'Y', 'N')";
$Row = mysqli_query($connect, $Sql);


if($Row) {
?>
<script type="text/javascript">
	alert("등록되었습니다.");
	location.href = "/m_public/mypage/lecture_status.html";
</script>
<?
}else{
?>
<script type="text/javascript">
	alert("등록중 문제가 발생했습니다.\n\n잠시후에 다시 시도하세요.");
</script>
<?
}
?>
</body>
</html>
<?mysqli_close($connect);?>