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
if($ctype == "Y") $MenuName = "숏폼";
if($ctype == "Z") $MenuName = "마이크로닝";
if($ctype == "W") $MenuName = "비환급";

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
    	val.action = "course_select_delete.php";
    	$("#BtnDelete").prop("disabled",true);
    	$("#BtnSubmit").prop("disabled",true);
    	val.submit();
    }
}
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
		<tr>
			<th><input type="checkbox" name="cj" id="cj" onclick="CheckAll()" style="width:17px; height:17px; background:none; border:none;"></th>
			<th>번호</th>
            <th>등급</th>
            <th>과정코드</th>
            <th>패키지콘텐츠 과정코드</th>
            <th>사이트노출</th>
            <th>컨텐츠 경로</th>
            <th>원격훈련일련번호</th>
            <th>과정분류1</th>
            <th>과정분류2</th>
            <th>과정명</th>
            <th>난이도(직급)</th>
            <th>직무분야</th>
            <th>관심분야</th>
            <th>역량</th>
            <th>차시수</th>
            <th>교육시간</th>
            <th>콘텐츠 시작일</th>
            <th>콘텐츠 종료일</th>
            <th>콘텐츠 업로드일</th>
            <th>교강사</th>
            <th>수료기준</th>
            <th>모바일지원</th>
            <th>교재비</th>
            <th>과정이미지</th>
            <th>과정소개</th>
            <th>교육대상</th>
            <th>교육목표</th>
            <th>교육비용 일반</th>
            <th>교육비용 우선지원</th>
            <th>교육비용 대규모 1000인 미만</th>
            <th>교육비용 대규모 1000인 이상</th>
            <th>상태</th>
		</tr>
		<?
		$error_count = 0;
		$i = 1;
		$bgcolor = "";

		$SQL = "SELECT * FROM CourseExcelTemp WHERE ID='$LoginAdminID' and Ctype = '$ctype' ORDER BY idx ASC";
		$QUERY = mysqli_query($connect, $SQL);
		if($QUERY && mysqli_num_rows($QUERY)){
			while($ROW = mysqli_fetch_array($QUERY)){
				extract($ROW);

				if($i%2==0) $bgcolor = "#f0f0f0";
				else $bgcolor = "#ffffff";
				
				if(!$LectureCode) {
				    $str_LectureCode = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_LectureCode = $LectureCode;
				}
				
				if(!$ClassGrade) {
				    $str_ClassGrade = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_ClassGrade = $ClassGrade;
				}
				
				if(!$UseYN) {
				    $str_UseYN = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_UseYN = $UseYN;
				}
				
				if(!$PackageLectureCode) $str_PackageLectureCode = "<font color='blue'>미입력</font>";
				else $str_PackageLectureCode = $PackageLectureCode;
				
				if(!$HrdSeq) $str_HrdSeq = "<font color='blue'>미입력</font>";
				else $str_HrdSeq = $HrdSeq;
				
				if(!$Category1) {
				    $str_Category1 = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_Category1 = $Category1;
				}
				
				if(!$Category2) {
				    $str_Category2 = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_Category2 = $Category2;
				}
				
				if(!$Keyword1) {
				    $str_Keyword1 = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_Keyword1 = $Keyword1;
				}
				
				if(!$Keyword2) {
				    $str_Keyword2 = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_Keyword2 = $Keyword2;
				}
				
				if(!$Keyword3) {
				    $str_Keyword3 = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_Keyword3 = $Keyword3;
				}
				
				if(!$Keyword4) {
				    $str_Keyword4 = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_Keyword4 = $Keyword4;
				}
				
				if(!$ServiceType) {
				    $str_ServiceType = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_ServiceType = $ServiceType;
				}
				
				if(!$ContentsName) {
				    $str_ContentsName = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_ContentsName = $ContentsName;
				}
				
				if(!$ContentsTime) {
				    $str_ContentsTime = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_ContentsTime = $ContentsTime;
				}
				
				if(!$Professor) $str_Professor = "<font color='blue'>미입력</font>";
				else $str_Professor = $Professor;
				
				if(!$PassTime) $str_PassTime = "<font color='blue'>미입력</font>";
				else $str_PassTime = $PassTime;
				
				if(!$Mobile) {
				    $str_Mobile = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_Mobile = $Mobile;
				}
				
				if(!$BookPrice) $str_BookPrice = "<font color='blue'>미입력</font>";
				else $str_BookPrice = $BookPrice;
								
				if(!$PreviewImage) $str_PreviewImage = "<font color='blue'>미입력</font>";
				else $str_PreviewImage = $PreviewImage;
				
				if(!$Intro) {
				    $str_Intro = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_Intro = $Intro;
				}
				
				if(!$EduTarget) {
				    $str_EduTarget = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_EduTarget = $EduTarget;
				}
				
				if(!$EduGoal) {
				    $str_EduGoal = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_EduGoal = $EduGoal;
				}
				
				if(!$ContentsURLSelect) {
				    $str_ContentsURLSelect = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_ContentsURLSelect = $ContentsURLSelect;
				}
				
				if(!$Chapter) {
				    $str_Chapter = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_Chapter = $Chapter;
				}
				
				if(!$ContentsStart) {
				    $str_ContentsStart = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_ContentsStart = date("Ymd", strtotime($ContentsStart));
				}
				
				if(!$ContentsEnd) {
				    $str_ContentsEnd = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_ContentsEnd = date("Ymd", strtotime($ContentsEnd));
				}
				
				if(!$UploadDate) {
				    $str_UploadDate = "<font color='red'>미입력</font>";
				    $error_count++;
				} else {
				    $str_UploadDate = date("Ymd", strtotime($UploadDate));
				}
				
				if(!$Price) $str_Price = "<font color='blue'>미입력</font>";
				else $str_Price = $Price;
				
				if(!$Price01View) $str_Price01View = "<font color='blue'>미입력</font>";
				else $str_Price01View = $Price01View;
				
				if(!$Price02View) $str_Price02View = "<font color='blue'>미입력</font>";
				else $str_Price02View = $Price02View;
				
				if(!$Price03View) $str_Price03View = "<font color='blue'>미입력</font>";
				else $str_Price03View = $Price03View;
				
				//Course 상에 동일한 LectureCode가 존재하는 경우 
				$sqlCheckDuplicate = "SELECT (SELECT COUNT(*) FROM Course WHERE LectureCode = '$LectureCode') AS courseCnt,
                                             (SELECT COUNT(*) FROM CourseExcelTemp WHERE LectureCode = '$LectureCode') AS courseExcelTempCnt";
				$queryResult = mysqli_query($connect, $sqlCheckDuplicate);
				
				if ($queryResult) {
				    $result = mysqli_fetch_assoc($queryResult);
				    $courseCnt = $result['courseCnt'];
				    $courseExcelTempCnt = $result['courseExcelTempCnt'];
				}
				
				if($courseCnt > 0){
				    $error_count++;
				    $str_LectureCode = $LectureCode." <font color='red'> 중복(이미 등록된 과정코드)</font>";
				}elseif($courseExcelTempCnt > 1){
				    $error_count++;
				    $str_LectureCode = $LectureCode." <font color='red'> 중복(등록하려는 데이터 중 동일 과정코드 존재)</font>";
				}
		?>
		<tr bgcolor="<?=$bgcolor?>" >
			<td align="center" class="text01"><input type="checkbox" name="check_seq" id="check_seq" value="<?=$idx?>" style="width:36px !important; height:17px; background:none; border:none;"><br><img src="images/btn_edit04.gif" style="padding-top:5px; cursor:pointer" onclick="CourseRegEdit('<?=$idx?>');"><?//=$idx?></td>
            <td align="center"><?=$i?></td>
            <td align="left"><?=$str_ClassGrade?></td>
            <td align="left"><?=$str_LectureCode?></td>
            <td align="left"><?=$str_PackageLectureCode?></td>
            <td align="left"><?=$str_UseYN?></td>
            <td align="left"><?=$str_ContentsURLSelect?></td>
            <td align="left"><?=$str_HrdSeq?></td>
            <td align="left"><?=$str_Category1?></td>
            <td align="left"><?=$str_Category2?></td>
            <td align="left"><?=$str_ContentsName?></td>
            <td align="left"><?=$str_Keyword1?></td>
            <td align="left"><?=$str_Keyword2?></td>
            <td align="left"><?=$str_Keyword3?></td>
            <td align="left"><?=$str_Keyword4?></td>
            <td align="left"><?=$str_Chapter?></td>
            <td align="left"><?=$str_ContentsTime?></td>
            <td align="left"><?=$str_ContentsStart?></td>
            <td align="left"><?=$str_ContentsEnd?></td>
            <td align="left"><?=$str_UploadDate?></td>
            <td align="left"><?=$str_Professor?></td>
            <td align="left"><?=$str_PassTime?></td>
            <td align="left"><?=$str_Mobile?></td>
            <td align="left"><?=$str_BookPrice?></td>
            <td align="left"><?=$str_PreviewImage?></td>
            <td align="left"><?=$str_Intro?></td>
            <td align="left"><?=$str_EduTarget?></td>
            <td align="left"><?=$str_EduGoal?></td>
            <td align="left"><?=$str_Price?></td>
            <td align="left"><?=$str_Price01View?></td>
            <td align="left"><?=$str_Price02View?></td>
            <td align="left"><?=$str_Price03View?></td>
			<td align="center"  class="text01"><span id="ContentsRegResult"><?=$ContentsRegResult?></span></td>
		</tr>
		<?
			 $i++;
			}
		}else{
		?>
		<tr>
			<td height="50" align="center" bgcolor="#FFFFFF" class="text01" colspan="33">업로드한 엑셀파일이 없습니다.</td>
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
		<span class="redB">오류 건수가 [ <?=number_format($error_count,0)?> ]건이 있습니다. </span>
		<?}else{?>
		<input type="button" id="BtnSubmit" value="컨텐츠 등록하기" onclick="CourseRegistSubmitOk('<?=$ctype?>')" class="btn_inputBlue01">
		<?}?>
		</td>
		<td width="150" align="right" valign="top">&nbsp;</td>
	</tr>
</table>
<?
mysqli_close($connect);
?>