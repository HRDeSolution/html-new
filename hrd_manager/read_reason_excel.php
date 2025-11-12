<?
include "../include/include_function.php";

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();

$col = Replace_Check($col);
$sw = Replace_Check($sw);

##-- 검색 조건
$where = array();
$target_col = '';

if ($sw) {
    if($col == "") {
        $where[] = "";
    } else {
        if ($col == 'ID') {
            $target_col = 'a.ID';
        } elseif ($col == 'Name') {
            $target_col = 'b.Name';
        } elseif ($col == 'AdminID') {
            $target_col = 'a.AdminID';
        }
        
        $where[] = "$target_col LIKE '%$sw%'";
    }
}

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

##-- 정렬조건
if($orderby == "") {
    $str_orderby = "ORDER BY a.RegDate DESC, a.idx DESC";
}else{
    $str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM InformationProtectionLog a LEFT JOIN Member b ON a.ID = b.ID $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

mysqli_free_result($Result);


$filename = "개인정보 열람내역_".date('Ymd');

$TOT_NO2 = $TOT_NO + 1;

//cell border
$objPHPExcel->getActiveSheet()->getStyle('A1:F'.$TOT_NO2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//align
$objPHPExcel->getActiveSheet()->getStyle('A1:F'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:F'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:F'.$TOT_NO2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//1행 처리
$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue("번호");
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("열람대상자");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("열람자");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("열람사유");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("열람구분");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("열람일");


$i=2;
$k = 1;
$SQL = "SELECT a.*, b.Name
	    FROM InformationProtectionLog a
        LEFT JOIN Member b ON a.ID = b.ID
	    $where $str_orderby ";  
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY)){
    while($ROW = mysqli_fetch_array($QUERY)){
        extract($ROW);
        
        $objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($Name."(".$ID.")", PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($AdminID, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($Content, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($Field, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($RegDate, PHPExcel_Cell_DataType::TYPE_STRING);
        
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