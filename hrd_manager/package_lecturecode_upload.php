<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$LectureCode = Replace_Check($LectureCode); //과정코드

$errorCnt;

//[1]해당 패키지에 저장된 컨텐츠 삭제
$Sql = "UPDATE Course SET PackageLectureCode='' WHERE idx=$idx AND LectureCode='$LectureCode'";
$Row = mysqli_query($connect, $Sql);
if(!$Row) $errorCnt++;

//[2]전체 컨텐츠 추출
$Sql1 = "SELECT GROUP_CONCAT(LectureCode SEPARATOR '|') FROM Course WHERE PackageYN='N' AND Del='N'";
$Result1 = mysqli_query($connect, $Sql1);
$Row1 = mysqli_fetch_array($Result1);
$LectureCodeList = $Row1[0];

//[3]전체 컨텐츠 일괄 등록
$Sql2 = "UPDATE Course SET PackageLectureCode='$LectureCodeList' WHERE idx=$idx AND LectureCode='$LectureCode'";
$Row2 = mysqli_query($connect, $Sql2);
if(!$Row2) $errorCnt++;


if($errorCnt >0) {
    $ProcessOk = "N";
    $msg = "오류가 발생했습니다.";
}else{
    $ProcessOk = "Y";
    $msg = "처리되었습니다.";
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
	alert("<?=$msg?>");
	<?if($ProcessOk=="Y") {?>
	top.location.reload();
	<?}?>
</SCRIPT>