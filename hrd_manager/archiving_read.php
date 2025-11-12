<?
$MenuType = "F";
$PageName = "archiving";
$ReadPage = "archiving_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);

$Sql = "SELECT a.* , b.Name
               ,AES_DECRYPT(UNHEX(b.Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(b.Mobile),'$DB_Enc_Key') AS Mobile  
               ,c.CompanyName 
        FROM Archiving a
        LEFT JOIN Member b ON a.ID = b.ID 
        LEFT JOIN Company c ON b.CompanyCode = c.CompanyCode 
        WHERE a.idx=$idx AND a.Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
if($Row) {
    extract($Row);
    
    //$Email = InformationProtection($Email,'Email','S');
    //$Mobile = InformationProtection($Mobile,'Mobile','S');
    
	$file1 = html_quote($FileName1); //첨부파일1
	$RealFileName1 = $RealFileName1; //첨부파일1 실제파일명
}
?>
<SCRIPT LANGUAGE="JavaScript">
function DelOk() {
	del_confirm = confirm("현재 글을 삭제하시겠습니까?");
	if(del_confirm==true) {
		DeleteForm.submit();
	}
}
</SCRIPT>
	<div class="contentBody">
    	<h2>아카이빙</h2>
        <div class="conZone">
			<form name="DeleteForm" method="post" action="archiving_script.php" enctype="multipart/form-data" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="del">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
			</form>
            <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
    	        <colgroup>
                    <col width="120px" />
                    <col width="" />
                    <col width="120px" />
                    <col width="" />
            	</colgroup>              	
              	<tr>
                    <th>아이디</th>
                    <td><?=$ID?></td>
                    <th>이름</th>
                    <td><?=$Name?></td>
              	</tr>
              	<tr>
              		<th>이메일</th>
                    <td><?=$Email?></td>
                    <th>연락처</th>
                    <td><?=$Mobile?></td>
              	</tr>
              	<tr>
                    <th>등록일</th>
                    <td colspan=3><?=$RegDate?></td>
              	</tr>
              	<tr>
                    <th>문의 제목</th>
                    <td colspan=3><?=$Title?></td>
	            </tr>
			  	<tr>
                    <th>내용</th>
                    <td colspan=3>
    				<table border="0" width="970px">
    					<tr><td style="line-height:1.6em; letter-spacing:-0.02em; border:0px"><?=$Contents?></td></tr>
    				</table>
    				</td>
              	</tr>
				<tr>
					<th>첨부 파일</th>
					<td><A HREF="/include/download.php?idx=<?=$idx?>&code=Archiving&file=1"><?=$RealFileName1?></A></td>
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
			<form name="Form1" method="post" action="archiving_script.php" enctype="multipart/form-data" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="reply">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
                	<colgroup>
                        <col width="120px" />
                        <col width="" />
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
                  	</tr>
                  	<tr>
                        <th>작성자</th>
                        <td><input name="Name2" type="text"  size="30" value="<?=$Name2?>"></td> 
                  	</tr>
					<tr>
    					<th>답변 내용</th>
    					<td height="28"><textarea name="Contents2" id="Contents2" rows="10" cols="100" style="width:970px; height:420px; display:none;"><?=$Contents2?></textarea></td>
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
					</tr>
				</table>
			 </form>
        </div>
    </div>
</div>
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
function SubmitOk() {
	val = document.Form1;

	if(val.Name2.value=="") {
		alert("작성자를 입력하세요.");
		val.Name2.focus();
		return;
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

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>