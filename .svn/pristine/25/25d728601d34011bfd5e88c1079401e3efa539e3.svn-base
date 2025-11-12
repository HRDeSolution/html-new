<?
include "../include/include_function.php";
ini_set('memory_limit','-1');
set_time_limit(0);

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();


$col = Replace_Check($col);
$sw = Replace_Check($sw);
$ServiceType = Replace_Check($ServiceType);
$ctype = Replace_Check($ctype);


##-- 검색 조건
$where = array();

if($sw){
    if($col=="") {
        $where[] = "";
    }else{
        if($col=="LectureCode") {
            $where[] = "a.LectureCode='$sw'";
        }else{
            $where[] = "a.$col LIKE '%$sw%'";
        }
    }
}
if($ServiceType) {
    $where[] = "ServiceType='$ServiceType'";
}
$where[] = "a.PackageYN='N'";
$where[] = "a.Del='N'";
$where[] = "a.ctype='$ctype'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$str_orderby = "ORDER BY a.RegDate DESC, a.idx DESC";

$JoinQuery = " CourseCyber AS a
        	LEFT OUTER JOIN CourseCategory AS b ON a.Category1=b.idx
        	LEFT OUTER JOIN CourseCategory AS c ON a.Category2=c.idx ";

$Sql2 = "SELECT COUNT(a.Seq) FROM $JoinQuery $where";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$TOT_NO = $Row2[0];



$filename = "단과컨텐츠관리(내일배움카드)_".date('Ymd');

$TOT_NO2 = $TOT_NO + 1;

//cell border
$objPHPExcel->getActiveSheet()->getStyle('A1:Q'.$TOT_NO2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//align
$objPHPExcel->getActiveSheet()->getStyle('A1:Q'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:Q'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:Q'.$TOT_NO2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//1행 처리
$objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue("번호");
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("등급");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("과정코드");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("서비스구분");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("과정분류");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("과정명");
$objPHPExcel->getActiveSheet()->getCell('G1')->setValue("총차시");
$objPHPExcel->getActiveSheet()->getCell('H1')->setValue("교육시간");
$objPHPExcel->getActiveSheet()->getCell('I1')->setValue("교육비");
$objPHPExcel->getActiveSheet()->getCell('J1')->setValue("자부담금");
$objPHPExcel->getActiveSheet()->getCell('K1')->setValue("심사코드");
$objPHPExcel->getActiveSheet()->getCell('L1')->setValue("HRD-NET과정코드");
$objPHPExcel->getActiveSheet()->getCell('M1')->setValue("유효기간");
$objPHPExcel->getActiveSheet()->getCell('N1')->setValue("인증만료");
$objPHPExcel->getActiveSheet()->getCell('O1')->setValue("모바일");
$objPHPExcel->getActiveSheet()->getCell('P1')->setValue("사이트 노출");
$objPHPExcel->getActiveSheet()->getCell('Q1')->setValue("8개차시 수강제한");

$i=2;
$k = 1;
$SQL = "SELECT a.*, b.CategoryName AS Category1Name, c.CategoryName AS Category2Name 
        FROM $JoinQuery $where $str_orderby";
//echo $SQL;
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY)){
    while($ROW = mysqli_fetch_array($QUERY)){
        extract($ROW);
        
        //과정분류
        if($Category2Name){
            $CategoryName= $Category1Name.">".$Category2Name;
        }else{
            $CategoryName= $Category1Name;
        }
        //교육비
        $education = number_format($Price,0)."원 / 대규모 1000인미만 : ".number_format($Price02,0)."원";
        //자부담금
        $selfPrice = "우선지원 : ".number_format($Price01,0)."원 / 대규모 1000인 이상 : ".number_format($Price03,0)."원";
        //유효기간
        $ContentsPeriod = substr($ContentsPeriod,0,10);
        //인증만료
        $ContentsExpire = substr($ContentsExpire,0,10);
        
        $objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($ClassGrade_array[$ClassGrade], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($LectureCode, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($ServiceTypeCourse_array[$ServiceType], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($CategoryName, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($ContentsName, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($Chapter."차시", PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('H'.$i)->setValueExplicit($ContentsTime."시간", PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('I'.$i)->setValueExplicit($education, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('J'.$i)->setValueExplicit($selfPrice, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('K'.$i)->setValueExplicit($PassCode, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('L'.$i)->setValueExplicit($HrdCode, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('M'.$i)->setValueExplicit($ContentsPeriod, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('N'.$i)->setValueExplicit($ContentsExpire, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('O'.$i)->setValueExplicit($UseYN_array[$Mobile], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('P'.$i)->setValueExplicit($UseYN_array[$UseYN], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('Q'.$i)->setValueExplicit($ChapterLimit_array[$ChapterLimit], PHPExcel_Cell_DataType::TYPE_STRING);
        
        $i++;
        $k++;
    }
}

// $objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($SQL, PHPExcel_Cell_DataType::TYPE_STRING);

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