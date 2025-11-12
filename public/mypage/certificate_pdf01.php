<?
header("content-type:text/html; charset=EUC-KR");
include "../../include/include_function.php";
require('../../lib/fpdf181/korean.php');

function truncateText($text, $maxLength) {
    if (mb_strlen($text, 'UTF-8') > $maxLength) {
        return mb_substr($text, 0, $maxLength, 'UTF-8'). '...';
    }
    return $text;
}

$LectureCode = Replace_Check_XSS2($LectureCode);
/*$Sql = "SELECT 
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
			WHERE a.Seq=$Seq";*/
$Sql = "SELECT m.Name, AES_DECRYPT(UNHEX(m.BirthDay),'$DB_Enc_Key') AS BirthDay,
	       s.LectureStart, s.LectureEnd, c.ContentsName, c2.CompanyName
        FROM Member m
            INNER JOIN Study s ON s.ID = m.ID
            INNER JOIN Course c ON c.LectureCode = '$LectureCode'
            INNER JOIN Company c2 ON c2.CompanyCode = m.CompanyCode 
        WHERE m.ID = '$LoginMemberID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
// 	$ID = $Row['ID'];
// 	$ServiceType = $Row['ServiceType'];
	$LectureStart = $Row['LectureStart'];
	$LectureEnd = $Row['LectureEnd'];
// 	$PassOk = $Row['PassOk'];
	$LectureCode = $Row['LectureCode'];
	$Name = $Row['Name'];
	$BirthDay = $Row['BirthDay'];
	$CompanyName = $Row['CompanyName'];
	$ContentsName = $Row['ContentsName'];
// 	$ContentsTime = $Row['ContentsTime'];
// 	$PaymentCount = $Row['PaymentCount'];

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

// if($PassOk!="Y") {
// 	$NotPDF = "N";
// 	$msg01 = "수료여부를 확인하세요.";
// }

// if($LoginAdminID && $LoginAdminDept=="A") {
// 	$PaymentCount=1; //관리자로 로그인시 결제여부와 상관없이 출력
// }

/*
if($PaymentCount<1) {
	$NotPDF = "N";
	$msg02 = "교육비 결제여부를 확인하세요.";
}
*/

if($NotPDF=="Y") {//여기로 옴
	$pdf = new PDF_Korean();
	$pdf->AddUHCFont();
	$pdf->AddPage();
	$pdf->AddUHCFont('바탕', 'Batang');
	$pdf->Image('../../images/certi_print_img01.jpg',2.5,2.5,205,292.5,'','');

	$pdf->Ln(25);
	$pdf->SetLeftMargin(63);
	$pdf->SetFont('바탕','',32);
	$pdf->WriteHTML("이      수      증");

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
	$pdf->WriteHTML("                훈련과정 : ".$contentsName);

	$pdf->Ln(10);
	$start_end = $LectureStart_Year.'년 '.$LectureStart_Month.'월 '.$LectureStart_Day.'일 ~ '.$LectureEnd_Year.'년 '.$LectureEnd_Month.'월 '.$LectureEnd_Day.'일';
	$pdf->WriteHTML("                훈련기간 : ".$start_end);

	$pdf->Ln(10);

	$pdf->SetLeftMargin(10);
	$pdf->Ln(34);
	$pdf->SetFont('바탕','',17);
// 	$pdf->Cell(0, 10, '위 사람은 본 교육원이 실시한', 0, 0, 'C');
// 	$pdf->Ln(10);
// 	$pdf->Cell(0, 10, '상기의 교육과정을 위 기간 동안 성실히 수행하여', 0, 0, 'C');
// 	$pdf->Ln(10);
// 	$pdf->Cell(0, 10, '수료하였기에 본 증서를 수여합니다.', 0, 0, 'C');
	$pdf->Cell(0, 10, '위 사람은 디지털원격훈련 아카이브(HRD 아카이브)를 통해', 0, 0, 'C');
	$pdf->Ln(10);
	$pdf->Cell(0, 10, '사업주 직업능력개발 훈련과정을 이수하였으므로', 0, 0, 'C');
	$pdf->Ln(10);
	$pdf->Cell(0, 10, '이 증서를 수여합니다.', 0, 0, 'C');
	
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
	$pdf->Image('../../images/company_stamp.png',$imageX, 235,25,26,'','');

    /*//차시 페이지 -----------------------------------------------------------------------------------------------------
    if( $ServiceType == 3 ){
        $sql4Chapter = "SELECT ContentsTitle
                                    FROM Contents
                                    WHERE idx IN (SELECT Sub_idx
                                                  FROM Chapter
                                                  WHERE LectureCode='$LectureCode')";
        $query = mysqli_query($connect,$sql4Chapter);
        $printedChaptersCount = 1;
        $row_count = mysqli_num_rows($query);
        
        if($row_count > 1){
            while($row = mysqli_fetch_assoc($query)){
                if($printedChaptersCount % 14 == 1){//차시 페이지 윗 부분 고정 -------------------------
                    $pdf->AddPage();
                    $pdf->Image('../../images/certi_print_img01.jpg',2.5,2.5,205,292.5,'','');
                    $pdf->Ln(15);
                    $pdf->SetLeftMargin(20);
                    $pdf->SetFont('바탕','',12);
                    $pdf->Cell(0, 1, '(별지)', 0, 1, 'L');
                    $pdf->Ln(15);
                    $pdf->SetFont('바탕', '', 12);
                    $pdf->Cell(0, 1, "가. 교육생 인증사항", 0, 1, 'L');
                    $pdf->Ln(5);
                    
                    //첫 번째 표 (교육생 인증사항)
                    $pdf->SetFont('바탕', '', 10);
                    $pdf->Cell(60, 10, "성명", 1, 0, 'C');
                    $pdf->Cell(40, 10, "생년월일", 1, 0, 'C');
                    $pdf->Cell(70, 10, "소속회사", 1, 1, 'C');
                    
                    $pdf->Cell(60, 10, $userName, 1, 0, 'C');
                    $pdf->Cell(40, 10, $birth, 1, 0, 'C');
                    $pdf->Cell(70, 10, $companyName, 1, 1, 'C');
                    
                    $pdf->Ln(15);
                    $pdf->SetFont('바탕', '', 12);
                    if($contentsNameArr2[1] != ""){
                        $pdf->Cell(0, 1, '나. 훈련과정 : '. $contentsName1.' : ', 0, 1, 'L');
                        $pdf->Ln(7);
                        $pdf->Cell(0, 1, $contentsName2, 0, 1, 'L');
                    }else{
                        $pdf->Cell(0, 1, '나. 훈련과정 : '. $contentsName, 0, 1, 'L');
                    }
                    $pdf->Ln(5);
                    
                    $pdf->SetFont('바탕', '', 10);
                    $pdf->Cell(10, 10, "연번", 1, 0, 'C');
                    $pdf->Cell(120, 10, "교육과정", 1, 0, 'C');
                    $pdf->Cell(20, 10, "교육시간", 1, 0, 'C');
                    $pdf->Cell(20, 10, "패스여부", 1, 1, 'C');
                }//--------------------------------------------------------------------------------
                //두번째 표
                $chapterName = iconv("UTF-8", "CP949", $row['ContentsTitle']);
                $pdf->Cell(10, 10, $printedChaptersCount, 1, 0, 'C'); 
                $truncatedChapterName = truncateText($chapterName, 55); // 원하는 길이 설정
                $pdf->Cell(120, 10, $truncatedChapterName, 1, 0, 'C');
                $pdf->Cell(20, 10, "1H", 1, 0, 'C');
                $pdf->Cell(20, 10, "P", 1, 1, 'C');
                
                if($printedChaptersCount % 14 == 0 || $row_count == $printedChaptersCount){//스탬프 부분
                    $pdf->Ln(5);
                    $pdf->Cell(0, 1, "*패스여부는 P(Pass) 또는 F(Fail)로 표기되었습니다.", 0, 1, 'L');
                    $pdf->SetFont('바탕','',18);
                    $pdf->SetXY($centerX, 260);
                    $pdf->Cell($textWidth, 1, $SiteName, 0, 0, 'C');
                    $imageY = 248;
                    $pdf->Image('../../images/company_stamp.png',$imageX,$imageY,25,26,'','');
                }
                $printedChaptersCount++;
            }
        }
    }*/
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