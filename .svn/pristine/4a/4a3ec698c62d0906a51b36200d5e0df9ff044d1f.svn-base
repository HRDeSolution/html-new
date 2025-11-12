<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$mode = Replace_Check($mode);
$idx = Replace_Check($idx);
$Category = Replace_Check($Category);
$idx_value = Replace_Check($idx_value);

$Keyword = Replace_Check($Keyword);
$UseYN = Replace_Check($UseYN);

$error_count = 0;
$url = "contents_flex_keyword_read.php?idx=".$Category;

//새글 작성---------------------------------------------------------------------------------------------------------
if($mode=="new") {    
    $maxno = max_number("idx","ContentsFlexKeyword");
    
    $Sql = "INSERT INTO ContentsFlexKeyword (idx, Category, Keyword, Del, RegDate, RegID, MdfDate, MdfID, UseYN)
            VALUES ($maxno, '$Category', '$Keyword', 'N', NOW(), '$LoginAdminID', NOW(), '$LoginAdminID', 'Y')";
    $Row = mysqli_query($connect, $Sql);
    if(!$Row) {
        $error_count++;
    }
}
//새글 작성-------------------------------------------------------------------------------------------------------------------------

//글 수정---------------------------------------------------------------------------------------------------------
if($mode=="edit") { 
    $Sql = "UPDATE ContentsFlexKeyword SET UseYN='$UseYN', Keyword='$Keyword', MdfDate=NOW(), MdfID='$LoginAdminID' WHERE idx=$idx";
    $Row = mysqli_query($connect, $Sql);
    if(!$Row) {
        $error_count++;
    }
}
//글 수정---------------------------------------------------------------------------------------------------------------------------

//정렬순서 -------------------------------------------------------------------------------------------------
if($mode=="OrderByProc") { 
    $idx_value_array = explode("|",$idx_value);
    
    $i = 1;
    foreach($idx_value_array as $idxA) {        
        $idx = trim($idxA);        
        if($idxA) {
            $Sql = "UPDATE ContentsFlexKeyword SET OrderByNum=$i WHERE idx=$idxA";
            $Row = mysqli_query($connect, $Sql);
            if(!$Row) {
                $error_count++;
            }
        }
        $i++;
    }    
}
//정렬순서 -------------------------------------------------------------------------------------------------------------------------

//글 삭제---------------------------------------------------------------------------------------------------------
if($mode=="del") { 
    $Sql = "UPDATE ContentsFlexKeyword SET Del='Y' WHERE idx=$idx";
    $Row = mysqli_query($connect, $Sql);
    if(!$Row) {
        $error_count++;
    }
}
//글 삭제-------------------------------------------------------------------------------------------------------------------------

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