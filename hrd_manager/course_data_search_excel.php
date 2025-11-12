<?
include "../include/include_function.php";
ini_set('memory_limit','-1');
set_time_limit(0);

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();

$SearchGubun  = Replace_Check($SearchGubun); //기간, 사업주 검색 구분
$CompanyName  = Replace_Check($CompanyName); //사업주명
$SearchYear   = Replace_Check($SearchYear); //검색 년도
$SearchMonth  = Replace_Check($SearchMonth); //검색 월
$SearchYear2  = Replace_Check($SearchYear2); //사업주검색 년도
$SearchMonth2 = Replace_Check($SearchMonth2); //사업주검색 월
$StudyPeriod  = Replace_Check($StudyPeriod); //검색 기간1(기간검색)
$StudyPeriod2 = Replace_Check($StudyPeriod2); //검색 기간2(사업주검색)
$CompanyCode  = Replace_Check($CompanyCodeA); //사업자 번호
$OpenChapter  = Replace_Check($OpenChapter); //실시회차
$LectureStart = Replace_Check($LectureStart); //교육 시작일
$LectureEnd   = Replace_Check($LectureEnd); //교육 종료일

##-- 검색 조건
$where = array();

//기간검색
if($SearchGubun=="A") {
    if($SearchYear)    $where[] = "YEAR(d.LectureStart)=".$SearchYear;
    if($SearchMonth)   $where[] = "MONTH(d.LectureStart)=".$SearchMonth;
    if($CompanyCode)   $where[] = "e.CompanyCode='".$CompanyCode."'";
    if($LectureStart)  $where[] = "d.LectureStart='".$LectureStart."'";
    if($LectureEnd)    $where[] = "d.LectureEnd='".$LectureEnd."'";
}

//사업주  검색
if($SearchGubun=="B") {
    if($SearchYear2)    $where[] = "YEAR(d.LectureStart)=".$SearchYear2;
    if($SearchMonth2)   $where[] = "MONTH(d.LectureStart)=".$SearchMonth2;
    if($CompanyName)    $where[] = "e.CompanyName LIKE '%".$CompanyName."%'";
    if($LectureStart)  $where[] = "d.LectureStart='".$LectureStart."'";
    if($LectureEnd)    $where[] = "d.LectureEnd='".$LectureEnd."'";
}

if($OpenChapter)    $where[] = "d.OpenChapter='".$OpenChapter."'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$str_orderby = "ORDER BY b.Name ASC ";

$Colume = " a.ID , a.LectureCode , a.Progress , a.StudyTime, a.Contents_idx
            ,b.Name , b.CompanyCode
            ,c.ServiceType , c.ContentsTime , c.ContentsName , c.Keyword2, c.LegalEduReq
            , (SELECT CategoryName FROM CourseCategory WHERE idx = c.Category1) AS Category1
            , (SELECT CategoryName FROM CourseCategory WHERE idx = c.Category2) AS Category2
            , (SELECT Keyword FROM ContentsKeyword WHERE Category =2 AND idx=c.Keyword2) AS Keyword2Name
            ,d.LectureStart , d.LectureEnd , d.OpenChapter
            ,e.CompanyName , e.CompanyCode ";

$JoinQuery = " Progress a
            LEFT JOIN `Member` b ON a.ID = b.ID
            LEFT JOIN Course c ON a.LectureCode = c.LectureCode
            LEFT JOIN Study d ON a.ID = d.ID
            LEFT JOIN Company e ON b.CompanyCode = e.CompanyCode ";

$Sql2 = "SELECT COUNT(a.idx) FROM $JoinQuery $where";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$TOT_NO = $Row2[0];

$filename = "과정이수데이터관리_".date('Ymd');

$TOT_NO2 = $TOT_NO + 1;

//cell border
$objPHPExcel->getActiveSheet()->getStyle('A1:N'.$TOT_NO2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//align
$objPHPExcel->getActiveSheet()->getStyle('A1:N'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:N'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:N'.$TOT_NO2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//1행 처리
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue("번호"); 
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("훈련생명");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("훈련생 아이디");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("분야");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("세부분야");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("NCS분류");
$objPHPExcel->getActiveSheet()->getCell('G1')->setValue("콘텐츠PK");
$objPHPExcel->getActiveSheet()->getCell('H1')->setValue("과정분류");
$objPHPExcel->getActiveSheet()->getCell('I1')->setValue("훈련과정ID");
$objPHPExcel->getActiveSheet()->getCell('J1')->setValue("과정명");
$objPHPExcel->getActiveSheet()->getCell('K1')->setValue("직무법정여부");
$objPHPExcel->getActiveSheet()->getCell('L1')->setValue("총 훈련시간(분)");
$objPHPExcel->getActiveSheet()->getCell('M1')->setValue("이수시간(분)");
$objPHPExcel->getActiveSheet()->getCell('N1')->setValue("이수율");


$i=2;
$k = 1;
$SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby";

$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY)){
    while($ROW = mysqli_fetch_array($QUERY)){

    	extract($ROW);

        if($LegalEduReq == 'Y') {
            $LegalEduReqEcu = '예';
        } else {
            $LegalEduReqEcu = '아니오';
        }

        if($Category1 == 'HRDe++') {
            $Category1 = '직무역량';
        }
    
    	//최종수강시간
    	if($StudyTime)   $TotalStudyTime = gmdate("i", $StudyTime);
    	else             $TotalStudyTime = "0";
    	
    	//20250630.YEON.윤희상부장 요청으로 이수율 수정
    	//이수율
    	$CourseProgress = floor($TotalStudyTime/$ContentsTime * 100);
    	
    	$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
    	$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($Name, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($ID, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($Category1, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($Keyword2Name, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($CourseData_array[$Keyword2], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($LectureCode, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('H'.$i)->setValueExplicit($ServiceType_array[$ServiceType], PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('I'.$i)->setValueExplicit("", PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('J'.$i)->setValueExplicit($ContentsName, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('K'.$i)->setValueExplicit($LegalEduReqEcu, PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('L'.$i)->setValueExplicit($ContentsTime."분", PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('M'.$i)->setValueExplicit($TotalStudyTime."분", PHPExcel_Cell_DataType::TYPE_STRING);
    	$objPHPExcel->getActiveSheet()->getCell('N'.$i)->setValueExplicit($CourseProgress."%", PHPExcel_Cell_DataType::TYPE_STRING);
    
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
