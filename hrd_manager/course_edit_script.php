<?
include "../include/include_function.php";
include "./include/include_admin_check.php";


$idx = Replace_Check2($idx2);
$ClassGrade = Replace_Check2($ClassGrade);
$LectureCode = Replace_Check2($LectureCode);
$PassCode = Replace_Check2($PassCode);
$UseYN = Replace_Check2($UseYN);
$ContentsURLSelect = Replace_Check2($ContentsURLSelect);
$HrdCode = Replace_Check2($HrdCode);
$Category1 = Replace_Check2($Category1);
$Category2 = Replace_Check2($Category2);
$ContentsName = Replace_Check2($ContentsName);
$Keyword1 = Replace_Check2($Keyword1);
$Keyword2 = Replace_Check2($Keyword2);
$Keyword3 = Replace_Check2($Keyword3);
$Keyword4 = Replace_Check2($Keyword4);
$Chapter = Replace_Check2($Chapter);
$ContentsTime = Replace_Check2($ContentsTime);
$ContentsStart = Replace_Check2($ContentsStart);
$ContentsEnd = Replace_Check2($ContentsEnd);
$UploadDate = Replace_Check2($UploadDate);
$Cp = Replace_Check2($Cp);
$Commission = Replace_Check2($Commission);
$Mobile = Replace_Check2($Mobile);
$BookPrice = Replace_Check2($BookPrice);
$BookIntro = Replace_Check2($BookIntro);
$PreviewImage = Replace_Check2($PreviewImage);
$Intro = Replace_Check2($Intro);
$EduTarget = Replace_Check2($EduTarget);
$EduGoal = Replace_Check2($EduGoal);


$Sql = "UPDATE CourseExcelTemp 
            SET ClassGrade='$ClassGrade', LectureCode='$LectureCode', PassCode='$PassCode', UseYN ='$UseYN', 
                ContentsURLSelect ='$ContentsURLSelect', HrdCode ='$HrdCode', Category1 ='$Category1', Category2 ='$Category2', 
                ContentsName ='$ContentsName', Keyword1 ='$Keyword1', Keyword2 ='$Keyword2', Keyword3 ='$Keyword3', Keyword4 ='$Keyword4', 
                Chapter ='$Chapter', ContentsTime ='$ContentsTime', ContentsStart ='$ContentsStart', ContentsEnd ='$ContentsEnd', 
                UploadDate ='$UploadDate', Cp ='$Cp', Commission ='$Commission', Mobile = '$Mobile', BookPrice = '$BookPrice', 
                BookIntro ='$BookIntro', PreviewImage ='$PreviewImage', Intro ='$Intro', EduTarget ='$EduTarget', EduGoal = '$EduGoal'
            WHERE idx=$idx";
$Row = mysqli_query($connect, $Sql);

if($Row) {
	$ProcessOk = "Y";
	$msg = "수정 되었습니다.";
}else{
	$ProcessOk = "N";
	$msg = "오류가 발생했습니다.";
	$msg = $Sql;
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	<?if($ProcessOk=="Y") {?>
	top.DataResultClose();
	top.CourseExcelUploadListRoading('A');
	<?}?>
//-->
</SCRIPT>