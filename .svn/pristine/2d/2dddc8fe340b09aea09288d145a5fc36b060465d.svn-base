<?
$MenuType = "G";
$PageName = "course_flex";
$ReadPage = "course_flex_read";
?>
<? include "./include/include_top.php"; ?>
<?
$mode = Replace_Check($mode);
$idx = Replace_Check($idx);

if(!$mode) $mode = "new";

Switch ($mode) {
	case "new":
		$ScriptTitle = "등록";
	break;
	case "edit":
		$ScriptTitle = "수정";
	break;
	case "del":
		$ScriptTitle = "삭제";
	break;
}

if($mode!="new") {
	$Sql = "SELECT * FROM CourseFlex WHERE idx=$idx";
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
	}
}

if($attachFile) $attachFileView = "<A HREF='./direct_download.php?code=Course&file=".$attachFile."'><B>".$attachFile."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('attachFile','attachFileArea') class='btn_inputLine01'>";
if($PreviewImage) $PreviewImageView = "<img src='/upload/Course/".$PreviewImage."' width='150' align='absmiddle'>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('PreviewImage','attachFileArea') class='btn_inputLine01'>";
if($BookImage) $BookImageView = "<img src='/upload/Course/".$BookImage."' width='150' align='absmiddle'>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('BookImage','attachFileArea') class='btn_inputLine01'>";
if(!$ContentsURLSelect) $ContentsURLSelect = "A";
?>
<script type="text/javascript">
$(document).ready(function(){
	$("#ContentsPeriod").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$('#ContentsPeriod').val("<?=$ContentsPeriod?>");

	$("#ContentsAccredit").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$('#ContentsAccredit').val("<?=$ContentsAccredit?>");

	$("#ContentsExpire").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$('#ContentsExpire').val("<?=$ContentsExpire?>");

	$("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:top; cursor:pointer;"); //이미지 버튼 style적용
});
</script>
	<div class="contentBody">
    	<h2>컨텐츠 관리 <?=$ScriptTitle?></h2>
	        <div class="conZone">
    			<?if($mode=="new" && $AdminWrite=="Y") {?>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;">
					<tr>
						<td align="right">
							<input type="button" value="차시 정보 가져오기" onclick="CourseFlexCopy()" class="btn_inputBlue01">
							<input type="button" value="컨텐츠 정보 가져오기" onclick="CourseFlexCopy2()" class="btn_inputBlue01">
						</td>
					</tr>
				</table>
				<?}?>
				<form name="Form1" method="post" action="course_flex_script.php" target="ScriptFrame">
    				<INPUT TYPE="hidden" name="mode" value="<?=$mode?>">
    				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
    				<INPUT TYPE="hidden" name="ctype" value="C">
                    <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
						<colgroup>
                            <col width="180px" />
                            <col width="" />
        					<col width="180px" />
                            <col width="" />
                      	</colgroup>
                  		<tr>
							<th>등급 / 과정코드</th>
							<td align="left">
            					<select name="ClassGrade" id="ClassGrade">
            					<?while (list($key,$value)=each($ClassGrade_array)) {?>
            						<option value="<?=$key?>" <?if($ClassGrade==$key) {?>selected<?}?>><?=$value?></option>
            					<?
            					}
            					reset($ClassGrade_array);
            					?>
            					</select>&nbsp;&nbsp;/&nbsp;&nbsp;<?if($LectureCode) {?><input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>"><span class="redB"><?=$LectureCode?></span><?}else{?><input name="LectureCode" id="LectureCode" type="text"  size="10" value="<?=$LectureCode?>" maxlength="10"><?}?>
            				</td>
        					<th>사이트노출 / 컨텐츠 경로</th>
        					<td align="left">
            					<select name="UseYN" id="UseYN">
            						<?
            						while (list($key,$value)=each($UseYN_array)) {
            						?>
            						<option value="<?=$key?>" <?if($UseYN==$key) {?>selected<?}?>><?=$value?></option>
            						<?
            						}
            						reset($UseYN_array);
            						?>
            					</select>&nbsp;&nbsp;/&nbsp;&nbsp;
            					<input type="radio" name="ContentsURLSelect" id="ContentsURLSelect1" value="A" <?if($ContentsURLSelect=="A") {?>checked<?}?>> <label for="ContentsURLSelect1">주 경로</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="ContentsURLSelect" id="ContentsURLSelect2" value="B" <?if($ContentsURLSelect=="B") {?>checked<?}?>> <label for="ContentsURLSelect2">예비 경로</label>
        					</td>
						</tr>
        				<tr>
        					<th>심사코드</th>
        					<td align="left"><input name="PassCode" id="PassCode" type="text"  size="30" value="<?=$PassCode?>"> </td>
        					<th>HRD-NET 과정코드</td>
        					<td align="left"><input name="HrdCode" id="HrdCode" type="text"  size="30" value="<?=$HrdCode?>"></td>
        				</tr>
        				<tr>
        					<th>과정분류</th>
        					<td align="left">
            					<select name="Category1" id="Category1" onchange="CourseFlexCategorySelect()">
            						<option value="">-- 대분류 선택 --</option>
            						<?
            						$SQL = "SELECT * FROM CourseFlexCategory WHERE Deep=1 AND UseYN='Y' AND Del='N' ORDER BY OrderByNum ASC, idx ASC";
            						//echo $SQL;
            						$QUERY = mysqli_query($connect, $SQL);
            						if($QUERY && mysqli_num_rows($QUERY)){
            							while($ROW = mysqli_fetch_array($QUERY)){
            						?>
            						<option value="<?=$ROW['idx']?>" <?if($ROW['idx']==$Category1) {?>selected<?}?>><?=$ROW['CategoryName']?></option>
            						<?
            							}
            						}
            						?>
            					</select>&nbsp;&nbsp;<span id="Category2Area"></span>
        					</td>
        					<th>서비스 구분</th>
        					<td align="left">
            					<select name="ServiceType" id="ServiceType">
            						<?
            						if($ctype_session=="A") {
            							while (list($key,$value)=each($ServiceTypeCourse_array)) {
            						?>
            						<option value="<?=$key?>" <?if($ServiceType==$key) {?>selected<?}?>><?=$value?></option>
            						<?
            							}
            							reset($ServiceTypeCourse_array);
            						}else{
            							while (list($key,$value)=each($ServiceTypeCourse2_array)) {
            						?>
            						<option value="<?=$key?>" <?if($ServiceType==$key) {?>selected<?}?>><?=$value?></option>
            						<?
            							}
            							reset($ServiceTypeCourse2_array);
            						}
            						?>
            					</select>
        					</td>
        				</tr>
        				<tr>
        					<th>과정명</th>
        					<td align="left"><input name="ContentsName" id="ContentsName" type="text"  size="80" value="<?=$ContentsName?>" maxlength="120"></td>
        					<th>난이도</th>
        					<td align="left">
            					<select name="Keyword2" id="Keyword2" style="width: 70px;text-align: center;">
            						<?
            						$SQL = "SELECT * FROM ContentsFlexKeyword WHERE Category =2 ORDER BY OrderByNum";
            						//echo $SQL;
            						$QUERY = mysqli_query($connect, $SQL);
            						if($QUERY && mysqli_num_rows($QUERY)){
            							while($ROW = mysqli_fetch_array($QUERY)){
            						?>
            						<option value="<?=$ROW['idx']?>" <?if($ROW['idx']==$Keyword2) {?>selected<?}?>><?=$ROW['Keyword']?></option>
            						<?
            							}
            						}
            						?>
            					</select>
        					</td>					
						</tr>
						<tr>
        					<th>관심분야</th>
        					<td align="left" colspan="3">
        						<span class="redB">관심분야 입력 시, 키워드 앞에 # 을 붙여주세요.<br> (ex)#경영/전략 #프리젠테이션 #재무회계</span><br>
        						<input name="Keyword1" id="Keyword1" type="text"  size="150" value="<?=$Keyword1?>" maxlength="300">
        					</td>
						</tr>
						<tr>
        					<th>근무분야</th>
        					<td align="left" colspan="3">
        						<span class="redB">근무분야 입력 시, 키워드 앞에 # 을 붙여주세요.<br> (ex)#일반사무 #경영 #지부지사</span><br>
        						<input name="Keyword3" id="Keyword3" type="text"  size="150" value="<?=$Keyword3?>" maxlength="300">
        					</td>
						</tr>
						<tr>
							<th>차시수</th>
        					<td bgcolor="#FFFFFF">
        						<span class="redB">차시없는 컨테츠일 경우, '0'으로 입력해주세요.</span>&nbsp;&nbsp;&nbsp;
        						<input name="Chapter" id="Chapter" type="text"  size="5" value="<?=$Chapter?>" maxlength="3"> 차시
        					</td>
							<th>교육시간</th>
        					<td bgcolor="#FFFFFF"><input name="ContentsTime" id="ContentsTime" type="text"  size="5" value="<?=$ContentsTime?>" maxlength="3"> 분</td>
        				</tr>	
						<tr>
        					<th>컨텐츠 URL</th>
        					<td align="left" colspan="3">
        						<span class="redB">차시없는 컨테츠일 경우에만 입력해주세요.</span><br>
        						<input name="ContentsURL" id="ContentsURL" type="text"  size="150" value="<?=$ContentsURL?>" maxlength="300">
        					</td>
						</tr>
						<tr>
        					<th>모바일 URL</th>
        					<td align="left" colspan="3">
        						<span class="redB">차시없는 컨테츠일 경우에만 입력해주세요.</span><br>
        						<input name="MobileURL" id="MobileURL" type="text"  size="150" value="<?=$MobileURL?>" maxlength="300">
        					</td>
						</tr>
        				<tr>
        					<th>컨텐츠 유효기간</th>
        					<td bgcolor="#FFFFFF"><input name="ContentsPeriod" id="ContentsPeriod" type="text"  size="12" value="<?=$ContentsPeriod?>" readonly> </td>
        					<th>인정만료일</th>
        					<td bgcolor="#FFFFFF"><input name="ContentsAccredit" id="ContentsAccredit" type="text"  size="12" value="<?=$ContentsAccredit?>" readonly>  ~ <input name="ContentsExpire" id="ContentsExpire" type="text"  size="12" value="<?=$ContentsExpire?>" readonly></td>
        				</tr>
        				<tr>
        					<th>CP사</th>
        					<td bgcolor="#FFFFFF"><input name="Cp" id="Cp" type="text"  size="50" value="<?=$Cp?>"> </td>
        					<th>CP 수수료</th>
        					<td bgcolor="#FFFFFF"><input name="Commission" id="Commission" type="text"  size="10" value="<?=$Commission?>" maxlength="5" style="text-align:right"> %</td>
        				</tr>
        				<tr>
        					<th>모바일 지원</th>
        					<td bgcolor="#FFFFFF">
            					<select name="Mobile" id="Mobile">
            						<?
            						while (list($key,$value)=each($UseYN_array)) {
            						?>
            						<option value="<?=$key?>" <?if($Mobile==$key) {?>selected<?}?>><?=$value?></option>
            						<?
            						}
            						reset($UseYN_array);
            						?>
            					</select>
        					</td>
        					<th>교재비</th>
        					<td bgcolor="#FFFFFF"><input name="BookPrice" id="BookPrice" type="text"  size="10" value="<?=$BookPrice?>" maxlength="6" style="text-align:right"> 원</td>
        				</tr>
        				<tr>
        					<th>참고도서설명</th>
        					<td bgcolor="#FFFFFF"><input name="BookIntro" id="BookIntro" type="text"  size="80" value="<?=$BookIntro?>"></td>
        					<th>학습자료 등록</th>
        					<td bgcolor="#FFFFFF"><input name="attachFile" id="attachFile" type="hidden" value="<?=$attachFile?>"><span id="attachFileArea"><?=$attachFileView?></span>&nbsp;<input type="button" value="파일 첨부" onclick="UploadFile('attachFile','attachFileArea','text');" class="btn_inputLine01" ></td>
        				</tr>
        				<tr>
        					<th>과정 이미지</th>
        					<td bgcolor="#FFFFFF"><input name="PreviewImage" id="PreviewImage" type="hidden" value="<?=$PreviewImage?>"><span id="PreviewImageArea"><?=$PreviewImageView?></span>&nbsp;<input type="button" value="파일 첨부" onclick="UploadFile('PreviewImage','PreviewImageArea','img');" class="btn_inputLine01" ></td>
        					<th>교재 이미지</th>
        					<td bgcolor="#FFFFFF"><input name="BookImage" id="BookImage" type="hidden" value="<?=$BookImage?>"><span id="BookImageArea"><?=$BookImageView?></span>&nbsp;<input type="button" value="파일 첨부" onclick="UploadFile('BookImage','BookImageArea','img');" class="btn_inputLine01" ></td>
        				</tr>
        				<tr>
        					<th>과정소개</th>
        					<td align="left" colspan="3"><textarea name="Intro" id="Intro" style="width:80%; height:160px;"><?=$Intro?></textarea></td>
        				</tr>
        				<tr>
        					<th>교육대상</th>
        					<td align="left" colspan="3"><textarea name="EduTarget" id="EduTarget" style="width:80%; height:160px;"><?=$EduTarget?></textarea></td>
        				</tr>
        				<tr>
        					<th>교육목표</th>
        					<td align="left" colspan="3"><textarea name="EduGoal" id="EduGoal" style="width:80%; height:160px;"><?=$EduGoal?></textarea></td>
        				</tr>
					</table>
			
        			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
        				<tr>
        					<td>&nbsp;</td>
        					<td height="15">&nbsp;</td>
        					<td>&nbsp;</td>
        				</tr>
        				<tr>
        					<td width="100" valign="top">&nbsp;</td>
        					<td align="center" valign="top">
        					<span id="SubmitBtn"><input type="button" value="<?=$ScriptTitle?>" onclick="SubmitOk()" class="btn_inputBlue01"></span>
        					<span id="Waiting" style="display:none"><strong>처리중입니다...</strong></span>
        					</td>
        					<td width="100" align="right" valign="top"><img src="images/none.gif" width="4" height="5"><input type="button" value="목록" onclick="location.href='<?=$PageName?>.php'" class="btn_inputLine01"></td>
        				</tr>
					</table>
				</form>
            	<!-- ## END -->
            </div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->
<SCRIPT LANGUAGE="JavaScript">
<?if($mode=="edit") {?>
CourseFlexCategorySelectAfter(<?=$Category1?>,<?=$Category2?>);
<?}?>
function SubmitOk() {
	val = document.Form1;
	
	<?if($mode=="new") {?>
	if($("#LectureCode").val()=="") {
		alert("과정코드를 입력하세요.");
		$("#LectureCode").focus();
		return;
	}
	if($("#LectureCode").val().length<4 || $("#LectureCode").val().length>10) {
		alert("과정코드는 영문 대문자, 숫자로 4자 이상, 10자 이하로 입력하세요.");
		$("#LectureCode").focus();
		return;
	}
	if(LectureCodeCheck($("#LectureCode").val())==false) {
		alert("과정코드는 영문 대문자, 숫자로 입력하세요.");
		$("#LectureCode").focus();
		return;
	}
	<?}?>

	var Category1Selected = $("#Category1 option:selected").val();
	var Category2Selected = $("#Category2 option:selected").val();
	var Keyword2Selected = $("#Keyword2 option:selected").val();

	if(Category1Selected=="") {
		alert("과정분류 대분류를 선택하세요.");
		$("#Category1").focus();
		return;
	}
	if(Category2Selected=="") {
		alert("과정분류 소분류를 선택하세요.");
		$("#Category2").focus();
		return;
	}
	if($("#ServiceType").val()=="") {
		alert("서비스구분을 선택하세요.");
		$("#ServiceType").focus();
		return;
	}
	if($("#ContentsName").val()=="") {
		alert("과정명을 입력하세요.");
		$("#ContentsName").focus();
		return;
	}	
	if(Keyword2Selected=="") {
		alert("난이도를 선택하세요.");
		$("#Keyword2").focus();
		return;
	}
	if($("#Keyword1").val()=="") {
		alert("관심분야를 입력하세요.");
		$("#Keyword1").focus();
		return;
	}
	if($("#Keyword3").val()=="") {
		alert("근무분야를 입력하세요.");
		$("#Keyword3").focus();
		return;
	}
	if($("#Chapter").val()=="") {
		alert("차시수를 입력하세요.");
		$("#Chapter").focus();
		return;
	}
	if($("#Chapter").val()!="0") {
		if($("#ContentsURL").val()=="") {
			alert("컨텐츠URL을 입력하세요.");
			$("#ContentsURL").focus();
			return;
		}
		if($("#MobileURL").val()=="") {
			alert("모바일URL을 입력하세요.");
			$("#MobileURL").focus();
			return;
		}
	}
	if($("#ContentsTime").val()=="") {
		alert("교육시간을 입력하세요.");
		$("#ContentsTime").focus();
		return;
	}
	if(IsNumber($("#ContentsTime").val())==false) {
		alert("교육시간은 숫자만 입력하세요.");
		$("#ContentsTime").focus();
		return;
	}
	if($("#ContentsPeriod").val()=="") {
		alert("컨텐츠 유효기간을 입력하세요.");
		$("#ContentsPeriod").focus();
		return;
	}
	if($("#ContentsAccredit").val()=="") {
		alert("인정만료일 시작일을 입력하세요.");
		$("#ContentsAccredit").focus();
		return;
	}
	if($("#ContentsExpire").val()=="") {
		alert("인정만료일 종료일을 입력하세요.");
		$("#ContentsExpire").focus();
		return;
	}

	Yes = confirm("<?=$ScriptTitle?> 하시겠습니까?");
	if(Yes==true) {
		$("#SubmitBtn").hide();
		$("#Waiting").show();
		val.submit();
	}
}
</SCRIPT>
<!-- Footer -->
<? include "./include/include_bottom.php"; ?>