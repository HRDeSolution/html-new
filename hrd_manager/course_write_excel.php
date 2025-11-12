<?
$MenuType = "E";
$PageName = "course";
// $ReadPage = "course_read";
?>
<? include "./include/include_top.php"; ?>
<?if($ctype) {
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
?>
<script type="text/javascript">
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
</script>
<div class="contentBody">
    <h2><?=$MenuName?> 엑셀 등록</h2>
    <b style="color:red;">***이 페이지에서 등록하는 데이터는 모두 "<?=$MenuName?>" 으로 등록이 됩니다. 다른 컨텐츠 유형으로 등록하시고 싶으시면 해당 컨텐츠 관리로 이동하셔서 업로드해주세요.</b><br><br>
    <div class="conZone">
		<form name="ExcelUpForm" method="post" action="course_excel_upload.php" enctype="multipart/form-data" target="ScriptFrame">
        	<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
            	<colgroup>
                    <col width="120px" />
                    <col width="" />
              	</colgroup>
              	<tr>
                	<th>등록 샘플</th>
                	<td>
                		<input type="button" value="양식 다운로드" class="btn_inputLine01" onclick="location.href='./sample/컨텐츠.xlsx'">&nbsp;&nbsp;&nbsp;&nbsp;
          				<input type="button" value="샘플 다운로드" class="btn_inputLine01" onclick="location.href='./sample/컨텐츠(샘플).xlsx'">
    				</td>
              	</tr>
              	<tr>
                    <th>파일 등록</th>
                    <td><input name="file" id="file" type="file"  size="60">&nbsp;&nbsp;&nbsp;&nbsp;
                		<span id="SubmitBtn"><input type="button" name="SubmitBtn" id="SubmitBtn" value="업로드 하기" class="btn_inputBlue01" onclick="UploadSubmitOk()"></span>
        				<span id="Waiting" style="display:none"><strong>처리중입니다. 잠시만 기다려 주세요...</strong></span>
        			</td>
              	</tr>
			</table>
		</form>
		<div id="ContentsUploadList"><br><br><br><center><img src="/images/loader.gif" alt="로딩중" /></center></div>
    </div>
</div>
</div>
<script type="text/javascript">
$(window).load(function() {
	CourseExcelUploadListRoading('A');
});
</script>
<!-- Footer -->
<? include "./include/include_bottom.php"; ?>