<?
include "../include/include_function.php";

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();


$col = Replace_Check($col);
$sw = Replace_Check($sw);
$RegDateStart = Replace_Check($StartDate);
$RegDateEnd = Replace_Check($EndDate);

/*
if(empty($RegDateStart)) {
	$RegDateStart = date('Y-m-d', strtotime('-1 week'));
	$RegDateEnd = date('Y-m-d');
}
*/

##-- 검색 조건
$where = array();

if($RegDateStart & $RegDateEnd)     $where[] = "a.ResDate >= '$RegDateStart 00:00:00' and  a.ResDate <= '$RegDateEnd 23:59:59'";
$where[] = "a.SendYN ='N'";
if($sw){
	if($col=="")    $where[] = "";
	else            $where[] = "$col LIKE '%$sw%'";
}

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";



##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM SmsRes a
        LEFT JOIN Member b ON a.ID = b.ID
        LEFT JOIN Company c ON b.CompanyCode = c.CompanyCode 
        $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];


$filename = "예약문자발송_".date('Ymd');

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
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("예약일자");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("사업주");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("회원명");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("아이디");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("연락처");


$i=2;
$k = 1;
$SQL = "SELECT	a.idx , a.ResDate , a.ID , a.Mobile ,
                b.Name ,
                c.CompanyName
        FROM SmsRes a
        LEFT JOIN Member b ON a.ID = b.ID
        LEFT JOIN Company c ON b.CompanyCode = c.CompanyCode 
        $where ORDER BY a.idx DESC";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY)){
    while($ROW = mysqli_fetch_array($QUERY)){
        extract($ROW);

        //$Mobile = InformationProtection($Mobile,'Mobile2','S');

        $objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($ResDate, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($CompanyName, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($Name, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($ID, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($Mobile, PHPExcel_Cell_DataType::TYPE_STRING);

        $i++;
        $k++;
	}
}

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