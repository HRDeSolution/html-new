<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$ID = Replace_Check($ID);
$mode = Replace_Check($mode);
$idx = Replace_Check($idx);
$CompanyCode = Replace_Check($CompanyCode);
 


if($mode=="New") {

	$Sql = "INSERT INTO MemberCompany(ID, CompanyCode, RegDate, Del) VALUES('$ID', '$CompanyCode', NOW(), 'N')";
	$Row = mysqli_query($connect, $Sql);
 
}

if($mode=="Edit") {

	$Sql = "UPDATE MemberCompany SET ID='$ID', CompanyCode='$CompanyCode' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

}

if($mode=="Delete") {

	$Sql = "UPDATE MemberCompany SET Del='Y' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

}



if($Row) {
	$ProcessOk = "Y";
	$msg = "처리되었습니다.";
}else{
	$ProcessOk = "N";
	$msg = "오류가 발생했습니다.";
}


mysqli_close($connect);
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	<?if($ProcessOk=="Y") {?>
	opener.location.reload();
	<?}?>
	self.close();
//-->
</SCRIPT>