<?
$MenuType = "F";
$PageName = "cheating_report";
$ReadPage = "cheating_report_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);

$Sql = "SELECT a.*
               ,AES_DECRYPT(UNHEX(a.Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(a.Mobile),'$DB_Enc_Key') AS Mobile  
        FROM Cheating a
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
    	<h2>부정제보</h2>
        <div class="conZone">
			<form name="DeleteForm" method="post" action="cheating_script.php" enctype="multipart/form-data" target="ScriptFrame">
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
                    <th>제보회신방법</th>
                    <td><?=$Cheating_array[$Category]?></td>
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
            </table>
            
			<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
				<tr>
					<td align="left" width="150" valign="top"><input type="button" value="삭 제" onclick="DelOk()" class="btn_inputLine01"></td>
					<td align="right" valign="top"><input type="button" value="목록" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'" class="btn_inputLine01"></td>
				</tr>
			</table>
			<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">상태 변경</span>
			</div>
			<form name="Form1" method="post" action="cheating_script.php" enctype="multipart/form-data" target="ScriptFrame">
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
                    <? if ($RegDate2) {?> 
                  	<tr>
                        <th>답변일자</th>
                        <td><?=$RegDate2?></td> 
                  	</tr>
                    <?}?>
                </table>
                <table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
					<tr>
    					<td align="left" width="150" valign="top"> </td>
    					<td align="center" valign="top">
    					<?if($AdminWrite=="Y") {?>
    					<span id="SubmitBtn"><input type="button" value="상태 변경" onclick="SubmitOk()" class="btn_inputBlue01"></span>
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
	val = document.Form1;

	if(val.Name2.value=="") {
		alert("작성자를 입력하세요.");
		val.Name2.focus();
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