<?
$MenuType = "E";
$PageName = "study_payment";
$ReadPage = "study_payment_read";
?>
<? include "./include/include_top.php"; ?>
<script type="text/javascript">
$(window).load(function() {
	LectureTermeSearch();
});
$(document).ready(function(){
	$("#LectureStart, #LectureEnd").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$("#LectureStart, #LectureEnd").val("");
	$("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:top; cursor:pointer;"); //이미지 버튼 style적용
});
</script>
	<div class="contentBody">
    	<h2>결제관리<span class="fs12 description">사업자의 교육비 결제를 관리합니다.</span></h2>
        <div class="conZone">
			<!-- 검색 -->
			<form name="search" id="search" method="POST">
    			<input type="hidden" name="SubmitFunction" id="SubmitFunction" value="StudyPaymentSearch(1)">
    			<div class="neoSearch">
    				<ul class="search">
    					<li>
    						<span class="item01"><label>수강기간</label></span>
    						<input name="LectureStart" id="LectureStart" type="text" size="12" value="" autocomplete='off'>  ~  <input name="LectureEnd" id="LectureEnd" type="text" size="12" value="" autocomplete='off'>
    					</li>
    					<li>
    						<span class="item01"><label>사업주명</label></span>
    						<input type="text" name="CompanyName" id="CompanyName" style="width:390px" placeholder="사업주명 입력" onfocus="CompanySearchAutoCompleteGo('B');" onKeyup="CompanySearchAutoCompleteGo('B');" autocomplete="off">
    						<div id="CompanyAutoCompleteResult" class="auto_complete_layer" style="display:none; left:440px"></div>
    						<span id="CompanySearchLectureTermeResult"></span>
    					</li>
    					<li>
    						<span class="item01"><label>환급여부</label></span>
    						<select name="ServiceType" id="ServiceType" style="width:150px">
    							<option value="">전체</option>
    							<?
    							while (list($key,$value)=each($ServiceType1_array)) {
    								?>
    								<option value="<?=$key?>"><?=$value?></option>
    							<?
    							}
    							reset($ServiceType1_array);
    							?>
    						</select>
    					</li>
    				</ul>
                    
                    <div class="mt10 tc pb5">
    					<button type="button" name="SearchBtn" id="SearchBtn" class="btn btn_Blue" style="width:200px;" onclick="StudyPaymentSearch()"><i class="fas fa-search"></i> 검색</button>
    					<button type="button" name="ExcelBtn" id="ExcelBtn" class="btn btn_Green line" style="width:200px;" onclick="StudyPaymentExcel();"><i class="fas fa-file-excel"></i> 검색 항목 엑셀 출력</button>
    				</div>
    			</div>
			</form>			
			<!-- //검색 -->
            
			<!--목록 -->
			<div id="SearchResult"><br><br><center><strong>검색 조건을 선택하세요.</strong></center></div>
       </div>
	</div>
</div>

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>