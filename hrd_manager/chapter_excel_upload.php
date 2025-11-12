<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

if($ctype) {
    $_SESSION["ctype_session"] = $ctype;
}else{
    if($ctype_session) {
        $ctype = $ctype_session;
    }else{
        $ctype = "X";
        $_SESSION["ctype_session"] = $ctype;
    }
}
if($ctype == "X") $MenuName = "이러닝";
if($ctype == "Y") $MenuName = "숏폼";
if($ctype == "Z") $MenuName = "마이크로닝";

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

	$query_select = "SELECT MAX(idx) FROM ChapterExcelTemp WHERE ID='$LoginAdminID'";
	//echo $query_select;
	$result_select = mysqli_query($connect, $query_select);
	$row_select = mysqli_fetch_array($result_select);
	$max_no = $row_select[0] + 1;

	$k = $max_no;
	for($i = 2; $i <= $maxRow; $i++) {

	    $LectureCode = $objWorksheet->getCell('A' . $i)->getValue(); //과정코드
	    $ChapterType = $objWorksheet->getCell('B' . $i)->getValue(); //유형
	    $SubIdx = $objWorksheet->getCell('C' . $i)->getValue(); //기초차시 idx값
	    $OrderByNum = $objWorksheet->getCell('D' . $i)->getValue(); // 정렬 순서


		$LectureCode = addslashes($LectureCode);
		$ChapterType = addslashes($ChapterType);
		$SubIdx = addslashes($SubIdx);
		$OrderByNum = addslashes($OrderByNum);

		
// 		$ContentsDate1 = date('Y-m-d H:i:s', strtotime($ContentsDate));
// 		$UploadStart1 = date('Y-m-d H:i:s', strtotime($UploadStart));
// 		$UploadEnd1 = date('Y-m-d H:i:s', strtotime($UploadEnd));
		/*
		$ContentsTitle = str_replace("\n","<BR>",$ContentsTitle);
		$Expl01 = str_replace("\n","<BR>",$Expl01);
		$Expl02 = str_replace("\n","<BR>",$Expl02);
		$Expl03 = str_replace("\n","<BR>",$Expl03);
		*/

		//임시 테이블에 등록
		$maxno = max_number("idx","ChapterExcelTemp");
		$Sql = "INSERT INTO ChapterExcelTemp
                    (idx, LectureCode, ChapterType, Sub_idx, OrderByNum, ID)
                VALUES
                    ($maxno, '$LectureCode', '$ChapterType', '$SubIdx', $OrderByNum, '$LoginAdminID')";
// 		echo $k.":".$Sql."<BR><BR>"; 
		$Row = mysqli_query($connect, $Sql);

		if(!$Row) {
?>
<script type="text/javascript">
<!--
	alert("데이터 확인 위해 엑셀파일을 저장중 오류 발생");
	top.location.reload();
//-->
</script>
<?
		exit;
		}
	$k++;
	}

?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
<!--
	top.document.ExcelUpForm.reset();
	top.$("#UploadSubmitBtn").show();
	top.$("#UploadWaiting").hide();
	top.ChapterExcelUploadListRoading('A');
//-->
</script>
<?

}catch (exception $e) {
?>
<script type="text/javascript">
<!--
	alert("엑셀파일을 읽는도중 오류가 발생하였습니다.");
//-->
</script>
<?
exit;
}

ob_end_flush(); // 버퍼의 내용을 출력한 후 현재 출력 버퍼를 종료 

mysqli_close($connect);
?>