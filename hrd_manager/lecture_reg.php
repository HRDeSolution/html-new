<?
$MenuType = "A";
$PageName = "lecture_reg";
?>
<? include "./include/include_top.php"; ?>
<script type="text/javascript">
$(document).ready(function(){
	$("#LectureStart, #LectureEnd, #ExcelLectureStart, #ExcelLectureEnd").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$("#LectureStart, #LectureEnd, #ExcelLectureStart, #ExcelLectureEnd").val("");
	$("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:top; cursor:pointer;"); //이미지 버튼 style적용
	
	$("#LectureCode, #ExcelLectureCode, #ExcelTutor").select2();
	changeSelect2Style();
});

function SubmitOk() {
	val = document.Form1;

	if(val.LectureStart.value=="") {
		alert("수강기간을 선택하세요.");
		return;
	}

	if(val.LectureEnd.value=="") {
		alert("수강기간을 선택하세요.");
		return;
	}

	if($("#UserID").length<1 || $("#UserID").val()=="") {
		alert("수강생을 검색하세요.");
		return;
	}

	if($("#Tutor").length<1 || $("#Tutor").val()=="") {
		alert("첨삭강사를 검색하세요.");
		return;
	}

	if($("#SalesManagerTemp").length<1 || $("#SalesManagerTemp").val()=="") {
		alert("영업담당자를 검색하세요.");
		return;
	}

	if(val.OpenChapter.value=="") {
		alert("실시회차를 입력하세요.");
		return;
	}

	if(IsNumber(val.OpenChapter.value)==false) {
		alert("실시회차는 숫자만 입력하세요.");
		return;
	}

	Yes = confirm("등록 하시겠습니까?");
	if(Yes==true) {
		$("#SubmitBtn").hide();
		$("#Waiting").show();
		val.submit();
	}
}

function UploadSubmitOk() {
	val = document.ExcelUpForm;
	if(val.file.value=="") {
		alert("엑셀 파일을 선택하세요.");
		val.file.focus();
		return;
	}

	Yes = confirm("업로드 하시겠습니까?");
	if(Yes==true) {
		$("#UploadSubmitBtn").hide();
		$("#UploadWaiting").show();
		val.submit();
	}
}
</SCRIPT>
<style>
	.select2-dropdown {
	width: 400px !important;
	}
</style>
	<div class="contentBody">
    	<h2>수강등록 개별 등록</h2>
        <div class="conZone">
	        <form name="Form1" method="post" action="lecture_reg_script.php" target="ScriptFrame">
				<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
            		<colgroup>
                		<col width="120px" />
                		<col width="" />
                		<col width="120px" />
                		<col width="" />
            	  	</colgroup>
            		<tr>
            			<th>수강 기간</th>
            			<td><input name="LectureStart" id="LectureStart" type="text" size="12" value="" readonly>  ~  <input name="LectureEnd" id="LectureEnd" type="text" size="12" value="" readonly></td>
            			<th>복습 기간</td>
            			<td>종료일로부터 일주일</td>
            		</tr>
            		<tr>
            			<th>과정 선택</font></th>
            			<td>
            			<select name="LectureCode" id="LectureCode" onchange="LectureCodeSelected()">
            				<optgroup label="-- 과 정 명 | 과정 코드 | 서비스 구분 --">
                			<?
                			$SQL = "SELECT * FROM Course WHERE Del='N' AND PackageYN = 'Y' AND UseYN='Y' ORDER BY ContentsName ASC";
                			$QUERY = mysqli_query($connect, $SQL);
                			if($QUERY && mysqli_num_rows($QUERY)){
                				while($ROW = mysqli_fetch_array($QUERY)){
                			?>
            				<option value="<?=$ROW['LectureCode']?>"><?=$ROW['ContentsName']?> | <?=$ROW['LectureCode']?></option>
                			<?
                				}
                			}
                			?>
                			</select>
            			</td>
            			<th>비용수급사업장</t>
            			<td><input type="text" name="nwIno" id="nwIno" size="20" value=""></td>
            		</tr>
            		<tr>
            			<th>수강생</th>
            			<td><input type="text" name="TempSearchID" id="TempSearchID" size="20"> <button type="button" onclick="LectureRegIDSearch()" class="btn round btn_LBlue line"><i class="xi-search"></i> 검색</button>&nbsp;<span id="SearchIDResult"></span></td>
            			<th>첨삭 강사</th>
            			<td><input type="text" name="TempSearchTutor" id="TempSearchTutor" size="20"> <button type="button" onclick="LectureRegTutorSearch()" class="btn round btn_LBlue line"><i class="xi-search"></i> 검색</button>&nbsp;<span id="SearchTutorResult"></span></td>
            		</tr>
            		<tr>
            			<th>영업 담당자</th>
            			<td><input name="SalesName" id="SalesName" type="text"  size="20" value="<?=$SalesName?>"> <button type="button" onclick="SalesManagerSearch();" class="btn round btn_LBlue line"><i class="xi-search"></i> 검색</button>&nbsp;&nbsp;<span id="SalesManagerHtml"></span></td>
            			<th>진도율</th>
            			<td>
            			<select name="Progress" id="Progress" style="width:100px">
            				<option value="0">0%</option>
            				<option value="50">50%</option>
            				<option value="80">80%</option>
            				<option value="100">100%</option>
            			</select>
            			</td>
            		</tr>
            		<tr>
            			<th>개설 용도</th>
            			<td bgcolor="#FFFFFF">
            			<select name="ServiceType" id="ServiceType" style="width:150px">
            				<option value="A">패키지</option>
            				<option value="W">비환급</option>
            			</select>
            			</td>
            			<th>실시 회차</th>
            			<td><input type="text" name="OpenChapter" id="OpenChapter" size="10" value="1"></td>
            		</tr>
				</table>
            	<!-- 버튼 -->
				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
            		<tr>
            			<td>&nbsp;</td>
            			<td height="15">&nbsp;</td>
            			<td>&nbsp;</td>
            		</tr>
            		<tr>
            			<td width="100" valign="top">&nbsp;</td>
            			<td align="center" valign="top">
            			<span id="SubmitBtn"><button type="button" onclick="SubmitOk()" class="btn btn_Blue">등록 하기</button></span>
            			<span id="Waiting" style="display:none"><strong>처리중입니다...</strong></span>
            			</td>
            			<td width="100" align="right" valign="top">&nbsp;</td>
            		</tr>
            	</table>
            	<!-- //버튼 -->
        	</form>
            
        	<div class="btnAreaTl02">
        		<span class="fs16b fc333B sub_title2">수강등록 엑셀파일로 등록</span>
        	</div>
            
        	<form name="ExcelUpForm" method="post" action="lecture_reg_excel_upload.php" enctype="multipart/form-data" target="ScriptFrame">
            	<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
            		<colgroup>
            			<col width="7%" />
            			<col width="33%" />
            			<col width="7%" />
            			<col width="53%" />
            		</colgroup>
            		<tr>
            			<th>파일 등록</th>
            			<td align="left"> <input name="file" id="file" type="file" size="60">
            				<span id="UploadSubmitBtn"><button type="button" onclick="UploadSubmitOk()" class="btn round btn_Blue line"><i class="xi-upload"></i> 업로드 하기</button></span>
            				<span id="UploadWaiting" style="display:none"><strong>처리중입니다. 잠시만 기다려 주세요...</strong></span>
            			</td>
            			<th>등록 샘플</th>
            			<td align="left">
            				<button type="button" onclick="location.href='./sample/수강등록.xlsx'" class="btn round btn_Green line"><i class="xi-download"></i> 양식 다운로드</button>
            				<button type="button" onclick="location.href='./sample/수강등록(샘플).xlsx'" class="btn round btn_Green line"><i class="xi-download"></i> 샘플 다운로드</button>
            			</td>
            		</tr>
            	</table>
        	</form>
			
			<!-- 엑셀 list -->
			<div id="ExcelUploadList"><br><br><br><center><img src="/images/loader.gif" alt="로딩중" /></center></div>
			<!-- //엑셀 list -->
	
        	<script type="text/javascript">
        	$(window).load(function() {
        		ExcelUploadListRoading('A');
        	});
        	</script>
        </div>
    </div>
</div>

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>