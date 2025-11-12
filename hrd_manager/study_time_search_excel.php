<?
include "../include/include_function.php";
error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );
ini_set("display_errors", 1);

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();

$StudyDate = Replace_Check($StudyDate); //수강날짜
$pg = Replace_Check($pg); //페이


$Sql = "SELECT COUNT(DISTINCT ID) FROM Progress WHERE RegDate LIKE '%$StudyDate%'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];


$filename = "일자별학습시간_".date('Ymd');

$TOT_NO2 = $TOT_NO + 1;

//cell border
$objPHPExcel->getActiveSheet()->getStyle('A1:H'.$TOT_NO2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//align
$objPHPExcel->getActiveSheet()->getStyle('A1:H'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:H'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:H'.$TOT_NO2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//1행 처리
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue("번호");
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("수강날짜");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("회사명");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("영업자ID");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("첨삭강사ID");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("ID");
$objPHPExcel->getActiveSheet()->getCell('G1')->setValue("이름");
$objPHPExcel->getActiveSheet()->getCell('H1')->setValue("수강시간");


$i=2;
$k = 1;

//[1]해당날짜 수강한 수강생 구하기
$Sql1 = "SELECT DISTINCT ID FROM ProgressLog WHERE RegDate LIKE '%$StudyDate%'";
$Query1 = mysqli_query($connect, $Sql1);
if($Query1 && mysqli_num_rows($Query1)){
    while($Row1 = mysqli_fetch_array($Query1)){
        $ID = $Row1['ID'];

        $StudyTimeSum = 0;
        
        //[2]해당날짜의 LectureCode와 Chapter_Seq 값 구하기
        $Sql2 = "SELECT DISTINCT a.LectureCode, a.ID , a.Chapter_Seq , b.Name , c.Tutor , c.SalesID , d.CompanyName
                FROM ProgressLog a
                LEFT JOIN `Member` b ON a.ID = b.ID
                LEFT JOIN Study c ON a.ID = c.ID
                LEFT JOIN Company d ON c.CompanyCode = d.CompanyCode
                WHERE a.ID = '$ID' AND a.RegDate LIKE '%$StudyDate%'";
        $Query2 = mysqli_query($connect, $Sql2);
        if($Query2 && mysqli_num_rows($Query2)){
            while($Row2 = mysqli_fetch_array($Query2)){
                $LectureCode = $Row2['LectureCode'];
                $Chapter_Seq = $Row2['Chapter_Seq'];
                $ID2 = $Row2['ID'];
                $Name = $Row2['Name'];
                $CompanyName = $Row2['CompanyName'];
                $Tutor = $Row2['Tutor'];
                $SalesID = $Row2['SalesID'];
                
                //[3]각 차시의 수강시간구하기
                $Sql3 = "SELECT MAX(StudyTime) - MIN(StudyTime) FROM ProgressLog
                         WHERE ID = '$ID2' AND RegDate LIKE '%$StudyDate%' AND LectureCode = '$LectureCode' AND Chapter_Seq  = $Chapter_Seq";
                $Result3 = mysqli_query($connect, $Sql3);
                $Row3 = mysqli_fetch_array($Result3);
                $StudyTime = $Row3[0];
                $StudyTimeSum = $StudyTimeSum + $StudyTime;
            }
        }
        $StudyTimeSum = gmdate("H시간 i분 s초", $StudyTimeSum);
        
        $objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($StudyDate, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($CompanyName, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($Tutor, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($SalesID, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($ID, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($Name, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('H'.$i)->setValueExplicit($StudyTimeSum, PHPExcel_Cell_DataType::TYPE_STRING);
        
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
