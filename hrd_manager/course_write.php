<?
$MenuType = "E";
$PageName = "course";
$ReadPage = "course_read";
?>
<? include "./include/include_top.php"; ?>
<?
if($ctype) {
    $_SESSION["ctype_session"] = $ctype;
}else{
    if($ctype_session) {
        $ctype = $ctype_session;
    }else{
        $ctype = "X";
        $_SESSION["ctype_session"] = $ctype;
    }
}
if($ctype == "X") $MenuName = "이러닝";
if($ctype == "Y") $MenuName = "숏폼";
if($ctype == "Z") $MenuName = "마이크로닝";
if($ctype == "W") $MenuName = "비환급";

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
	$Sql = "SELECT * FROM Course WHERE idx=$idx";
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
		$ContentsStart = substr($Row['ContentsStart'],0,10); //컨텐츠 유효 시작일
		$ContentsEnd = substr($Row['ContentsEnd'],0,10); //컨텐츠 유효 종료일
		$UploadDate = substr($Row['UploadDate'],0,10); //컨텐츠업로드 날짜
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
		$LegalEduReq = $Row['LegalEduReq'];
	}
}

if($attachFile) $attachFileView = "<A HREF='./direct_download.php?code=Course&file=".$attachFile."'><B>".$attachFile."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('attachFile','attachFileArea') class='btn_inputLine01'>";
if($PreviewImage) $PreviewImageView = "<img src='/upload/Course/".$PreviewImage."' width='150' align='absmiddle'>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('PreviewImage','attachFileArea') class='btn_inputLine01'>";
if($BookImage) $BookImageView = "<img src='/upload/Course/".$BookImage."' width='150' align='absmiddle'>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('BookImage','attachFileArea') class='btn_inputLine01'>";
if(!$ContentsURLSelect) $ContentsURLSelect = "A";
?>
<script type="text/javascript">
$(document).ready(function(){
	$("#ContentsStart").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$('#ContentsStart').val("<?=$ContentsStart?>");

	$("#ContentsEnd").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$('#ContentsEnd').val("<?=$ContentsEnd?>");

	$("#UploadDate").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$('#UploadDate').val("<?=$UploadDate?>");

	$("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:top; cursor:pointer;"); //이미지 버튼 style적용
});

//컨텐츠정보가져오기
function CourseCopy(ctype) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_White']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '750px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./course_copy.php', { t: '1111', ctype: ctype }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 50 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '150px',
				width: '1300px',
				left: body_width / 2 - 750,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

//과정분류Select
function CourseCategorySelect() {
	var Category1Selected = $('#Category1 option:selected').val();

	$("span[id='Category2Area']").load('./course_category_select.php', { Category1: Category1Selected }, function () {});
}

function CourseCategorySelectAfter(Category1, Category2) {
	$("span[id='Category2Area']").load('./course_category_select.php', { Category1: Category1, Category2: Category2 }, function () {});
}

</script>
    <div class="contentBody">
    	<h2><?=$MenuName?> 컨텐츠 관리 <?=$ScriptTitle?></h2>
        <div class="conZone">
			<?if($mode=="new" && $AdminWrite=="Y") {?>
			<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;">
				<tr>
					<td align="right">
						<input type="button" value="컨텐츠 정보 가져오기" onclick="CourseCopy('<?=$ctype?>')" class="btn_inputBlue01">
					</td>
				</tr>
			</table>
			<?}?>
			<form name="Form1" method="post" action="course_script.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				<INPUT TYPE="hidden" name="ctype" value="<?=$ctype?>">
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
        						<?while (list($key,$value)=each($UseYN_array)) {?>
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
    					<th>패키지콘텐츠 과정코드</th>
    					<td align="left"><input name="PackageLectureCode" id="PackageLectureCode" type="text"  size="30" value="<?=$PackageLectureCode?>"> </td>
    					<th>원격훈련일련번호 </td>
    					<td align="left"><input name="HrdSeq" id="HrdSeq" type="text"  size="30" value="<?=$HrdSeq?>"></td>
    				</tr>
    				<tr>
    					<th>과정분류</th>
    					<td align="left">
        					<select name="Category1" id="Category1" onchange="CourseCategorySelect()">
        						<option value="">-- 대분류 선택 --</option>
        						<?
        						$SQL = "SELECT * FROM CourseCategory WHERE Deep=1 AND UseYN='Y' AND Del='N' ORDER BY OrderByNum ASC, idx ASC";
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
    						<?=$ServiceType_array[$ctype]?>
    						<input type="hidden" name="ServiceType" id="ServiceType" value="<?=$ctype?>"/>
    					</td>
    				</tr>
    				<tr>
    					<th>과정명</th>
    					<td align="left" colspan="1"><input name="ContentsName" id="ContentsName" type="text"  size="80" value="<?=$ContentsName?>" maxlength="120"></td>
						<th>법정교육여부</th>
						<td align="left">
							<input type="radio" name="LegalEduReq" id="LegalEduReq1" value="Y" <?if($LegalEduReq=="Y") {?>checked<?}?>> <label for="LegalEduReq1">예</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="LegalEduReq" id="LegalEduReq2" value="N" <?if($LegalEduReq=="N") {?>checked<?}?>> <label for="LegalEduReq2">아니오</label>
						</td>
					</tr>
					<tr>
						<th>난이도(직급)</th>
    					<td align="left">
        					<select name="Keyword1" id="Keyword1">
        						<?
        						$SQL = "SELECT * FROM ContentsKeyword WHERE Category =1 ORDER BY OrderByNum";
        						//echo $SQL;
        						$QUERY = mysqli_query($connect, $SQL);
        						if($QUERY && mysqli_num_rows($QUERY)){
        							while($ROW = mysqli_fetch_array($QUERY)){
        						?>
        						<option value="<?=$ROW['idx']?>" <?if($ROW['idx']==$Keyword1) {?>selected<?}?>><?=$ROW['Keyword']?></option>
        						<?
        							}
        						}
        						?>
        					</select>
    					</td>
    					<th>직무분야</th>
    					<td align="left">
    						<select name="Keyword2" id="Keyword2">
        						<?
        						$SQL = "SELECT * FROM ContentsKeyword WHERE Category =2 ORDER BY OrderByNum";
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
                            <ul id="interestList" class="checkbox_wrap">
                            <?
                                $i           = 0;
                                $strHtml     = "";
                                $keyword3Arr = explode(',', $Keyword3);

                                $SQLA   = " SELECT aValue, idx AS keywordIdx FROM ArchiveQuestion WHERE aType = 'B' AND aDepth = 'step01' AND aGroup = 'A' AND aBind = 'col3' ORDER BY aOrder ASC ";
                                $QUERYA = mysqli_query($connect, $SQLA);
                                if( $QUERYA && mysqli_num_rows($QUERYA) ) {
                                    while( $ROWA = mysqli_fetch_array($QUERYA) ) {
                                        extract($ROWA);
                                        
                                        $isChecked = in_array($keywordIdx, $keyword3Arr) ? "checked" : "";

                                        $strHtml .= ' <li> ';
                                        $strHtml .= '   <input type="checkbox" name="Keyword3[]" id="InterestChk'.($i+1).'" value="'.$keywordIdx.'" '.$isChecked.' onclick="limitCheckboxSelection(this)"> ';
                                        $strHtml .= '   <label for="InterestChk'.($i+1).'">'.$aValue.'</label> ';
                                        $strHtml .= ' </li> ';
                                        $i++;
                                    }
                                }
                                echo $strHtml;
                            ?>
                            </ul>
    					</td>
					</tr>
					<tr>
    					<th>역량</th>
    					<td align="left" colspan="3">
                        <ul id="abilityList" class="checkbox_wrap">
                            <?
                                $i           = 0;
                                $strHtml     = "";
                                $keyword4Arr =  explode(',', $Keyword4);

                                $SQLA   = " SELECT aValue, idx AS keywordIdx FROM ArchiveQuestion WHERE aType = 'B' AND aDepth = 'step01' AND aGroup = 'A' AND aBind = 'col4' ORDER BY aOrder ASC ";
                                $QUERYA = mysqli_query($connect, $SQLA);
                                if( $QUERYA && mysqli_num_rows($QUERYA) ) {
                                    while( $ROWA = mysqli_fetch_array($QUERYA) ) {
                                        extract($ROWA);

                                        $isChecked = in_array($keywordIdx, $keyword4Arr) ? "checked" : "";

                                        $strHtml .= ' <li> ';
                                        $strHtml .= '   <input type="checkbox" name="Keyword4[]" id="AbilityChk'.($i+1).'" value="'.$keywordIdx.'" '.$isChecked.' onclick="limitCheckboxSelection2(this)"> ';
                                        $strHtml .= '   <label for="AbilityChk'.($i+1).'">'.$aValue.'</label> ';
                                        $strHtml .= ' </li> ';
                                        $i++;
                                    }
                                }
                                echo $strHtml;
                            ?>
                        </ul>

    					</td>
					</tr>
					<tr>
						<th>차시수</th>
    					<td bgcolor="#FFFFFF">
    						<input name="Chapter" id="Chapter" type="text"  size="5" value="<?=$Chapter?>" maxlength="3"> 차시
    					</td>
						<th>교육시간</th>
    					<td bgcolor="#FFFFFF"><input name="ContentsTime" id="ContentsTime" type="text"  size="5" value="<?=$ContentsTime?>" maxlength="3"> 분</td>
    				</tr>
    				<!-- 	
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
					 -->
    				<tr>
    					<th>컨텐츠 제작연도 기간</th>
    					<td bgcolor="#FFFFFF"><input name="ContentsStart" id="ContentsStart" type="text"  size="12" value="<?=$ContentsStart?>" readonly>  ~ <input name="ContentsEnd" id="ContentsEnd" type="text"  size="12" value="<?=$ContentsEnd?>" readonly> </td>
    					<th>컨텐츠 업로드 일자</th>
    					<td bgcolor="#FFFFFF"><input name="UploadDate" id="UploadDate" type="text"  size="12" value="<?=$UploadDate?>" readonly></td>
    				</tr>
    				<tr>
    					<th>교강사</th>
    					<td bgcolor="#FFFFFF"><input name="Professor" id="Professor" type="text"  size="50" value="<?=$Professor?>"> </td>
    					<th>수료기준</th>
    					<td bgcolor="#FFFFFF"><input name="PassTime" id="PassTime" type="text"  size="10" value="<?=$PassTime?>" maxlength="3" style="text-align:right"> 시간 이상</td>
    				</tr>
    				<tr>
    					<th>수강비용</th>
    					<td bgcolor="#FFFFFF" colspan="3">
    						<input name="Price" id="Price" type="text"  size="10" value="<?=$Price?>" maxlength="7" style="text-align:right"> 원&nbsp;&nbsp;|&nbsp;&nbsp;
        					<span class="redB">환급비용 </span>&nbsp;:&nbsp;
        					우선지원 : <input name="Price01View" id="Price01View" type="text"  size="10" value="<?=$Price01View?>" maxlength="7" style="text-align:right"> 원&nbsp;&nbsp;/&nbsp;&nbsp;
        					대규모 1000인 미만 : <input name="Price02View" id="Price02View" type="text"  size="10" value="<?=$Price02View?>" maxlength="7" style="text-align:right"> 원&nbsp;&nbsp;/&nbsp;&nbsp;
        					대규모 1000인 이상 : <input name="Price03View" id="Price03View" type="text"  size="10" value="<?=$Price03View?>" maxlength="7" style="text-align:right"> 원
    					</td>
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
        </div>
    </div>
	<!-- Right // -->
</div>
<!-- Content // -->
<SCRIPT LANGUAGE="JavaScript">
<?if($mode=="edit") {?>
CourseCategorySelectAfter(<?=$Category1?>,<?=$Category2?>);
<?}?>

function limitCheckboxSelection(clicked) {
    const checkedBoxes = document.querySelectorAll('input[name="Keyword3[]"]:checked');
    
    // 새로 체크할 때, 최대 3개 초과 방지
    if (clicked.checked && checkedBoxes.length > 3) {
        alert("최대 3개까지만 선택할 수 있습니다.");
        clicked.checked = false;
        return;
    }
}

function limitCheckboxSelection2(clicked) {
    const checkedBoxes2 = document.querySelectorAll('input[name="Keyword4[]"]:checked');
    
    // 새로 체크할 때, 최대 3개 초과 방지
    if (clicked.checked && checkedBoxes2.length > 3) {
        alert("최대 3개까지만 선택할 수 있습니다.");
        clicked.checked = false;
        return;
    }
}

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
	
	var Keyword1Selected = $("#Keyword1 option:selected").val();
	var Keyword2Selected = $("#Keyword2 option:selected").val();

    var Interestchecked = document.querySelectorAll('input[name="Keyword3[]"]:checked');
    var Abilitychecked = document.querySelectorAll('input[name="Keyword4[]"]:checked');

    if(Interestchecked.length === 0) {
		alert("관심분야를 선택하세요.");
		$("#Keyword3").focus();
		return;
	}

    if(Abilitychecked.length === 0) {
		alert("역량을 선택하세요.");
		$("#Keyword3").focus();
		return;
	}


	if(Category1Selected=="") {
		alert("과정분류 대분류를 선택하세요.");
		$("#Category1").focus();
		return;
	}
	if(Category2Selected=="") {
		alert("과정분류 중분류를 선택하세요.");
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
	if(Keyword1Selected=="") {
		alert("난이도(직급)를 선택하세요.");
		$("#Keyword1").focus();
		return;
	}
	if($("#Keyword2Selected").val()=="") {
		alert("직무분야를 선택하세요.");
		$("#Keyword2").focus();
		return;
	}
	// if($("#Keyword3").val()=="") {
	// 	alert("관심분야를 입력하세요.");
	// 	$("#Keyword3").focus();
	// 	return;
	// }

	// if($("#Keyword4").val()=="") {
	// 	alert("역량을 입력하세요.");
	// 	$("#Keyword4").focus();
	// 	return;
	// }
	if($("#Chapter").val()=="") {
		alert("차시수를 입력하세요.");
		$("#Chapter").focus();
		return;
	}
	if($("#Chapter").val()=="0") {
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
	if($("#ContentsStart").val()=="") {
		alert("컨텐츠 시작일을 입력하세요.");
		$("#ContentsStart").focus();
		return;
	}
	if($("#ContentsEnd").val()=="") {
		alert("콘텐츠 만료일을 입력하세요.");
		$("#ContentsEnd").focus();
		return;
	}
	if($("#UploadDate").val()=="") {
		alert("콘텐츠 업로드일을 입력하세요.");
		$("#UploadDate").focus();
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