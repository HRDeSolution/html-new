<?
//********************************************************************
// 교육종료 (수강기간 기준)
// (1)수강 마감 일괄 처리
// (2)수료증,교육결과보고서 파일 교육담당자 메일로 발송
//    → 메일발송 템플릿 모드 : email / 템플릿 코드 : hrd0630
//********************************************************************

include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$LectureStart = Replace_Check($LectureStart); //시작일
$LectureEnd   = Replace_Check($LectureEnd);   //종료일
$CompanyCode  = Replace_Check($CompanyCode);  //사업주 코드
$CompanyName  = Replace_Check($CompanyName);  //사업주명

$batchSize = 1000; // 한번에 처리할 데이터 수
$offset = 0; //OFFSET 초기값
$hasMoreData = true; //데이터가 더 남아 있는지

//********************************************************************
//(1) 수강마감 일괄처리
//********************************************************************
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

//********************************************************************
// (2)수료증,교육결과보고서 파일 교육담당자 메일로 발송
//    → 메일발송 템플릿 모드 : email / 템플릿 코드 : hrd0630
//********************************************************************

//[1] 발송할 메세지 확인
$SqM = "SELECT * FROM SendMessage WHERE TemplateCode = 'hrd0630'";
$ResultM = mysqli_query($connect, $SqM);
$RowM = mysqli_fetch_array($ResultM);
if($RowM) {
    $Massage            = $RowM['Massage'];
    $TemplateCode 	    = $RowM['TemplateCode'];
    $TemplateMessage 	= $RowM['TemplateMessage'];
}
//[2]받을사람 메일주소 확인
$SqlS = "SELECT c.EduManagerEmail AS Email FROM Company c WHERE c.CompanyCode = '$CompanyCode'";
$ResultS = mysqli_query($connect, $SqlS);
$RowS = mysqli_fetch_array($ResultS);
if($RowS) {
    $Email  = $RowS['Email']; //교육담당자 이메일주
    $ID     = "";            //교육담당자는 아이디가 없음.
}
$downloadUrlA = $SiteURL."/include/certificate_pdf02.php?LectureStart= $LectureStart&LectureEnd=$LectureEnd&CompanyCode=$CompanyCode&LectureCode=$LectureCode";
$downloadUrlB = $SiteURL."/include/archive_report.html?CompanyCode=$CompanyCode";

//[3]메일형식 작성 
$subject = "[".$SiteName."] 아카이브REPORT 및 수료증 발송_교육담당자님 귀하";
$message2 = nl2br($Massage);
$Massage = "<div style='width:800px; margin:0 auto; padding-bottom:40px;'>
    	<div style='margin-top:40px; font-size:16px; line-height:1.8em;'>
        	<ul style='list-style-type: none;'>
            	<li>".$message2."</li>
                <li>수료증 : <a href='$downloadUrlA'>다운로드</a></li>
                <li>아카이브REPORT : <a href='$downloadUrlB'>다운로드</a></li>
        	</ul>
        </div>
    </div>";
$Massage_db = addslashes($Massage);

//[4]메일발송 로그 기록
$maxno=0;
$SqlI = "INSERT INTO EmailSendLogForEduManager( CompanyCode,  MassageTitle, Massage, Code, Email, InputID, RegDate)
         VALUES('$CompanyCodeA' , '$subject', '$Massage_db', 'N', '$Email', '$LoginAdminID', NOW())";
$RowI = mysqli_query($connect, $SqlI);

//[5]메일발송 
$SiteEmail = "hrde@hrdeedu.co.kr";
$fromaddress = $SiteEmail;
$toaddress = $Email;
$body = $Massage."<img src='".$SiteURL."/lib/EmailRecive/email_recive.php?num=".$maxno."' width='0' height='0'>";
$fromname = $SiteName;

$send = nmail($fromaddress, $toaddress, $subject, $body, $fromname);


if($error_count>0) {
    mysqli_query($connect, "ROLLBACK");
    echo "N";
}else{
    if($SqlI && $send){
        mysqli_query($connect, "COMMIT");
        echo "Y";
    }else{
        mysqli_query($connect, "ROLLBACK");
        echo "N";
    }    
}

mysqli_close($connect);
?>