<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$mode = Replace_Check($mode);
$idx = Replace_Check($idx);
$InfoName = Replace_Check($InfoName);
$InfoValue = Replace_Check($InfoValue);
$UseYN = Replace_Check($UseYN);

$error_count = 0;
$url = "site_info2_list.php";

//새글 작성---------------------------------------------------------------------------------------------------------
if($mode=="new") {    
    $maxno = max_number("idx","SiteInfomation2");    
    $Sql = "INSERT INTO SiteInfomation2 (idx, InfoName, InfoValue, RegID, RegDate, UseYN)
            VALUES ($maxno, '$InfoName', '$InfoValue', '$LoginAdminID', NOW(), 'Y')";
    $Row = mysqli_query($connect, $Sql);
    if(!$Row) {
        $error_count++;
    }
}
//새글 작성-------------------------------------------------------------------------------------------------------------------------

//글 수정---------------------------------------------------------------------------------------------------------
if($mode=="edit") { 
    $Sql = "UPDATE SiteInfomation2 SET UseYN='$UseYN', InfoName = '$InfoName', InfoValue='$InfoValue', MdfDate=NOW(), MdfID='$LoginAdminID' WHERE idx=$idx";
    $Row = mysqli_query($connect, $Sql);
    if(!$Row) {
        $error_count++;
    }
}
//글 수정---------------------------------------------------------------------------------------------------------------------------

if($error_count>0) {
    mysqli_query($connect, "ROLLBACK");
    $ProcessOk = "N";
    $msg = "처리중 ".$error_count."건의 DB에러가 발생하였습니다. 롤백 처리하였습니다. 데이터를 확인하세요.";
}else{
    mysqli_query($connect, "COMMIT");
    $ProcessOk = "Y";
    $msg = "처리되었습니다.";
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
    alert("<?=$msg?>");
    top.$("#SubmitBtn").show();
    top.$("#Waiting").hide();
    <?if($ProcessOk=="Y") {?>
    top.location.href="<?=$url?>";
    <?}?>
//-->
</SCRIPT>