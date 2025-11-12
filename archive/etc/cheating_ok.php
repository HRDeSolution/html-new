<?
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의
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

// 필수값 검증
if (
    empty($report_name) ||
    empty($report_reply) ||
    empty($report_phone) ||
    empty($report_email) ||
    empty($report_title) ||
    empty($report_content)
) {
    echo "<script>alert('필수 입력 항목이 누락되었습니다.'); history.back();</script>";
    exit;
}

$Name     = Replace_Check_XSS2($report_name);
$Category = Replace_Check_XSS2($report_reply);
$Mobile   = Replace_Check_XSS2($report_phone);
$Email    = Replace_Check_XSS2($report_email);
$Title    = Replace_Check_XSS2($report_title);
$Contents = Replace_Check_XSS2($report_content);


$Mobile_enc = "HEX(AES_ENCRYPT('$Mobile','$DB_Enc_Key'))";
$Email_enc = "HEX(AES_ENCRYPT('$Email','$DB_Enc_Key'))";

$sql = "INSERT INTO Cheating(Name, Category, Mobile, Email, Title, Contents, RegDate, Del, Status)
	    VALUES('$Name', '$Category', $Mobile_enc, $Email_enc, '$Title', '$Contents', NOW(), 'N', 'A')";

$Row = mysqli_query($connect, $sql);

if($Row) {
?>
<script type="text/javascript">
	alert("제출되었습니다.");
	top.location.reload();
</script>
<?
}else{
?>
<script type="text/javascript">
	alert("등록중 문제가 발생했습니다.\n\n잠시후에 다시 시도하세요.");
</script>
<?}?>
</body>
</html>
<?mysqli_close($connect);?>