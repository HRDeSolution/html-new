<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$mode = Replace_Check($mode);
$LectureCode = Replace_Check($LectureCode);
$Chapter_seq = Replace_Check($Chapter_seq);
$ContentGubunOnly = Replace_Check($ContentGubunOnly);
$type = Replace_Check($type);

$Sql = "SELECT * FROM $type WHERE LectureCode='$LectureCode'";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
if($Row) {
	$ContentsName = html_quote($Row['ContentsName']); //과정명
}

if($mode!="new") {
	$Sql = "SELECT * FROM Chapter WHERE Seq=$Chapter_seq AND LectureCode='$LectureCode'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);
	if($Row) {
		$LectureCode = $Row['LectureCode']; //과정 코드
		$ChapterType = $Row['ChapterType']; //차시 구분
		$Sub_idx = $Row['Sub_idx']; //강의 또는 문제 idx값
		$OrderByNum = $Row['OrderByNum']; //정렬번호
	}
}

if(!$OrderByNum) {
	$query_select = "SELECT MAX(OrderByNum) FROM Chapter WHERE LectureCode='$LectureCode'";
	$result_select = mysqli_query($connect, $query_select);
	$result_row = mysqli_fetch_array($result_select);
	$max_no = $result_row[0];
	$OrderByNum = $max_no + 1;	
}

//차시 유형
if(!$ChapterType) {
	$ChapterType = "A";
}

$ContentsTR = "";
$ExamTR = "none";
$DiscussionTR = "none";

if($ChapterType=="A" && $mode=="edit") {
	$Sql = "SELECT Gubun FROM Contents WHERE idx=$Sub_idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$ContentGubun = $Row['Gubun']; //차시 구분
	}
}
?>
<div class="Content">
	<div class="contentBody">
		<h2>차시 구성</h2>
		<div class="conZone">
			<form name="Form1" method="post" action="chapter_regist_script.php" target="ScriptFrame">
    			<INPUT TYPE="hidden" name="mode" id="mode" value="<?=$mode?>">
    			<INPUT TYPE="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
    			<INPUT TYPE="hidden" name="Chapter_seq" id="Chapter_seq" value="<?=$Chapter_seq?>">
    			<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
			  		<colgroup>
        				<col width="120px" />
        				<col width="" />
			  		</colgroup>
			  		<tr>
        				<th>차시 유형</th>
        				<td>
    						<input type="hidden" name="ChapterType" id="ChapterType" value="A">강의차시&nbsp;&nbsp;
    						<input type="checkbox" name="ContentGubunOnly" id="ContentGubunOnly" value="Y" <?if($ContentGubunOnly=="Y") {?>checked<?}?> onclick="ChapterRegistReload('<?=$mode?>','<?=$LectureCode?>','<?=$Chapter_seq?>', '<?=$type?>')"> <label for="ContentGubunOnly">현재 강의와 일치하는 차시구분만 보기</label>
						</td>
			  		</tr>
			  		<tr id="ContentsTR" style="display:<?=$ContentsTR?>">
        				<th>차시 구분 선택</th>
        				<td>
            				<select name="ContentGubun" id="ContentGubun" onchange="ChapterContentsSelect('<?=$Sub_idx?>');" style="width:620px">
            					<option value="">-- 차시구분 선택 --</option>
            					<?
            					if($ContentGubunOnly=="Y") {
            						$ContentGubun_str = " AND Gubun='$ContentsName' ";
            					}
            					$SQL = "SELECT DISTINCT(Gubun) FROM Contents WHERE Del='N' $ContentGubun_str ORDER BY Gubun ASC";
            					//echo $SQL;
            					$QUERY = mysqli_query($connect, $SQL);
            					if($QUERY && mysqli_num_rows($QUERY)){
            						while($Row = mysqli_fetch_array($QUERY)){
            					?>
            					<option value="<?=$Row['Gubun']?>" <?if($Row['Gubun']==$ContentGubun) {?>selected<?}?>><?=$Row['Gubun']?></option>
            					<?
            						}
            					}
            					?>
            				</select>
            				<?if($mode=="new") {?>&nbsp;&nbsp;<input type="button" value="선택한 [차시 구분] 모두 등록하기" class="btn_inputSm01" onclick="ChapterContentsBatch();"><?}?>
        				</td>
  			  		</tr>
			  		<tr id="ContentsTR" style="display:<?=$ContentsTR?>">
						<th>기초 차시 선택</th>
						<td>
							<div id="Content_idx_div">
								<select name="Content_idx" id="Content_idx" style="width:100%">
                					<option value="">-- 기초 차시 선택 --</option>
                					<optgroup label="차시명 (하부 컨텐츠수)">
                				<?
                				if($mode!="new") {
                					$SQL = "SELECT *, (SELECT COUNT(*) FROM ContentsDetail WHERE Contents_idx=Contents.idx) AS ContentsDetail_Count FROM Contents WHERE Del='N' AND Gubun='$ContentGubun' ORDER BY RegDate ASC";
                					$QUERY = mysqli_query($connect, $SQL);
                					if($QUERY && mysqli_num_rows($QUERY)){
                						$i = 1;
                						while($Row = mysqli_fetch_array($QUERY)){
                				?>
                					<option value="<?=$Row['idx']?>" <?if($Row['idx']==$Sub_idx) {?>selected<?}?>><?=$i?>. <?=html_quote($Row['ContentsTitle'])?>  (<?=$Row['ContentsDetail_Count']?>) </option>
                				<?
                				    		$i++;
                						}
                					}
                				}
                				?>
                				</select>
                			</div>
                		</td>
			  		</tr>
			  		<tr>
        				<th>정렬 순서</th>
        				<td><input name="OrderByNum" id="OrderByNum" type="text"  size="5" value="<?=$OrderByNum?>" maxlength="3"></td>
					</tr>
				</table>
			</form>
			
			<!-- 버튼 -->
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
				<tr>
					<td align="left" width="200">&nbsp;</td>
					<td align="center">
    					<span id="SubmitBtn"><input type="button" value="등록 하기" onclick="ChapterSubmitOk();" class="btn_inputBlue01"></span>
    					<span id="Waiting" style="display:none"><strong>처리중입니다...</strong></span>
    				</td>
					<td width="200" align="right"><input type="button" value="닫  기" onclick="DataResultClose();" class="btn_inputLine01"></td>
				</tr>
			</table>
			<!-- //버튼 -->
		</div>
	</div>
</div>
<script>
function ChapterRegist(mode, LectureCode, Chapter_seq, ContentGubunOnly,type) {
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

	$('#DataResult').load('./chapter_regist.php', { mode: mode, LectureCode: LectureCode, Chapter_seq: Chapter_seq, ContentGubunOnly: ContentGubunOnly, type: type }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 750 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '750px',
				width: '1100px',
				left: body_width / 2 - 750,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

//동일차시 구성
function ChapterRegistReload(mode, LectureCode, Chapter_seq, type) {
	if ($("input:checkbox[id='ContentGubunOnly']").is(':checked') == true) {
		ContentGubunOnly_value = 'Y';
	} else {
		ContentGubunOnly_value = 'N';
	}
	ChapterRegist(mode, LectureCode, Chapter_seq, ContentGubunOnly_value, type);
}

//차시구분 선택에 따라 기초차시list 변동
function ChapterContentsSelect(Sub_idx) {
	var ContentGubun = $('#ContentGubun').val();
	
	$("div[id='Content_idx_div']").load('./chapter_content_select.php', { ContentGubun: ContentGubun, Sub_idx: Sub_idx }, function () {});
}

//등록하기
function ChapterSubmitOk() {
	val = document.Form1;
	var checked_value = $(':radio[name="ChapterType"]:checked').val();

	if (checked_value == 'A') {
		if ($('#Content_idx').val() == '') {
			alert('기초 차시를 선택하세요.');
			return;
		}
	}

	if ($('#OrderByNum').val() == '') {
		alert('정렬순서를 입력하세요.');
		return;
	}

	if (IsNumber($('#OrderByNum').val()) == false) {
		alert('정렬순서를 숫자만 입력하세요.');
		return;
	}

	Yes = confirm('등록 하시겠습니까?');
	if (Yes == true) {
		$('#SubmitBtn').hide();
		$('#Waiting').show();
		val.submit();
	}
}

//선택한차시구분에 따라 기초차시list
function ChapterContentsBatch() {
	var ContentGubun_value = $('select[id=ContentGubun] option:selected').val();
	var ContentGubun_value_text = $('select[id=ContentGubun] option:selected').text();

	if (ContentGubun_value == '') {
		alert('차시 구분을 선택하세요.');
		return;
	}

	var Content_idx_option_count = eval($('select[id=Content_idx] option').size());

	if (Content_idx_option_count < 2) {
		alert('선택한 차시구분에 등록된 기초차시가 없습니다.');
		return;
	}

	Yes = confirm('선택한 차시구분에 등록된 ' + (Content_idx_option_count - 1) + '개의 기초차시를\n\n모두 등록하시겠습니까?');
	if (Yes == true) {
		document.Form1.action = 'chapter_regist_batch.php';
		Form1.submit();
	}
}
</script>
<?
mysqli_close($connect);
?>