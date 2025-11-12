<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx  = Replace_Check($idx);
$mode = Replace_Check($mode);

$ClassGrade         = Replace_Check($ClassGrade); //등급
$LectureCode        = Replace_Check($LectureCode); //과정코드
$UseYN              = Replace_Check($UseYN); //사이트 노출
$Category1          = Replace_Check($Category1); //과정분류 대분류
$Category2          = Replace_Check($Category2); //과정분류 중분류
$ServiceType        = Replace_Check($ServiceType); //서비스구분
$ContentsName       = Replace_Check($ContentsName); //과정명
$ContentsTime       = Replace_Check($ContentsTime); //교육시간
$ContentsStart      = Replace_Check($ContentsStart); //컨텐츠 유효 시작일
$ContentsEnd        = Replace_Check($ContentsEnd); //컨텐츠 유효 종료일
$UploadDate         = Replace_Check($UploadDate); //컨텐츠업로드 날짜
$Mobile             = Replace_Check($Mobile); //모바일 지원
$BookPrice          = Replace_Check($BookPrice); //교재비
$attachFile         = Replace_Check($attachFile); //학습자료
$PreviewImage       = Replace_Check($PreviewImage); //과정 이미지
$BookImage          = Replace_Check($BookImage); //교재 이미지
$Intro              = Replace_Check2($Intro); //과정소개
$EduTarget          = Replace_Check2($EduTarget); //교육대상
$EduGoal            = Replace_Check2($EduGoal); //교육목표
$ContentsURLSelect  = Replace_Check($ContentsURLSelect); //컨텐츠 URL 주경로, 예비경로 선택 여부 A: 주, B: 예비
$Keyword1           = Replace_Check($Keyword1); //난이도(직급)
$Keyword2           = Replace_Check($Keyword2); //직무분야
$Keyword3           = Replace_Check(implode(',', $_POST['Keyword3'])); //관심분야
$Keyword4           = Replace_Check(implode(',', $_POST['Keyword4'])); //역량
$ContentsURL        = Replace_Check($ContentsURL); //컨텐츠URL
$MobileURL          = Replace_Check($MobileURL); //모바일URL
$Chapter            = Replace_Check($Chapter); //차시수
$PackageLectureCode = Replace_Check($PackageLectureCode); //패키지콘텐츠과정코드
$HrdSeq             = Replace_Check($HrdSeq); //원격훈련일련번호
$Professor          = Replace_Check($Professor); //교강사
$Price              = Replace_Check($Price); //교육비용 일반
$Price01View        = Replace_Check($Price01View); //교육비용 우선지원
$Price02View        = Replace_Check($Price02View); //교육비용 대규모 1000인 미만
$Price03View        = Replace_Check($Price03View); //교육비용 대규모 1000인 이상
$PassTime           = Replace_Check($PassTime); //수료기준 시간
$LegalEduReq        = Replace_Check($LegalEduReq); //수료기준 시간

/*
$UploadStart = $UploadStart." 00:01:55";
$UploadEnd = $UploadEnd." 23:59:55";
*/
$cmd = false;

if(!$Category2) $Category2 = 0;
if(!$Commission) $Commission = 0;
if(!$BookPrice) $BookPrice = 0;
if(!$ctype) $ctype = "X";

//새글 작성---------------------------------------------------------------------------------------------------------
if($mode=="new") { 
    //과정코드 중복체크
    $Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
    $Result = mysqli_query($connect, $Sql);
    $Row = mysqli_fetch_array($Result);
    if($Row) {
	?>
	<script type="text/javascript">
		alert("동일한 과정코드가 존재하거나 삭제된 과정코드입니다.");
		top.$("#SubmitBtn").show();
		top.$("#Waiting").hide();
	</script>
	<?
	   exit;
	}

	$maxno = max_number("idx","Course");

	$Sql = "INSERT INTO Course 
				(idx, ctype,  ClassGrade, LectureCode, UseYN, Category1, Category2, ServiceType, ContentsName, ContentsTime, 
				Chapter, ContentsStart, ContentsEnd, UploadDate, Keyword1, Keyword2, Keyword3, Keyword4,
				Mobile, BookPrice,attachFile, PreviewImage, BookImage, 
				Intro, EduTarget, EduGoal, Del, RegDate, ContentsURLSelect, ContentsURL, MobileURL,
                PackageLectureCode, HrdSeq, Professor, Price, Price01View, Price02View, Price03View, PassTime, LegalEduReq)
				VALUES 
				($maxno, '$ctype', '$ClassGrade', '$LectureCode', '$UseYN', $Category1, $Category2, '$ServiceType', '$ContentsName', $ContentsTime,
				'$Chapter', '$ContentsStart', '$ContentsEnd', '$UploadDate', '$Keyword1', '$Keyword2', '$Keyword3', '$Keyword4',
				'$Mobile', $BookPrice, '$attachFile', '$PreviewImage', '$BookImage',  
				'$Intro', '$EduTarget', '$EduGoal', 'N', NOW(), '$ContentsURLSelect', '$ContentsURL', '$MobileURL',
                '$PackageLectureCode', '$HrdSeq', '$Professor', '$Price', '$Price01View', '$Price02View', '$Price03View', '$PassTime', '$LegalEduReq')";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "course_read.php?idx=".$maxno;

}
//새글 작성-------------------------------------------------------------------------------------------------------------------------

//글 수정---------------------------------------------------------------------------------------------------------
if($mode=="edit") { 
	$Sql = "UPDATE Course SET 
					ClassGrade='$ClassGrade', UseYN='$UseYN', Category1=$Category1, Category2=$Category2, ServiceType='$ServiceType', 
					ContentsName='$ContentsName', Chapter='$Chapter', ContentsTime='$ContentsTime', ContentsStart='$ContentsStart', ContentsEnd='$ContentsEnd', UploadDate='$UploadDate',
					Mobile='$Mobile', BookPrice=$BookPrice, attachFile='$attachFile', PreviewImage='$PreviewImage', BookImage='$BookImage',
					Intro='$Intro', EduTarget='$EduTarget', EduGoal='$EduGoal', ContentsURLSelect='$ContentsURLSelect' , ContentsURL='$ContentsURL', MobileURL='$MobileURL', 
                    Keyword1='$Keyword1', Keyword2 ='$Keyword2', Keyword3='$Keyword3', Keyword4='$Keyword4',
                    PackageLectureCode='$PackageLectureCode', HrdSeq='$HrdSeq', Professor='$Professor', Price='$Price', Price01View	='$Price01View', Price02View='$Price02View', Price03View='$Price03View', PassTime='$PassTime', LegalEduReq='$LegalEduReq'
				WHERE idx=$idx AND LectureCode='$LectureCode'";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "course_read.php?idx=".$idx;

}
//글 수정-------------------------------------------------------------------------------------------------------------------------

//글 삭제---------------------------------------------------------------------------------------------------------
if($mode=="del") {

	$Sql = "UPDATE Course SET Del='Y' WHERE idx=$idx AND LectureCode='$LectureCode'";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "course.php?col=".$col."&sw=".$sw;

}
//글 삭제-------------------------------------------------------------------------------------------------------------------------

if($Row && $cmd) {
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
	alert("<?=$msg?>");
	top.$("#SubmitBtn").show();
	top.$("#Waiting").hide();
	<?if($ProcessOk=="Y") {?>
	top.location.href="<?=$url?>";
	<?}?>
</SCRIPT>