<?
include "../include/include_function.php";

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();

$idx = Replace_Check($idx);

$Sql = "SELECT * FROM Course WHERE idx=$idx AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
if($Row) {
    $LectureCode = $Row['LectureCode']; //과정코드
    $ContentsName = html_quote($Row['ContentsName']); //과정명
    $PackageLectureCode = $Row['PackageLectureCode']; //패키지에 포함된 강의 코드
}

$PackageLectureCode_Array = explode("|",$PackageLectureCode);

$LectureCode_list;
foreach ($PackageLectureCode_Array as $PackageLectureCode_Array_value) {
    if($LectureCode_list) $LectureCode_list = $LectureCode_list.", '".$PackageLectureCode_Array_value."'";
    else $LectureCode_list = "'".$PackageLectureCode_Array_value."'";
}

$Sql1 = "SELECT COUNT(*) FROM Course WHERE PackageYN='N' AND Del='N' AND LectureCode IN ($LectureCode_list)";
$Result1 = mysqli_query($connect, $Sql1);
$Row1 = mysqli_fetch_array($Result1);
$TOT_NO = $Row1[0];

mysqli_free_result($Result);


$filename = $ContentsName."_컨텐츠목록_".date('Ymd');

$TOT_NO2 = $TOT_NO + 1;

//cell border
$objPHPExcel->getActiveSheet()->getStyle('A1:E'.$TOT_NO2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//align
$objPHPExcel->getActiveSheet()->getStyle('A1:E'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:E'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:E'.$TOT_NO2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//1행 처리
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue("번호");
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("강의 코드");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("과정명");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("수강 유형");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("차시수");

$i=2;
$k = 1;
$SQL = "SELECT * FROM Course WHERE PackageYN='N' AND Del='N' AND LectureCode IN ($LectureCode_list) ORDER BY idx";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY)){
    while($ROW = mysqli_fetch_array($QUERY)){
    	extract($ROW);
    
    	$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
    	$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($ROW['LectureCode'], PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($ROW['ContentsName'], PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($ServiceType_array[$ROW['ServiceType']], PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($ROW['Chapter'], PHPExcel_Cell_DataType::TYPE_STRING);
    
    	$i++;
    	$k++;
	}
}
mysqli_free_result($QUERY);

$objPHPExcel->getActiveSheet()->setTitle('Sheet1');
$objPHPExcel->setActiveSheetIndex(0);
$filename = iconv("UTF-8", "EUC-KR", $filename);

/*
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=".$filename.".xls");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save('php://output');

exit;
*/

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=".$filename.".xlsx");
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
?>