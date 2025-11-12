<?
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의

if($LoginMemberID) {
    
    $Sql = "SELECT * FROM Member WHERE ID='$LoginMemberID'";
    //echo $Sql;
    $Result = mysqli_query($connect, $Sql);
    $Row = mysqli_fetch_array($Result);
    
    if($Row) {
        $Name = $Row['Name'];
        $Mobile = $Row['Mobile'];
        $Email = $Row['Email'];
    }
}
?>
<script type="text/javascript" src="/include/function.js?t=<?=date('YmdHis')?>"></script>

<!-- <form name="CounselAskForm" method="POST" action="/public/support/counsel_ask_ok.php" target="ScriptFrame"> -->
<!-- <input type="hidden" name="ID" id="ID" value="<?=$LoginMemberID?>"> -->
<!-- layer Ask -->

<style> 
    .modal-wrap2 {position:fixed;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;z-index:1000;}
    .modal-wrap2 .close-btn { position: absolute;cursor: pointer;}
    .modal-wrap2 .close-btn i {font-size: 35px;}
</style>
<!--modal01-->
<div class="modal-bg"></div>
<div id="modal01" class="modal-wrap2">
    <div class="close-btn" onclick="javascript:DataResultClose();">
        <i class="ph-thin ph-x"></i>
    </div>
    <h2>상담 문의 등록</h2>
    <form name="CounselForm" method="POST" enctype="multipart/form-data" action="/public/support/ask_ok.php" target="ScriptFrame">
    	<input type='hidden' name='Name' value='<?=$Name?>'>
    	<input type='hidden' name='Mobile' value='<?=$Mobile?>'>
    	<input type='hidden' name='Email' value='<?=$Email?>'>
	    <div class="input_wrap mt50">
	        <p class="title">문의 종류</p>
	        <div class="input_box">
	       		<select name="CounselType" id="CounselType" class="input-type">
		       	<?
		    		while (list($key,$value)=each($Counsel_array)) {
    			?>
						<option value="<?=$key?>" <?if($Status==$key) {?>selected<?}?>><?=$value?></option>
					<?}?>
	        	</select>
	        </div>
	    </div>
	    <div class="input_wrap mt10">
	        <p class="title">문의 내용</p>
	        <div class="input_box">
	            <input type="text" name='Title' id='Title' placeholder="제목을 입력해 주세요" class="input-title">
	            <textarea name="Content" id="Content" cols="30" rows="10" placeholder="내용을 입력해 주세요" class="input-content "></textarea>
	        </div>
	    </div>
	    <div class="input_wrap">
	        <p class="title">사진 첨부</p>
	        <div class="input_box">
	            <input name="file" type="file" class="input-file" id="input-file">
				<output id="output-file"></output>
	            <span>사진 첨부는 10MB 미만 파일만 등록 가능합니다.</span>
	        </div>
	    </div>
	    <div class="input_wrap">
	        <p class="title">보안 코드</p>
		    <div class="input_box captcha_box">
	            <div class="captcha"><img src="/include/make_image.php" alt=""></div>
	            <input type="text" name="SecurityCode" id="SecurityCode" placeholder="왼쪽의 보안코드를 입력해주세요." class="input-title">
	        </div>
	    </div>
	    <div class="submit_btn">
	        <button type='button' onclick="uploadCounsel()" >등록</button> <!-- href="#modal02" -->
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
</script>