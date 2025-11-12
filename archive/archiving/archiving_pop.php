<?
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의

if(!$LoginMemberID){
?>
<script>
alert("로그인이 필요한 페이지입니다.");
location.href = "/public/member/login.html";
</script>
<?
}
?>
<script type="text/javascript" src="/include/function.js?t=<?=date('YmdHis')?>"></script>
<style> 
    .modal-wrap2 {position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;z-index:1000;}
    .modal-wrap2 .close-btn { position: absolute;cursor: pointer;}
    .modal-wrap2 .close-btn i {font-size: 35px;}
	.modal-wrap2 .notice{background-color: #f7f7f7;  padding: 10px 20px;  font-size: 14px; margin: 10px 0;}
	.modal-wrap2 .notice p{position: relative; padding-left:160px; margin: 10px 0;}
	.modal-wrap2 .notice p b{position: absolute; top:0; left:0;}
</style>
<div class="modal-bg"></div>
<div id="modal01" class="modal-wrap2">
    <div class="close-btn" onclick="javascript:DataResultClose();"><img src="../img/common/close.png" alt="닫기기"></div>
    <h2>아카이빙 등록</h2>
	<div class="notice">
		<p>
			<b>올바른 업로드 요청 예시</b>
			✔ 기업 내 직무 교육 영상<br>
			✔ 산업별 전문 교육 자료<br>
			✔ 사내 역량 강화 프로그램 콘텐츠
		</p>
		<p>
		<b>업로드 제한 대상</b>
			✖ 광고 및 홍보성 영상<br>
			✖ 저작권 문제가 있는 콘텐츠<br>
			✖ 교육과 무관한 일반 영상
		</p>
	</div>
    <form name="ArchivingForm" method="POST" enctype="multipart/form-data" action="/archive/archiving/archiving_ok.php" target="ScriptFrame">
		<input type="hidden" name="CsrfToken" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
    	<div class="input_wrap mt10">
	        <p class="title">제목</p>
	        <div class="input_box">
	            <input readonly type="text" name='Title' id='Title' class="input-title" value="기업자체컨텐츠 등록 요청">
	        </div>
	    </div>
	    <div class="input_wrap mt10">
	        <p class="title">내용</p>
	        <div class="input_box">
	            <textarea name="Content" id="Content" cols="30" rows="10" placeholder="내용을 입력해 주세요" class="input-content "></textarea>
	        </div>
	    </div>
	    <div class="input_wrap">
	        <p class="title">파일 업로드</p>
	        <div class="input_box">
	            <input name="file" id="file" type="file" class="input-file" id="input-file">
				<output id="output-file"></output>
	            <span>사진 첨부는 10MB 미만 파일만 등록 가능합니다.</span>
	        </div>
	    </div>
	    <div class="submit_btn">
	        <button type='button' onclick="uploadArchiving()" >등록</button>
	    </div>
    </form>
    
</div>
<script>
/* 파일용량 제한*/
$("input[name=file").on("change", function(){
    let maxSize = 10 * 1024 * 1024; //* 10MB 사이즈 제한
	let fileSize = this.files[0].size; //업로드한 파일용량

    if(fileSize > maxSize){
		alert("파일첨부 사이즈는 10MB 이내로 가능합니다.");
		input.value = ""; //업로드한 파일 제거
		output.value = "";
		return; 
	}
});

function uploadArchiving(){
	var form = $("form[name='ArchivingForm']");
	if (form) {
		if ($('#Content').val() == '') {
			alert('내용을 입력하세요.');
			$('#Content').focus();
			return;
		}
		if ($('#file').val() == '') {
			alert('파일을 등록해주세요.');
			$('#file').focus();
			return;
		}
				
		Yes = confirm('등록하시겠습니까?');
		if (Yes == true) {
			form.submit();
		}
	}else{
		console.error('cannot find a form');
	}
}
</script>