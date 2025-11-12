<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

if($ctype) {
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
if($ctype == "Y") $MenuName = "마이크로닝";
if($ctype == "Z") $MenuName = "숏폼";

$str = Replace_Check($str);

if($str=="A") {
	$ContentsRegResult = "대기";
}
if($str=="B") {
	$ContentsRegResult = "<font color='blue'>등록</font>";
}
if($str=="C") {
	$ContentsRegResult = "<font color='red'>오류</font>";
}
?>
<!-- <script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script> -->
<script type="text/javascript">
<!--
	function CheckAll() {

	val = document.Form2;

	checkbox_count = $("input[id='check_seq']").length;
	//alert(checkbox_count);


	if(checkbox_count==0) {
		alert("등록된 엑셀파일이 없습니다.");
		return;
	}

	if(checkbox_count > 1) {
		for (i=0; i<val.check_seq.length; i++) {
		if (val.cj.checked == true) {
			if(val.check_seq[i].disabled == false) {
				val.check_seq[i].checked = true;
			}
		}else{
			val.check_seq[i].checked = false;
		}
	}

	}else{
		if (val.cj.checked == true) {
			if(val.check_seq.disabled == false) {
				val.check_seq.checked = true;
			}
		}else{
			val.check_seq.checked = false;
		}

	}

}

function CheckedDelete() {

val = document.Form2;

checkbox_count = $("input[id='check_seq']").length;
//alert(checkbox_count);


if(checkbox_count==0) {
	alert("등록된 엑셀파일이 없습니다.");
	return;
}

var idx_value = "";

if(checkbox_count > 1) {
	for (i=0; i<val.check_seq.length; i++) {
		if(val.check_seq[i].checked == true) {
			idx_value += val.check_seq[i].value + "|";
		}
	}
}else{
	if(val.check_seq.checked == true) {
		idx_value += val.check_seq.value + "|";
	}
}

if(idx_value=="") {
	alert("삭제하려는 항목을 선택하세요.");
	return;
}

Yes = confirm("선택한 항목을 삭제하시겠습니까?");
if(Yes==true) {
	val.idx_value.value = idx_value;
	val.mode.value = "del";
	val.action = "chapter_select_delete.php";
	$("#BtnDelete").prop("disabled",true);
	$("#BtnSubmit").prop("disabled",true);
	val.submit();
}

}
//-->
</script>
<br><br>
<div class="tl pt15">
* 붉은색으로 표시된 항목은 오류가 예상되는 항목입니다.<br>
* 상태 설명 : 대기(엑셀을 업로드 후 등록 대기 상태), 처리중(DB 입력 처리중), 등록(정상적으로 등록 완료), 오류(DB입력 오류)
</div>

<form name="Form2" method="post" target="ScriptFrame">
	<input type="hidden" name="idx_value" id="idx_value">
	<input type="hidden" name="mode" id="mode">
	<div style="overflow-x:scroll; display:block; width: calc(100vw - 278px);">
		<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
<!-- 		<colgroup> -->
<!-- 			<col width="30px" /> -->
<!-- 			<col width="40px" /> -->
<!-- 			<col width="*" /> -->
<!-- 			<col width="*" /> -->
<!-- 			<col width="*" /> -->
<!-- 			<col width="*" /> -->
<!-- 			<col width="*" /> -->
<!-- 			<col width="*" /> -->
<!-- 			<col width="*" /> -->
<!-- 			<col width="*" /> -->
<!-- 			<col width="*" /> -->
<!-- 			<col width="*" /> -->
<!-- 			<col width="*" /> -->
<!-- 			<col width="50px" /> -->
<!-- 		</colgroup> --> 
		<tr>
			<th><input type="checkbox" name="cj" id="cj" onclick="CheckAll()" style="width:17px; height:17px; background:none; border:none;"></th>
			<th>번호</th>
            <th>과정코드</th>
            <th>유형</th>
            <th>기초차시 idx값</th>
            <th>정렬 순서</th>
            <th>상태</th>
		</tr>
		<?
		$error_count = 0;
		$i = 1;
		$bgcolor = "";

		$SQL = "SELECT * FROM ChapterExcelTemp WHERE ID='$LoginAdminID' ORDER BY idx ASC";
		$QUERY = mysqli_query($connect, $SQL);
		if($QUERY && mysqli_num_rows($QUERY))
		{
			while($ROW = mysqli_fetch_array($QUERY))
			{
				extract($ROW);

				if($i%2==0) {
					$bgcolor = "#f0f0f0";
				}else{
					$bgcolor = "#ffffff";
				}
				
				if(!$LectureCode) {
				    $str_LectureCode = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_LectureCode = $LectureCode;
				}
				if(!$ChapterType) {
				    $str_ChapterType = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_ChapterType = $ChapterType;
				}
				if(!$Sub_idx) {
				    $str_Sub_idx = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_Sub_idx = $Sub_idx;
				}
				if(!$OrderByNum) {
				    $str_OrderByNum = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_OrderByNum = $OrderByNum;
				}

				$sql4DuplicateIdx = "SELECT COUNT(*) AS cnt1 FROM Chapter where LectureCode='$LectureCode' AND Sub_idx = '$Sub_idx'";
				$query4DuplicateIdx = mysqli_query($connect, $sql4DuplicateIdx);
				if ($query4DuplicateIdx) {
				    $result = mysqli_fetch_assoc($query4DuplicateIdx);
				    $isDuplicatedIdx = $result['cnt1'];
				}
				
				if($isDuplicatedIdx > 0){
				    $error_count++;
				    $str_Sub_idx = $Sub_idx." <font color='red'> 중복(이미 해당 과정코드에 동일한 차시가 존재)</font>";
				}

				
				$sql4DuplicateOrderByNum = "SELECT COUNT(*) AS cnt2 FROM Chapter where LectureCode='$LectureCode' AND OrderByNum = '$OrderByNum'";
				$query4DuplicateOrderByNum = mysqli_query($connect, $sql4DuplicateOrderByNum);
				if ($query4DuplicateOrderByNum) {
				    $result = mysqli_fetch_assoc($query4DuplicateOrderByNum);
				    $isDuplicatedOrderByNum = $result['cnt2'];
				}
				
				if($isDuplicatedOrderByNum > 0){
				    $error_count++;
				    $str_OrderByNum = $OrderByNum."<font color='red'> 중복(이미 해당 과정코드에 동일한 정렬순서가 존재)</font>";
				}
		?>
		<tr bgcolor="<?=$bgcolor?>" >
			<td align="center" class="text01"><input type="checkbox" name="check_seq" id="check_seq" value="<?=$idx?>" style="width:17px; height:17px; background:none; border:none;"><br><img src="images/btn_edit04.gif" style="padding-top:5px; cursor:pointer" onclick="ChapterRegEdit('<?=$idx?>');"><?//=$idx?></td>
            <td align="center"><?=$i?></td>
            <td align="left"><?=$str_LectureCode?></td>
            <td align="left"><?=$str_ChapterType?></td>
            <td align="left"><?=$str_Sub_idx?></td>
            <td align="left"><?=$str_OrderByNum?></td>
			<td align="center"  class="text01"><span id="ContentsRegResult"><?=$ContentsRegResult?></span></td>
		</tr>
		<?
			$i++;
			}
		}else{
		?>
		<tr>
			<td height="50" align="center" bgcolor="#FFFFFF" class="text01" colspan="25">업로드한 엑셀파일이 없습니다.</td>
		</tr>
		<? } ?>
		</table>
	</div>
</form>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>&nbsp;</td>
		<td height="15">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="150" valign="top"><input type="button" id="BtnDelete" value="선택항목 삭제" onclick="CheckedDelete()" class="btn_inputLine01"></td>
		<td align="center" valign="top">
		<?if($error_count>0) {?>
		<span class="redB">오류 건수가 [ <?=number_format($error_count,0)?> ]건이 있습니다.</span>
		<?}else{?>
		<input type="button" id="BtnSubmit" value="차시 등록하기" onclick="ChapterRegistSubmitOk()" class="btn_inputBlue01">
		<?}?>
		</td>
		<td width="150" align="right" valign="top">&nbsp;</td>
	</tr>
</table>
<?
mysqli_close($connect);
?>