<?
$MenuType = "D";
$PageName = "ability_question_manager";
$ReadPage = "ability_question_manager_read";
$ADepth_array = array(
    "step01" => "1단계", 
    "step02" => "2단계", 
    "step03" => "3단계"
);
reset($ADepth_array);

$AGroup_array = array(
    "A" => "일반", 
    "W" => "직무(실무자)", 
    "M" => "직무(관리자)",
    "C" => "공통",
    "L" => "리더십"
);

reset($AGroup_array);
?>
<? include "./include/include_top.php"; ?>
<?
$mode = Replace_Check($mode);
$idx = Replace_Check($idx);

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

if($mode!="new") {
	$Sql = "SELECT * FROM ArchiveQuestion WHERE idx=$idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);
	if($Row) {
        $aValue       = $Row['aValue']; //아이디 
        $aDepth       = $Row['aDepth']; //아이디 
        $aGroup       = $Row['aGroup']; //아이디 
        $aOrder       = $Row['aOrder']; //아이디 
        $aValueDetail = $Row['aValueDetail']; //아이디
	}
}
?>
	<div class="contentBody">
    	<h2>역량진단 문항관리 <?=$ScriptTitle?></h2>
        <div class="conZone">
			<form name="Form1" method="post" action="ability_question_manager_script.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" id="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" name="idx" id="idx" value="<?=$idx?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                	<colgroup>
                        <col width="120px" />
                        <col width="" />
					</colgroup>
                    <tr>
                        <th>단계</th>
                        <td>
        					<select name="aDepth">
        						<option value="">-- 단계 선택 --</option>
        						<? while (list($key,$value)=each($ADepth_array)) {?>
        						<option value="<?=$key?>" <?if($aDepth==$key) {?>selected<?}?>><?=$value?></option>
        						<?}?>
        					</select>
    					</td>
                  	</tr>
                  	<tr>
                        <th>타입</th>
                        <td>
        					<select name="aGroup">
        						<option value="">-- 타입 선택 --</option>
        						<?
                                while (list($key,$value)=each($AGroup_array)) {?>
        						<option value="<?=$key?>" <?if($aGroup==$key) {?>selected<?}?>><?=$value?></option>
        						<?}?>
        					</select>
    					</td>
                  	</tr>
                  	<tr>
                        <th>순서</th>
                        <td><input name="aOrder" id="aOrder" type="text"  size="11" value="<?=$aOrder;?>"></td>
                  	</tr>
                  	<tr>
                        <th>문항</th>
                        <td><input name="aValue" id="aValue" type="text"  size="100" value="<?=$aValue;?>"></td>
                  	</tr>
                  	<tr>
                        <th>문항 상세</th>
                        <td><textarea name="aValueDetail" id="aValueDetail" rows="5" cols="100" style="resize: none;" placeholder="내용을 입력해 주세요."><?=$aValueDetail;?></textarea></td>
                  	</tr>
                </table>
			</form>
            <div class="btnAreaTc02" id="SubmitBtn">
				<button type="button" name="SubmitBtn" id="SubmitBtn" class="btn btn_Blue" onclick="SubmitOk()"><?=$ScriptTitle?></button>
				<button type="button" name="ResetBtn" id="ResetBtn" class="btn btn_DGray line" onClick="location.reload();">다시 작성</button>
			</div>
			<div class="btnAreaTc02" id="Waiting" style="display:none"><strong>처리중입니다...</strong></div>
		</div>
	</div>
</div>
<SCRIPT LANGUAGE="JavaScript">
function SubmitOk() {
	val = document.Form1;

	<?if($mode=="new") {?>
	if($("#ID").val()=="") {
		alert("아이디를 입력하세요.");
		$("#ID").focus();
		return;
	}
	if($("#Pwd").val()=="") {
		alert("비밀번호를 입력하세요.");
		$("#Pwd").focus();
		return;
	}
	<?}?>

	if($("#aOrder").val()=="") {
		alert("순서를 입력하세요.");
		return;
	}

    if($("#aValue").val()=="") {
		alert("문항을 입력하세요.");
		return;
	}


	Yes = confirm("<?=$ScriptTitle?> 하시겠습니까?");
	if(Yes==true) {
		$("#SubmitBtn").hide();
		$("#Waiting").show();
		val.submit();
	}
}
</SCRIPT>
<? include "./include/include_bottom.php"; ?>