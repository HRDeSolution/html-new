<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$LectureStart = Replace_Check($LectureStart); //수강기간 시작일
$LectureEnd = Replace_Check($LectureEnd); //수강기간 종료일
$LectureCode = Replace_Check($LectureCode); //강의 코드
$UserID = Replace_Check($UserID); //수강생 아이디
$Tutor = Replace_Check($Tutor); //첨삭강사 아이디
$ServiceType = Replace_Check($ServiceType); //개설용도
$Progress = Replace_Check($Progress); //진도율
$OpenChapter = Replace_Check($OpenChapter); //실시 회차
$SalesManagerTemp = Replace_Check($SalesManagerTemp); //영업담당자
$nwIno = Replace_Check($nwIno); //비용수급사업장

$LectureStart2 = $LectureStart." 00:01:05";
$LectureEnd2 = $LectureEnd." 23:59:55";

$indate_str = strtotime($LectureEnd."+1 week");
$LectureReStudy = date("Y-m-d",$indate_str);

$msg = "초기";

//회원정보에서 소속 사업주 사업자번호와 이름 조회
$Sql = "SELECT CompanyCode, Name FROM Member WHERE ID='$UserID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$CompanyCode = $Row['CompanyCode'];
	$Name = $Row['Name'];
}

//사업자 번호가 있다면 교육비 산정을 위해 회사규모를 구한다.
if($CompanyCode) {
	$Sql = "SELECT CompanyScale FROM Company WHERE CompanyCode='$CompanyCode'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$CompanyScale = $Row['CompanyScale'];
	}else{
		$CompanyScale = "C";
	}

}

//수강 차수 구하기
$Sql2 = "SELECT idx FROM LectureTerme 
         WHERE LectureCode='$LectureCode' AND LectureStart='$LectureStart' AND LectureEnd='$LectureEnd' AND ServiceType='$ServiceType' AND OpenChapter=$OpenChapter";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
if($Row2) { //동일한 수강차수가 있다면
	$LectureTerme_idx = $Row2['idx'];
}else{ //수강차수가 없다면 신규 등록
	$LectureTerme_idx = max_number("idx","LectureTerme");
	$Sql2_L = "INSERT INTO LectureTerme(idx, LectureCode, LectureStart, LectureEnd, ServiceType, OpenChapter)
               VALUES($LectureTerme_idx, '$LectureCode', '$LectureStart', '$LectureEnd', '$ServiceType', $OpenChapter)";
	$Row2_L = mysqli_query($connect, $Sql2_L);

	if(!$Row2_L) { //쿼리 실패시 에러카운터 증가
		$error_count++;
		$error_count1=$OpenChapter;
	}
}


//수강기간이 겹칠경우 방지
$Sql3 = " SELECT COUNT(*) FROM Study
          WHERE ID = '$UserID' AND LectureStart <= '$LectureEnd' AND LectureEnd >= '$LectureStart'";
$Result3 = mysqli_query($connect, $Sql3);
$Row3 = mysqli_fetch_array($Result3);
$LectureTerm_check = $Row3[0];


$StudyKey = $LectureTerme_idx."_".$UserID;

$Sql = "SELECT COUNT(*) FROM Study WHERE StudyKey='$StudyKey'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

$StudyKey_check = $Row[0];

if($StudyKey_check>0 || $LectureTerm_check>0) {
	$error_count++;
	$msg = "\\n------------------------------------------\\n\\n[동일한 과정·수강기간·서비스구분이 존재합니다.]";
}else{
	//강의 입력
    $max_Seq = max_number("Seq","Study");
	$Sql_Input = "INSERT INTO Study(Seq, LectureTerme_idx, LectureCode, ServiceType, Tutor, ID, CompanyCode, LectureStart, LectureEnd, LectureReStudy, 
						          Progress, OpenChapter, StudyKey, PackageRef, PackageLevel, InputID, InputDate, SalesID) 
				 VALUES($max_Seq, $LectureTerme_idx, '$LectureCode', '$ServiceType', '$Tutor', '$UserID', '$CompanyCode', '$LectureStart', '$LectureEnd', '$LectureReStudy', 
				        $Progress, $OpenChapter, '$StudyKey', 1, 0, '$LoginAdminID', NOW(), '$SalesManagerTemp')";
	$Row_Input = mysqli_query($connect, $Sql_Input);
	//echo $Sql_Input;

	if(!$Row_Input) { //쿼리 실패시 에러카운터 증가
		$error_count++;
		$msg = "[DB입력 오류]";
	}else{
		$msg = "등록 되었습니다.";
	}
}

//비용수급사업장이 등록된 경우 회원정보 수정
if($nwIno) {
	$Sql = "UPDATE Member SET nwIno='$nwIno' WHERE ID='$UserID'";
	$Row = mysqli_query($connect, $Sql);

	if(!$Row) { //쿼리 실패시 에러카운터 증가
		$error_count++;
		$msg = "[회원정보(비용수급사업장) 오류]";
	}
}

if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$msg = "처리중 ".$error_count."건의 에러가 발생하였습니다.\\n\\n롤백 처리하였습니다.\\n\\n입력한 자료를 확인하세요.\\n\\n".$msg;
	$ProcessOk = "N";
}else{
	mysqli_query($connect, "COMMIT");
	$ProcessOk = "Y";
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
	alert("<?=$msg?>");
	<?if($ProcessOk=="Y") {?>
	top.location.reload();
	<?}else{?>
	top.$("#SubmitBtn").show();
	top.$("#Waiting").hide();
	<?}?>
</SCRIPT>