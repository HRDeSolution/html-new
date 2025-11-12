<?
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의

if($LoginMemberID) {

	$Sql = "SELECT *, AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile FROM Member WHERE ID='$LoginMemberID'";
	//echo $Sql;
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {

		$Name = $Row['Name'];
		$Mobile = $Row['Mobile'];
		$Email = $Row['Email'];

		$Mobile_Array = explode("-",$Mobile);
		$Mobile01 = $Mobile_Array[0];
		$Mobile02 = $Mobile_Array[1];
		$Mobile03 = $Mobile_Array[2];

	}

}
?>
<!-- layer Ask -->
<style> 
    .modal-wrap2 {position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;z-index:1000;  padding: 50px;}
    .modal-wrap2 h2{ font-size: 30px; font-weight: bold; line-height: 50px;}
    .modal-wrap2 .close-btn { position: absolute;cursor: pointer;  top: 50px; right: 50px;}
    .modal-wrap2 .close-btn i {font-size: 35px;}
</style>

<!--modal01-->
<!--간편문의 팝업-->
<div id="modal01" class="modal-wrap2">
    <div class="close-btn" onclick="javascript:DataResultClose();">
        <i class="fa-solid fa-xmark"></i>
    </div>
    <h2>간편문의</h2>
    
    <form name="SimpleAskForm" method="POST" action="/public/member/simple_ask_ok.php" target="ScriptFrame">
		<input type="hidden" name="ID" id="ID" value="<?=$LoginMemberID?>">
	    <div class="input_wrap mt50">
	        <p class="title">이름</p>
	        <div class="input_box">
	            <input name="Name" id="Name" type="text" class="wid200" maxlength="20" value="<?=$Name?>" />
	        </div>
	    </div>
	    <div class="input_wrap">
	        <p class="title">전화번호</p>
	        <div class="input_box">
	            <div class="phonenumber_input">
	                <input type="text"  value="<?=$Mobile01?>" name="Phone01" id="Phone01" maxlength="3" > - <input type="text" value="<?=$Mobile02?>" name="Phone02" id="Phone02" maxlength="4"> - <input type="text" value="<?=$Mobile03?>" name="Phone03" id="Phone03" maxlength="4" > 
	            </div>
	        </div>
	    </div>
	    <div class="input_wrap">
	        <div class="input_wrap">
	            <p class="title">이메일</p>
	            <div class="input_box">
	                <input type="text" name="Email" id="Email" class="wid330" maxlength="50" value="<?=$Email?>" />
	            </div>
	        </div>
	    </div>
	    <div class="input_wrap">
	        <div class="input_wrap">
	            <p class="title">문의내용</p>
	            <div class="input_box">
	                <textarea name="Contents" id="Contents" cols="30" rows="10" placeholder="내용을 입력해 주세요" class="input-content "></textarea>
	            </div>
	        </div>
	    </div>
	    <div class="input_wrap mt20">
	        <p class="title">보안 코드</p>
	        <div class="input_box captcha_box">
	            <div class="captcha"><img src="/include/make_image.php" alt=""></div>
	            <input type="text" name="SecurityCode" id="SecurityCode" placeholder="왼쪽의 보안코드를 입력해주세요." class="input-title">
	        </div>
	    </div>
	    <div class="notice_box">
	        <p class="title">답변<br>알림</p>
	        <div> 
	        	<p>- 기재한 메일 주소와 연락처로 답변이 전송됩니다.</p>
	         	<p>- 메일 주소와 연락처는 회원님의 의견 답변을 위한 용도로만 이용됩니다.</p>
	            <p>- 수신 거부 상태이면 답변 알림을 받을 수 없습니다.</p>
	        </div>
	    </div>
	    <div class="agree_wrap">
	        <input type="checkbox" name="privacy" id="privacy">
	        <label for="agree">개인정보수집방침에 동의합니다.</label>
	        <button type='button' onclick="window.open('/public/etc/agreement.html')">내용보기</button>
	    </div>
	    <div class="submit_btn">
	        <button type='button' onclick="SimpleAskSubmit()">등록</button>
	    </div>
	</form>
</div>