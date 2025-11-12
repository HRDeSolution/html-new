<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$seq_value  = Replace_Check($seq_value);
$SmsResDate = Replace_Check($SmsResDate);
$SmsResTime = Replace_Check($SmsResTime);
$Massage 	= Replace_Check($Massage);

$seq_value_array = explode("|",$seq_value);
$ResDate = $SmsResDate." ".$SmsResTime.":00:00";

foreach($seq_value_array as $seq) {
    $seq = trim($seq);

    if($seq) {
        $Sql = "SELECT  a.Seq, a.ServiceType, a.ID, a.LectureStart, a.LectureEnd, a.Progress, a.PassOK, a.certCount, a.StudyEnd, a.LectureCode, a.CompanyCode
                        ,b.ContentsName
                        ,c.Name, c.Depart, AES_DECRYPT(UNHEX(c.Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(c.Mobile),'$DB_Enc_Key') AS Mobile
                        ,d.CompanyName, d.SendSMS, d.CyberEnabled, d.CyberURL
                        ,e.Name AS TutorName
                FROM Study AS a
                LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode
                LEFT OUTER JOIN Member AS c ON a.ID=c.ID
                LEFT OUTER JOIN Company AS d ON a.CompanyCode=d.CompanyCode
                LEFT OUTER JOIN StaffInfo AS e ON a.Tutor=e.ID
                WHERE a.Seq=$seq";
        $Result = mysqli_query($connect, $Sql);
        $Row = mysqli_fetch_array($Result);
        if($Row) {
            $Study_Seq     = $Row['Seq'];
            $Name          = $Row['Name'];
            $CompanyName   = $Row['CompanyName'];
            $Email         = $Row['Email'];
            $Mobile        = $Row['Mobile'];
            $LectureStart  = $Row['LectureStart'];
            $LectureEnd    = $Row['LectureEnd'];
            $ID            = $Row['ID'];
            $ContentsName  = $Row['ContentsName'];
            $SendSMS       = $Row['SendSMS'];
            $CyberEnabled  = $Row['CyberEnabled'];
            $CyberURL      = $Row['CyberURL'];
            $PassProgress  = $ROW['PassProgress'];
            $PassScore     = $ROW['PassScore'];
        }

        $Massage = addslashes($Massage);
        $Massage = str_replace("#{시작}",$LectureStart,$Massage);
        $Massage = str_replace("#{종료}",$LectureEnd,$Massage);
        $Massage = str_replace("#{회사명}",$SiteName,$Massage);
        $Massage = str_replace("#{소속업체명}",$CompanyName,$Massage);
        $Massage = str_replace("#{도메인}",$SiteURL,$Massage);
        $Massage = str_replace("#{아이디}",$ID,$Massage);
        $Massage = str_replace("#{이름}",$Name,$Massage);
        $Massage = str_replace("#{과정명}",$ContentsName,$Massage);
        $Massage = str_replace("#{진도율}",$PassProgress,$Massage);
        $Massage = str_replace("#{합격점}",$PassScore,$Massage);
    }

    $maxno = max_number("idx","SmsRes");
    $Sql1 = "INSERT INTO SmsRes(idx, ID, Study_Seq, Massage, Mobile, InputID, RegDate, ResDate)
			VALUES($maxno, '$ID', $Study_Seq, '$Massage', '$Mobile', '$LoginAdminID', NOW(), '$ResDate')";
    $Row1 = mysqli_query($connect, $Sql1);
    if(!$Row1) $error_count++;

}

if($error_count>0) {
    mysqli_query($connect, "ROLLBACK");
	//$msg = "처리중 ".$error_count."건의 DB에러가 발생하였습니다. 롤백 처리하였습니다. 데이터를 확인하세요.";
    $msg = $Sql."<br>".$Sql1;
}else{
    mysqli_query($connect, "COMMIT");
	$msg = "문자발송이 예약되었습니다.";
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
    alert("<?=$msg?>");
	top.$("#SubmitBtn").show();
	top.$("#Waiting").hide();
	top.DataResultClose();
</SCRIPT>