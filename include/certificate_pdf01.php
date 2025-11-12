<?
header("content-type:text/html; charset=EUC-KR");
include "../include/include_function.php";
require('../lib/fpdf181/korean.php');

function truncateText($text, $maxLength) {
    if (mb_strlen($text, 'UTF-8') > $maxLength) {
        return mb_substr($text, 0, $maxLength, 'UTF-8'). '...';
    }
    return $text;
}

$Seq = Replace_Check_XSS2($Seq);
$Sql = "SELECT 
			a.ID, a.LectureStart, a.LectureEnd, a.PassOk, a.ServiceType, a.LectureCode, 
			b.Name, AES_DECRYPT(UNHEX(b.BirthDay),'$DB_Enc_Key') AS BirthDay, 
			c.CompanyName, 
			d.ContentsName, d.ContentsTime, 
			(SELECT COUNT(idx) FROM PaymentSheet WHERE CompanyCode=a.CompanyCode AND LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND PayStatus='Y') AS PaymentCount 
			FROM 
			Study AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON a.CompanyCode=c.CompanyCode 
			LEFT OUTER JOIN Course AS d ON a.LectureCode=d.LectureCode 
			WHERE a.Seq=$Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$ID = $Row['ID'];
	$ServiceType = $Row['ServiceType'];
	$LectureStart = $Row['LectureStart'];
	$LectureEnd = $Row['LectureEnd'];
	$PassOk = $Row['PassOk'];
	$LectureCode = $Row['LectureCode'];
	$Name = $Row['Name'];
	$BirthDay = $Row['BirthDay'];
	$CompanyName = $Row['CompanyName'];
	$ContentsName = $Row['ContentsName'];
	$ContentsTime = $Row['ContentsTime'];
	$PaymentCount = $Row['PaymentCount'];

	$LectureStart_array = explode("-",$LectureStart);
	$LectureStart_Year = $LectureStart_array[0];
	$LectureStart_Month = $LectureStart_array[1];
	$LectureStart_Day = $LectureStart_array[2];
	$LectureStart_view = $LectureStart_Year."년 ".$LectureStart_Month."월 ".$LectureStart_Day."일";

	$LectureEnd_array = explode("-",$LectureEnd);
	$LectureEnd_Year = $LectureEnd_array[0];
	$LectureEnd_Month = $LectureEnd_array[1];
	$LectureEnd_Day = $LectureEnd_array[2];
	$LectureEnd_view = $LectureEnd_Year."년 ".$LectureEnd_Month."월 ".$LectureEnd_Day."일";

	$resultDate00 = date('Y-m-d');
	$resultDate01 = substr($resultDate00,0,4);
	$resultDate02 = substr($resultDate00,5,2);
	$resultDate03 = substr($resultDate00,8,2);
	$resultDate = $resultDate01." 년  ".(int)$resultDate02."월  ".(int)$resultDate03."일";
}

$NotPDF = "Y";

if($PassOk!="Y") {
	$NotPDF = "N";
	$msg01 = "수료여부를 확인하세요.";
}

if($LoginAdminID && $LoginAdminDept=="A") {
	$PaymentCount=1; //관리자로 로그인시 결제여부와 상관없이 출력
}

/*
if($PaymentCount<1) {
	$NotPDF = "N";
	$msg02 = "교육비 결제여부를 확인하세요.";
}
*/


if($NotPDF=="Y") {
	$pdf = new PDF_Korean();
	$pdf->AddUHCFont();
	$pdf->AddPage();
	$pdf->AddUHCFont('바탕', 'Batang');
	$pdf->Image('../images/certi_print_img01.jpg',2.5,2.5,205,292.5,'','');

	$pdf->Ln(25);
	$pdf->SetLeftMargin(63);
	$pdf->SetFont('바탕','',32);
	$pdf->WriteHTML("수      료      증");

	$pdf->SetLeftMargin(0);
	$pdf->Ln(26);
	$pdf->SetFont('바탕','',14);
	$userName = iconv("UTF-8", "CP949", $Name);
	$pdf->WriteHTML("                성      명 : ".$userName);

	$pdf->Ln(10);
	$birth = iconv("UTF-8", "CP949", $BirthDay);
	$pdf->WriteHTML("                생년월일 : ".$birth);

	$pdf->Ln(16);
	$companyName = iconv("UTF-8", "CP949", $CompanyName);
	$pdf->WriteHTML("                소속회사 : ".$companyName);

	$pdf->Ln(10);
	$contentsName = iconv("UTF-8", "CP949", $ContentsName);
	$pdf->WriteHTML("                훈련과정 : 디지털원격훈련 아카이브");

	$pdf->Ln(10);
	$start_end = $LectureStart_Year.'년 '.$LectureStart_Month.'월 '.$LectureStart_Day.'일 ~ '.$LectureEnd_Year.'년 '.$LectureEnd_Month.'월 '.$LectureEnd_Day.'일 (15Hh)';
	$pdf->WriteHTML("                훈련기간 : ".$start_end);

	$pdf->Ln(10);

	$pdf->SetLeftMargin(10);
	$pdf->Ln(34);
	$pdf->SetFont('바탕','',17);

	$pdf->Cell(0, 10, '위 사람은 국민 평생 직업능력 개발법 제20조 및', 0, 0, 'C');
	$pdf->Ln(10);
	$pdf->Cell(0, 10, '제24조의 규정에 의하여 본 교육원이 실시한', 0, 0, 'C');
	$pdf->Ln(10);
	$pdf->Cell(0, 10, '위 훈련 과정을 위 기간 동안 성실히', 0, 0, 'C');
	$pdf->Ln(10);
	$pdf->Cell(0, 10, '수행하였기에 본 증서를 수여합니다.', 0, 0, 'C');

	$pdf->Ln(30);
	$pdf->SetFont('바탕','',18);
	$pdf->Cell(0, 10, $resultDate, 0, 0, 'C');
	$pdf->Ln(32);
	$pdf->SetFont('바탕','',18);
	$SiteName = iconv("UTF-8", "CP949", $CertSiteName);
	
	$textWidth = $pdf->GetStringWidth($SiteName);
	$pageWidth = $pdf->GetPageWidth();
	$centerX = ($pageWidth - $textWidth) / 2;
	
	$pdf->SetXY($centerX, 245);
	$pdf->Cell($textWidth, 10, $SiteName, 0, 0, 'C');
	$imageX = $centerX + $textWidth - ($textWidth * 0.1);
	$pdf->Image('../images/company_stamp.png',$imageX, 235,25,26,'','');

	$FileName = iconv("CP949","UTF-8", "수료증_".date('YmdHis').".pdf");
	$pdf->Output('D',$FileName,true);

}else{

	$msg01 = iconv("CP949","UTF-8",$msg01);
	$msg02 = iconv("CP949","UTF-8",$msg02);
?>
<script type="text/javascript">
<!--
	alert("<?=$msg01?>\n\n<?=$msg02?>");
//-->
</script>
<?
}
?>