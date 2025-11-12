
<?include "../../include/include_function.php"; //DB연결 및 각종 함수 정의?>
<?
$ID        = $_GET['ID'];
?>
<body>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    border: none;
    font-family: NanumSquareB;
    }
 
    h2{
    text-align: center;
    padding: 15px 0;
    font-size: 25px;
    font-weight: 500;
    line-height: 40px;
    background-color: #2b549d;
    color: #fff;
    }
    #other_otp{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    padding: 50px 20px;
    }
    button{
    background-color: #f0f0f0;
    padding: 15px 0;
    border-radius: 10px;
    cursor: pointer;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="/include/function.js"></script>
  <div class="canvas">
    <h2>본인 인증</h2>

		<?php if($EVAL_CD != '00'){ ?>
		<div id="other_otp" >
	        <button type="button" onclick="fnPopup();">휴대폰 인증하기</button>
            <button type="button" onclick="fnPopupipin();">아이핀 인증하기</button>
		</div>
		<?php } ?>
    </div>

<script type="text/javascript">
    function fnPopup(){

        window.opener.open('', 'popupChk', 'width=500, height=550, top=100, left=400, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
        document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
        document.form_chk.target = "popupChk";
        document.form_chk.submit();
    }

    function fnPopupipin(){
        window.opener.open('', 'popupIPIN2', 'width=300, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
        document.form_ipin.target = "popupIPIN2";
        document.form_ipin.action = "https://cert.vno.co.kr/ipin.cb";
        document.form_ipin.submit();

        self.close();
    }
    
</script>
<?

//휴대폰 인증관련 ##################################################################################
$sitecode = $CheckPlus_sitecode; // NICE로부터 부여받은 사이트 코드
$sitepasswd = $CheckPlus_sitepasswd; // NICE로부터 부여받은 사이트 패스워드

$cb_encode_path = $Auth_Mobile_path;

$authtype = "";      		// 없으면 기본 선택화면, X: 공인인증서, M: 핸드폰, C: 카드 (1가지만 사용 가능)

$popgubun 	= "N";		//Y : 취소버튼 있음 / N : 취소버튼 없음
$customize 	= "";		//없으면 기본 웹페이지 / Mobile : 모바일페이지 (default값은 빈값, 환경에 맞는 화면 제공)

$gender = "";      		// 없으면 기본 선택화면, 0: 여자, 1: 남자

//$reqseq = "REQ_0123456789";     // 요청 번호, 이는 성공/실패후에 같은 값으로 되돌려주게 되므로
$reqseq = $LectureCode."_".date('YmdHis');
// 업체에서 적절하게 변경하여 쓰거나, 아래와 같이 생성한다.
//if (extension_loaded($module)) {// 동적으로 모듈 로드 했을경우
    //$reqseq = get_cprequest_no($sitecode);
//} else {
//	$reqseq = "Module get_request_no is not compiled into PHP";
//}

// CheckPlus(본인인증) 처리 후, 결과 데이타를 리턴 받기위해 다음예제와 같이 http부터 입력합니다.
// 리턴url은 인증 전 인증페이지를 호출하기 전 url과 동일해야 합니다. ex) 인증 전 url : http://www.~ 리턴 url : http://www.~
$returnurl = $SiteURL."/lib/CheckPlusSafe/checkplus_success_first.php";	// 성공시 이동될 URL
$errorurl = $SiteURL."/lib/CheckPlusSafe/checkplus_fail.php";		// 실패시 이동될 URL

// reqseq값은 성공페이지로 갈 경우 검증을 위하여 세션에 담아둔다.

$_SESSION["REQ_SEQ"] = $reqseq;

// 입력될 plain 데이타를 만든다.
$plaindata = "7:REQ_SEQ" . strlen($reqseq) . ":" . $reqseq .
                 "8:SITECODE" . strlen($sitecode) . ":" . $sitecode .
                 "9:AUTH_TYPE" . strlen($authtype) . ":". $authtype .
                 "7:RTN_URL" . strlen($returnurl) . ":" . $returnurl .
                 "7:ERR_URL" . strlen($errorurl) . ":" . $errorurl .
                 "11:POPUP_GUBUN" . strlen($popgubun) . ":" . $popgubun .
                 "9:CUSTOMIZE" . strlen($customize) . ":" . $customize .
                 "6:GENDER" . strlen($gender) . ":" . $gender ;


$enc_data = `$cb_encode_path ENC $sitecode $sitepasswd $plaindata`;


if( $enc_data == -1 )
{
    $returnMsg = "암/복호화 시스템 오류입니다.";
    $enc_data = "";
}
else if( $enc_data== -2 )
{
    $returnMsg = "암호화 처리 오류입니다.";
        $enc_data = "";
}
    else if( $enc_data== -3 )
    {
        $returnMsg = "암호화 데이터 오류 입니다.";
        $enc_data = "";
    }
    else if( $enc_data== -9 )
    {
        $returnMsg = "입력값 오류 입니다.";
        $enc_data = "";
    }

//echo $returnMsg;
//echo $enc_data; //업체정보 암호화 데이타
//휴대폰 인증관련 ##################################################################################

//IPIN 인증관련 ##################################################################################
$sSiteCode				= $IPIN_CheckPlus_sitecode;			// NICE평가정보에서 발급한 IPIN 서비스 사이트코드
$sSitePw				= $IPIN_CheckPlus_sitepasswd;		// NICE평가정보에서 발급한 IPIN 서비스 사이트패스워드
$sModulePath			= $Auth_IPIN_path;			// 하단내용 참조
$sReturnURL				= $SiteURL."/lib/NiceIPIN/ipin_process_first.php";		// 하단내용 참조
$sCPRequest				= session_id();			// 하단내용 참조

// CP요청번호 생성
// 실행방법은 싱글쿼터(`) 외에도, 'exec(), system(), shell_exec()' 등등 귀사 정책에 맞게 처리하시기 바랍니다. 
// 예) $sCPRequest = system("$sModulePath SEQ $sSiteCode");
//$sCPRequest = `$sModulePath SEQ $sSiteCode`;
//$sCPRequest = $LectureCode."_".date('YmdHis');

// CP요청번호 세션에 저장 
// 저장된 값은 ipin_result.php 페이지에서 데이타 위변조 검사에 이용됩니다.
$_SESSION['CPREQUEST'] = $sCPRequest;

$sEncData					= "";			// 암호화 된 데이타
$sRtnMsg					= "";			// 처리결과 메세지

// 암호화 데이타 생성
// 실행방법은 싱글쿼터(`) 외에도, 'exec(), system(), shell_exec()' 등등 귀사 정책에 맞게 처리하시기 바랍니다.
// 예) $sEncData	= system("$sModulePath REQ $sSiteCode $sSitePw $sCPRequest $sReturnURL");
$sEncData	= `$sModulePath REQ $sSiteCode $sSitePw $sCPRequest $sReturnURL`;

// 리턴 결과값에 따른 처리사항
if ($sEncData == -9)
{
    $sRtnMsg = "입력값 오류 : 암호화 처리시, 필요한 파라미터값의 정보를 정확하게 입력해 주시기 바랍니다.";
} else {
    $sRtnMsg = "$sEncData 변수에 암호화 데이타가 확인되면 정상, 정상이 아닌 경우 리턴코드 확인 후 NICE평가정보 개발 담당자에게 문의해 주세요.";
}
//echo "값:".$sEncData;
//IPIN 인증관련 ##################################################################################
?>
<form name="form_chk" method="post">
    <input type="hidden" name="m" value="checkplusSerivce">
    <input type="hidden" name="EncodeData" value="<?= $enc_data ?>">
    <input type="hidden" name="param_r1" value="<?=$ID?>">
    <input type="hidden" name="param_r2" value="">
    <input type="hidden" name="param_r3" value="">
</form>

<form name="form_ipin" method="post">
    <input type="hidden" name="m" value="pubmain">
    <input type="hidden" name="enc_data" value="<?= $sEncData ?>">
	<input type="hidden" name="param_r1" value="<?=$ID?>">
    <input type="hidden" name="param_r2" value="">
    <input type="hidden" name="param_r3" value="">
</form>


    </body>
</html>
