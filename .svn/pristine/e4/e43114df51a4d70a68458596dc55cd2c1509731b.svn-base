<?
$MenuType = "F";
$PageName = "contents_keyword";
$ReadPage = "contents_keyword_read";

include "../include/include_function.php";
include "./include/include_admin_check.php";

$cat = Replace_Check($cat); //카테고리 분류값
$idxA = Replace_Check($idx); //인덱스
$mode = Replace_Check($mode);

if(!$mode) {
    $mode = "new";
}
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
?>
    <div class="contentBody">
    	<h2>컨텐츠 키워드 <?=$ScriptTitle?></h2>
            <div class="conZone">
<?
$Sql = "SELECT * FROM ContentsKeyword WHERE idx=$idxA";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
    $idx = $Row['idx'];
    $Category = $Row['Category']; //과정분류
	$Keyword = $Row['Keyword']; //키워드
	$UseYN = $Row['UseYN']; //사용여부
}
?>
			<form name="DeleteForm" method="post" action="contents_keyword_script.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="del">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				<INPUT TYPE="hidden" name="Category" value="<?=$cat?>">
			</form>
            <!-- 입력 -->
			<form name="Form1" method="post" action="contents_keyword_script.php" enctype="multipart/form-data" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				<INPUT TYPE="hidden" name="Category" value="<?=$cat?>">
            	<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
              		<colgroup>
                		<col width="120px" />
                		<col width="" />
              		</colgroup>
              		<tr>
						<th>과정분류</th>
						<td>
						<?
						if($cat == 0){
						    echo "전체";
						}else{
						    echo $ContentsCategory1_array[$cat];
						}
						?>
						</td>
					</tr>
					<tr>
						<th>키워드</font></th>
						<td align="left"><input name="Keyword" id="Keyword" type="text"  size="80" <?if($mode!="new"){?>value="<?=$Keyword?>"<?}?> maxlength="120"></td>
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
                
            <!-- 버튼 -->
	  		<div class="btnAreaTc02" id="SubmitBtn">
            	<input type="button" name="SubmitBtn" id="SubmitBtn" value="<?=$ScriptTitle?>" class="btn_inputBlue01" onclick="SubmitOk()">
      			<?if($mode != "new"){?><input type="button" name="ResetBtn" id="ResetBtn" value="삭제" class="btn_inputLine01" onclick="DelOk()"><?}?>
            </div>
			<div class="btnAreaTc02" id="Waiting" style="display:none"><strong>처리중입니다...</strong></div>
		</div>
    </div>
</div>
    <!-- Content // -->
<SCRIPT LANGUAGE="JavaScript">
<!--
function SubmitOk() {
	val = document.Form1;

	if(val.Keyword.value=="") {
		alert("키워드를 입력하세요.");
		val.Keyword.focus();
		return;
	}
	Yes = confirm("등록하시겠습니까?");
	if(Yes==true) {
		$("#SubmitBtn").hide();
		$("#Waiting").show();
		val.submit();
	}
}

function DelOk() {
	del_confirm = confirm("현재 컨텐츠를 삭제하시겠습니까?");
	if(del_confirm==true) {
		DeleteForm.submit();
	}
}
//-->
</SCRIPT>