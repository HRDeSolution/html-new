<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

if($ctype) {
    $_SESSION["ctype_session"] = $ctype;
}else{
    if($ctype_session) {
        $ctype = $ctype_session;
    }else{
        $ctype = "X";
        $_SESSION["ctype_session"] = $ctype;
    }
}
if($ctype == "X") $MenuName = "이러닝";
if($ctype == "Y") $MenuName = "숏폼";
if($ctype == "Z") $MenuName = "마이크로닝";
if($ctype == "W") $MenuName = "비환급";

ob_start(); 

require_once "../lib/PHPExcel_1.8.0/Classes/PHPExcel.php"; // PHPExcel.php
$objPHPExcel = new PHPExcel();
require_once "../lib/PHPExcel_1.8.0/Classes/PHPExcel/IOFactory.php"; // IOFactory.php


$fileName = $_FILES['file']['tmp_name'];

try{
	// 업로드 된 엑셀 형식에 맞는 Reader객체를 만든다.
	$objReader = PHPExcel_IOFactory::createReaderForFile($fileName);
	// 읽기전용으로 설정
	$objReader->setReadDataOnly(true);
	// 엑셀파일을 읽는다
	$objExcel = $objReader->load($fileName);
	// 첫번째 시트를 선택
	$objExcel->setActiveSheetIndex(0);
	$objWorksheet = $objExcel->getActiveSheet();
	$rowIterator = $objWorksheet->getRowIterator();

	foreach ($rowIterator as $row) { // 모든 행에 대해서
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false); 
	}

	$maxRow = $objWorksheet->getHighestRow();

	$query_select = "SELECT MAX(idx) FROM CourseExcelTemp WHERE ID='$LoginAdminID'";
	//echo $query_select;
	$result_select = mysqli_query($connect, $query_select);
	$row_select = mysqli_fetch_array($result_select);
	$max_no = $row_select[0] + 1;

	$k = $max_no;
	for($i = 2; $i <= $maxRow; $i++) {
	    $ClassGrade = $objWorksheet->getCell('A' . $i)->getValue(); // 등급
	    $LectureCode = $objWorksheet->getCell('B' . $i)->getValue(); //과정코드
	    $PackageLectureCode = $objWorksheet->getCell('C' . $i)->getValue(); //패키지콘텐츠과정코드
	    $UseYN = $objWorksheet->getCell('D' . $i)->getValue(); // 사이트노출
	    $ContentsURLSelect = $objWorksheet->getCell('E' . $i)->getValue(); // 컨텐츠 경로
	    $HrdSeq = $objWorksheet->getCell('F' . $i)->getValue(); // 원격훈련일련번호
	    $Category1 = $objWorksheet->getCell('G' . $i)->getValue(); // 과정분류1
	    $Category2 = $objWorksheet->getCell('H' . $i)->getValue(); // 과정분류2
	    $ContentsName = $objWorksheet->getCell('I' . $i)->getValue(); // 과정명
		$Keyword1 = $objWorksheet->getCell('J' . $i)->getValue(); // 난이도(직급)
		$Keyword2 = $objWorksheet->getCell('K' . $i)->getValue(); // 직무분야    
		$Keyword3 = $objWorksheet->getCell('L' . $i)->getValue(); // 관심분야
		$Keyword4 = $objWorksheet->getCell('M' . $i)->getValue(); // 역량
		$Chapter = $objWorksheet->getCell('N' . $i)->getValue(); // 차시수
		$ContentsTime = $objWorksheet->getCell('O' . $i)->getValue(); // 교육시간
		$ContentsStart= $objWorksheet->getCell('P' . $i)->getValue(); // 컨텐츠 유효 시작일
		$ContentsEnd= $objWorksheet->getCell('Q' . $i)->getValue(); // 컨텐츠 유효 만료일
		$UploadDate = $objWorksheet->getCell('R' . $i)->getValue(); // 컨텐츠 업로드일
		$Professor = $objWorksheet->getCell('S' . $i)->getValue(); // 교강사
		$PassTime = $objWorksheet->getCell('T' . $i)->getValue(); // 수료기준
		$Mobile = $objWorksheet->getCell('U' . $i)->getValue(); // 모바일지원
		$BookPrice = $objWorksheet->getCell('V' . $i)->getValue(); // 교재비
		$PreviewImage = $objWorksheet->getCell('W' . $i)->getValue(); // 과정이미지
		$Intro = $objWorksheet->getCell('X' . $i)->getValue(); // 과정소개
		$EduTarget = $objWorksheet->getCell('Y' . $i)->getValue(); // 교육대상
		$EduGoal = $objWorksheet->getCell('Z' . $i)->getValue(); // 교육목표
		$Price = $objWorksheet->getCell('AA' . $i)->getValue(); // 교육비용 일반
		$Price01View = $objWorksheet->getCell('AB' . $i)->getValue(); // 교육비용 우선지원
		$Price02View = $objWorksheet->getCell('AC' . $i)->getValue(); // 교육비용 대규모 1000인 미만
		$Price03View = $objWorksheet->getCell('AD' . $i)->getValue(); // 교육비용 대규모 1000인 이상

		$ClassGrade = addslashes($ClassGrade);
		$LectureCode = addslashes($LectureCode);
		$PackageLectureCode = addslashes($PackageLectureCode);
		$UseYN = addslashes($UseYN);
		$ContentsURLSelect = addslashes($ContentsURLSelect);
		$HrdSeq = addslashes($HrdSeq);
		$Category1 = addslashes($Category1);
		$Category2 = addslashes($Category2);
		$ContentsName = addslashes($ContentsName);
		$Keyword1 = addslashes($Keyword1);
		$Keyword2 = addslashes($Keyword2);
		$Keyword3 = addslashes($Keyword3);
		$Keyword4 = addslashes($Keyword4);
		$Chapter = addslashes($Chapter);
		$ContentsTime = addslashes($ContentsTime);
		$ContentsStart= addslashes($ContentsStart);
		$ContentsEnd= addslashes($ContentsEnd);
		$UploadDate = addslashes($UploadDate);
		$Professor = addslashes($Professor);
		$PassTime = addslashes($PassTime);
		$Mobile = addslashes($Mobile);
		$BookPrice = addslashes($BookPrice);
		$PreviewImage = addslashes($PreviewImage);
		$Intro = addslashes($Intro);
		$EduTarget = addslashes($EduTarget);
		$EduGoal = addslashes($EduGoal);		
		$Price = addslashes($Price);
		$Price01View = addslashes($Price01View);
		$Price02View = addslashes($Price02View);
		$Price03View = addslashes($Price03View);
		
		$ContentsTime = round($ContentsTime);
		
// 		$ContentsDate1 = date('Y-m-d H:i:s', strtotime($ContentsDate));
// 		$UploadStart1 = date('Y-m-d H:i:s', strtotime($UploadStart));
// 		$UploadEnd1 = date('Y-m-d H:i:s', strtotime($UploadEnd));
		/*
		$ContentsTitle = str_replace("\n","<BR>",$ContentsTitle);
		$Expl01 = str_replace("\n","<BR>",$Expl01);
		$Expl02 = str_replace("\n","<BR>",$Expl02);
		$Expl03 = str_replace("\n","<BR>",$Expl03);
		*/

		//임시 테이블에 등록
		$maxno = max_number("idx","CourseExcelTemp");
		$Sql = "INSERT INTO CourseExcelTemp
                    (idx, Ctype, ClassGrade, LectureCode, UseYN, ContentsURLSelect, Category1, Category2,
                     ContentsName, Keyword1, Keyword2, Keyword3, Keyword4, Chapter, ContentsTime, ContentsStart,
                     ContentsEnd, UploadDate, Mobile, BookPrice, PreviewImage,
                     Intro, EduTarget, EduGoal, ID, ServiceType,
                     PackageLectureCode, HrdSeq, Professor, Price, Price01View, Price02View, Price03View, PassTime)
                VALUES
                    ($maxno, '$ctype', '$ClassGrade', '$LectureCode', '$UseYN', '$ContentsURLSelect', '$Category1', '$Category2',
                     '$ContentsName', '$Keyword1', '$Keyword2', '$Keyword3', '$Keyword4', '$Chapter', '$ContentsTime', '$ContentsStart',
                     '$ContentsEnd', '$UploadDate', '$Mobile', $BookPrice, '$PreviewImage',
                     '$Intro', '$EduTarget', '$EduGoal', '$LoginAdminID', '$ctype',
                     '$PackageLectureCode', '$HrdSeq', '$Professor', '$Price', '$Price01View', '$Price02View', '$Price03View', '$PassTime')";
// 		echo $k.":".$Sql."<BR><BR>"; 
		$Row = mysqli_query($connect, $Sql);
		if(!$Row) {
?>
<script type="text/javascript">
	alert("데이터 확인 위해 엑셀파일을 저장중 오류 발생  ");
	top.location.reload();
</script>
<?
            exit;
		}
        $k++;
	}

?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
	top.document.ExcelUpForm.reset();
	top.$("#UploadSubmitBtn").show();
	top.$("#UploadWaiting").hide();
	top.CourseExcelUploadListRoading('A');
</script>
<?

}catch (exception $e) {
?>
<script type="text/javascript">
<!--
	alert("엑셀파일을 읽는도중 오류가 발생하였습니다.");
//-->
</script>
<?
exit;
}

ob_end_flush(); // 버퍼의 내용을 출력한 후 현재 출력 버퍼를 종료 

mysqli_close($connect);
?>