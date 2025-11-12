<?
//********************************************************************
// 교육진행보고서 메일 발송
// 교육담당자 메일로 발송
// → 메일발송 템플릿 모드 : email / 템플릿 코드 : hrd0631
//********************************************************************

include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$CompanyCode  = Replace_Check($CompanyCode);  //사업주 코드
$LectureStart = Replace_Check($LectureStart); //시작일
$LectureEnd   = Replace_Check($LectureEnd);   //종료일
$ServiceType  = Replace_Check($ServiceType);  //환급여부
$LectureCode  = Replace_Check($LectureCode);  //과정코드

//[1] 발송할 메세지 확인
$SqM = "SELECT * FROM SendMessage WHERE TemplateCode = 'hrd0631'";
$ResultM = mysqli_query($connect, $SqM);
$RowM = mysqli_fetch_array($ResultM);
if($RowM) {
    $Massage            = $RowM['Massage'];
    $TemplateCode 	    = $RowM['TemplateCode'];
    $TemplateMessage 	= $RowM['TemplateMessage'];
}
//[2]받을사람 메일주소 확인
$SqlS = "SELECT c.EduManagerEmail AS Email , s.ID FROM Company c LEFT JOIN Study s ON s.CompanyCode = c.CompanyCode WHERE c.CompanyCode = '$CompanyCode'";
$ResultS = mysqli_query($connect, $SqlS);
$RowS = mysqli_fetch_array($ResultS);
if($RowS) {
    $Email  = $RowS['Email'];
    $ID     = $RowS['ID'];
}

$downloadUrl = $SiteURL."/include/study_end_doc02.php?CompanyCode=$CompanyCode&LectureStart=$LectureStart&LectureEnd=$LectureEnd&ServiceType=$ServiceType&LectureCode=$LectureCode";

//[3]메일형식 작성
$subject = "[".$SiteName."] 훈련진행보고서 발송_교육담당자님 귀하";
$message2 = nl2br($Massage);
$Massage = "<div style='width:800px; margin:0 auto; padding-bottom:40px;'>
    	<div style='margin-top:40px; font-size:16px; line-height:1.8em;'>
        	<ul style='list-style-type: none;'>
            	<li>".$message2."</li>
                <li>교육진행보고서 : <a href='$downloadUrl'>다운로드</a></li>
        	</ul>
        </div>
    </div>";
$Massage_db = addslashes($Massage);

//[4]메일발송 로그 기록
//$maxno = max_number("idx","EmailSendLogForEduManager");
/*$SqlI = "INSERT INTO EmailSendLogForEduManager(idx, CompanyCode,  MassageTitle, Massage, Code, Email, InputID, RegDate)
         VALUES($maxno, '$CompanyCodeA' , '$subject', '$message2', 'N', '$Email', '$LoginAdminID', NOW())";
*/
$SqlI = "INSERT INTO EmailSendLogForEduManager( CompanyCode,  MassageTitle, Massage, Code, Email, InputID, RegDate)
         VALUES('$CompanyCode' , '$subject', '$Massage_db', 'N', '$Email', '$LoginAdminID', NOW())";

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