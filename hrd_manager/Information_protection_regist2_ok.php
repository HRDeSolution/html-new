<?php
include "../include/include_function.php";
include "./include/include_admin_check.php";

$TB       = Replace_Check($TB);
$url      = Replace_Check($url);
$Exp      = Replace_Check($Exp);
$send_url = Replace_Check($send_url);
$ID       = Replace_Check($ID);
$AdminID  = Replace_Check($AdminID);
$Gubun    = Replace_Check($Gubun);
$Content  = Replace_Check($Content);

$allowed_gubun = ['학습자 관리', '학습자 요청', '기타 상담'];
if (!in_array($Gubun, $allowed_gubun, true)) {
?>
<script type="text/javascript">
alert("구분 값이 올바르지 않습니다.");
top.DataResultClose2();
</script>
<?php
    exit;
}

$Content = trim($Content);

if ($Content === '') {
?>
<script type="text/javascript">
alert("사유를 입력하세요.");
top.DataResultClose2();
</script>
<?php
    exit;
}

if (!preg_match('/^[가-힣a-zA-Z0-9\s]+$/u', $Content)) {
?>
<script type="text/javascript">
alert("사유에는 한글, 영문, 숫자, 공백만 입력 가능합니다. (기호 금지)");
top.DataResultClose2();
</script>
<?php
    exit;
}

$Sql = "
  INSERT INTO InformationProtectionLog
    (TB, Field, ID, url, AdminID, Gubun, Content, RegDate)
  VALUES
    ('$TB', '$Exp', '$ID', '$url', '$AdminID', '$Gubun', '$Content', NOW())
";
$Row = mysqli_query($connect, $Sql);

if ($Row) {
?>
<script type="text/javascript">
//--
top.DataResultClose2();
top.location.href = "<?= $send_url ?>";
//--
</script>
<?php
} else {
?>
<script type="text/javascript">
//--
alert("개인정보 열람사유 등록중 오류 발생");
top.DataResultClose2();
//--
</script>
<?php
}

mysqli_close($connect);
?>
