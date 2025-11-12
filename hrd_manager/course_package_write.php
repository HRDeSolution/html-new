<?
$MenuType = "D";
$PageName = "course_package";
$ReadPage = "course_package_read";
?>
<? include "./include/include_top.php"; ?>
<?
$mode = Replace_Check($mode);
$idx = Replace_Check($idx);

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

if($mode!="new") {
	$Sql = "SELECT * FROM Course WHERE idx=$idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$LectureCode = $Row['LectureCode']; //과정코드
		$UseYN = $Row['UseYN']; //사이트 노출
		$HrdCode = $Row['HrdCode']; //HRD-NET과정코드
		$ContentsName = html_quote($Row['ContentsName']); //과정명
	}
}
?>
    <div class="contentBody">
        <h2>패키지 컨텐츠 관리 <?=$ScriptTitle?></h2>
        <div class="conZone">
			<form name="Form1" method="post" action="course_package_script.php" target="ScriptFrame">
    			<INPUT TYPE="hidden" name="mode" value="<?=$mode?>">
    			<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                	<colgroup>
                        <col width="120px" />
                        <col width="" />
        				<col width="120px" />
                        <col width="" />
                  	</colgroup>
                  	<tr>
                        <th>과정코드</th>
                        <td><?if($LectureCode) {?><input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>"><span class="redB"><?=$LectureCode?></span><?}else{?><input name="LectureCode" id="LectureCode" type="text"  size="10" value="<?=$LectureCode?>" maxlength="10"><?}?></td>
        				<th>사용 여부</th>
                        <td>
        				<select name="UseYN" id="UseYN">
    					<?while (list($key,$value)=each($UseYN_array)) {?>
        					<option value="<?=$key?>" <?if($UseYN==$key) {?>selected<?}?>><?=$value?></option>
    					<?
    					}
    					reset($UseYN_array);
    					?>
        				</select>
        				</td>
                  	</tr>
    			  	<tr>
                        <th>HRD-NET 과정코드</th>
                        <td colspan="3"><input name="HrdCode" id="HrdCode" type="text"  size="100" value="<?=$HrdCode?>" maxlength="120"></td>
                  	</tr>
    			  	<tr>
                        <th>과정명</th>
                        <td colspan="3"><input name="ContentsName" id="ContentsName" type="text"  size="100" value="<?=$ContentsName?>" maxlength="120"></td>
                  	</tr>
                </table>
            </form>
	  		<div class="btnAreaTc02" id="SubmitBtn">
            	<input type="button" name="SubmitBtn" id="SubmitBtn" value="<?=$ScriptTitle?>" class="btn_inputBlue01" onclick="SubmitOk()">
      			<input type="button" name="ResetBtn" id="ResetBtn" value="목록" class="btn_inputLine01" onclick="location.href='<?=$PageName?>.php'">
            </div>
			<div class="btnAreaTc02" id="Waiting" style="display:none"><strong>처리중입니다...</strong></div>
        </div>
    </div>
</div>
<SCRIPT LANGUAGE="JavaScript">
function SubmitOk() {
	val = document.Form1;

	<?if($mode=="new") {?>
	if($("#LectureCode").val()=="") {
		alert("과정코드를 입력하세요.");
		$("#LectureCode").focus();
		return;
	}
	if($("#LectureCode").val().length<4 || $("#LectureCode").val().length>10) {
		alert("과정코드는 영문 대문자, 숫자로 4자 이상, 10자 이하로 입력하세요.");
		$("#LectureCode").focus();
		return;
	}
	if(LectureCodeCheck($("#LectureCode").val())==false) {
		alert("과정코드는 영문 대문자, 숫자로 입력하세요.");
		$("#LectureCode").focus();
		return;
	}
	<?}?>

	if($("#ContentsName").val()=="") {
		alert("과정명을 입력하세요.");
		$("#ContentsName").focus();
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
<!-- Footer -->
<? include "./include/include_bottom.php"; ?>