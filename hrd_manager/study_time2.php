<?
$MenuType = "B";
$PageName = "study_time2";
?>
<? include "./include/include_top.php"; ?>
<script type="text/javascript">
$(document).ready(function(){
	$("#StudyDate").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$("#StudyDate").val("");
	$("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:top; cursor:pointer;"); //이미지 버튼 style적용
});
</script>
<div class="contentBody">
	<h2>일자별 학습시간 관리</h2>
    <div class="conZone">
		<form name="search" id="search" method="POST">
			<input type="hidden" name="SubmitFunction" id="SubmitFunction" value="StudyIPSearch(1)">
			<div class="neoSearch">
				<ul class="search">
					<li>
						<span class="item01">수강날짜</span>&emsp;
						<input name="StudyDate" id="StudyDate" type="text" size="12" value="" readonly>
					</li>
					<li>
						<span class="item01">아이디</span>&emsp;
						<input type="text" name="ID" id="ID" style="width:100px">
					</li>
				</ul>
                <!-- btn -->
			  	<div class="mt10 tc pb5">
                	<button type="button" name="SearchBtn" id="SearchBtn" class="btn btn_Blue" style="width:200px;" onclick="StudyTime2Search(1)"><i class="fas fa-search"></i> 검색</button>&nbsp;&nbsp;
	      		</div>
                <!-- btn // -->
			</div>
		</form>
		
        <!--목록 -->
        <div id="SearchResult"><br><br><center><strong>검색 조건을 선택하세요.</strong></center></div>
    </div>
</div>
</div>

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>