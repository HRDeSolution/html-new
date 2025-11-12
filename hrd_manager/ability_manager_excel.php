<?
include "../include/include_function.php";

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();

$col = Replace_Check($col);
$sw = Replace_Check($sw);
$Gubun = Replace_Check($Gubun);

##-- 검색조건
$where = array();

if($sw){
	if($col=="") {
		$where[] = "";
	}else{
        $where[] = ($col=="aValue") ? "aq.aValue LIKE '%$sw%'" :" $col LIKE '%$sw%'" ;
	}
}
// if($Gubun) {
// 	$where[] = "Gubun='$Gubun'";
// }
// $where[] = "Del='N'";

$where[] = "aq.idx NOT IN (36, 37, 38, 39, 40)";


$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY ar.regDate DESC, aq.aOrder ASC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM ArchiveAbilityResult2 ar 
        LEFT JOIN ArchiveQuestion aq ON aq.idx = ar.question_idx 
        LEFT JOIN `Member` m ON ar.ID = m.ID $where";

$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];


mysqli_free_result($Result);


$filename = "역량진단관리_".date('Ymd');

$TOT_NO2 = $TOT_NO + 1;

//cell border
$objPHPExcel->getActiveSheet()->getStyle('A1:I'.$TOT_NO2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//align
$objPHPExcel->getActiveSheet()->getStyle('A1:I'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:I'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:I'.$TOT_NO2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//1행 처리
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue("번호");
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("아이디");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("이름");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("단계");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("타입");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("역량");
$objPHPExcel->getActiveSheet()->getCell('G1')->setValue("문항");
$objPHPExcel->getActiveSheet()->getCell('H1')->setValue("선택값");
$objPHPExcel->getActiveSheet()->getCell('I1')->setValue("등록일");



$i=2;
$k = 1;
$SQL = "SELECT ar.idx, ar.ID, m.Name, ar.aValue, aq.aDepth, aq.aGroup, aq.aOrder, aq.aBind, aq.aValue AS aValue2, ar.regDate, aq.aType FROM ArchiveAbilityResult2 ar 
        LEFT JOIN ArchiveQuestion aq ON aq.idx = ar.question_idx 
        LEFT JOIN `Member` m ON ar.ID = m.ID 
        $where $str_orderby ";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY)){
    while($ROW = mysqli_fetch_array($QUERY)){
    	extract($ROW);
    
    	$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
    	$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($ID, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($Name, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($abilityDepth_array[$aDepth], PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($abilityGroup_array[$aGroup], PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($abilityBind_array[$aBind], PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($aValue2, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('H'.$i)->setValueExplicit(($aType == "A" && $aDepth == "step02") ? str_repeat('★ ', $aValue) : $abilityValue_array[$aValue], PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('I'.$i)->setValueExplicit($regDate, PHPExcel_Cell_DataType::TYPE_STRING);
    
    	$i++;
    	$k++;
	}
}
mysqli_free_result($QUERY);

$objPHPExcel->getActiveSheet()->setTitle('Sheet1');
$objPHPExcel->setActiveSheetIndex(0);
$filename = iconv("UTF-8", "EUC-KR", $filename);

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