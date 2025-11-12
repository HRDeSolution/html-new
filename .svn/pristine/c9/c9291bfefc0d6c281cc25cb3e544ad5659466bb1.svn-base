<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$idx_value = Replace_Check($idx_value);
$mode = Replace_Check($mode);

$error_count = 0;

//선택항목삭제
if($mode=="del"){
	$idx_value_array = explode("|",$idx_value);

	foreach($idx_value_array as $idx) {
		$idx = trim($idx);
		if($idx) {
			$Sql = "DELETE FROM CompanyExcelTemp WHERE idx=$idx AND ID='$LoginAdminID'";
			$Row = mysqli_query($connect, $Sql);
			
			//쿼리 실패시 에러카운터 증가
			if(!$Row) {
				$error_count++;
			}
		}
	}
	$msg = "삭제되었습니다.";
}

//등록
if($mode=="input"){
	$SQL = "SELECT * FROM CompanyExcelTemp WHERE ID='$LoginAdminID' ORDER BY idx ASC";
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY)){
		while($ROW = mysqli_fetch_array($QUERY)){
			$CompanyName = $ROW['CompanyName'];
			$CompanyID = $ROW['CompanyID'];
			$CompanyScale = $ROW['CompanyScale'];
			$CompanyCode = $ROW['CompanyCode'];
			$HRD = $ROW['HRD'];
			$Ceo = $ROW['Ceo'];
			$Zipcode = $ROW['Zipcode'];
			$Address01 = $ROW['Address01'];
			$Address02 = $ROW['Address02'];
			$Uptae = $ROW['Uptae'];
			$Upjong = $ROW['Upjong'];
			$Tel = $ROW['Tel'];
			$Email = $ROW['Email'];
			$EduManager = $ROW['EduManager'];
			$EduManagerPhone = $ROW['EduManagerPhone'];
			$EduManagerEmail = $ROW['EduManagerEmail'];
			$SalesManager = $ROW['SalesManager'];
			$Remark = Replace_Check2($ROW['Remark']);
			$CyberEnabled = $ROW['CyberEnabled'];
			$Tel2 = $ROW['Tel2'];
			$Fax2 = $ROW['Fax2'];
			$CSEnabled = $ROW['CSEnabled'];
			$HomePage = $ROW['HomePage'];

			$Sql = "SELECT COUNT(*) FROM Company WHERE CompanyCode='$CompanyCode'";
			$Result = mysqli_query($connect, $Sql);
			$Row = mysqli_fetch_array($Result);
			$TOT_NO = $Row[0];

			//동일한 사업자번호가 존재시 UPDATE
			if($TOT_NO>0) {
				$Sql2 = "UPDATE Company SET CompanyScale='$CompanyScale', CompanyName='$CompanyName', HRD='$HRD', Ceo='$Ceo', Uptae='$Uptae', Upjong='$Upjong', Zipcode='$Zipcode', Address01='$Address01', Address02='$Address02', Tel='$Tel', Tel2='$Tel2', Fax2='$Fax2', Email='$Email', CSEnabled='$CSEnabled', CyberEnabled='$CyberEnabled', EduManager='$EduManager', EduManagerPhone='$EduManagerPhone', EduManagerEmail='$EduManagerEmail', SalesManager='$SalesManager', Remark='$Remark', HomePage='$HomePage' WHERE CompanyCode='$CompanyCode'";
				$Row2 = mysqli_query($connect, $Sql2);

				//쿼리 실패시 에러카운터 증가
				if(!$Row2){
					$error_count++;
				}
				
            //사업주 정보 신규 등록
			}else{
				$maxno = max_number("idx","Company");
				$Del = "N";

				$Sql2 = "INSERT INTO Company (idx, CompanyScale, CompanyCode, CompanyName, CompanyID, HRD, Ceo, Uptae, Upjong, Zipcode, Address01, Address02, Tel, Tel2, Fax, Fax2, Email, BankName, BankNumber, CSEnabled, CyberEnabled, HomePage, CyberURL, EduManager, EduManagerPhone, EduManagerEmail, SalesManager, RegDate, Remark, Del) 
						VALUES ($maxno, '$CompanyScale', '$CompanyCode', '$CompanyName', '$CompanyID', '$HRD', '$Ceo', '$Uptae', '$Upjong', '$Zipcode', '$Address01', '$Address02', '$Tel', '$Tel2', '$Fax', '$Fax2', '$Email', '$BankName', '$BankNumber', '$CSEnabled', '$CyberEnabled', '$HomePage', '$CyberURL', '$EduManager', '$EduManagerPhone', '$EduManagerEmail', '$SalesManager', NOW(), '$Remark','$Del')";
				$Row2 = mysqli_query($connect, $Sql2);

				//쿼리 실패시 에러카운터 증가
				if(!$Row2) {
					$error_count++;
				}
			}
		}
	}
	//임시 테이블 삭제
	$Sql3 = "DELETE FROM CompanyExcelTemp WHERE ID='$LoginAdminID'";
	$Row3 = mysqli_query($connect, $Sql3);
	//쿼리 실패시 에러카운터 증가
	if(!$Row3) {
		$error_count++;
	}
	$msg = "등록되었습니다.";
}

if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$msg = "처리중 ".$error_count."건의 DB에러가 발생하였습니다. 롤백 처리하였습니다. 데이터를 확인하세요.";
}else{
	mysqli_query($connect, "COMMIT");
}
mysqli_close($connect);
?>
<SCRIPT LANGUAGE="JavaScript">
	alert("<?=$msg?>");
	top.location.reload();
</SCRIPT>