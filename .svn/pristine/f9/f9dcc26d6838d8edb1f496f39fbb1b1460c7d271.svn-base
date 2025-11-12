<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);

$error_count = 0;

## 발송할 정보 확인 ------------------------------------------------------------------------------------------------
$Sql1 = "SELECT *, AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(Phone),'$DB_Enc_Key') AS Phone FROM FlexInquiry WHERE idx=$idx AND Del='N'";
$Result1 = mysqli_query($connect, $Sql1);
$Row1 = mysqli_fetch_array($Result1);
if($Row1) {
    $ServiceType = $Row1['ServiceType']; //문의종류
    $CompanyName = $Row1['CompanyName']; //회사명
    $Name        = $Row1['Name']; //문의자이름
    $Phone       = $Row1['Phone']; //전화번호
    $Email       = $Row1['Email']; //이메일
    $Personnel   = $Row1['Personnel']; //예상인원
    $Contents    = nl2br($Row1['Contents']); //내용
    
    $send_date = date('Y-m-d H:i:s');
}
## 발송할 정보 확인 ------------------------------------------------------------------------------------------------

## 문자발송 ------------------------------------------------------------------------------------------------
if($mode == "sms"){
    //[1]발송할 문자 확인
    $Sql = "SELECT * FROM SendMessage WHERE MessageMode='cancel_message'";
    $Result = mysqli_query($connect, $Sql);
    $Row = mysqli_fetch_array($Result);
    if($Row) {
        $Massage            = $Row['Massage'];
        $TemplateCode 	    = $Row['TemplateCode'];
        $TemplateMessage 	= $Row['TemplateMessage'];
    }
    
    //[2]문자보낼 내용 데이터 맞게 넣기
    $Phone = str_replace("-","",$Phone);
    $TemplateMessage2 = str_replace("#{이름}",$Name,$TemplateMessage);
    $TemplateMessage2 = str_replace("#{과정명}",$CompanyName,$TemplateMessage2);
    
    //[3]발송 로그 기록
    $maxno = max_number("idx","SmsSendLog");
    $etc1 = $maxno;
    $Sql1 = "INSERT INTO SmsSendLog(idx, ID, Study_Seq, Massage, Code, Mobile, InputID, RegDate)
            VALUES($maxno, 'FLEX문의', 0, '$TemplateMessage2', '', '$Phone', '$LoginAdminID', NOW())";
    $Row1 = mysqli_query($connect, $Sql1);
    if(!$Sql1)  $error_count++;
    
    //[4]카톡발송(카톡안되면 문자발송)
    $kakaotalk_result = kakaotalk_send_before01($TemplateCode,$Phone,$TemplateMessage2,$send_date);
    if($kakaotalk_result=="Y") $code = "0000";  else $code = "0001";
    
    //[5]발송로그 code값 업데이트
    $Sql3 = "UPDATE SmsSendLog SET Code='$code' WHERE idx=$maxno";
    $Row3 = mysqli_query($connect, $Sql3);
    if(!$Sql3)  $error_count++;
    
    //[6]문자발송일시 등록
    if($code == "0000"){
        $Sql2 = "UPDATE FlexInquiry SET RegDate3=NOW() WHERE idx=$idx";
        $Row2 = mysqli_query($connect, $Sql2);
        if(!$Sql2) $error_count++;
    }
}
## 문자발송 ------------------------------------------------------------------------------------------------

## 메일발송 ------------------------------------------------------------------------------------------------
if($mode == "Email"){
    //[1]발송할 메일 확인
    $Sql = "SELECT * FROM SendMessage WHERE TemplateCode='hrd0629'";
    $Result = mysqli_query($connect, $Sql);
    $Row = mysqli_fetch_array($Result);
    if($Row) {
        $Massage            = $Row['Massage'];
        $TemplateCode 	    = $Row['TemplateCode'];
        $TemplateMessage 	= $Row['TemplateMessage'];
    }
    
    //[2]메일보낼 내용 데이터 맞게 넣기
    $subject = "[HRDe평생교육원] TEST 메일발송";
    $SiteEmail = "hrde1@hrde.co.kr";
    $TemplateMessage2 = str_replace("#{소속업체명}",$CompanyName,$TemplateMessage);
    
    //[3]발송 로그 기록 (메일내용은 너무 길어 DB에 제목으로 대체에서 등록)
    $maxno = max_number("idx","EmailSendLog");
    $Sql1 = "INSERT INTO EmailSendLog(idx, ID, Study_Seq, MassageTitle, Massage, Code, Email, InputID, RegDate)
            VALUES($maxno, 'FLEX문의', '0', '$subject', '$subject', 'N', '$Email', '$LoginAdminID', NOW())";
    $Row1 = mysqli_query($connect, $Sql1);
    if(!$Sql1) $error_count++;
    
    //[4]메일발송
    $fromaddress = $SiteEmail;
    $toaddress = $Email;
    $body = $TemplateMessage2."<img src='".$SiteURL."/lib/EmailRecive/email_recive.php?num=".$maxno."' width='0' height='0'>";
    $fromname = $SiteName;
    
    $subject = iconv("UTF-8","EUC-KR",$subject);
    $body = iconv("UTF-8","EUC-KR",$body);
    $fromname = iconv("UTF-8","EUC-KR",$fromname);
    
    $send = nmail($fromaddress, $toaddress, $subject, $body, $fromname);
    
    //[5]메일발송일시 등록
    $Sql2 = "UPDATE FlexInquiry SET RegDate4=NOW() WHERE idx=$idx";
    $Row2 = mysqli_query($connect, $Sql2);
    if(!$Sql2) $error_count++;
}
## 메일발송 ------------------------------------------------------------------------------------------------


if($error_count>0) {
    echo "Fail";
}else{
    echo "Success";
}

mysqli_close($connect);
?>