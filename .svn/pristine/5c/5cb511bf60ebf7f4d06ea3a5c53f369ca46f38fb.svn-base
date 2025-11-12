<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);

$pg = Replace_Check($pg);
$col = Replace_Check($col);
$sw = Replace_Check($sw);

//답변 정보
$Name2 = Replace_Check($Name2); //답변 작성자
$Contents2 = Replace_Check2($Contents2); //답변 내용

//답글 작성
if($mode=="reply") {
    $Sql = "UPDATE Review SET Name2='$Name2', Contents2='$Contents2', RegDate2=NOW(), Status='B' WHERE idx=$idx";
    $Row = mysqli_query($connect, $Sql);
    
    $url = "after.php?col=".$col."&sw=".$sw;
}

//삭제
if($mode=="del"){
	$Sql = "UPDATE Review SET Del='Y' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);
	
	$url = "after.php?col=".$col."&sw=".$sw;
}

//쿼리 오류 확인
if($Row) {
	$ProcessOk = "Y";
	$msg = "처리되었습니다.";
}else{
	$ProcessOk = "N";
	$msg = "오류가 발생했습니다.";
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	<?if($ProcessOk=="Y") {?>
	top.location.href="<?=$url?>";
	<?}?>
//-->
</SCRIPT>