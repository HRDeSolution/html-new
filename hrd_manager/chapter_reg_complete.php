<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;
$idx = Replace_Check($Seq);

//등록된 엑셀정보 불러오기
$Sql = "SELECT * FROM ChapterExcelTemp WHERE idx=$idx AND ID='$LoginAdminID'";
//echo $Sql."<BR>";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if ($Row) {
    $idx = $Row['idx']; // 고유 증가값
    $LectureCode = $Row['LectureCode']; // 고유 증가값
    $ChapterType = $Row['ChapterType']; // 고유 증가값
    $Sub_idx = $Row['Sub_idx']; // 고유 증가값
    $OrderByNum = $Row['OrderByNum']; // 고유 증가값
    $ID = $Row['ID']; // 등록자 아이디
}

// 특수문자 이스케이프 처리
$idx = addslashes($idx);
$LectureCode = addslashes($LectureCode);
$ChapterType = addslashes($ChapterType);
$Sub_idx = addslashes($Sub_idx);
$OrderByNum = addslashes($OrderByNum);
$ID = addslashes($ID);

$maxno = max_number("Seq","Chapter");

//상위 기초차시 등록
$Sql2 = "INSERT INTO Chapter (Seq, LectureCode, ChapterType, Sub_idx, OrderByNum, RegDate) 
            VALUES ($maxno, '$LectureCode', '$ChapterType', '$Sub_idx', $OrderByNum, NOW())";
$Row2 = mysqli_query($connect, $Sql2);

if(!$Row2) { //쿼리 실패시 에러카운터 증가
	$error_count++;
}

//등록 처리가 완료되면 엑셀 업로드 내역 삭제
if($error_count<1) {
	$Sql_d = "DELETE FROM ChapterExcelTemp WHERE idx=$idx AND ID='$LoginAdminID'";
	mysqli_query($connect, $Sql_d);
}

if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$msg = "<font color='red'>$Sql2</font>";
}else{
	mysqli_query($connect, "COMMIT");
	$msg = "<font color='blue'>등록</font>";
}

echo $msg;
mysqli_close($connect);
?>