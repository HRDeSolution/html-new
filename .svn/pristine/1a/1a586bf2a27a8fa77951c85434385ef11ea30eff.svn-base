<?
$MenuType = "H";
$PageName = "flex_inquiry";
$ReadPage = "flex_inquiry_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);

$Sql = "SELECT *, AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(Phone),'$DB_Enc_Key') AS Phone FROM FlexInquiry WHERE idx=$idx AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
    $ServiceType = $Row['ServiceType']; //문의종류
    $CompanyName = $Row['CompanyName']; //회사명
    $Name        = $Row['Name']; //문의자이름
    $Phone       = $Row['Phone']; //전화번호
    $Email       = $Row['Email']; //이메일
    $Personnel   = $Row['Personnel']; //예상인원
    $Contents    = nl2br($Row['Contents']); //내용
    $RegDate     = $Row['RegDate']; //문의일
    $Status      = $Row['Status']; //상태
    $Name2       = $Row['Name2']; //답변자이름
    $Contents2   = nl2br($Row['Contents2']); //답변 내용
    $RegDate2    = $Row['RegDate2']; //답변등록일시
    $MdfDate2    = $Row['MdfDate2']; //답변수정일시
    $RegDate3    = $Row['RegDate3']; //문자발송일시
    $RegDate4    = $Row['RegDate4']; //메일발송일시
    
	//$Email = InformationProtection($Email,'Email','S');
	//$Phone = InformationProtection($Phone,'Mobile','S');
}
?>
	<div class="contentBody">
    	<h2>FLEX 문의</h2>
        <div class="conZone">
			<form name="DeleteForm" method="post" action="flex_inquiry_script.php" enctype="multipart/form-data" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="del">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
			</form>
            <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
            	<colgroup>
                    <col width="120px" />
                    <col width="250px" />
                    <col width="100px" />
                    <col width="250px" />
              	</colgroup>
              	<tr>
                    <th>문의종류</th>
                    <td colspan="3"><?=$Inquiry_type_array[$ServiceType]?></td>
              	</tr>
              	<tr>
                    <th>회사명</th>
                    <td><?=$CompanyName?></td>
                    <th>이름</th>
                    <td><?=$Name?></td>
              	</tr>
              	<tr>
                    <th>연락처</th>
                    <td><?=$Phone?></td>
                    <th>이메일</th>
                    <td><?=$Email?></td>
              	</tr>
              	<tr>
                    <th>예상인원</th>
                    <td><?=$Personnel?>명</td>
                    <th>문의일</th>
                    <td><?=$RegDate?></td>
              	</tr>
			  	<tr>
                    <th>내용</th>
                    <td colspan="3">
        				<table border="0" width="970px">
        					<tr>
        						<td style="border:0px"><?=$Contents?></td>
        					</tr>
        				</table>
    				</td>
              	</tr>
            </table>
			<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
				<tr>
					<td align="left" width="150" valign="top"><input type="button" value="삭 제" onclick="DelOk()" class="btn_inputLine01"></td>
					<td align="right" valign="top"><input type="button" value="목록" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'" class="btn_inputLine01"></td>
				</tr>
			</table>
			
			<br><br><br>
			<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">답변</span>
			</div>
			<form name="Form1" method="post" action="flex_inquiry_script.php" enctype="multipart/form-data" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="reply">
				<INPUT TYPE="hidden" name="idx" id="idx" value="<?=$idx?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
                	<colgroup>
                        <col width="120px" />
                        <col width="250px" />
                        <col width="100px" />
                        <col width="250px" />
                  	</colgroup>
                  	<tr>
                        <th>처리 상태</th>
                        <td>
        					<select name="Status" id="Status" style="width:120px">
        					<?while (list($key,$value)=each($CounselStatus_array)) {?>
        						<option value="<?=$key?>" <?if($Status==$key) {?>selected<?}?>><?=$value?></option>
        					<?}?>
        					</select>
    					</td>
    					<th>작성자</th>
                        <td>
                        	<?if($Name2){?>
                        	<?=$Name2?>
                        	<?}else{?>
                        	<input name="Name2" type="text"  size="30" value="<?=$Name2?>">
                        	<?}?>
                        </td>
                  	</tr>
                  	<tr>
                  		<th>문자 발송</th>
    					<td>
    						<button type="button" name="SendBtn" id="SendBtn" class="btn btn_Green line" style="width:150px;" onclick="FlexInquiryAnswer('sms')"><i class="xi-message"></i> 문자 발송</button>
    					</td>
    					<th>문자발송 일시</th>
                        <td><?if($RegDate3) echo $RegDate3; else echo"미발송";?></td>
                  	</tr>
                  	<tr>
                  		<th>메일 발송</th>
    					<td>
							<button type="button" name="SendBtn3" id="SendBtn3" class="btn btn_Blue line" style="width:150px;" onclick="FlexInquiryAnswer('Email')"><i class="xi-mail"></i> 메일 발송</button>
    					</td>
    					<th>메일발송 일시</th>
                        <td><?if($RegDate4) echo $RegDate4; else echo"미발송";?></td>
                  	</tr>
                  	<tr>
                        <th>답변등록 일시</th>
                        <td><?if($RegDate2) echo $RegDate2; else echo"-";?></td>
                        <th>답변수정 일시</th>
                        <td><?if($MdfDate2) echo $MdfDate2; else echo"-";?></td>
                  	</tr>
					<tr>
    					<th>답변 내용</th>
    					<td height="28"  colspan="3"><textarea name="Contents2" id="Contents2" rows="10" cols="100" style="width:970px; height:420px; display:none;"><?=$Contents2?></textarea></td>
					</tr>
                </table>
           		<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
					<tr>
    					<td align="left" width="150" valign="top"> </td>
    					<td align="center" valign="top">
        					<?if($AdminWrite=="Y") {?>
        					<span id="SubmitBtn"><input type="button" value="답변 하기" onclick="SubmitOk()" class="btn_inputBlue01"></span>
        					<span id="Waiting" style="display:none"><strong>처리중입니다...</strong></span>
        					<?}?>
    					</td>
    					<td width="150" align="right" valign="top"><input type="button" value="목록" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'" class="btn_inputLine01"></td>
					</tr>
				</table>
			</form>
        </div>
    </div>
</div>
<SCRIPT LANGUAGE="JavaScript">
function SubmitOk() {
	var ChkInsert = "<?=$RegDate2?>";
	val = document.Form1;

	if(ChkInsert == ""){
		if(val.Name2.value=="") {
			alert("작성자를 입력하세요.");
			val.Name2.focus();
			return;
		}
	}
	
	oEditors.getById["Contents2"].exec("UPDATE_CONTENTS_FIELD", []);
	if(document.getElementById("Contents2").value.length < 15) {
		alert("답변 내용을 15자 이상 입력해주세요");
		return;
	}

	Yes = confirm("등록하시겠습니까?");
	if(Yes==true) {
		$("#SubmitBtn").hide();
		$("#Waiting").show();
		val.submit();
	}
}
</SCRIPT>
<script type="text/javascript">
var oEditors = [];

// 추가 글꼴 목록
//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];

nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "Contents2",
	sSkinURI: "./smarteditor/SmartEditor2Skin.html",	
	htParams : {
		bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
		//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
		fOnBeforeUnload : function(){
			//alert("완료!");
		}
	}, //boolean
	fOnAppLoad : function(){
		//예제 코드
		//var sHTML = "";
		//oEditors.getById["contents"].exec("PASTE_HTML", [sHTML]);
	},
	fCreator: "createSEditor2"
});
</script>
<SCRIPT LANGUAGE="JavaScript">
    function DelOk() {
    	del_confirm = confirm("현재 글을 삭제하시겠습니까?");
    	if(del_confirm==true) {
    		DeleteForm.submit();
    	}
    }
    
    function ChangeOk() {
        change_confirm = confirm("상태를 변경하시겠습니까?");
    	if(change_confirm==true) {
    		ChangeForm.submit();
    	}
    }
</SCRIPT>

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>