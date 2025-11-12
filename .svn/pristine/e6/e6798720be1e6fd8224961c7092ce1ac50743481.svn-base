<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);

$ClassGrade = Replace_Check($ClassGrade); //등급
$LectureCode = Replace_Check($LectureCode); //과정코드
$UseYN = Replace_Check($UseYN); //사이트 노출
$PassCode = Replace_Check($PassCode); //심사코드
$HrdCode = Replace_Check($HrdCode); //HRD-NET 과정코드
$Category1 = Replace_Check($Category1); //과정분류 대분류
$Category2 = Replace_Check($Category2); //과정분류 소분류
$ServiceType = Replace_Check($ServiceType); //수강방법
$ContentsName = Replace_Check($ContentsName); //과정명
$ContentsTime = Replace_Check($ContentsTime); //교육시간
$ContentsPeriod = Replace_Check($ContentsPeriod); //컨텐츠 유효기간
$ContentsAccredit = Replace_Check($ContentsAccredit); //인정만료일 시작일
$ContentsExpire = Replace_Check($ContentsExpire); //인정만료일 종료일
$Cp = Replace_Check($Cp); //cp사
$Commission = Replace_Check($Commission); //cp 수수료
$Mobile = Replace_Check($Mobile); //모바일 지원
$BookPrice = Replace_Check($BookPrice); //교재비
$BookIntro = Replace_Check($BookIntro); //참고도서설명
$attachFile = Replace_Check($attachFile); //학습자료
$PreviewImage = Replace_Check($PreviewImage); //과정 이미지
$BookImage = Replace_Check($BookImage); //교재 이미지
$Intro = Replace_Check2($Intro); //과정소개
$EduTarget = Replace_Check2($EduTarget); //교육대상
$EduGoal = Replace_Check2($EduGoal); //교육목표
$tok2 = Replace_Check($tok2); //tok2 연계여부
$ctype = Replace_Check($ctype); //구분 A:사업자과정, B:근로자과정, C:FLEX
$IE8Compat = Replace_Check($IE8Compat); //브라우저 호환성 여부
$ContentsURLSelect = Replace_Check($ContentsURLSelect); //컨텐츠 URL 주경로, 예비경로 선택 여부 A:주, B:예비
$Keyword1 = Replace_Check($Keyword1); //관심분야
$Keyword2 = Replace_Check($Keyword2); //난이도
$Keyword3 = Replace_Check($Keyword3); //직무분야
$ContentsURL = Replace_Check($ContentsURL); //컨텐츠URL
$MobileURL = Replace_Check($MobileURL); //모바일URL
$Chapter = Replace_Check($Chapter); //차시수

$ContentsPeriod = $ContentsPeriod." 23:59:55";
$ContentsAccredit = $ContentsAccredit." 00:01:55";
$ContentsExpire = $ContentsExpire." 23:59:55";

if(!$Commission) $Commission = 0;
if(!$BookPrice) $BookPrice = 0;
if(!$tok2) $tok2 = "N";
if(!$ctype) $ctype = "C";
if(!$ServiceType) $ServiceType = "4";
if(!$IE8Compat) $IE8Compat = "N";

//새글 작성---------------------------------------------------------------------------------------------------------
if($mode=="new") { 
	//과정코드 중복체크(내배카)
	$SqlA = "SELECT * FROM CourseCyber WHERE LectureCode='$LectureCode'";
	$ResultA = mysqli_query($connect, $SqlA);
	$RowA = mysqli_fetch_array($ResultA);
	//과정코드 중복체크(사업주훈련)
	$SqlB = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
	$ResultB = mysqli_query($connect, $SqlB);
	$RowB = mysqli_fetch_array($ResultB);
	//과정코드 중복체크(FLEX)
	$SqlC = "SELECT * FROM CourseFlex WHERE LectureCode='$LectureCode'";
	$ResultC = mysqli_query($connect, $SqlC);
	$RowC = mysqli_fetch_array($ResultC);
	if($RowA || $RowB || $RowC) {
	?>
	<script type="text/javascript">
		alert("동일한 과정코드가 존재하거나 삭제된 과정코드입니다.");
		top.$("#SubmitBtn").show();
		top.$("#Waiting").hide();
	</script>
	<?
	   exit;
	}	

	$maxno = max_number("idx","CourseFlex");
	$Sql = "INSERT INTO CourseFlex
                (idx, LectureCode, ClassGrade, UseYN, PassCode, HrdCode, Category1, Category2, Keyword1, Keyword2, Keyword3, ServiceType,
                ContentsName, ContentsTime, ContentsPeriod, ContentsAccredit, ContentsExpire, Cp, Commission, Mobile, BookPrice, BookIntro, attachFile, PreviewImage, BookImage,
                Intro, EduTarget, EduGoal, Del, RegDate, tok2, ctype, IE8Compat, ContentsURLSelect, ContentsURL, MobileURL, Chapter)
			VALUES 
				($maxno, '$LectureCode', '$ClassGrade', '$UseYN', '$PassCode', '$HrdCode', '$Category1', '$Category2', '$Keyword1', '$Keyword2', '$Keyword3', '$ServiceType',
                '$ContentsName', '$ContentsTime', '$ContentsPeriod', '$ContentsAccredit', '$ContentsExpire', '$Cp', $Commission, '$Mobile', $BookPrice, '$BookIntro', '$attachFile', '$PreviewImage', '$BookImage',
				'$Intro', '$EduTarget', '$EduGoal', 'N', NOW(), '$tok2', '$ctype', '$IE8Compat', '$ContentsURLSelect', '$ContentsURL', '$MobileURL', '$Chapter')";
	$Row = mysqli_query($connect, $Sql);
	
	$cmd = true;
	$url = "course_flex_read.php?idx=".$maxno;
}
//새글 작성-------------------------------------------------------------------------------------------------------------------------

//글 수정---------------------------------------------------------------------------------------------------------
if($mode=="edit") {
	$Sql = "UPDATE CourseFlex SET 
					ClassGrade='$ClassGrade', UseYN='$UseYN', PassCode='$PassCode', HrdCode='$HrdCode', Category1='$Category1', Category2='$Category2',
                    Keyword1='$Keyword1', Keyword2='$Keyword2', Keyword3='$Keyword3', ServiceType='$ServiceType', ContentsName='$ContentsName', ContentsTime='$ContentsTime',
                    ContentsPeriod='$ContentsPeriod', ContentsAccredit='$ContentsAccredit', ContentsExpire='$ContentsExpire', Cp='$Cp', Commission=$Commission, Mobile='$Mobile', BookPrice=$BookPrice, BookIntro='$BookIntro', attachFile='$attachFile', 
					PreviewImage='$PreviewImage', BookImage='$BookImage', Intro='$Intro', EduTarget='$EduTarget', EduGoal='$EduGoal', tok2='$tok2', IE8Compat='$IE8Compat', ContentsURLSelect='$ContentsURLSelect' , ContentsURL='$ContentsURL', MobileURL='$MobileURL', Chapter='$Chapter'
			WHERE idx=$idx AND LectureCode='$LectureCode'";
	$Row = mysqli_query($connect, $Sql);
	
	$cmd = true;
	$url = "course_flex_read.php?idx=".$idx;

}
//글 수정-------------------------------------------------------------------------------------------------------------------------

//글 삭제---------------------------------------------------------------------------------------------------------
if($mode=="del") { 
	$Sql = "UPDATE CourseFlex SET Del='Y' WHERE idx=$idx AND LectureCode='$LectureCode'";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "course_flex.php?col=".$col."&sw=".$sw;

}
//글 삭제-------------------------------------------------------------------------------------------------------------------------

if($Row && $cmd) {
	$ProcessOk = "Y";
	$msg = "처리되었습니다.";
}else{
	$ProcessOk = "N";
	$msg = "오류가 발생했습니다.";
	//$msg = $Sql;
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	top.$("#SubmitBtn").show();
	top.$("#Waiting").hide();
	<?if($ProcessOk=="Y") {?>
	top.location.href="<?=$url?>";
	<?}?>
//-->
</SCRIPT>