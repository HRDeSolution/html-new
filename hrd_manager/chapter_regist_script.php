<?
include "../include/include_function.php";
include "./include/include_admin_check.php";
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<?
$mode = Replace_Check($mode);
$LectureCode = Replace_Check($LectureCode);
$Chapter_seq = Replace_Check($Chapter_seq);

$ChapterType = Replace_Check($ChapterType);
$Content_idx = Replace_Check($Content_idx);
$OrderByNum = Replace_Check($OrderByNum);

$cmd = false;

$Sub_idx = $Content_idx;

//신규작성
if($mode=="new"){
	$maxno = max_number("Seq","Chapter");
	$Sql = "INSERT INTO Chapter (Seq, LectureCode, ChapterType, Sub_idx, OrderByNum, RegDate) 
			VALUES ($maxno, '$LectureCode', '$ChapterType', '$Sub_idx', $OrderByNum, NOW())";
	$Row = mysqli_query($connect, $Sql);
	$cmd = true;
}

//수정
if($mode=="edit"){
	$Sql = "UPDATE Chapter SET ChapterType='$ChapterType', Sub_idx='$Sub_idx', OrderByNum=$OrderByNum WHERE Seq=$Chapter_seq";
	$Row = mysqli_query($connect, $Sql);
	$cmd = true;
}

//삭제
if($mode=="del"){
	$Sql = "DELETE FROM  Chapter  WHERE Seq=$Chapter_seq";
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