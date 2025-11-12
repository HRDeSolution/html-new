<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;
$Proc;

$idx_value = Replace_Check($idx_value);
$idx_array = explode('|',$idx_value);


//메인화면 노출
if($mode == "mainShow"){
    foreach($idx_array as $idx) {
        $Sql = "UPDATE Review SET MainYN='Y' , UseYN ='Y' WHERE idx=$idx";
        $Row = mysqli_query($connect, $Sql);
    }
}
//메인화면 미노출
if($mode == "mainNoShow"){
    foreach($idx_array as $idx) {
        $Sql = "UPDATE Review SET MainYN='N' WHERE idx=$idx";
        $Row = mysqli_query($connect, $Sql);
    }
}
//홈페이지 노출
if($mode == "show"){
    foreach($idx_array as $idx) {    
        $Sql = "UPDATE Review SET UseYN='Y' WHERE idx=$idx";
        $Row = mysqli_query($connect, $Sql);
    }
}
//홈페이지 미노출
if($mode == "noShow"){
    foreach($idx_array as $idx) {
        $Sql = "UPDATE Review SET UseYN='N', MainYN='N' WHERE idx=$idx";
        $Row = mysqli_query($connect, $Sql);
    }
}

$url = "after.php?col=".$col."&sw=".$sw;

//쿼리 오류 확인
if($error_count>0) {
    mysqli_query($connect, "ROLLBACK");
    $Proc = "N";
    $msg = "오류가 발생했습니다.";
}else{
    mysqli_query($connect, "COMMIT");
    $Proc = "Y";
    $msg = "처리되었습니다.";
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
	alert("<?=$msg?>");
	<?if($Proc=="Y") {?>
	top.location.href="<?=$url?>";
	<?}?>
</SCRIPT>