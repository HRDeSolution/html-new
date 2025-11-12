<?
include "../include/include_function.php";
include "./include/include_admin_check.php";


$idx = Replace_Check2($idx2);
$LectureCode = Replace_Check2($LectureCode);
$ChapterType = Replace_Check2($ChapterType);
$Sub_idx = Replace_Check($Sub_idx);
$OrderByNum = Replace_Check2($OrderByNum);


$Sql = "UPDATE ChapterExcelTemp 
            SET LectureCode='$LectureCode', ChapterType='$ChapterType', Sub_idx='$Sub_idx', OrderByNum =$OrderByNum WHERE idx=$idx";
$Row = mysqli_query($connect, $Sql);

if($Row) {
	$ProcessOk = "Y";
	$msg = "수정 되었습니다.";
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
	top.DataResultClose();
	top.ChapterExcelUploadListRoading('A');
	<?}?>
//-->
</SCRIPT>