<?
$MenuType = "F";
$PageName = "lecture_event";
$ReadPage = "lecture_event_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);

$Sql = "SELECT a.ID , a.Stage , a.StageCount , a.Status , a.StatusRegDate , a.StatusName ,
               b.Name , AES_DECRYPT(UNHEX(b.Mobile ),'$DB_Enc_Key') AS Mobile 
        FROM LectureEvent a
        LEFT JOIN `Member` b ON a.ID = b.ID 
        WHERE a.idx=$idx  ";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
if($Row) {
    extract($Row);
}
?>
	<div class="contentBody">
    	<h2>이벤트관리</h2>
        <div class="conZone">
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
              		<th>스테이지</th>
                    <td><?=$Stage."Days"?></td>
                    <th>카운트</th>
                    <td><?=$StageCount?></td>
              	</tr>
              	<tr>
                    <th>전화번호</th>
                    <td colspan=3><?=$Mobile?></td>
              	</tr>
            </table>
            
			<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">상태 변경</span>
			</div>
			<form name="Form1" method="post" action="lecture_event_script.php" enctype="multipart/form-data" target="ScriptFrame">
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
                        <td><input name="StatusName" type="text"  size="30" value="<?=$StatusName?>"></td> 
                  	</tr>
                    <? if ($RegDate2) {?> 
                  	<tr>
                        <th>상태변경일자</th>
                        <td><?=$StatusRegDate?></td> 
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

	if(val.StatusName.value=="") {
		alert("작성자를 입력하세요.");
		val.StatusName.focus();
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