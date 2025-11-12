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
$CompanyCodeA  = Replace_Check($CompanyCodeA); //사업자 번호
$OpenChapter  = Replace_Check($OpenChapter); //실시회차
$ServiceType  = Replace_Check($ServiceType); //개설용도
$ID           = Replace_Check($ID); //이름, 아이디
$SalesID      = Replace_Check($SalesID); //영업자 이름, 아이디
$Progress1    = Replace_Check($Progress1); //진도율 시작
$Progress2    = Replace_Check($Progress2); //진도율 종료
$TutorStatus  = Replace_Check($TutorStatus); //첨삭 여부
$LectureCode  = Replace_Check($LectureCode); //강의 코드
$PassOk       = Replace_Check($PassOk); //수료여부
$certCount    = Replace_Check($certCount); //실명인증 횟수
$LectureStart = Replace_Check($LectureStart); //교육 시작일
$LectureEnd   = Replace_Check($LectureEnd); //교육 종료일
$Tutor        = Replace_Check($Tutor); //교강사
$EduManager   = Replace_Check($EduManager); //교육담당자

##-- 검색 조건
$where = array();

//기간검색
if($SearchGubun=="A") {
    if($SearchYear)    $where[] = "YEAR(c.LectureStart)=".$SearchYear;
    if($SearchMonth)   $where[] = "MONTH(c.LectureStart)=".$SearchMonth;
    if($CompanyCode)   $where[] = "c.CompanyCode='".$CompanyCode."'";
    if($LectureStart)  $where[] = "c.LectureStart='".$LectureStart."'";
    if($LectureEnd)    $where[] = "c.LectureEnd='".$LectureEnd."'";
}

//사업주  검색 
if($SearchGubun=="B") {
    if($SearchYear2)    $where[] = "YEAR(c.LectureStart)=".$SearchYear2;
    if($SearchMonth2)   $where[] = "MONTH(c.LectureStart)=".$SearchMonth2;
    if($CompanyName)    $where[] = "d.CompanyName LIKE '%".$CompanyName."%'";
    if($LectureStart)  $where[] = "c.LectureStart='".$LectureStart."'";
    if($LectureEnd)    $where[] = "c.LectureEnd='".$LectureEnd."'";
}

if($OpenChapter != ""){
    if($OpenChapter == 0)   $where[] = "c.OpenChapter='0' ";
    else                    $where[] = "c.OpenChapter='".$OpenChapter."'";
}

if($ServiceType)    $where[] = "c.ServiceType='".$ServiceType."'";
if($ID)             $where[] = "(c.ID='".$ID."' OR e.Name='".$ID."')";
if($SalesID)        $where[] = "(c.SalesID='".$SalesID."' OR f.Name='".$SalesID."')";

if($Progress2) {
    if(!$Progress1)    $Progress1 = 0;
	$where[] = "(a.Progress BETWEEN ".$Progress1." AND ".$Progress2.")";
}

if($TutorStatus=="N")   $where[] = "c.StudyEnd='N'";
if($LectureCode)        $where[] = "a.LectureCode='".$LectureCode."'";
if($PassOk)             $where[] = "c.PassOk='".$PassOk."'";

if($certCount) {
    if($certCount=="Y")    $where[] = "g.CertDate IS NOT NULL";
    else   $where[] = "g.CertDate IS NULL";
}

if($Tutor)      $where[] = "c.Tutor='".$Tutor."'";
if($EduManager) $where[] = "e.EduManager='".$EduManager."'";

//첨삭강사의 경우 본인의 건만 체크
if($LoginAdminDept=="C") {
	$where[] = "c.Tutor='".$LoginAdminID."'";
}

//영업사원의 경우 본인과 하부 조직의 내용만 체크====================================================================================================================
if($LoginAdminDept=="B") {
	$Sql = "SELECT *, (SELECT DeptString FROM DeptStructure WHERE idx=StaffInfo.Dept_idx) AS DeptString FROM StaffInfo WHERE ID='$LoginAdminID'";
	$Result = mysqli_query($connect, $Sql); 
	$Row = mysqli_fetch_array($Result);
	if($Row) {
		$DeptString = $Row['DeptString'];
		$Dept_idx = $Row['Dept_idx'];
	}
	if($DeptString) {

	//현재 해당 조직이 하부에 조직이 존재하면 팀장급 이상이므로 하부 조직 모두, 하부조직이 없으면 말단 영업사원이므로 본인것만 나오게한다.
		$Sql2 = "SELECT COUNT(*) AS DeptCount FROM DeptStructure WHERE DeptString LIKE '$DeptString%'";
		$Result2 = mysqli_query($connect, $Sql2);
		$Row2 = mysqli_fetch_array($Result2);
		if ($Row2) {			
			$DeptCount = $Row2['DeptCount'];
		}
		
		//하부조직이 있는 경우
		if($DeptCount > 1) {
			$Dept_String = "";
			$SQL = "SELECT DeptString FROM DeptStructure WHERE DeptString LIKE '$DeptString%' ORDER BY Deep ASC";
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY)){
				while($ROW = mysqli_fetch_array($QUERY)){
					if($ROW['DeptString']) {
						$Dept_String = $Dept_String.$ROW['DeptString'];
					}
				}
			}

			$DeptString_array = explode("|",$Dept_String);
			$DeptString_array = array_unique($DeptString_array);
			$DeptString_array_count = count($DeptString_array);

			$Dept_idx_query = "";
			$i = 0;
			foreach($DeptString_array as $DeptString_array_value) {
                if($DeptString_array_value) {
                    if(!$Dept_idx_query) $Dept_idx_query = "f.Dept_idx=$DeptString_array_value";
                    else $Dept_idx_query = $Dept_idx_query." OR f.Dept_idx=$DeptString_array_value";
                }
                $i++;
			}

			$Dept_idx_query  = "(f.Dept_idx=".$Dept_idx." OR ".$Dept_idx_query.")";

			$where[] = $Dept_idx_query;
			
		//하부조직이 없는 경우
		}else{ 
			$where[] = "c.SalesID='".$LoginAdminID."'";
		}
	}else{
		$where[] = "c.SalesID='".$LoginAdminID."'";
	}
}
//영업사원 ==========================================================================================================================================================



$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$JoinQuery = " Progress a
            LEFT OUTER JOIN Course b ON a.LectureCode = b.LectureCode 
            LEFT JOIN Study c ON a.ID = c.ID
            LEFT JOIN Company d ON c.CompanyCode = d.CompanyCode 
            LEFT JOIN Member e ON a.ID = e.ID
            LEFT JOIN StaffInfo f ON c.SalesID = f.ID 
            LEFT JOIN UserCertOTP g ON c.Seq =g.Study_Seq AND c.ID - g.ID AND c.LectureCode = g.LectureCode  ";

$Sql2 = "SELECT COUNT(DISTINCT(a.LectureCode))  FROM $JoinQuery $where";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$TOT_NO = $Row2[0];

$filename = "학습내역관리_".date('Ymd');

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
            FROM $JoinQuery $where ";
//echo $SQL;
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY)){
    while($ROW = mysqli_fetch_array($QUERY)){
    	extract($ROW);
    
    	if($TotalProgress > 100) $TotalProgress = 100;
        $TotalStudyTime = gmdate("H시간 i분 s초", $TotalStudyTime);
    	   	
    	
    	$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC); //번호
    	$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($ServiceType_array[$ServiceType], PHPExcel_Cell_DataType::TYPE_STRING); //과정구분
    	$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($ContentsName, PHPExcel_Cell_DataType::TYPE_STRING); //과정명
    	$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($TotalProgress."%", PHPExcel_Cell_DataType::TYPE_STRING); //진도율
    	$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($TotalStudyTime, PHPExcel_Cell_DataType::TYPE_STRING); //수강시간
    	$objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($StartDate, PHPExcel_Cell_DataType::TYPE_STRING); //학습시작일
    	$objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($EndDate, PHPExcel_Cell_DataType::TYPE_STRING); //학습종료일
    
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
