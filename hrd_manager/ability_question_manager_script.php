<?
include "../include/include_function.php";
include "./include/include_admin_check.php";
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<?
$mode = Replace_Check($mode);
$idx = Replace_Check($idx);

$aDepth = Replace_Check($aDepth);
$aGroup = Replace_Check($aGroup);
$aOrder = Replace_Check($aOrder);
$aValue = Replace_Check($aValue);

$cmd = false;

//신규작성
if($mode=="new"){
	$Sql = "INSERT INTO ArchiveQuestion (aDepth, aGroup, aOrder, aValue, aValueDetail, regDate) 
			VALUES ('$aDepth', '$aGroup', '$aOrder', '$aValue', '$aValueDetail', NOW())";
	$Row = mysqli_query($connect, $Sql);
	$cmd = true;
}

//수정
if($mode=="edit"){
	$Sql = "UPDATE ArchiveQuestion SET aDepth='$aDepth', aGroup='$aGroup', aOrder='$aOrder', aValue='$aValue', aValueDetail='$aValueDetail', modDate=NOW() WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);
	$cmd = true;
}

//삭제
if($mode=="del"){
	$Sql = "DELETE FROM  ArchiveQuestion  WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);
	$cmd = true;
}

if($Row && $cmd) {
	$ProcessOk = "Y";
	$msg = "처리되었습니다.";
}else{
	$ProcessOk = "N";
	$msg = "오류가 발생했습니다.";
}
mysqli_close($connect);
?>
<SCRIPT LANGUAGE="JavaScript">
	alert("<?=$msg?>");
	<?if($ProcessOk=="Y") {?>
		<?if($mode=="new") {?>
			top.$("#SubmitBtn").show();
			top.$("#Waiting").hide();
			var OrderByNum2 = eval(top.$("#OrderByNum").val())+1;
			top.$("#OrderByNum").val(OrderByNum2);
			top.ChapterListRoading();
		<?}?>
		<?if($mode=="edit") {?>
			top.ChapterListRoading();
			top.DataResultClose();
		<?}?>
		<?if($mode=="del") {?>
			top.DataResultClose();
			top.location.reload();
		<?}?>
	<?}?>
</SCRIPT>