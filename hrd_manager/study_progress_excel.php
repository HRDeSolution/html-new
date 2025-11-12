<?
include "../include/include_function.php";

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();

$id = Replace_Check($id);

$Sql = "SELECT COUNT( DISTINCT(a.LectureCode) )
        FROM Progress a
        LEFT OUTER JOIN Course b ON a.LectureCode = b.LectureCode
        WHERE a.ID = '$id'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

$Sql2 = "SELECT Name FROM Member WHERE ID='$id'";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$Name = $Row2[0];


$filename = $Name."_학습내역_".date('Ymd');

$TOT_NO2 = $TOT_NO + 1;

//cell border
$objPHPExcel->getActiveSheet()->getStyle('A1:G'.$TOT_NO2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//align
$objPHPExcel->getActiveSheet()->getStyle('A1:G'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:G'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:G'.$TOT_NO2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//1행 처리
$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue("번호");
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("과정구분");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("과정명");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("진도율");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("수강시간");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("학습시작일");
$objPHPExcel->getActiveSheet()->getCell('G1')->setValue("학습종료일");

$i=2;
$k = 1;

$SQL = "SELECT  DISTINCT(a.LectureCode), a.ID , a.Study_Seq ,
        		b.ServiceType , b.ContentsName ,
        		(SELECT RegDate FROM ProgressLog WHERE ID = a.ID AND LectureCode = a.LectureCode ORDER BY idx LIMIT 1) AS StartDate,
        		(SELECT RegDate FROM ProgressLog WHERE ID = a.ID AND LectureCode = a.LectureCode ORDER BY idx DESC LIMIT 1) AS EndDate,
                (SELECT FLOOR((SUM(IF(Progress>100,100,Progress)))/(b.Chapter*100)*100) AS TotalProgress FROM Progress WHERE ID = a.ID AND LectureCode = a.LectureCode) AS TotalProgress,
        		(SELECT SUM(StudyTime) FROM Progress WHERE ID =  a.ID AND LectureCode = a.LectureCode) AS TotalStudyTime
        FROM Progress a
        LEFT OUTER JOIN Course b ON a.LectureCode = b.LectureCode
        LEFT JOIN Study c ON a.ID = c.ID
        WHERE a.ID = '$id' AND c.StudyEnd='N' AND a.RegDate > c.LectureStart  AND a.RegDate < c.LectureEnd ";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY)) {
    while($ROW = mysqli_fetch_array($QUERY)) {
        extract($ROW);
        $TotalStudyTime = gmdate("H시간 i분 s초", $TotalStudyTime);
        
        $objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($ServiceType_array[$ServiceType], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($ContentsName, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($TotalProgress."%", PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($TotalStudyTime, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($StartDate, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($EndDate, PHPExcel_Cell_DataType::TYPE_STRING);
        
        $i++;
        $k++;
    }
}

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
