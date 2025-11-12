<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);

$Sql = "SELECT * FROM ChapterExcelTemp WHERE idx=$idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
    $idx = $Row['idx']; // 고유 증가값
    $LectureCode = $Row['LectureCode']; // 과정코드
    $ChapterType = $Row['ChapterType']; // 타입
    $Sub_idx = $Row['Sub_idx']; // 기초차시 idx
    $OrderByNum = $Row['OrderByNum']; // 순서값
    $ID = $Row['ID']; // 등록자 아이디
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
			
			<form name="EditForm" method="post" action="chapter_edit_script.php" target="ScriptFrame">
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
    					<th>과정코드</th>
    					<td align="left" colspan="3">
        					<input name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
    					</td>
    					<th>유형</th>
    					<td colspan="3" align="left">
    						<input name="ChapterType" id="ChapterType" type="text"  size="30" value="<?=$ChapterType?>"> 
						</td>
    				</tr>
    				<tr>
    					<th>기초차시 idx값</th>
    					<td align="left" colspan="3">
							<input name="Sub_idx" id="Sub_idx" value="<?=$Sub_idx?>"size="30">
    					</td>
    					<th>정렬순서</th>
						<td align="left" colspan="3">
							<input name="OrderByNum" id="OrderByNum" value="<?=$OrderByNum?>"size="30">
    					</td>
    				</tr>
				</table>
			</form>

			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
				<tr>
					<td align="left" width="200">&nbsp;</td>
					<td align="center">
					<span id="EditSubmitBtn"><input type="button" value="수정 하기" onclick="ChapterEditSubmitOk();" class="btn_inputBlue01"></span>
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
function ChapterEditSubmitOk() {

	val = document.EditForm;

	if($("#LectureCode").val()=="") {
		alert("과정코드를 입력하세요.");
		$("#LectureCode").focus();
		return;
	}
	if($("#ChapterType").val()=="") {
		alert("유형을 입력하세요.");
		$("#ChapterType").focus();
		return;
	}
	if($("#Sub_idx").val()=="") {
		alert("기초차시 idx값을 입력하세요.");
		$("#Sub_idx").focus();
		return;
	}
	if($("#OrderByNum").val()=="") {
		alert("정렬순서를 입력하세요.");
		$("#OrderByNum").focus();
		return;
	}

// 	if(val.Sub_idx.value=="") {
// 		alert("기초차시 idx값을 입력하세요.");
// 		val.LectureTime.focus();
// 		return;
// 	}

	if(IsNumber(val.Sub_idx.value)==false) {
		alert("기초차시 idx값은 숫자만 입력하세요.");
		val.LectureTime.focus();
		return;
	}
	
	if(IsNumber(val.OrderByNum.value)==false) {
		alert("정렬순서는 숫자만 입력하세요.");
		val.LectureTime.focus();
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