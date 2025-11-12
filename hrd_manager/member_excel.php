<?
include "../include/include_function.php";

require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel.php';
require_once '../lib/PHPExcel_1.8.0/Classes/PHPExcel/Cell/AdvancedValueBinder.php';

PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );

$objPHPExcel = new PHPExcel();


$col = Replace_Check($col);
$sw = Replace_Check($sw);
// 무필터(=전체 다운로드) 감지

$isFullDump = (trim($sw) === '' && trim($col) === '');

if ($isFullDump) {
    $filename = "회원전체목록_" . date('Ymd');

    header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
    header("Content-Disposition: attachment; filename={$filename}.xls");
    header('Cache-Control: no-cache, must-revalidate');

    // 엑셀용 HTML 시작
    echo '<html><head><meta charset="UTF-8"></head><body>';
    // 테이블 기본 스타일(보더/정렬)
    echo '<table border="1" cellspacing="0" cellpadding="4" style="border-collapse:collapse; font-family:Malgun Gothic, Apple SD Gothic Neo, sans-serif; font-size:11pt;">';

    // 헤더 행 (배경 회색, 중앙정렬, 볼드)
    echo '<tr style="background:#E8E8E8; text-align:center; font-weight:bold;">';
    $headers = ['번호','아이디','이름','생년월일','성별','이메일','전화번호','휴대폰','영문 이름','우편번호',
                '주소','상세 주소','부서','직위','관심분야','가입경로','메일링','ACS','가입일','교육 담당자 여부',
                '계정사용 여부','사업주','대리수강 방지','마케팅 수신동의'];
    foreach ($headers as $h) echo '<th style="white-space:nowrap;">'.htmlspecialchars($h, ENT_QUOTES, 'UTF-8').'</th>';
    echo '</tr>';

    // 데이터 행 스트리밍 (배치로 메모리 보호)
    $limit  = 5000;
    $offset = 0;
    $k = 1;

    $baseWhere = "WHERE a.MemberOut='N' AND a.Sleep='N'";
    $orderby   = "ORDER BY a.RegDate DESC, a.idx DESC";

    while (true) {
        $SQL = "
        SELECT
            a.ID, a.Name, 
            AES_DECRYPT(UNHEX(a.BirthDay),'$DB_Enc_Key') AS BirthDay,
            a.Gender, AES_DECRYPT(UNHEX(a.Email),'$DB_Enc_Key') AS Email,
            a.Tel, AES_DECRYPT(UNHEX(a.Mobile),'$DB_Enc_Key') AS Mobile,
            a.NameEng, a.Zipcode, a.Address01, a.Address02,
            a.Depart, a.Position, a.Etc01, a.Etc02,
            a.Mailling, a.ACS, a.RegDate, a.EduManager, a.UseYN,
            b.CompanyName, a.ProtectID, a.Marketing
        FROM Member a
        LEFT JOIN Company b ON a.CompanyCode = b.CompanyCode
        $baseWhere
        $orderby
        LIMIT $limit OFFSET $offset";

        $QUERY = mysqli_query($connect, $SQL);
        if (!$QUERY || !mysqli_num_rows($QUERY)) break;

        while ($ROW = mysqli_fetch_assoc($QUERY)) {
            // 마스킹/라벨 매핑
            $Email    = InformationProtection($ROW['Email'],'Email','S');
            $BirthDay = InformationProtection($ROW['BirthDay'],'BirthDay','S');
            $Gender   = $Gender_array[$ROW['Gender']] ?? '';
            $Mkt      = $CompanySMS_array[$ROW['Marketing']] ?? '';

            // 엑셀에서 0앞자리/하이픈 유지: mso-number-format:'\@' (문자 취급)
            $asText = "style=\"mso-number-format:'\\@';\"";
            echo '<tr>';

            // 번호(숫자)
            echo '<td style="text-align:center;">'.$k.'</td>';

            // 아이디/우편번호/휴대폰 등은 앞자리 0보호 위해 텍스트 서식
            echo '<td '.$asText.'>'.htmlspecialchars($ROW['ID'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td '.$asText.'>'.htmlspecialchars($ROW['Name'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td '.$asText.'>'.htmlspecialchars($BirthDay, ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td '.$asText.'>'.htmlspecialchars($Gender, ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td '.$asText.'>'.htmlspecialchars($Email, ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td '.$asText.'>'.htmlspecialchars($ROW['Tel'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td '.$asText.'>'.htmlspecialchars($ROW['Mobile'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td '.$asText.'>'.htmlspecialchars($ROW['NameEng'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td '.$asText.'>'.htmlspecialchars($ROW['Zipcode'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td>'.htmlspecialchars($ROW['Address01'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td>'.htmlspecialchars($ROW['Address02'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td>'.htmlspecialchars($ROW['Depart'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td>'.htmlspecialchars($ROW['Position'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td>'.htmlspecialchars($ROW['Etc01'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td>'.htmlspecialchars($ROW['Etc02'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td>'.htmlspecialchars($ROW['Mailling'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td>'.htmlspecialchars($ROW['ACS'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td '.$asText.'>'.htmlspecialchars($ROW['RegDate'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td>'.htmlspecialchars($ROW['EduManager'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td>'.htmlspecialchars($ROW['UseYN'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td>'.htmlspecialchars($ROW['CompanyName'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td>'.htmlspecialchars($ROW['ProtectID'], ENT_QUOTES, 'UTF-8').'</td>';
            echo '<td>'.htmlspecialchars($Mkt, ENT_QUOTES, 'UTF-8').'</td>';

            echo '</tr>';
            $k++;
        }

        // 점진 전송
        if (function_exists('ob_flush')) { ob_flush(); }
        flush();

        $offset += $limit;
    }

    echo '</table></body></html>';
    exit;
}


$where = array();


if($sw){
	if($col=="") {
		$where[] = "";
	}else{
		$where[] = "$col LIKE '%$sw%'";
	}
}

if($col=="a.LastLogin"){
    $yearAgoDate = date("Y-m-d", strtotime("-1 year"));
    $where[] = "$col < '$yearAgoDate'";
}

$where[] = "a.MemberOut='N'";
$where[] = "a.Sleep='N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건

$orderby = "ORDER BY a.RegDate DESC, a.idx DESC";

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM Member AS a LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];


$filename = "수강생목록_".date('Ymd');

$TOT_NO2 = $TOT_NO + 1;

//cell border
$objPHPExcel->getActiveSheet()->getStyle('A1:W'.$TOT_NO2)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
//align
$objPHPExcel->getActiveSheet()->getStyle('A1:W'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:W'.$TOT_NO2)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:W'.$TOT_NO2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


//1행 처리
$objPHPExcel->getActiveSheet()->getStyle('A1:W1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('E8E8E8E8');
$objPHPExcel->getActiveSheet()->getCell('A1')->setValue("번호");
$objPHPExcel->getActiveSheet()->getCell('B1')->setValue("아이디");
$objPHPExcel->getActiveSheet()->getCell('C1')->setValue("이름");
$objPHPExcel->getActiveSheet()->getCell('D1')->setValue("생년월일"); // Brad (2021.11.26) : '생년월일' 추가
$objPHPExcel->getActiveSheet()->getCell('E1')->setValue("성별");
$objPHPExcel->getActiveSheet()->getCell('F1')->setValue("이메일");
$objPHPExcel->getActiveSheet()->getCell('G1')->setValue("전화번호");
$objPHPExcel->getActiveSheet()->getCell('H1')->setValue("휴대폰");
$objPHPExcel->getActiveSheet()->getCell('I1')->setValue("영문 이름");
$objPHPExcel->getActiveSheet()->getCell('J1')->setValue("우편번호");
$objPHPExcel->getActiveSheet()->getCell('K1')->setValue("주소");
$objPHPExcel->getActiveSheet()->getCell('L1')->setValue("상세 주소");
$objPHPExcel->getActiveSheet()->getCell('M1')->setValue("부서");
$objPHPExcel->getActiveSheet()->getCell('N1')->setValue("직위");
$objPHPExcel->getActiveSheet()->getCell('O1')->setValue("관심분야");
$objPHPExcel->getActiveSheet()->getCell('P1')->setValue("가입경로");
$objPHPExcel->getActiveSheet()->getCell('Q1')->setValue("메일링");
$objPHPExcel->getActiveSheet()->getCell('R1')->setValue("ACS");
$objPHPExcel->getActiveSheet()->getCell('S1')->setValue("가입일");
$objPHPExcel->getActiveSheet()->getCell('T1')->setValue("교육 담당자 여부");
$objPHPExcel->getActiveSheet()->getCell('U1')->setValue("계정사용 여부");
$objPHPExcel->getActiveSheet()->getCell('V1')->setValue("사업주");
$objPHPExcel->getActiveSheet()->getCell('W1')->setValue("대리수강 방지");
$objPHPExcel->getActiveSheet()->getCell('X1')->setValue("마케팅 수신동의");


$i=2;
$k = 1;
// Brad (2021.11.26) : '생년월일' 추가
$SQL = "SELECT  a.*, b.CompanyName, 
                AES_DECRYPT(UNHEX(a.BirthDay),'$DB_Enc_Key') AS BirthDay,
                AES_DECRYPT(UNHEX(a.Email),'$DB_Enc_Key') AS Email,
                AES_DECRYPT(UNHEX(a.Mobile),'$DB_Enc_Key') AS Mobile
                FROM Member AS a LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode $where $orderby";
$QUERY = mysqli_query($connect, $SQL);

if($QUERY && mysqli_num_rows($QUERY)) {
	while($ROW = mysqli_fetch_array($QUERY)) {
		extract($ROW);

		$Email = InformationProtection($Email,'Email','S');
		$BirthDay = InformationProtection($BirthDay,'BirthDay','S');
        //20250923.YEON.노현정이사 요청으로 핸드폰 번호 정보숨김 해제
        //$Mobile = InformationProtection($Mobile,'Mobile','S');

		$objPHPExcel->getActiveSheet()->getCell('A'.$i)->setValueExplicit($k, PHPExcel_Cell_DataType::TYPE_NUMERIC);
		$objPHPExcel->getActiveSheet()->getCell('B'.$i)->setValueExplicit($ID, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('C'.$i)->setValueExplicit($Name, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('D'.$i)->setValueExplicit($BirthDay, PHPExcel_Cell_DataType::TYPE_STRING); // Brad (2021.11.26) : '생년월일' 추가
		$objPHPExcel->getActiveSheet()->getCell('E'.$i)->setValueExplicit($Gender_array[$Gender], PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('F'.$i)->setValueExplicit($Email, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('G'.$i)->setValueExplicit($Tel, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('H'.$i)->setValueExplicit($Mobile, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('I'.$i)->setValueExplicit($NameEng, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('J'.$i)->setValueExplicit($Zipcode, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('K'.$i)->setValueExplicit($Address01, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('L'.$i)->setValueExplicit($Address02, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('M'.$i)->setValueExplicit($Depart, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('N'.$i)->setValueExplicit($Position, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('O'.$i)->setValueExplicit($Etc01, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('P'.$i)->setValueExplicit($Etc02, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('Q'.$i)->setValueExplicit($Mailling, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('R'.$i)->setValueExplicit($ACS, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('S'.$i)->setValueExplicit($RegDate, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('T'.$i)->setValueExplicit($EduManager, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('U'.$i)->setValueExplicit($UseYN, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('V'.$i)->setValueExplicit($CompanyName, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('W'.$i)->setValueExplicit($ProtectID, PHPExcel_Cell_DataType::TYPE_STRING);
		$objPHPExcel->getActiveSheet()->getCell('X'.$i)->setValueExplicit($CompanySMS_array[$Marketing], PHPExcel_Cell_DataType::TYPE_STRING);

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
