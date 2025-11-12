<?
$MenuType = "D";
$PageName = "course_package";
$ReadPage = "course_package_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);

$Sql = "SELECT * FROM Course WHERE idx=$idx AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
if($Row) {
	$LectureCode = $Row['LectureCode']; //과정코드
	$UseYN = $Row['UseYN']; //사이트 노출
	$HrdCode = $Row['HrdCode']; //HRD-NET과정코드
	$ContentsName = html_quote($Row['ContentsName']); //과정명

	$PackageYN = $Row['PackageYN']; //패키지 유무
	$PackageRef = $Row['PackageRef']; //패키지 번호
	$PackageLectureCode = $Row['PackageLectureCode']; //패키지에 포함된 강의 코드

	$PackageRef_pad = PackageRefLeftString($PackageRef);
}
?>
<form name="ReadScriptForm2" method="GET" action="<?=$read_page?>">
<input type="hidden" name="idx" value="<?=$idx?>">
<input type="hidden" name="pg">
</form>
<?
##-- 페이지 조건
$page_size = 10;
$block_size = 10;
if(!$pg) $pg = 1;

$PackageLectureCode_Array = explode("|",$PackageLectureCode);

$LectureCode_list;
foreach ($PackageLectureCode_Array as $PackageLectureCode_Array_value) {
    if($LectureCode_list) $LectureCode_list = $LectureCode_list.", '".$PackageLectureCode_Array_value."'";
    else $LectureCode_list = "'".$PackageLectureCode_Array_value."'";
}


$Sql1 = "SELECT COUNT(*) FROM Course WHERE PackageYN='N' AND Del='N' AND LectureCode IN ($LectureCode_list)";
$Result1 = mysqli_query($connect, $Sql1);
$Row1 = mysqli_fetch_array($Result1);
$TOT_NO = $Row1[0];

##-- 페이지 클래스 생성
include_once("../include/include_page4.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
<SCRIPT LANGUAGE="JavaScript">
//삭제
function DelOk() {
	del_confirm = confirm("현재 컨텐츠를 삭제하시겠습니까?");
	if(del_confirm==true) {
		DeleteForm.submit();
	}
}

//강의검색
function PackageSearch() {
	$("span[id='PackageSearchResult']").html('<center><img src="/images/loader.gif" alt="로딩중" /></center>');

	var ContentsName = $('#ContentsName').val();

	$("span[id='PackageSearchResult']").load('./package_search.php', { ContentsName: ContentsName }, function () {});
}

//저장하기
function PackageChapterSave() {
	var LectureCode_value_temp_array = '';
	var LectureCode_value_temp_count = $("input[id='LectureCode_value_temp']").length;
	
	if (LectureCode_value_temp_count < 1) {
		Yes = confirm('패키지로 선택한 단과 컨텐츠가 없습니다.\n\n저장 하시겠습니까?');
		if (Yes == true) {
			$("input[id='PackageLectureCode']").val('');
			Form1.submit();
		} else {
			return;
		}
	} else {
		for (i = 0; i < LectureCode_value_temp_count; i++) {
			if (LectureCode_value_temp_array == '') {
				LectureCode_value_temp_array = $("input[id='LectureCode_value_temp']:eq(" + i + ')').val();
			} else {
				LectureCode_value_temp_array = LectureCode_value_temp_array + '|' + $("input[id='LectureCode_value_temp']:eq(" + i + ')').val();
			}
		}

		$("input[id='PackageLectureCode']").val(LectureCode_value_temp_array);
		
		Yes = confirm('저장 하시겠습니까?');
		if (Yes == true) {
			Form1.submit();
		}
	}
}

//페이징
function readRun2(num) {
	document.ReadScriptForm2.pg.value = num;
	document.ReadScriptForm2.submit();
}

//컨텐츠 일괄 등록
function PackageLectureCodeUpload(){
	Yes = confirm('컨테츠를 일괄등록 하시겠습니까?');
	if (Yes == true) {
		var currentWidth = $(window).width();
    	var LocWidth = currentWidth / 2;
    	var body_width = screen.width - 20;
    	var body_height = $('html body').height();
    
    	$("div[id='SysBg_White']").css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		}).show();
    
    	$("div[id='Roading']").css({
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		}).show();
    		
		UploadForm1.submit();
	}
}
</SCRIPT>
	<form name=UploadForm1 method="POST" action="package_lecturecode_upload.php" target="ScriptFrame">
		<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
		<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
	</form>
    <div class="contentBody">
    	<h2>패키지 컨텐츠 관리</h2>
        <div class="conZone">
			<input type="hidden" name="LectureCodeValue" id="LectureCodeValue" value="<?=$LectureCode?>">
			<form name="DeleteForm" method="post" action="course_package_script.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="del">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				<INPUT TYPE="hidden" name="LectureCode" value="<?=$LectureCode?>">
			</form>
            <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
            	<colgroup>
                    <col width="120px" />
                    <col width="" />
    				<col width="120px" />
                    <col width="" />
              	</colgroup>
				<tr>
					<th>과정코드</th>
					<td><span class="redB"><?=$LectureCode?></span></td>
					<th>HRD-NET 과정코드</th>
					<td><?=$HrdCode?></td>
					
				</tr>
				<tr>
					<th>과정명</th>
					<td> <?=$ContentsName?></td>
					<th>사용 여부</th>
					<td><?=$UseYN_array[$UseYN]?></td>
				</tr>
				<tr>
					<th>서비스 구분</th>
					<td>환급</td>
					<th>수강 제한</th>
					<td>8시간 수강제한</td>
				</tr>
				<tr>
					<th>진도시간 기준</th>
					<td>진도시간 기준 15시간(900분)이상</td>
					<th>진도체크방식</th>
					<td>시간</td>
				</tr>
				<tr>
					<th>모바일 지원</th>
					<td>사용</td>
					<th>수료기준</th>
					<td>진도율 : 15시간 이상</td>
				</tr>
            </table>
			<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
				<tr>
					<td align="left" width="150" valign="top"><input type="button" value="컨텐츠 삭제" onclick="DelOk()" class="btn_inputLine01"></td>
					<td align="center" valign="top">
					<input type="button" value="컨텐츠 수정" onclick="location.href='<?=$PageName?>_write.php?mode=edit&idx=<?=$idx?>&col=<?=$col?>&sw=<?=urlencode($sw)?>'" class="btn_inputBlue01"></td>
					<td width="150" align="right" valign="top"><input type="button" value="목록" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'" class="btn_inputLine01"></td>
				</tr>
			</table>
			<br><br>
			
			<?if($AdminWrite=="Y") {?>
			<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">패키지 강의 검색</span>
			</div>
			<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
              <colgroup>
                <col width="120px" />
                <col width="" />
              </colgroup>
				<tr>
					<th>강의 검색</th>
					<td> <input name="ContentsName" id="ContentsName" type="text"  size="100" value="" maxlength="120">&nbsp;<input type="button" value="검색" onclick="PackageSearch();" class="btn_inputSm01"></td>
				</tr>
				<tr>
					<th>검색 결과</th>
					<td> <span id="PackageSearchResult"></span></td>
				</tr>
            </table>
			<?}?>

			<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">패키지로 선택한 단과 컨텐츠</span>
				<input type="button" style="float: right;" value="컨텐츠 일괄 등록" onclick="Javascript:PackageLectureCodeUpload();" class="btn_inputSm01">
				<button type="button" name="ExcelOutBtn" id="ExcelOutBtn" style="float: right; margin-top: 3px; margin-right: 10px;" class="btn btn_Green line" onClick="location.href='course_package_excel.php?idx=<?=$idx?>'"><i class="fas fa-file-excel"></i> 엑셀 출력</button>				
			</div>
    		<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
    			<colgroup>
        			<!-- <col width="80px" />
        			<col width="100px" /> -->
        			<col width="100px" />
        			<col width="" />
        			<col width="100px" />
        			<col width="100px" />
        			<?if($AdminWrite=="Y") {?>
        			<col width="60px">
        			<?}?>
    		  	</colgroup>
				<tr>
        			<!-- <th>순서</th>
                    <th>순서 조정</th> -->
        			<th>강의 코드</th>
                    <th>과정명</th>
                    <th>수강 유형</th>
        			<th>차시수</th>
        			<?if($AdminWrite=="Y") {?>
        			<th>삭제</th>
        			<?}?>
				</tr>
    		</table>
			<table id="PackageCourseTable" width="100%" cellpadding="0" cellspacing="0" class="list_ty01">
				<colgroup>
    				<!-- <col width="80px" />
    				<col width="100px" /> -->
    				<col width="100px" />
    				<col width="" />
    				<col width="100px" />
    				<col width="100px" />
    				<?if($AdminWrite=="Y") {?>
    				<col width="60px">
    				<?}?>
			  	</colgroup>
        		<?
        		if($PackageLectureCode){
        		    $i = 1;
				    $SQL = "SELECT * FROM Course 
                            WHERE PackageYN='N' AND Del='N' AND LectureCode IN ($LectureCode_list)
                            ORDER BY idx LIMIT $PAGE_CLASS->page_start, $page_size";
				    //echo $SQL;
				    $QUERY = mysqli_query($connect, $SQL);
				    if($QUERY && mysqli_num_rows($QUERY)){
				        while($ROW = mysqli_fetch_array($QUERY)){
				           // extract($ROW);
        		?>
				<tr>
                    <!-- <td align="center"><?=$i?></td>
                    <td align="center"><input type="hidden" name="LectureCode_value_temp" id="LectureCode_value_temp" value="<?=$ROW['LectureCode']?>"><input type="button" value="▲" onclick="PackageChapterListMoveUp(this);" style="width:30px;"> <input type="button" value="▼" onclick="PackageChapterListMoveDown(this);" style="width:30px;"></td>  -->
        			<td align="center"><input type="hidden" name="LectureCode_value_temp" id="LectureCode_value_temp" value="<?=$ROW['LectureCode']?>"><?=$ROW['LectureCode']?></td>
        			<td align="left"><?=$ROW['ContentsName']?></td>
                    <td align="center"><?=$ServiceType_array[$ROW['ServiceType']]?></td>
        			<td align="center"><?=$ROW['Chapter']?>차시</td>
        			<td><input type="button" value="삭제" onclick="Javascript:PackageChapterExamDelRow(this);" class="btn_inputSm01"></td>
          		</tr>
        		<?
                            $i++;
				        }
        			}
        		}
        		?>
        	</table>
        	
        	<!-- 페이징 -->
        	<?=$BLOCK_LIST?>
        	<!-- //페이징 -->
        	
    		<?if($AdminWrite=="Y") {?>
    		<form name="Form1" method="POST" action="package_lecture_script.php" target="ScriptFrame">
    			<input type="hidden" name="idx" id="idx" value="<?=$idx?>">
    			<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
    			<input type="hidden" name="PackageLectureCode" id="PackageLectureCode" value="<?=$PackageLectureCode?>">
    		</form>
    		<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="margin-top:20px">
    			<tr>
    				<td valign="top" ><input type="button" value="저장 하기" class="btn_inputBlue01" onclick="PackageChapterSave();"></td>
    			</tr>
    		</table>
    		<?}?>
        </div>
    </div>
</div>

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>