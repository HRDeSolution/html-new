<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$CompanyCode  = Replace_Check($CompanyCode); //사업자번호
$LectureStart = Replace_Check($LectureStart);//시작일
$LectureEnd   = Replace_Check($LectureEnd);  //종료일
$LectureCode  = Replace_Check($LectureCode); //과정코드

$batchSize = 2; // 한번에 처리할 데이터 수
$offset = 0; //OFFSET 초기값
$hasMoreData = true; //데이터가 더 남아 있는지

while($hasMoreData){
    //[1]해당 조건(수강기간.사업주명)에 해당되는 데이터 확인
    $Sql = "SELECT s.LectureCode , s.LectureStart , s.LectureEnd , c.CompanyName , c.CompanyCode, s.ServiceType, s.ID
            FROM Study s
            LEFT JOIN Company c on s.CompanyCode = c.CompanyCode
            WHERE c.CompanyCode='$CompanyCode' AND s.LectureStart='$LectureStart' AND s.LectureEnd='$LectureEnd'
            ORDER BY s.Seq
            LIMIT $batchSize OFFSET $offset";
    $QUERY = mysqli_query($connect, $Sql);
    
    //결과 데이터 유무 확인
    if(mysqli_num_rows($QUERY) == 0){
        $hasMoreData = false; //더 이상 처리할 데이터 없음
        break;
    }
    
    //[2]데이터 개수만큼 while문
    while($ROW = mysqli_fetch_array($QUERY)){
        $LectureCodeA   = $ROW['LectureCode'];
        $LectureStartA  = $ROW['LectureStart'];
        $LectureEndA    = $ROW['LectureEnd'];
        $CompanyNameA   = $ROW['CompanyName'];
        $CompanyCodeA   = $ROW['CompanyCode'];
        $ServiceTypeA   = $ROW['ServiceType'];
        $IDA   = $ROW['ID'];
        
        //[3]해당 데이터가 마감테이블(StudyEnd)에 존재하는지 확인
        $SqlA = "SELECT  COUNT(*) FROM StudyEnd s
                 LEFT JOIN Company c on s.CompanyCode = c.CompanyCode
                 WHERE s.LectureStart = '$LectureStartA' and s.LectureEnd = '$LectureEndA' AND s.LectureCode = '$LectureCodeA' AND s.ID = '$IDA'";
        $ResultA = mysqli_query($connect, $SqlA);
        $ROWA = mysqli_fetch_array($ResultA);
        $TOT_NO = $ROWA[0];
        
        if($TOT_NO>0) {
            //[3-1]존재할 경우, Update
            $Sql1= "UPDATE StudyEnd SET StudyEndInputID='$LoginAdminID', StudyEndInputDate=NOW(), ResultViewInputID='$LoginAdminID', ResultViewInputDate=NOW()
                    WHERE LectureStart = '$LectureStartA' AND LectureEnd = '$LectureEndA' AND  CompanyCode = '$CompanyCodeA' AND ID = '$IDA' ";
            $Row1 = mysqli_query($connect, $Sql1);
            
            $Sql2 = "UPDATE Study SET StudyEnd='Y' WHERE LectureStart = '$LectureStartA' AND LectureEnd = '$LectureEndA' AND  CompanyCode = '$CompanyCodeA' ";
            $Row2 = mysqli_query($connect, $Sql2);
        }else{
            //[3-2]없을 경우, Insert
            $Sql1 = "INSERT INTO StudyEnd(CompanyCode, ServiceType, ID, LectureCode, LectureStart, LectureEnd, StudyEndInputID, StudyEndInputDate, ResultViewInputID, ResultViewInputDate)
                    VALUES('$CompanyCodeA', '$ServiceTypeA', '$IDA', '$LectureCodeA','$LectureStartA', '$LectureEndA', '$LoginAdminID', NOW(), '$LoginAdminID', NOW());  ";
            $Row1 = mysqli_query($connect, $Sql1);
            
            $Sql2 = "UPDATE Study SET StudyEnd='Y' WHERE LectureStart = '$LectureStartA' AND LectureEnd = '$LectureEndA' AND CompanyCode = '$CompanyCodeA' ";
            $Row2 = mysqli_query($connect, $Sql2);
        }
    }
    
    //OFFSET 증가
    $offset = $offset+$batchSize;
    
    //쿼리 실패시 에러카운터 증
    if(!$Row1) {
        $error_count++;
    }
    if(!$Row2) {
        $error_count++;
    }
}

if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	echo "N";
}else{
	mysqli_query($connect, "COMMIT");
	echo "Y";
}
mysqli_close($connect);
?>