<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idxA = Replace_Check($idx); //인덱스
$mode = Replace_Check($mode);

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

$Sql = "SELECT * FROM SiteInfomation2 WHERE idx=$idxA";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
if($Row) {
    $idx       = $Row['idx'];
    $InfoName  = $Row['InfoName'];
    $InfoValue = $Row['InfoValue'];
    $UseYN     = $Row['UseYN'];
}
?>
	<div class="contentBody">
    	<h2>교육원 고유정보 <?=$ScriptTitle?></h2>
        <div class="conZone">
			<form name="Form1" method="post" action="site_info2_script.php" enctype="multipart/form-data" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
            	<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
              		<colgroup>
                		<col width="120px" />
                		<col width="" />
              		</colgroup>
              		<tr>
						<th>정보명</th>
						<td align="left"><input name="InfoName" id="InfoName" type="text"  size="80" <?if($mode!="new"){?>value="<?=$InfoName?>"<?}?> maxlength="120"></td>
					</tr>
					<tr>
						<th>정보내용</font></th>
						<td align="left"><input name="InfoValue" id="InfoValue" type="text"  size="80" <?if($mode!="new"){?>value="<?=$InfoValue?>"<?}?> maxlength="120"></td>
					</tr>
					<tr>
						<th>사용여부</font></th>
						<td align="left">
							<input type="radio" name="UseYN" id="UseYN1" value="Y" <?if($UseYN=="Y" || !$UseYN) {?>checked<?}?>><label for="UseYN1">사용</label>&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="UseYN" id="UseYN2" value="N" <?if($UseYN=="N") {?>checked<?}?>><label for="UseYN2">미사용</label>
						</td>
					</tr>
        		</table>
            </form>
            <div class="btnAreaTc02" id="SubmitBtn">
            	<input type="button" name="SubmitBtn" id="SubmitBtn" value="<?=$ScriptTitle?>" class="btn_inputBlue01" onclick="SubmitOk()">
            </div>
			<div class="btnAreaTc02" id="Waiting" style="display:none"><strong>처리중입니다...</strong></div>
		</div>
    </div>
</div>

<SCRIPT LANGUAGE="JavaScript">
function SubmitOk() {
	val = document.Form1;

	if(val.InfoName.value=="") {
		alert("정보명을 입력하세요.");
		val.InfoName.focus();
		return;
	}
	if(val.InfoValue.value=="") {
		alert("정보내용을 입력하세요.");
		val.InfoValue.focus();
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