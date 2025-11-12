<?
include $_SERVER['DOCUMENT_ROOT'] . "/m_include/include_function.php"; //DB연결 및 각종 함수 정의
include $_SERVER['DOCUMENT_ROOT'] . "/m_include/login_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);

$Title = Replace_Check($Title);
$Contents = Replace_Check($Contents);
$StarPoint = Replace_Check($StarPoint);

//수정
if($mode=="modify") {
    $Sql = "UPDATE Review SET Title='$Title', Contents='$Contents', StarPoint=$StarPoint WHERE idx=$idx";
    $Row = mysqli_query($connect, $Sql);
}

//삭제
if($mode=="del"){
    $Sql = "UPDATE Review SET Del='Y' WHERE idx=$idx";
    $Row = mysqli_query($connect, $Sql);
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
<script type="text/javascript" src="./m_include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
	alert("<?=$msg?>");
	<?if($ProcessOk=="Y") {?>
	top.location.href="/m_public/mypage/survey.html";
	<?}?>
</SCRIPT>