<?
include "../include/include_function.php";

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();

$col = Replace_Check($col);
$sw = Replace_Check($sw);

$where = array();

if($sw){
    if($col=="") {
        $where[] = "";
    }else{
        if($col=="ContentsName") $where[] = "a.ContentsName LIKE '%$sw%'";
        if($col=="Cnt") $where[] = "a.Cnt = '$sw'";
    }
}

//과정분류
if($Category1){
    $where[] = "a.Category1 = '$Category1'";
    
    if($Category2) $where[] = "a.Category2 = '$Category2'";
}

//직무분야
if($Keyword2) $where[] = "a.Keyword2 = '$Keyword2'";


$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$JoinQuery = " Course a
            LEFT OUTER JOIN CourseCategory b ON a.Category1=b.idx
            LEFT OUTER JOIN CourseCategory c ON a.Category2=c.idx ";

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM $JoinQuery $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];


$filename = "관심강의_".date('Ymd');

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
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("과정분류");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("직무분야");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("과정명");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("조회수");


$i=2;
$k = 1;
$SQL = "SELECT a.cnt , a.ContentsName , a.Category1, a.Category2, a.Keyword2 ,
               b.CategoryName AS Category1 , c.CategoryName AS Category2,
               (SELECT Keyword FROM ContentsKeyword WHERE Category =2 AND idx = a.Keyword2) AS Keyword2Name
        FROM $JoinQuery $where ORDER BY a.cnt , a.ContentsName ";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY)){
    while($ROW = mysqli_fetch_array($QUERY)){
    	extract($ROW);
    
    	$DeptStringName = DeptStringNaming($DeptString);
    	$Str_Category = $Category1.">".$Category2;
    
    	$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
    	$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($Str_Category, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($Keyword2Name, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($ContentsName, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($cnt, PHPExcel_Cell_DataType::TYPE_STRING);
    
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
