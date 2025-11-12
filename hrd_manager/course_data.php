<?
$MenuType = "B";
$PageName = "course_data";
?>
<? include "./include/include_top.php"; ?>
<SCRIPT LANGUAGE="JavaScript">
$(document).ready(function() {
	$("#LectureCode").select2();
	changeSelect2Style();
});

$(window).load(function() {
	LectureTermeSearch();
});
</SCRIPT>
    <div class="contentBody">
    	<h2>과정 이수데이터 관리</h2>
        <div class="conZone">
        	<form name="search" id="search" method="POST">
            	<input type="hidden" name="SubmitFunction" id="SubmitFunction" value="CourseDataSearch(1)">
            	<input type="hidden" name="LectureStart" id="LectureStart">
            	<input type="hidden" name="LectureEnd" id="LectureEnd">
            	<input type="hidden" name="CompanyCodeA" id="CompanyCodeA">
            	<div class="neoSearch">
            		<ul class="search">
            			<li style="border:none;">
                        	<input type="radio" name="SearchGubun" id="SearchGubun1" value="A" checked onclick="SearchGubunChange('A')" style="width:15px; height:15px; background:none; border:none;">
                          	<span class="item01"><label for="SearchGubun1">기간 검색</label></span>&emsp;
            				<input type="radio" name="SearchGubun" id="SearchGubun2" value="B" onclick="SearchGubunChange('B')" style="width:15px; height:15px; background:none; border:none;">
            				<span class="item01"><label for="SearchGubun2">사업주 검색</label></span>
                        </li>
            			<li>
            				<span id="SearchGubunResult1">
                                <select name="SearchYear" id="SearchYear" onchange="LectureTermeSearch()" style="width:100px">
            						<?for($i=2018;$i<=date("Y");$i++) {?>
            						<option value="<?=$i?>" <?if($i==date("Y")) {?>selected<?}?>><?=$i?>년</option>
            						<?}?>
                              	</select>&nbsp;
            					<select name="SearchMonth" id="SearchMonth" onchange="LectureTermeSearch()" style="width:80px">
            						<option value="">전체</option>
            						<?for($i=1;$i<=12;$i++) {?>
            						<option value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>" <?if($i==date("m")) {?>selected<?}?>><?=$i?>월</option>
            						<?}?>
                              	</select>
                                <span id="LectureTermeResult"></span>
            					<span id="LectureCompanyResult"></span>
            				</span>
                            <span id="SearchGubunResult2" style="display:none"><input type="text" name="CompanyName" id="CompanyName" style="width:450px" placeholder="사업주명 입력" onfocus="CompanySearchAutoCompleteGo('A');" onKeyup="CompanySearchAutoCompleteGo('A');"></span>
            				<div id="CompanyAutoCompleteResult" class="auto_complete_layer" style="display:none"></div>
            				<span id="CompanyTerm" style="display:none">
            					<input type="hidden" name="CompanyCode" id="CompanyCode">
            					<select name="SearchYear2" id="SearchYear2" onchange="CompanySearchLectureTermeSearch(document.getElementById('CompanyCode').value)" style="width:100px">
                                	<?for($i=2018;$i<=date("Y");$i++) {?>
                                	<option value="<?=$i?>" <?if($i==date("Y")) {?>selected<?}?>><?=$i?>년</option>
                                	<?}?>
                                </select>&nbsp;
                                <select name="SearchMonth2" id="SearchMonth2" onchange="CompanySearchLectureTermeSearch(document.getElementById('CompanyCode').value)" style="width:80px">
                                	<option value="">전체</option>
                                	<?for($i=1;$i<=12;$i++) {?>
                                	<option value="<?=str_pad($i, 2, "0", STR_PAD_LEFT)?>" <?if($i==date("m")) {?>selected<?}?>><?=$i?>월</option>
                                	<?}?>
                                </select>
            				</span>
            				<span id="CompanySearchLectureTermeResult"></span>
            			</li>
            			<li>
            				<span class="item01">실시회차</span>
                        	<input type="text" name="OpenChapter" id="OpenChapter" style="width:100px">
            			</li>
            		</ul>
            		
                    <!-- btn -->
            		<div class="mt10 tc pb5">
                    	<button type="button" name="ExcelBtn" id="ExcelBtn" class="btn btn_Green line" style="width:200px;" onclick="CourseDataExcel();">검색 결과 &nbsp;<i class="fas fa-file-excel"></i> 엑셀 출력</button>
                    	<button type="button" name="SearchBtn" id="SearchBtn" class="btn btn_Blue" style="width:200px;" onclick="CourseDataSearch(1)"><i class="fas fa-search"></i> 검색</button>					
            		</div>
                    <!-- btn // -->
            	</div>
        	</form>
        	
        	<!--목록 -->
        	<div id="SearchResult"><br><br><center><strong>검색 조건을 선택하세요.</strong></center></div>
        	<!--//목록 -->
        </div>
    </div>
</div>

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>