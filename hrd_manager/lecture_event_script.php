<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);

$col = Replace_Check($col);
$sw = Replace_Check($sw);

$cmd = false;

$Sql = "UPDATE LectureEvent SET StatusName='$StatusName', StatusRegDate=NOW(), Status='$Status'  WHERE idx=$idx";
$Row = mysqli_query($connect, $Sql);

$cmd = true;
$url = "lecture_event.php?col=".$col."&sw=".$sw;


if($Row && $cmd) {
	$ProcessOk = "Y";
	$msg = "처리되었습니다.";
}else{
	$ProcessOk = "N";
	$msg = "오류가 발생했습니다. 관리자에게 문의하세요.";
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
	alert("<?=$msg?>");
	top.$("#SubmitBtn").show();
	top.$("#Waiting").hide();
	<?if($ProcessOk=="Y") {?>
	top.location.href="<?=$url?>";
	<?}?>
</SCRIPT>