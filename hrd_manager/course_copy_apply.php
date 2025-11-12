<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$LectureCode = Replace_Check($LectureCode);

$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
if($Row) {
    $ClassGrade = $Row['ClassGrade']; //등급
    $LectureCode = $Row['LectureCode']; //과정코드
    $UseYN = $Row['UseYN']; //사이트 노출
    $Category1 = $Row['Category1']; //과정분류 대분류
    $Category2 = $Row['Category2']; //과정분류 중분류
    $ServiceType = $Row['ServiceType']; //서비스 구분
    $ContentsName = html_quote($Row['ContentsName']); //과정명
    $ContentsTime = $Row['ContentsTime']; //교육시간
    $ContentsDate = substr($Row['ContentsDate'],0,10); //컨텐츠 제작연도
    $UploadStart = substr($Row['UploadStart'],0,10); //컨텐츠업로드 시작일
    $UploadEnd = substr($Row['UploadEnd'],0,10); //컨텐츠업로드 종료일
    $Mobile = $Row['Mobile']; //모바일 지원
    $BookPrice = $Row['BookPrice']; //교재비
    $attachFile = html_quote($Row['attachFile']); //학습자료
    $PreviewImage = html_quote($Row['PreviewImage']); //과정 이미지
    $BookImage = html_quote($Row['BookImage']); //교재 이미지
    $Intro = $Row['Intro']; //과정소개
    $EduTarget = $Row['EduTarget']; //교육대상
    $EduGoal = $Row['EduGoal']; //교육목표
    $ContentsURLSelect = $Row['ContentsURLSelect']; //컨텐츠 URL 주경로, 예비경로 선택 여부 A:주, B:예비
    $Keyword1 = $Row['Keyword1']; //난이도(직급)
    $Keyword2 = $Row['Keyword2']; //직무분야
    $Keyword3 = $Row['Keyword3']; //관심분야
    $Keyword4 = $Row['Keyword4']; //역량
    $ContentsURL = $Row['ContentsURL']; //컨텐츠URL
    $MobileURL = $Row['MobileURL']; //모바일URL
    $Chapter = $Row['Chapter']; //차시수
    $PackageLectureCode = $Row['PackageLectureCode']; //패키지콘텐츠과정코드
    $HrdSeq = $Row['HrdSeq']; //원격훈련일련번호
    $Professor = $Row['Professor']; //교강사
    $Price = $Row['Price']; //교육비용 일반
    $Price01View = $Row['Price01View']; //교육비용 우선지원
    $Price02View = $Row['Price02View']; //교육비용 대규모 1000인 미만
    $Price03View = $Row['Price03View']; //교육비용 대규모 1000인 이상
    $PassTime = $Row['PassTime']; //수료기준 시간

	$Intro = str_replace("\r\n","<BR />",$Intro);
	$EduTarget = str_replace("\r\n","<BR />",$EduTarget);
	$EduGoal = str_replace("\r\n","<BR />",$EduGoal);
}

if($attachFile) $attachFileView = "<A HREF='./direct_download.php?code=Course&file=".$attachFile."'><B>".$attachFile."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('attachFile','attachFileArea') class='btn_inputLine01'>";
if($PreviewImage) $PreviewImageView = "<img src='/upload/Course/".$PreviewImage."' width='150' align='absmiddle'>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('PreviewImage','attachFileArea') class='btn_inputLine01'>";
if($BookImage) $BookImageView = "<img src='/upload/Course/".$BookImage."' width='150' align='absmiddle'>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('BookImage','attachFileArea') class='btn_inputLine01'>";

mysqli_close($connect);
?>
<script>
function CourseCategorySelectAfter(Category1, Category2) {
	$("span[id='Category2Area']").load('./course_category_select.php', { Category1: Category1, Category2: Category2 }, function () {});
}
</script>
<script type="text/javascript">
	top.$("#ClassGrade").val("<?=$ClassGrade?>");
	top.$("#UseYN").val("<?=$UseYN?>");
	<?if($ctype_session==$ctype) {?>
	top.$("#Category1").val("<?=$Category1?>");
	top.CourseCategorySelectAfter(<?=$Category1?>,<?=$Category2?>);
	<?}?>
	top.$("#ServiceType").val("<?=$ServiceType?>");
	top.$("#ContentsName").val("<?=$ContentsName?>");
	top.$("#Chapter").val("<?=$Chapter?>");
	top.$("#ContentsTime").val("<?=$ContentsTime?>");	
	top.$("#ContentsDate").val("<?=$ContentsDate?>");
	top.$("#UploadStart").val("<?=$UploadStart?>");
	top.$("#UploadEnd").val("<?=$UploadEnd?>");
	top.$("#Mobile").val("<?=$Mobile?>");
	top.$("#BookPrice").val("<?=$BookPrice?>");
	top.$("#attachFile").val("<?=$attachFile?>");
	top.$("#attachFileArea").html("<?=$attachFileView?>");
	top.$("#PreviewImage").val("<?=$PreviewImage?>");
	top.$("#PreviewImageArea").html("<?=$PreviewImageView?>");
	top.$("#BookImage").val("<?=$BookImage?>");
	top.$("#BookImageArea").html("<?=$BookImageView?>");	
	top.$("#PackageLectureCode").html("<?=$PackageLectureCode?>");
	top.$("#HrdSeq").html("<?=$HrdSeq?>");
	top.$("#Professor").html("<?=$Professor?>");
	top.$("#Price").html("<?=$Price?>");
	top.$("#Price01View").html("<?=$Price01View?>");
	top.$("#Price02View").html("<?=$Price02View?>");
	top.$("#Price03View").html("<?=$Price03View?>");
	top.$("#PassTime").html("<?=$PassTime?>");
	
	var Intro_temp = "<?=$Intro?>";
	top.$('#Intro').val(Intro_temp.replace(/<BR\s?\/?>/g,"\n")); 

	var EduTarget_temp = "<?=$EduTarget?>";
	top.$('#EduTarget').val(EduTarget_temp.replace(/<BR\s?\/?>/g,"\n")); 

	var EduGoal_temp = "<?=$EduGoal?>";
	top.$('#EduGoal').val(EduGoal_temp.replace(/<BR\s?\/?>/g,"\n")); 

	top.DataResultClose();
</script>