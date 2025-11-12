<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$LectureCode = Replace_Check_XSS2($LectureCode); //강의코드
$data = Replace_Check_XSS2($data); //사이트구분 - A:사업주훈련/B:내일배움카드

$DBtable;
if($data == "A"){
    $DBtable = "Course";
}else{
    $DBtable = "CourseCyber";
}

//[1]과정 정보 구하기
$Sql = "SELECT * FROM $DBtable WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Course_idx = $Row['idx']; //과정 고유번호
	$ContentsName = $Row['ContentsName']; //과정명
	$attachFile = $Row['attachFile']; //학습자료
	$Professor = $Row['Professor']; //내용전문가 
	$CompleteTime = $Row['CompleteTime'] * 60; //진도시간 기준
}


//[2]첫번째 차시 구하기
$Sql = "SELECT Sub_idx FROM Chapter WHERE LectureCode='$LectureCode' AND ChapterType='A' ORDER BY OrderByNum ASC";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$Contents_idx = $Row[0];


//[3]차시 정보 구하기
$Sql = "SELECT * FROM Contents WHERE idx='$Contents_idx'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ContentsTitle = $Row['ContentsTitle']; //차시명
	$Expl01 = nl2br($Row['Expl01']); //차시 목표
	$Expl02 = nl2br($Row['Expl02']); //훈련 내용
	$Expl03 = nl2br($Row['Expl03']); //학습 활동
}


//[4]컨텐츠 정보 구하기
$Sql = "SELECT * FROM ContentsDetail WHERE Contents_idx=$Contents_idx AND (ContentsType='A' OR ContentsType='B') ORDER BY OrderByNum ASC, Seq ASC LIMIT 0,1";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ContentsDetail_Seq = $Row['Seq'];
	$ContentsType = $Row['ContentsType'];
	$ContentsURL = $Row['ContentsURL'];
}

//[5]플레쉬 또는 동영상 정보 구하기
if($ContentsType=="A") { //플레쉬 강의의 경우
	$PlayPath = $FlashServerURL.$ContentsURL ;
	$PlayerFunction = "<div id='CloseBtn' style='position:relative; z-index:10000'>";
	$PlayerFunction .= "<a href='Javascript:DataResultClose();'><img src='/images/common/close1_2_on.png'></a>";
	$PlayerFunction .= "</div>";
	$PlayerFunction .= "<div class='flashArea' style='background-color:#fff; text-align:center'>";
	$PlayerFunction .= "<input type='hidden' name='ContentsType' id='ContentsType' value='A'>";
	$PlayerFunction .= "<iframe name='mPlayer' id='mPlayer'  src='".$PlayPath."' border='0' frameborder='0' onload='resizeIframe(this)' scrolling='no'></iframe>";
	$PlayerFunction .= "</div>";
}
if($ContentsType=="B") { //동영상 강의의 경우
	$PlayPath = $MovieServerURL.$ContentsURL ;
	$PlayerFunction = "<div id='CloseBtn' style='position:relative; z-index:10000'>";
	$PlayerFunction .= "<a href='Javascript:DataResultClose();'><img src='/images/common/close1_2_on.png'></a>";
	$PlayerFunction .= "</div>";
	$PlayerFunction .= "<div class='flashArea' style='background-color:#000; text-align:center'>";
	$PlayerFunction .= "<input type='hidden' name='ContentsType' id='ContentsType' value='B'>";
	$PlayerFunction .= "<video id='mPlayer' width='1020' height='655' controls autoplay><source src='".$PlayPath."' type='video/mp4'></video>";
	$PlayerFunction .= "</div>";
}
?>
<?
if(!$ContentsURL) {
?>
<script type="text/javascript">
<!--
	alert("등록된 미리보기 강의가 없습니다.");
	DataResultClose();
//-->
</script>
<?
}
?>
<?=$PlayerFunction?>