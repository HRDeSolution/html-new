<?
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의
?>
<script type="text/javascript" src="/include/function.js?t=<?=date('YmdHis')?>"></script>
<style> 
    .modal-wrap {position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;z-index:1000;height: 90%;overflow-y: auto; border-radius: 15px;}
    .modal-wrap::-webkit-scrollbar { display: none; }
    .modal-wrap .close-btn { position: absolute;cursor: pointer;}
    .modal-wrap .close-btn i {font-size: 35px;}
</style>
<div id="modal01" class="modal-wrap">
    <div class="close-btn" onclick="Javascript:DataResultClose();"><i class="ph-thin ph-x"></i></div>
    <h2>서비스 문의</h2>
    <form name="InquiryForm" method="POST" action="/hrdflex/main/inquiry_ok.php" target="ScriptFrame">
        <div class="input_wrap mt50">
            <p class="title">문의 종류</p>
            <div class="input_box">
                <select name="ServiceType" id="ServiceType" class="input-type">
                	<?while (list($key,$value)=each($Inquiry_type_array)) {?>
    				<option value="<?=$key?>"><?=$value?></option>
    				<?}?>
                </select>
            </div>
        </div>
        <div class="input_wrap">
            <p class="title">회사명</p>
            <div class="input_box"><input type="text" name="CompanyName" id="CompanyName" placeholder="회사명을 입력해 주세요" class="input-title"></div>
        </div>
        <div class="input_wrap">
            <p class="title">이름</p>
            <div class="input_box"><input type="text" name="Name" id="Name" placeholder="담당자 이름을 입력해 주세요" class="input-title"></div>
        </div>
        <div class="input_wrap">
            <p class="title">연락처</p>
            <div class="phonenumber_input input_box">
            	<input type="text" name="Phone01" id="Phone01" maxlength="3" > - <input type="text" name="Phone02" id="Phone02" maxlength="4"> - <input type="text" name="Phone03" id="Phone03" maxlength="4" >
            </div>
        </div>
        <div class="input_wrap">
            <p class="title">이메일</p>
            <div class="input_box"><input type="text" name="Email" id="Email" placeholder="회사 이메일을 입력해 주세요" class="input-title"></div>
        </div>
        <div class="input_wrap">
            <p class="title">예상인원</p>
            <div class="input_box"><input type="text" name="Personnel" id="Personnel" placeholder="직원 수를 입력해 주세요" class="input-title"></div>
        </div>
        <div class="input_wrap">
            <p class="title">문의 내용</p>
            <div class="input_box">
                <textarea name="Contents" id="Contents" cols="30" rows="10" placeholder="문의내용을 입력해 주세요"></textarea>
            </div>
        </div>
        <div class="notice_box">
            <div class="title">개인정보 수집 및 이용에 대한 안내</div>
            <div class="content">
                <p>- 수집항목: 이름, 이메일, 연락처 그 외 개인이 직접 입력한 내용</p>
                <p>- 수집목적: 문의 결과 회신</p>
                <p>- 이용기간: 개인정보 수집 및 이용목적 달성 후 해당정보 즉시 파기</p>
            </div>
            <div class="agree">
                <input type="checkbox" name="Agree" id="Agree">
                <label for="agree">위 개인정보 수집 및 이용에 동의합니다.</label>
            </div>
        </div>
        <div class="submit_btn">
        	<button type="button" onclick="InsertInquiry()">문의하기</button>
    	</div>
	</form>
</div>