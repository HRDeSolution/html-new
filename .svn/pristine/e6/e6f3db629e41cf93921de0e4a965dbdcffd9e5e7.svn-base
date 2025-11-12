<?
include "../include/include_function.php";

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();

$CompanyName = Replace_Check($CompanyName); //사업주명
$LectureStartA = Replace_Check($LectureStart); //수강기간 시작일자
$LectureEndA = Replace_Check($LectureEnd); //수강기간 종료일자
$ServiceType = Replace_Check($ServiceType); //환급여부

##-- 검색 조건
$where = array();

if($CompanyName) {
    $where[] = "b.CompanyName LIKE '%".$CompanyName."%'";
}
if($LectureStartA) {
    $where[] = "a.LectureStart='".$LectureStartA."'";
}
if($LectureEndA) {
    $where[] = "a.LectureEnd='".$LectureEndA."'";
}
if($ServiceType) {
    $where[] = "a.ServiceType=".$ServiceType;
}else{
    $where[] = "a.ServiceType IN (1,3,5)";
}

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$str_orderby = "ORDER BY a.LectureStart ASC, a.LectureEnd ASC, b.CompanyName ASC";

$JoinQuery = " Study AS a
				LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode
				LEFT OUTER JOIN PaymentSheet AS c ON a.CompanyCode=c.CompanyCode AND a.LectureStart=c.LectureStart AND a.LectureEnd=c.LectureEnd
                LEFT OUTER JOIN Course d ON a.LectureCode = d.LectureCode  ";

$Sql2 = "SELECT COUNT(*) FROM $JoinQuery $where";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$TOT_NO = $Row2[0];


$filename = "결제관리_".date('Ymd');

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
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("기업명");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("수강기간");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("과정명");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("수강인원");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("교육비");
$objPHPExcel->getActiveSheet()->getCell('G1')->setValue("납부액");
$objPHPExcel->getActiveSheet()->getCell('H1')->setValue("입금액");

$i=2;
$k = 1;
$SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby";
$SQL = "SELECT DISTINCT(a.CompanyCode), a.LectureStart , a.LectureEnd , b.CompanyName, d.ContentsName ,
			(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType=1) AS StudyCount,
			(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (3,5)) AS StudyBeCount,
			(SELECT SUM(Price) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (1,3,5)) AS TotalPrice
		FROM $JoinQuery $where $str_orderby";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY)){
    while($ROW = mysqli_fetch_array($QUERY)){
        $CompanyCode = $ROW['CompanyCode']; //기업코드
        $CompanyName = $ROW['CompanyName']; //기업명        
        $LectureStart = $ROW['LectureStart']; //수강기간 시작일자
        $LectureEnd = $ROW['LectureEnd']; //수강기간 종료일자
    	$ContentsName = $ROW['ContentsName']; //과정명
    	$StudyCount = $ROW['StudyCount']; //수강인원-환급
    	$StudyBeCount = $ROW['StudyBeCount']; //수강인원-비환급
    	$TotalPrice = $ROW['TotalPrice']; //교육비   

    	//수강기간
	    $LectureDate = $LectureStart."~".$LectureEnd;
	    
	    //수강인원
	    $StudyCNT = "환급 : ".$StudyCount." / 비환급 : ".$StudyBeCount;
	    
	    $NameChk1 = strpos($ContentsName, '_기업직업훈련');
	    $NameChk2 = strpos($ContentsName, '_기업직업훈련카드');
	    
	    //기업직업훈련일 경우
	    if($NameChk1 || $NameChk2){
	        $TotalPrice2 = 0; //납부액
	        $TotalPrice3 = $TotalPrice; //입금액
	        
	        //일반사업주훈련일 경우
	    }else{
	        $TotalPrice2 = $TotalPrice; //납부액
	        $TotalPrice3 = $TotalPrice - ($TotalPrice*0.1); //입금액
	    }

    	$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
    	$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($CompanyName, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($LectureDate, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($ContentsName, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($StudyCNT, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit(number_format($TotalPrice,0), PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit(number_format($TotalPrice2,0), PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('H'.$i)->setValueExplicit(number_format($TotalPrice3,0), PHPExcel_Cell_DataType::TYPE_STRING);    
    
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
