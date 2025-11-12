<?
include "../../include/include_function.php";

require_once '../../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();

$LectureStart = Replace_Check_XSS2($LectureStart);
$LectureEnd = Replace_Check_XSS2($LectureEnd);
$LectureCode = Replace_Check_XSS2($LectureCode);

$Colume = " a.CompanyCode, c.ServiceType, c.Category1, c.Category2, c.ContentsName, c.LectureCode, d.ID, d.Name, a.Seq, a.PassOK ,
        (SELECT CategoryName FROM CourseCategory WHERE idx=c.Category1) AS Category1Name, 
        (SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode AND PassOk='Y') AS StudyCount, 
        (SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode AND PassOk='N') AS StudyBeCount,
        (SELECT SUM(p.StudyTime) FROM Progress p WHERE p.ID = a.ID AND p.RegDate > '$LectureStart' AND p.RegDate < '$LectureEnd') AS TotalStudyTime ";

$JoinQuery = "Study AS a 
        LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode 
        LEFT OUTER JOIN Course AS c ON a.LectureCode=c.LectureCode 
        LEFT OUTER JOIN `Member` AS d ON a.ID = d.ID" ;

$where = " WHERE b.CompanyCode=(SELECT CompanyCode FROM `Member` WHERE ID='$LoginMemberID') AND a.ServiceType IN ('A') AND a.LectureStart='$LectureStart' AND a.LectureEnd='$LectureEnd' ";

$Sql = "SELECT COUNT(a.Seq) FROM $JoinQuery $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

$filename = "수강생리스트_".date('Ymd');

$TOT_NO2 = $TOT_NO + 1;

//cell border
$objPHPExcel->getActiveSheet()->getStyle('A1:F'.$TOT_NO2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//align
$objPHPExcel->getActiveSheet()->getStyle('A1:F'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:F'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:F'.$TOT_NO2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//1행 처리
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);


$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue("번호");
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("이름");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("아아디");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("과정명");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("총학습시간");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("수료여부");

$i=2;
$k = 1;
$SQL = "SELECT $Colume FROM $JoinQuery $where ORDER BY c.ContentsName ASC ";
// echo $SQL;
// exit;
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY)){
    while($ROW = mysqli_fetch_array($QUERY))	{
    	extract($ROW);
    
    	//전체수강시간
    	if($TotalStudyTime > 86400){
    	    $sec = $TotalStudyTime;
    	    $h = floor($sec / 3600);
    	    $m = floor(($sec % 3600) / 60);
    	    $s = $sec % 60;
    	    
    	    $TotalStudyTime = sprintf("%02d시간 %02d분 %02d초", $h, $m, $s);
    	}else{
    	    $TotalStudyTime = gmdate("H시간 i분 s초", $TotalStudyTime);
    	}
    	
    	if($PassOK == "Y") $PassOKStr = "수료"; else $PassOKStr = "미수료";
    
    	$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
    	$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($Name, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($ID, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($ContentsName, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($TotalStudyTime, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($PassOKStr, PHPExcel_Cell_DataType::TYPE_STRING);
    
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
