<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

ob_start(); 

require_once "../lib/PHPExcel_1.8.0/Classes/PHPExcel.php"; // PHPExcel.php
$objPHPExcel = new PHPExcel();
require_once "../lib/PHPExcel_1.8.0/Classes/PHPExcel/IOFactory.php"; // IOFactory.php


$fileName = $_FILES['file']['tmp_name'];

try{
	// 업로드 된 엑셀 형식에 맞는 Reader객체를 만든다.
	$objReader = PHPExcel_IOFactory::createReaderForFile($fileName);
	// 읽기전용으로 설정
	$objReader->setReadDataOnly(true);
	// 엑셀파일을 읽는다
	$objExcel = $objReader->load($fileName);
	// 첫번째 시트를 선택
	$objExcel->setActiveSheetIndex(0);
	$objWorksheet = $objExcel->getActiveSheet();
	$rowIterator = $objWorksheet->getRowIterator();

	foreach ($rowIterator as $row) { // 모든 행에 대해서
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false); 
	}

	$maxRow = $objWorksheet->getHighestRow();

	$query_select = "SELECT MAX(idx) FROM StudyExcelTemp WHERE ID='$LoginAdminID'";
	$result_select = mysqli_query($connect, $query_select);
	$result_row = mysqli_fetch_array($result_select);
	$max_no = $result_row[0] + 1;


	$k = $max_no;
	$startLine = 2;
	$excelType = 'v1';
	
	for($i = $startLine; $i <= $maxRow; $i++) {
		
	    $LectureCode = trim($objWorksheet->getCell('A' . $i)->getValue()); // 강의코드
	    $ContentsName = $objWorksheet->getCell('B' . $i)->getValue(); // 과정명
	    $Tutor = trim($objWorksheet->getCell('C' . $i)->getValue()); // 첨삭강사
	    $Name = trim($objWorksheet->getCell('D' . $i)->getValue()); //성명
	    $ResNo = trim($objWorksheet->getCell('E' . $i)->getValue()); // 주민번호
	    $Mobile = trim($objWorksheet->getCell('F' . $i)->getValue()); // 휴대폰
	    $Email = trim($objWorksheet->getCell('G' . $i)->getValue()); // 이메일
	    $CompanyCode = trim($objWorksheet->getCell('H' . $i)->getValue()); // 사업자번호
	    $CompanyName = $objWorksheet->getCell('I' . $i)->getValue(); // 기업명
	    $Depart = trim($objWorksheet->getCell('J' . $i)->getValue()); // 부서
	    $LectureStart = trim($objWorksheet->getCell('K' . $i)->getValue()); // 수강 시작일
	    $LectureEnd = trim($objWorksheet->getCell('L' . $i)->getValue()); // 수강 종료일
	    $ServiceType = trim($objWorksheet->getCell('M' . $i)->getValue()); // 서비스 구분
	    $UserID = trim($objWorksheet->getCell('N' . $i)->getValue()); // 수강생 아이디
	    $Pwd = trim($objWorksheet->getCell('O' . $i)->getValue()); // 비밀번호
	    $nwIno = trim($objWorksheet->getCell('P' . $i)->getValue()); // 비용수급사업장
	    $trneeSe = trim($objWorksheet->getCell('Q' . $i)->getValue()); // 훈련생구분
	    $IrglbrSe = trim($objWorksheet->getCell('R' . $i)->getValue()); // 비정규직구분
	    $OpenChapter = trim($objWorksheet->getCell('S' . $i)->getValue()); // 실시회차
	    $SalesID = trim($objWorksheet->getCell('T' . $i)->getValue()); // 영업담당자 아이디
	    $EduManager = trim($objWorksheet->getCell('U' . $i)->getValue()); // 교육담당자 여부
	    
	    $LectureStart = PHPExcel_Style_NumberFormat::toFormattedString($LectureStart, PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
	    $LectureEnd = PHPExcel_Style_NumberFormat::toFormattedString($LectureEnd, PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);

		if($LectureCode) {
		    
		    $LectureReStudy = date("Y-m-d",strtotime($LectureEnd . "+1 week")); // 복습종료일 (수강종료일+7)

			$CompanyCode = trim($CompanyCode);
			$CompanyCode = str_replace('-','',$CompanyCode);
			$CompanyCode = str_replace(' ','',$CompanyCode);

			if(!$trneeSe) {
				$trneeSe = "007";
			}

			if(!$IrglbrSe) {
				$IrglbrSe = "000";
			}

			if($EduManager=="1" || $EduManager=="Y") {
				$EduManager = "Y";
			}else{
				$EduManager = "N";
			}

			if(!$SalesID || strlen($SalesID) < 2) {
				$query_select2 = "SELECT SalesManager FROM Company WHERE CompanyCode='$CompanyCode'";
				$result_select2 = mysqli_query($connect, $query_select2);
				$result_row2 = mysqli_fetch_array($result_select2);
				$SalesID = $result_row2['SalesManager'];
			}

			if(!$OpenChapter) {
				$OpenChapter = 1;
			}
			
			//20250630.YEON.비환급일경우에는 실시회차가 무조건 "0"
			if($ServiceType == "W"){
			    $OpenChapter = 0;
			}

			$ResNo_array = explode("-",$ResNo);
			$ResNo01 = $ResNo_array[0];
			$ResNo02 = $ResNo_array[1];

			$InputResNo = $ResNo01.$ResNo02;

			$Sql_m = "SELECT * FROM Member WHERE ResNo=HEX(AES_ENCRYPT('$InputResNo','$DB_Enc_Key'))";
			$Result_m = mysqli_query($connect, $Sql_m);
			$Row_m = mysqli_fetch_array($Result_m);

			if($Row_m) {
				$UserID = $Row_m['ID'];
			}

			//임시 테이블에 등록
			$maxno = max_number("idx","StudyExcelTemp");
			$Sql = "INSERT INTO StudyExcelTemp (idx, ID, LectureCode, Tutor, Name, ResNo, Mobile, Email, CompanyCode, Depart, LectureStart, LectureEnd, LectureReStudy,
                                                ServiceType, UserID, Pwd, nwIno, trneeSe, IrglbrSe, OpenChapter, SalesID, EduManager, RegDate) 
					VALUES($maxno, '$LoginAdminID', '$LectureCode', '$Tutor', '$Name', '$ResNo', '$Mobile', '$Email', '$CompanyCode', '$Depart', '$LectureStart', '$LectureEnd', '$LectureReStudy',
                           '$ServiceType', '$UserID', '$Pwd', '$nwIno', '$trneeSe', '$IrglbrSe', '$OpenChapter', '$SalesID', '$EduManager', NOW())";
			//echo $Sql;
			$Row = mysqli_query($connect, $Sql);

			if(!$Row) {
	?>
	<script type="text/javascript">
		alert("데이터 확인 위해 엑셀파일을 저장중 오류 발생");
		top.location.reload();
	</script>
	<?
	       		exit;
			}

		}
    	$k++;
	}
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
	top.document.ExcelUpForm.reset();
	top.$("#UploadSubmitBtn").show();
	top.$("#UploadWaiting").hide();
	top.ExcelUploadListRoading('A');
	
	top.$('#ExcelServiceType').val("3").trigger('change');
	top.$('#ExcelLectureCode option:eq(0)').prop('selected', true).trigger('change');
</script>
<?
}catch (exception $e) {
?>
<script type="text/javascript">
	alert("엑셀파일을 읽는도중 오류가 발생하였습니다.");
</script>
<?
    exit;
}

ob_end_flush(); // 버퍼의 내용을 출력한 후 현재 출력 버퍼를 종료 

mysqli_close($connect);
?>