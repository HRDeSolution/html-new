<?
include $_SERVER['DOCUMENT_ROOT'] . "/include/include_function.php"; //DB연결 및 각종 함수 정의

// $MemberType = Replace_Check_XSS2($MemberType);
$Name = Replace_Check_XSS2($Name);
$Mobile01 = Replace_Check_XSS2($Mobile01);
$Mobile02 = Replace_Check_XSS2($Mobile02);
$Mobile03 = Replace_Check_XSS2($Mobile03);

$Mobile = $Mobile01."-".$Mobile02."-".$Mobile03;

$Mobile_enc = "HEX(AES_ENCRYPT('$Mobile','$DB_Enc_Key'))";

$Sql = "SELECT * FROM Member WHERE Name='$Name' AND Mobile=$Mobile_enc AND MemberOut='N' AND UseYN='Y'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	if($Row['Sleep']=="Y") {
		$msg = "현재 휴면계정 상태입니다.[휴면계정 복구] 메뉴를 통해 계정을 복구하세요.";
	}else{
		//아이디 휴대폰으로 전송
		$ID = $Row['ID'];
		
		//문자 발송 처리
		$msg_type = 'find_id';
		$msg_mobile = str_replace("-","",$Mobile);
		$msg_var = $Name."|".$ID;
		$user_id = $ID;
		$input_id = $ID;

		$Sql = "SELECT * FROM SendMessage WHERE MessageMode='$msg_type'";
		$Result = mysqli_query($connect, $Sql);
		$Row = mysqli_fetch_array($Result);
		if($Row) {
		    $Massage         = $Row['Massage'];
		    $TemplateCode    = $Row['TemplateCode'];
		    $TemplateMessage = $Row['TemplateMessage'];
		    $MessageMode     = $Row['MessageMode'];
		    $EmTitle         = $Row['EmTitle'];
		}
		
		$msg_var_arrary = explode("|",$msg_var);
		
		$TRAN_MSG = str_replace("#{고객명}",$msg_var_arrary[0],$TemplateMessage);
		$TRAN_MSG = str_replace("#{이름}",$msg_var_arrary[0],$TRAN_MSG);
		$TRAN_MSG = str_replace("#{아이디}",$msg_var_arrary[1],$TRAN_MSG);
		
		//발송 로그 기록
		$maxno = max_number("idx","SmsSendLog");
		$etc1 = $maxno;
		$Sql = "INSERT INTO SmsSendLog(idx, ID, Study_Seq, Massage, Code, Mobile, InputID, RegDate)
               VALUES($maxno, '$user_id', 0, '$TRAN_MSG', '', '$msg_mobile', '$input_id', NOW())";
		$Row = mysqli_query($connect, $Sql);
		
		//문자발송
		$kakaotalk_result = aligo_send($msg_mobile,$TRAN_MSG,$TRAN_CALLBACK);

		if($kakaotalk_result=="Y")    $msg = "등록된 휴대폰번호로 아이디를 전송하였습니다.";
		else  $msg = "시스템 오류가 발생했습니다. 관리자에게 문의하세요.";
	}
}else{
	$msg = "입력하신 정보로 일치하는 회원정보가 없습니다.";
}
?>
<!-- layer - ID -->
<div class="layerArea wid450">
	<div id="modal01" class="modal-wrap">
		<div class="close-btn" onclick="Javascript:DataResultClose();"><i class="ph-thin ph-x"></i></div>
		<span>아이디 찾기</span>
		<em><?=$msg?></em>
		<button class="btn_black" onclick="Javascript:DataResultClose();">확인</button>
	</div>
</div>
<!-- layer - ID // -->
<?
mysqli_close($connect);
?>