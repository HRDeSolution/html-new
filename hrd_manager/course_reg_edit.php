<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);

$Sql = "SELECT * FROM CourseExcelTemp WHERE idx=$idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
    $idx = $Row['idx']; // 고유 증가값
    $Ctype = $Row['Ctype']; // 구분 X:이러닝 / Y:마이크로닝 / Z:숏폼
    $LectureCode = $Row['LectureCode']; // 강의 코드
    $ClassGrade = $Row['ClassGrade']; // 등급
    $UseYN = $Row['UseYN']; // 사이트 노출
    $PassCode = $Row['PassCode']; // 심사코드
    $HrdCode = $Row['HrdCode']; // HRD-NET 과정코드
    $Category1 = $Row['Category1']; // 과정분류 대분류
    $Category2 = $Row['Category2']; // 과정분류 중분류
    $Keyword1 = $Row['Keyword1']; // 난이도(직급)
    $Keyword2 = $Row['Keyword2']; // 직무분야
    $Keyword3 = $Row['Keyword3']; // 관심분야
    $Keyword4 = $Row['Keyword4']; // 역량
    $ServiceType = $Row['ServiceType']; // 서비스구분
    $ContentsName = $Row['ContentsName']; // 과정명
    $ContentsTime = $Row['ContentsTime']; // 교육시간
    $Cp = $Row['Cp']; // CP사
    $Commission = $Row['Commission']; // CP 수수료
    $Mobile = $Row['Mobile']; // 모바일 지원
    $BookPrice = $Row['BookPrice']; // 교재비
    $BookIntro = $Row['BookIntro']; // 참고도서설명
    $PreviewImage = $Row['PreviewImage']; // 과정 이미지
    $Intro = $Row['Intro']; // 과정소개
    $EduTarget = $Row['EduTarget']; // 교육대상
    $EduGoal = $Row['EduGoal']; // 교육목표
    $ContentsURLSelect = $Row['ContentsURLSelect']; // A:컨텐츠 URL 직접입력 / B:예비경로
    $Chapter = $Row['Chapter']; // 차시수
    $ContentsStart = $Row['ContentsStart']; // 컨텐츠 유효 시작일
    $ContentsEnd = $Row['ContentsEnd']; // 컨텐츠 유효 만료일
    $UploadDate = $Row['UploadDate']; // 컨텐츠 업로드일
    
    $ID = $Row['ID']; // 등록자 아이디

    $ContentsStart2 = date("Ymd", strtotime($ContentsStart));
    $ContentsEnd2 = date("Ymd", strtotime($ContentsEnd));
    $UploadDate2 = date("Ymd", strtotime($UploadDate));
}
?>
<!-- <script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<script type="text/javascript" src="./smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script> -->
<div class="Content">

	<div class="contentBody">
		<!-- ########## -->
		<h2>업로드한 엑셀파일 수정</h2>
		
		<div class="conZone">
			<!-- ## START -->
			
			<form name="EditForm" method="post" action="course_edit_script.php" target="ScriptFrame">
			<input type="hidden" name="idx2" id="idx2" value="<?=$idx?>">
			<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
					<colgroup>
                        <col width="180px" />
                        <col width="" />
    					<col width="180px" />
						<col width="" />
						<col width="180px" />
						<col width="" />
						<col width="180px" />
						<col width="" />
                  	</colgroup>
              		<tr>
						<th>등급</th>
						<td align="left">
        					<input name = "ClassGrade" id = "ClassGrade" value = "<?=$ClassGrade?>"> 
        				</td>
    					<th>과정코드</th>
    					<td align="left">
        					<input name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
    					</td>
						<th>사이트노출</th>
						<td align="left">
							<input name="UseYN" id="UseYN" value="<?=$UseYN?>">
        				</td>
    					<th>컨텐츠경로</th>
    					<td align="left">
        						<input name="ContentsURLSelect" id="ContentsURLSelect1" value="A" readonly>
    					</td>
					</tr>
    				<tr>
    					<th>심사코드</th>
    					<td colspan="3" align="left"><input name="PassCode" id="PassCode" type="text"  size="30" value="<?=$PassCode?>"> </td>
    					<th>HRD-NET 과정코드</td>
    					<td colspan="3" align="left"><input name="HrdCode" id="HrdCode" type="text"  size="30" value="<?=$HrdCode?>"></td>
    				</tr>
    				<tr>
    					<th>과정분류1</th>
    					<td align="left" colspan="3">
							<input name="Category1" id="Category1" value="<?=$Category1?>"size="30">
    					</td>
    					<th>과정분류2</th>
						<td align="left" colspan="3">
							<input name="Category2" id="Category2" value="<?=$Category2?>"size="30">
    					</td>
    				</tr>
    				<tr>
    					<th>과정명</th>
    					<td align="left" colspan="7"><input name="ContentsName" id="ContentsName" type="text"  size="150" value="<?=$ContentsName?>" maxlength="300"></td>
					</tr>
					<tr>
						<th>난이도(직급)</th>
    					<td align="left" colspan="3">
							<input name="Keyword1" id="Keyword1" value="<?=$Keyword1?>"size="30">
    					</td>
    					<th>직무분야</th>
    					<td align="left" colspan="3">
							<input name="Keyword2" id="Keyword2" value="<?=$Keyword2?>"size="30">
    					</td>
					</tr>
					<tr>
    					<th>관심분야</th>
    					<td align="left" colspan="7">
    						<span class="redB">관심분야 입력 시, 키워드 앞에 # 을 붙여주세요. (ex)#경영/전략 #프리젠테이션 #재무회계</span><br>
    						<input name="Keyword3" id="Keyword3" type="text"  size="150" value="<?=$Keyword3?>" maxlength="300">
    					</td>
					</tr>
					<tr>
    					<th>역량</th>
    					<td align="left" colspan="7">
    						<span class="redB">역량 입력 시, 키워드 앞에 # 을 붙여주세요. (ex)#경영의식 #고객지향성 #변화혁신마인드</span><br>
    						<input name="Keyword4" id="Keyword4" type="text"  size="150" value="<?=$Keyword4?>" maxlength="300">
    					</td>
					</tr>
					<tr>
						<th>차시수</th>
    					<td bgcolor="#FFFFFF" colspan="3">
    						<input name="Chapter" id="Chapter" type="text"  size="5" value="<?=$Chapter?>" maxlength="3"> 차시
    					</td>
						<th>교육시간</th>
    					<td bgcolor="#FFFFFF" colspan="3"><input name="ContentsTime" id="ContentsTime" type="text"  size="5" value="<?=$ContentsTime?>" maxlength="3"> 분</td>
    				</tr>
    				<tr>
    					<th>컨텐츠 유효기간</th>
    					<td bgcolor="#FFFFFF"><input name="ContentsStart" id="ContentsStart" type="text"  size="12" value="<?=$ContentsStart2?>">  ~ <input name="ContentsEnd" id="ContentsEnd" type="text"  size="12" value="<?=$ContentsEnd2?>"> </td>
    					<th>컨텐츠 업로드 일자</th>
    					<td bgcolor="#FFFFFF"><input name="UploadDate" id="UploadDate" type="text"  size="12" value="<?=$UploadDate2?>"></td>
    				</tr>
    				<tr>
    					<th>CP사</th>
    					<td bgcolor="#FFFFFF" colspan="3"><input name="Cp" id="Cp" type="text"  size="80" value="<?=$Cp?>"> </td>
    					<th>CP 수수료</th>
    					<td bgcolor="#FFFFFF" colspan="3"><input name="Commission" id="Commission" type="text"  size="10" value="<?=$Commission?>" maxlength="5" style="text-align:right"> %</td>
    				</tr>
    				<tr>
    					<th>모바일 지원</th>
    					<td bgcolor="#FFFFFF" colspan="3">
        					<input name="Mobile" id="Mobile" type="text"  size="5" value="<?=$Mobile?>" maxlength="3">
    					</td>
    					<th>교재비</th>
    					<td bgcolor="#FFFFFF" colspan="3"><input name="BookPrice" id="BookPrice" type="text"  size="10" value="<?=$BookPrice?>" maxlength="6" style="text-align:right"> 원</td>
    				</tr>
    				<tr>
    					<th>참고도서설명</th>
    					<td bgcolor="#FFFFFF" colspan="3"><input name="BookIntro" id="BookIntro" type="text" size="80"   value="<?=$BookIntro?>"></td>
						<th>과정 이미지</th>
    					<td bgcolor="#FFFFFF" colspan="3"><input name="PreviewImage" id="PreviewImage" type="text"  value="<?=$PreviewImage?>"></td>
    				</tr>
    				<tr>
    					<th>과정소개</th>
    					<td align="left" colspan="7"><textarea name="Intro" id="Intro" style="width:100%; height:160px;"><?=$Intro?></textarea></td>
    				</tr>
    				<tr>
    					<th>교육대상</th>
    					<td align="left" colspan="7"><textarea name="EduTarget" id="EduTarget" style="width:100%; height:160px;"><?=$EduTarget?></textarea></td>
    				</tr>
    				<tr>
    					<th>교육목표</th>
    					<td align="left" colspan="7"><textarea name="EduGoal" id="EduGoal" style="width:100%; height:160px;"><?=$EduGoal?></textarea></td>
    				</tr>
				</table>
			</form>

			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
				<tr>
					<td align="left" width="200">&nbsp;</td>
					<td align="center">
					<span id="EditSubmitBtn"><input type="button" value="수정 하기" onclick="CourseEditSubmitOk();" class="btn_inputBlue01"></span>
					<span id="EditWaiting" style="display:none"><strong>처리중입니다...</strong></span>
					</td>
					<td width="200" align="right"><input type="button" value="닫  기" onclick="DataResultClose();" class="btn_inputLine01"></td>
				</tr>
			</table>

			
			<!-- ## END -->
		</div>
		<!-- ########## // -->
	</div>

</div>


<SCRIPT LANGUAGE="JavaScript">
<!--
function CourseEditSubmitOk() {

	val = document.EditForm;

	if($("#ClassGrade").val()=="") {
		alert("등급을 입력하세요.");
		$("#ClassGrade").focus();
		return;
	}
	if($("#LectureCode").val()=="") {
		alert("과정코드를 입력하세요.");
		$("#LectureCode").focus();
		return;
	}
	if($("#UseYN").val()=="") {
		alert("사이트노출을 입력하세요.");
		$("#UseYN").focus();
		return;
	}
	if($("#ContentsURLSelect1").val()=="") {
		alert("컨텐츠경로를 입력하세요.");
		$("#ContentsURLSelect1").focus();
		return;
	}
// 	if($("#PassCode").val()=="") {
// 		alert("심사코드를 입력하세요.");
// 		$("#PassCode").focus();
// 		return;
// 	}
// 	if($("#HrdCode").val()=="") {
// 		alert("HRD-NET 과정코드를 입력하세요.");
// 		$("#HrdCode").focus();
// 		return;
// 	}
	if($("#Category1").val()=="") {
		alert("과정분류1 입력하세요.");
		$("#Category1").focus();
		return;
	}
	if($("#Category2").val()=="") {
		alert("과정분류2 입력하세요.");
		$("#Category2").focus();
		return;
	}
	if($("#ContentsName").val()=="") {
		alert("과정명 입력하세요.");
		$("#ContentsName").focus();
		return;
	}
	if($("#Keyword1").val()=="") {
		alert("난이도(직급) 입력하세요.");
		$("#Keyword1").focus();
		return;
	}
	if($("#Keyword2").val()=="") {
		alert("직무분야 입력하세요.");
		$("#Keyword2").focus();
		return;
	}
	if($("#Keyword3").val()=="") {
		alert("관심분야 입력하세요.");
		$("#Keyword3").focus();
		return;
	}
	if($("#Keyword4").val()=="") {
		alert("역량 입력하세요.");
		$("#Keyword4").focus();
		return;
	}
	if($("#Chapter").val()=="") {
		alert("차시수 입력하세요.");
		$("#Chapter").focus();
		return;
	}
	if($("#ContentsTime").val()=="") {
		alert("교육시간 입력하세요.");
		$("#ContentsTime").focus();
		return;
	}
	if($("#ContentsStart").val()=="") {
		alert("컨텐츠 유효기간 입력하세요.");
		$("#ContentsStart").focus();
		return;
	}
	if($("#ContentsEnd").val()=="") {
		alert("컨텐츠 유효기간 입력하세요.");
		$("#ContentsEnd").focus();
		return;
	}
	if($("#UploadDate").val()=="") {
		alert("컨텐츠 업로드일 입력하세요.");
		$("#UploadDate").focus();
		return;
	}
// 	if($("#Cp").val()=="") {
// 		alert("CP사 입력하세요.");
// 		$("#Cp").focus();
// 		return;
// 	}
// 	if($("#Commission").val()=="") {
// 		alert("CP 수수료 입력하세요.");
// 		$("#Commission").focus();
// 		return;
// 	}
	if($("#Mobile").val()=="") {
		alert("모바일 지원 입력하세요.");
		$("#Mobile").focus();
		return;
	}
// 	if($("#BookPrice").val()=="") {
// 		alert("교재비 입력하세요.");
// 		$("#BookPrice").focus();
// 		return;
// 	}
// 	if($("#BookIntro").val()=="") {
// 		alert("참고도서설명 입력하세요.");
// 		$("#BookIntro").focus();
// 		return;
// 	}
// 	if($("#PreviewImage").val()=="") {
// 		alert("과정 이미지 입력하세요.");
// 		$("#PreviewImage").focus();
// 		return;
// 	}
	if($("#Intro").val()=="") {
		alert("과정소개 입력하세요.");
		$("#Intro").focus();
		return;
	}
	if($("#EduTarget").val()=="") {
		alert("교육대상 입력하세요.");
		$("#EduTarget").focus();
		return;
	}
	if($("#EduGoal").val()=="") {
		alert("교육목표 입력하세요.");
		$("#EduGoal").focus();
		return;
	}

	if(IsNumber(val.Category1.value)==false) {
		alert("과정분류1은 숫자만 입력하세요.");
		val.Category1.focus();
		return;
	}

	if(IsNumber(val.Category2.value)==false) {
		alert("과정분류2은 숫자만 입력하세요.");
		val.Category2.focus();
		return;
	}

	if(IsNumber(val.Keyword1.value)==false) {
		alert("난이도(직급)은 숫자만 입력하세요.");
		val.Keyword1.focus();
		return;
	}

	if(IsNumber(val.Keyword2.value)==false) {
		alert("직무분야는 숫자만 입력하세요.");
		val.Keyword2.focus();
		return;
	}

	if(IsNumber(val.Chapter.value)==false) {
		alert("차시수는 숫자만 입력하세요.");
		val.Chapter.focus();
		return;
	}

	if(IsNumber(val.ContentsTime.value)==false) {
		alert("교육시간은 숫자만 입력하세요.");
		val.ContentsTime.focus();
		return;
	}

	if(IsNumber(val.Commission.value)==false) {
		alert("cp수수료는 숫자만 입력하세요.");
		val.ContentsTime.focus();
		return;
	}

	if(IsNumber(val.BookPrice.value)==false) {
		alert("교재비는 숫자만 입력하세요.");
		val.BookPrice.focus();
		return;
	}

	Yes = confirm("등록하시겠습니까?");
	if(Yes==true) {
		val.submit();
	}
}
//-->
</SCRIPT>
<?
mysqli_close($connect);
?>