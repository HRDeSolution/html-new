<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);
$Contents2 = Replace_Check2($Contents2);

$col = Replace_Check($col);
$sw = Replace_Check($sw);

$cmd = false;

//답글 작성
if($mode=="reply") {
    $Sql = "UPDATE Cheating SET Name2='$Name2', RegDate2=NOW(), Status='$Status'  WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);
	
	$cmd = true;
	$url = "cheating_report.php?col=".$col."&sw=".$sw;
}

//글 삭제
if($mode=="del") {
	$Sql = "UPDATE Cheating SET Del='Y' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "cheating_report.php?col=".$col."&sw=".$sw;
}

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