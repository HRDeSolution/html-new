<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);
$ctype = Replace_Check($ctype); //메뉴구분 (A: BEST컨텐츠관리 /B: NEW컨텐츠관리)
$gubun = Replace_Check($gubun); //컨텐츠구분 (1: 국민내일배움카드 /2: 평생교육바우처 /3: 직무스킬업)
$LectureCode = Replace_Check($LectureCode);
$idx_value = Replace_Check($idx_value);


$table;
if($ctype == "A"){
    $table = "BestContentsList";
}
if($ctype == "B"){
    $table = "NewContentsList";
}

$error_count = 0;

/* 과정추가하기 ---------------------------------------------------------------------------------------------- */
if($mode=="Add") {
	$Sql = "SELECT COUNT(*) FROM $table WHERE LectureCode='$LectureCode' AND gubun='$gubun'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);
	$TOT_NO = $Row[0];

	if($TOT_NO>0) {
?>
<script type="text/javascript">
<!--
	alert("이미 등록된 과정이 있습니다.");
//-->
</script>
<?
	   exit;
	}
	$maxno = max_number("idx",$table);
	
	$Sql = "INSERT INTO $table(idx, gubun, LectureCode, RegDate, RegID) VALUES($maxno, '$gubun', '$LectureCode', NOW(), '$LoginAdminID')";
	$Row = mysqli_query($connect, $Sql);
	if(!$Row) { //쿼리 실패시 에러카운터 증가
		$error_count++;
	}
}

/* 과정삭제하기 ---------------------------------------------------------------------------------------------- */
if($mode=="Delete") {
	$Sql = "DELETE FROM $table WHERE idx=$idx AND LectureCode='$LectureCode' AND gubun = '$gubun'";
	$Row = mysqli_query($connect, $Sql);
	if(!$Row) { //쿼리 실패시 에러카운터 증가
		$error_count++;
	}
}

/* 과정정렬하기 ---------------------------------------------------------------------------------------------- */
if($mode=="OrderByProc") {
	$idx_value_array = explode("|",$idx_value);

	$i = 1;
	
	foreach($idx_value_array as $idxA) {
	    $idxA = trim($idxA);
	    if($idxA) {
			$Sql = "UPDATE $table SET OrderByNum=$i WHERE idx=$idxA AND gubun = '$gubun'";
			$Row = mysqli_query($connect, $Sql);
			if(!$Row) { //쿼리 실패시 에러카운터 증가
				$error_count++;
			}
		}
	   $i++;
	}
}

$msg = "처리되었습니다.";

if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$msg = "처리중 ".$error_count."건의 DB에러가 발생하였습니다. 롤백 처리하였습니다. 데이터를 확인하세요.";
}else{
	mysqli_query($connect, "COMMIT");
}


mysqli_close($connect);
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	top.location.reload();
//-->
</SCRIPT>