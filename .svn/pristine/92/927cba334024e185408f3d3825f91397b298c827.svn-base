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
$ctype = Replace_Check($ctype);


##-- 검색 조건
$where = array();

if($sw){
    if($col=="") {
        $where[] = "";
    }else{
        if($col=="LectureCode") $where[] = "a.LectureCode='$sw'";  else  $where[] = "a.$col LIKE '%$sw%'";
    }
}
$where[] = "a.Del='N'";
$where[] = "a.ctype='C'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$str_orderby = "ORDER BY a.RegDate DESC, a.idx DESC";

$JoinQuery = " CourseFlex AS a
        	LEFT OUTER JOIN CourseFlexCategory AS b ON a.Category1=b.idx
        	LEFT OUTER JOIN CourseFlexCategory AS c ON a.Category2=c.idx ";

$Sql2 = "SELECT COUNT(a.Seq) FROM $JoinQuery $where";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$TOT_NO = $Row2[0];

$filename = "컨텐츠관리(FLEX)_".date('Ymd');

$TOT_NO2 = $TOT_NO + 1;

//cell border
$objPHPExcel->getActiveSheet()->getStyle('A1:L'.$TOT_NO2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//align
$objPHPExcel->getActiveSheet()->getStyle('A1:L'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:L'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:L'.$TOT_NO2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//1행 처리
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue("번호");
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("등급");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("과정코드");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("과정분류");
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("과정명");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("차시/교육시간");
$objPHPExcel->getActiveSheet()->getCell('G1')->setValue("심사코드");
$objPHPExcel->getActiveSheet()->getCell('H1')->setValue("HRD-NET과정코드");
$objPHPExcel->getActiveSheet()->getCell('I1')->setValue("유효기간");
$objPHPExcel->getActiveSheet()->getCell('J1')->setValue("인증만료");
$objPHPExcel->getActiveSheet()->getCell('K1')->setValue("모바일");
$objPHPExcel->getActiveSheet()->getCell('L1')->setValue("사이트노출");

$i=2;
$k = 1;
$SQL = "SELECT a.*, b.CategoryName AS CategoryName1, c.CategoryName AS CategoryName2
        FROM $JoinQuery $where $str_orderby";
//echo $SQL;
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY)){
    while($ROW = mysqli_fetch_array($QUERY)){
        extract($ROW);
        
        //과정분류
        if($CategoryName2) $CategoryName= $CategoryName1.">".$CategoryName2; else $CategoryName= $CategoryName1;
        //차시
        if($Chapter != "0") $ChapterVal = $Chapter."차시";  else  $ChapterVal = "없음";
        //유효기간
        $ContentsPeriod = substr($ContentsPeriod,0,10);
        //인증만료
        $ContentsExpire = substr($ContentsExpire,0,10);
        
        $objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
        $objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($ClassGrade_array[$ClassGrade], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($LectureCode, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($CategoryName, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($ContentsName, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($ChapterVal."/".$ContentsTime."시간", PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($PassCode, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('H'.$i)->setValueExplicit($HrdCode, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('I'.$i)->setValueExplicit($ContentsPeriod, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('J'.$i)->setValueExplicit($ContentsExpire, PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('K'.$i)->setValueExplicit($UseYN_array[$Mobile], PHPExcel_Cell_DataType::TYPE_STRING);
        $objPHPExcel->getActiveSheet()->getCell('L'.$i)->setValueExplicit($UseYN_array[$UseYN], PHPExcel_Cell_DataType::TYPE_STRING);
        
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