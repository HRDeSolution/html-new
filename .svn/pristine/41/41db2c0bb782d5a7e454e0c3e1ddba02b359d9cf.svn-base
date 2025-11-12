<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);

$Status = Replace_Check($Status);
$Name2 = Replace_Check($Name2);
$Contents2 = Replace_Check2($Contents2);

$cmd = false;

## 답글 등록-------------------------------------------------------------------------------------------------------------------------
if($mode=="reply") {
    ## 답변 처음등록인지 확인
    $Sql = "SELECT RegDate2 FROM FlexInquiry WHERE idx=$idx";
    $Result = mysqli_query($connect, $Sql);
    $Row = mysqli_fetch_array($Result);
    $ChkInsert = $Row[0];
    
    //처음등록이 아님
    if($ChkInsert){
        $SqlA = "UPDATE FlexInquiry SET Status='$Status', Contents2='$Contents2', MdfDate2=NOW() WHERE idx=$idx";
        $RowA = mysqli_query($connect, $SqlA);
        $cmd = true;
        
    //처음 등록
    }else{
        $SqlA = "UPDATE FlexInquiry SET Status='$Status', Name2='$Name2', Contents2='$Contents2', RegDate2=NOW() WHERE idx=$idx";
        $RowA = mysqli_query($connect, $SqlA);
        $cmd = true;
    }
    
    $url = "flex_inquiry.php";
}
## 답글 등록-------------------------------------------------------------------------------------------------------------------------

## 삭제 ------------------------------------------------------------------------------------------------ 
if($mode=="del") {
	$Sql = "UPDATE FlexInquiry SET Del='Y' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "flex_inquiry.php";
}
## 삭제 ------------------------------------------------------------------------------------------------

if($Row && $cmd) {
	$ProcessOk = "Y";
	$msg = "처리되었습니다.";
}else{
	$ProcessOk = "N";
	$msg = "오류가 발생했습니다. 관리자에게 문의하세요.";
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
	alert("<?=$msg?>");
	top.$("#SubmitBtn").show();
	top.$("#Waiting").hide();
	<?if($ProcessOk=="Y") {?>
	top.location.href="<?=$url?>";
	<?}?>
</SCRIPT>