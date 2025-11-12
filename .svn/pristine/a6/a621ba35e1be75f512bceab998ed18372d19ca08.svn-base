<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$ID = Replace_Check($ID);
$idx = Replace_Check($idx);
$Status = Replace_Check($Status);

//-----------------------------------------------------------
//[1]상태변경
//-----------------------------------------------------------
$Sql = "UPDATE LectureRequest2 SET Status='$Status' WHERE ID='$ID' AND idx=$idx";
$Row = mysqli_query($connect, $Sql);
if(!$Row) { //쿼리 실패시 에러카운터 증가
    $error_count++;
    $msg = "[상태변경 오류]";
}else{
    $msg = "등록 되었습니다.";
}


//-----------------------------------------------------------
//[2]Study테이블 등록
//-----------------------------------------------------------
//[2-1]해당 강의정보 구하기
$Sql2 = "SELECT * FROM LectureRequest2 WHERE idx=$idx AND ID='$ID'";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
if($Row2){
    $LectureCode = $Row2['LectureCode'];
    $LectureStart = $Row2['LectureStart'];
    $LectureEnd = $Row2['LectureEnd'];
    $Price = $Row2['Price']; //판매가
    $SubPrice = $Row2['SubPrice']; //정부지원금
    $PointPrice = $Row2['PointPrice']; //학습포인트
    $CouponPrice = $Row2['CouponPrice']; //쿠폰
    $RealPrice = $Row2['RealPrice']; //자부담금
}
//[2-2]교육과정 정보를 불러오기
$SqlA = "SELECT Price, Price01, Price02, Price03, Price01View, Price02View, Price03View, PackageYN, PackageRef, PackageLectureCode, TotalPassMid, TotalPassTest, TotalPassReport 
         FROM CourseCyber WHERE LectureCode='$LectureCode'";
$ResultA = mysqli_query($connect, $SqlA);
$RowA = mysqli_fetch_array($ResultA);

if($RowA) {
    $Price = $RowA['Price']; //교육비용
    $Price01 = $RowA['Price01']; //자부담금 일반훈련생
    $Price02 = $RowA['Price02']; //자부담금 취성패
    $Price03 = $RowA['Price03']; //자부담금 근로장려금
    
    $Price01View = $RowA['Price01View']; //교육비용 환급비용 - 일반훈련생
    $Price02View = $RowA['Price02View']; //교육비용 환급비용 - 취성패
    $Price03View = $RowA['Price03View']; //교육비용 환급비용 - 근로장려금
    
    $PackageYN = $RowA['PackageYN']; //패키지 강의 여부
    $PackageRef = $RowA['PackageRef']; //패키지 고유번호
    $PackageLectureCode = $RowA['PackageLectureCode']; //패키지에 포함된 강의코드 코드1|코드2|코드3
    
    $TotalPassMid = $RowA['TotalPassMid']; //중간평가 총점
    $TotalPassTest = $RowA['TotalPassTest']; //최종평가 총점
    $TotalPassReport = $RowA['TotalPassReport']; //과제 총점
}

//[2-3]수강 차수 구하기
$Sql3 = "SELECT idx FROM LectureTerme WHERE LectureCode='$LectureCode' AND LectureStart='$LectureStart' AND LectureEnd='$LectureEnd' AND ServiceType=4 AND OpenChapter=1";
$Result3 = mysqli_query($connect, $Sql3);
$Row3 = mysqli_fetch_array($Result3);

if($Row3) {//동일한 수강차수가 있다면
    $LectureTerme_idx = $Row3['idx'];
}else{ //수강차수가 없다면 신규 등록
    $LectureTerme_idx = max_number("idx","LectureTerme");
    $Sql3_L = "INSERT INTO LectureTerme(idx, LectureCode, LectureStart, LectureEnd, ServiceType, OpenChapter) 
                VALUES($LectureTerme_idx, '$LectureCode', '$LectureStart', '$LectureEnd', 4, 1)";
    $Row3_L = mysqli_query($connect, $Sql3_L);    
    if(!$Row3_L) { //쿼리 실패시 에러카운터 증가
        $error_count++;
    }
}

$StudyKey = $LectureTerme_idx."_".$ID; //수강중복체크값

//[2-4]Study테이블에 있는지 확인
$Sql = "SELECT COUNT(*) FROM Study WHERE StudyKey='$StudyKey'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$StudyKey_check = $Row[0];

//[2-4-1]Study테이블에 있으면, 안내문구
if($StudyKey_check>0) {
    $error_count++;
    $msg = "\\n------------------------------------------\\n\\n[동일한 과정·수강기간·서비스구분이 존재합니다.]";
//[2-4-2]Study테이블에 있으면, 안내문구
}else{
    //복습일자설정(학습종료일+7일)
    $indate_str = strtotime($LectureEnd."+7 days");
    $LectureReStudy = date("Y-m-d",$indate_str);
    
    //강의 입력
    $max_Seq = max_number("Seq","Study");
    $Sql_Input = "INSERT INTO Study(Seq, LectureTerme_idx, LectureCode, ServiceType, ID, LectureStart, LectureEnd, LectureReStudy, Progress, OpenChapter,
	                       			StudyKey, MidStatus, TestStatus, ReportStatus, Price, rPrice, rPrice2, rPrice3, rPrice4, rPrice5, rPrice6, PackageRef, PackageLevel, InputID, InputDate)
				VALUES($max_Seq, $LectureTerme_idx, '$LectureCode', 4, '$ID', '$LectureStart', '$LectureEnd', '$LectureReStudy', 0, 1,
					 '$StudyKey', 'N', 'N', 'N', $Price, $Price01View, $Price01, $Price02View, $Price03View, $Price02, $Price03, 0, 0, '$LoginAdminID', NOW())";
    $Row_Input = mysqli_query($connect, $Sql_Input);
	//echo $Sql_Input;
						
	if(!$Row_Input) { //쿼리 실패시 에러카운터 증가
	   $error_count++;
	   $msg = "[수강등록 오류]";
    }else{
	    $msg = "등록 되었습니다.";
	}						
}

if($error_count>0) {
    mysqli_query($connect, "ROLLBACK");
    $msg = "처리중 ".$error_count."건의 에러가 발생하였습니다.\\n\\n롤백 처리하였습니다.\\n\\n입력한 자료를 확인하세요.\\n\\n".$msg;
    echo $msg;
    echo $Sql_Input;
}else{
    mysqli_query($connect, "COMMIT");
    echo "Success";
}


mysqli_close($connect);
?>