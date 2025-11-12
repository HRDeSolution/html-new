<?
//********************************************************************
// 실시계획서 교육담당자에게 안내 메일 발송
//********************************************************************

include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$CompanyName = Replace_Check($CompanyName); //사업주명
//분기선택값
$Schedule = Replace_Check($Schedule);
$Schedule7 = Replace_Check($Schedule7);
$Schedule8 = Replace_Check($Schedule8);
//교육일
$LectureStart1 = Replace_Check($LectureStart1); //5대법정교육 시작일
$LectureEnd1 = Replace_Check($LectureEnd1); //5대법정교육 종료일
$LectureStart2 = Replace_Check($LectureStart2); //공공기관 일반기관 필수교육 시작일
$LectureEnd2 = Replace_Check($LectureEnd2); //공공기관 일반기관 필수교육 종료일
$LectureStart3 = Replace_Check($LectureStart3); //의료기관 법정교육 시작일
$LectureEnd3 = Replace_Check($LectureEnd3); //의료기관 법정교육 종료일
$LectureStart4 = Replace_Check($LectureStart4); //의료기관 인증 필수교육 시작일
$LectureEnd4 = Replace_Check($LectureEnd4); //의료기관 인증 필수교육 종료일
$LectureStart5 = Replace_Check($LectureStart5); //요양기관 법정교육 시작일
$LectureEnd5 = Replace_Check($LectureEnd5); //요양기관 법정교육 종료일
$LectureStart6 = Replace_Check($LectureStart6); //보육기관 법정교육 시작일
$LectureEnd6 = Replace_Check($LectureEnd6); //보육기관 법정교육 종료일
$LectureStart7 = Replace_Check($LectureStart7); //직무교육1 시작일
$LectureEnd7 = Replace_Check($LectureEnd7); //직무교육1 종료일
$LectureStart8 = Replace_Check($LectureStart8); //직무교육2 시작일
$LectureEnd8 = Replace_Check($LectureEnd8); //직무교육2 종료일
//교육과정
$lecture1_value = Replace_Check($lecture1_value); //5대법정교육
$lecture2_value = Replace_Check($lecture2_value); //공공기관 일반기관 필수교육
$lecture3_value = Replace_Check($lecture3_value); //의료기관 법정교육
$lecture4_value = Replace_Check($lecture4_value); //의료기관 인증 필수교육
$lecture5_value = Replace_Check($lecture5_value); //요양기관 법정교육
$lecture6_value = Replace_Check($lecture6_value); //보육기관 법정교육
$lecture7_value = Replace_Check($lecture7_value); //직무교육1
$lecture8_value = Replace_Check($lecture8_value); //직무교육2


//[1] 발송할 메세지 확인
$SqlM = "SELECT * FROM SendMessage WHERE TemplateCode = 'hrd0632'";
$ResultM = mysqli_query($connect, $SqlM);
$RowM = mysqli_fetch_array($ResultM);
if($RowM) {
    $Massage            = $RowM['Massage'];
    $TemplateCode 	    = $RowM['TemplateCode'];
    $TemplateMessage 	= $RowM['TemplateMessage'];
}
//[2]받을사람 메일주소 확인
//[2-1]교육담당자 소속 회사 코드 조회
$SqlS = "SELECT c.EduManagerEmail AS Email, CompanyCode FROM Company c WHERE c.CompanyName = '$CompanyName'";
$ResultS = mysqli_query($connect, $SqlS);
$RowS = mysqli_fetch_array($ResultS);
if($RowS) {
    $Email  = $RowS['Email']; //교육담당자 이메일주소
    $ID     = "";            //교육담당자는 아이디가 없음.
    $CompanyCodeA = $RowS['CompanyCode'];
}

$downloadUrl = $SiteURL."/include/practice_doc.php?CompanyName=$CompanyName&Schedule=$Schedule&Schedule7=$Schedule7&Schedule8=$Schedule8&LectureStart1=$LectureStart1&LectureEnd1=$LectureEnd1&LectureStart2=$LectureStart2&LectureEnd2=$LectureEnd2&LectureStart3=$LectureStart3&LectureEnd3=$LectureEnd3&LectureStart4=$LectureStart4&LectureEnd4=$LectureEnd4&LectureStart5=$LectureStart5&LectureEnd5=$LectureEnd5&LectureStart6=$LectureStart6&LectureEnd6=$LectureEnd6&LectureStart7=$LectureStart7&LectureEnd7=$LectureEnd7&LectureStart8=$LectureStart8&LectureEnd8=$LectureEnd8&lecture1_value=$lecture1_value&lecture2_value=$lecture2_value&lecture3_value=$lecture3_value&lecture4_value=$lecture4_value&lecture5_value=$lecture5_value&lecture6_value=$lecture6_value&lecture7_value=$lecture7_value&lecture8_value=$lecture8_value&LoginAdminDepart=$LoginAdminDepart&LoginAdminName=$LoginAdminName&LoginAdminID=$LoginAdminID";

//[3]메일형식 작성
$subject = "[".$SiteName."] 실시계획서 안내 메일 발송_교육담당자님 귀하";
$message2 = nl2br($Massage);
$Massage = "<div style='width:800px; margin:0 auto; padding-bottom:40px;'>
            	<div style='margin-top:40px; font-size:16px; line-height:1.8em;'>
                	<ul style='list-style-type: none;'>
                    	<li>".$message2."</li>
                        <li>실시계획서 : <a href='$downloadUrl'>다운로드</a></li>
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