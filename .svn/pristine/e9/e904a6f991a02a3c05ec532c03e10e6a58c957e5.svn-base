<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$LectureCode = Replace_Check($LectureCode);

$Sql = "SELECT * FROM CourseFlex WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
    $ClassGrade = $Row['ClassGrade']; //등급
    $LectureCode = $Row['LectureCode']; //과정코드
    $UseYN = $Row['UseYN']; //사이트 노출
    $PassCode = $Row['PassCode']; //심사코드
    $HrdCode = $Row['HrdCode']; //HRD-NET 과정코드
    $Category1 = $Row['Category1']; //과정분류 대분류
    $Category2 = $Row['Category2']; //과정분류 소분류
    $ServiceType = $Row['ServiceType']; //서비스 구분
    $ContentsName = html_quote($Row['ContentsName']); //과정명
    $ContentsTime = $Row['ContentsTime']; //교육시간
    $ContentsPeriod = substr($Row['ContentsPeriod'],0,10); //컨텐츠 유효기간
    $ContentsAccredit = substr($Row['ContentsAccredit'],0,10); //인정만료일 시작일
    $ContentsExpire = substr($Row['ContentsExpire'],0,10); //인정만료일 종료일
    $Cp = html_quote($Row['Cp']); //cp사
    $Commission = $Row['Commission']; //cp 수수료
    $Mobile = $Row['Mobile']; //모바일 지원
    $BookPrice = $Row['BookPrice']; //교재비
    $BookIntro = html_quote($Row['BookIntro']); //참고도서설명
    $attachFile = html_quote($Row['attachFile']); //학습자료
    $PreviewImage = html_quote($Row['PreviewImage']); //과정 이미지
    $BookImage = html_quote($Row['BookImage']); //교재 이미지
    $Intro = $Row['Intro']; //과정소개
    $EduTarget = $Row['EduTarget']; //교육대상
    $EduGoal = $Row['EduGoal']; //교육목표
    $tok2 = $Row['tok2']; //tok2 연계여부
    $IE8Compat = $Row['IE8Compat']; //브라우저 호환성 여부
    $ContentsURLSelect = $Row['ContentsURLSelect']; //컨텐츠 URL 주경로, 예비경로 선택 여부 A:주, B:예비
    $Keyword1 = $Row['Keyword1']; //관심분야
    $Keyword2 = $Row['Keyword2']; //난이도
    $Keyword3 = $Row['Keyword3']; //근무분야
    $ContentsURL = $Row['ContentsURL']; //컨텐츠URL
    $MobileURL = $Row['MobileURL']; //모바일URL
    $Chapter = $Row['Chapter']; //차시수
	
	$Intro = str_replace("\r\n","<BR />",$Intro);
	$EduTarget = str_replace("\r\n","<BR />",$EduTarget);
	$EduGoal = str_replace("\r\n","<BR />",$EduGoal);
}

if($attachFile) $attachFileView = "<A HREF='./direct_download.php?code=Course&file=".$attachFile."'><B>".$attachFile."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('attachFile','attachFileArea') class='btn_inputLine01'>";
if($PreviewImage) $PreviewImageView = "<img src='/upload/Course/".$PreviewImage."' width='150' align='absmiddle'>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('PreviewImage','attachFileArea') class='btn_inputLine01'>";
if($BookImage) $BookImageView = "<img src='/upload/Course/".$BookImage."' width='150' align='absmiddle'>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('BookImage','attachFileArea') class='btn_inputLine01'>";

mysqli_close($connect);
?>
<script type="text/javascript">
	top.$("#ClassGrade").val("<?=$ClassGrade?>");
	top.$("#UseYN").val("<?=$UseYN?>");
	top.$("#PassCode").val("<?=$PassCode?>");
	top.$("#HrdCode").val("<?=$HrdCode?>");
	top.$("#Category1").val("<?=$Category1?>");
	top.$("#Category2").val("<?=$Category2?>");
	top.$("#Keyword1").val("<?=$Keyword1?>");
	top.$("#Keyword2").val("<?=$Keyword2?>");
	top.$("#Keyword3").val("<?=$Keyword3?>");
	top.$("#ServiceType").val("<?=$ServiceType?>");
	top.$("#ContentsName").val("<?=$ContentsName?>");
	top.$("#Chapter").val("<?=$Chapter?>");
	top.$("#ContentsTime").val("<?=$ContentsTime?>");
	top.$("#ContentsPeriod").val("<?=$ContentsPeriod?>");
	top.$("#ContentsAccredit").val("<?=$ContentsAccredit?>");
	top.$("#ContentsExpire").val("<?=$ContentsExpire?>");
	top.$("#Cp").val("<?=$Cp?>");
	top.$("#Commission").val("<?=$Commission?>");
	top.$("#Mobile").val("<?=$Mobile?>");
	top.$("#BookPrice").val("<?=$BookPrice?>");
	top.$("#BookIntro").val("<?=$BookIntro?>");
	top.$("#attachFile").val("<?=$attachFile?>");
	top.$("#attachFileArea").html("<?=$attachFileView?>");
	top.$("#PreviewImage").val("<?=$PreviewImage?>");
	top.$("#PreviewImageArea").html("<?=$PreviewImageView?>");
	top.$("#BookImage").val("<?=$BookImage?>");
	top.$("#BookImageArea").html("<?=$BookImageView?>");
	
	var Intro_temp = "<?=$Intro?>";
	top.$('#Intro').val(Intro_temp.replace(/<BR\s?\/?>/g,"\n")); 

	var EduTarget_temp = "<?=$EduTarget?>";
	top.$('#EduTarget').val(EduTarget_temp.replace(/<BR\s?\/?>/g,"\n")); 

	var EduGoal_temp = "<?=$EduGoal?>";
	top.$('#EduGoal').val(EduGoal_temp.replace(/<BR\s?\/?>/g,"\n")); 

	top.DataResultClose();
</script>