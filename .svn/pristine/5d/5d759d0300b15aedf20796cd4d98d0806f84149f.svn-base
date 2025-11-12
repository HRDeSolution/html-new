<?
$MenuType = "F";
$PageName = "study_correct2";
?>
<? include "./include/include_top.php"; ?>
<SCRIPT LANGUAGE="JavaScript">
$(document).ready(function() {
	$("#ID").bind("focus", function() {
		$(document).keydown(function(e) {
			if(e.keyCode===13) {
				StudyCorrectSearch(1);
			}
		});
	});
});
$(window).load(function() {
	LectureTermeSearch();
});
</SCRIPT>
	<div class="contentBody">
    	<h2>첨삭관리</h2>
        <div class="conZone">
			<!-- 검색 -->
			<form name="search" id="search" method="POST">
    			<input type="hidden" name="SubmitFunction" id="SubmitFunction" value="StudyCorrectSearch2(1)">
    			<input type="hidden" name="ctype" id="ctype" value="B">
    			<div class="neoSearch">
    				<ul class="search">
    					<li>
    						<span class="item01">수강기간</span>&nbsp;
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
    						</span>
                            <span id="SearchGubunResult2" style="display:none"><input type="text" name="CompanyName" id="CompanyName" style="width:450px" placeholder="사업주명 입력" onfocus="CompanySearchAutoCompleteGo();" onKeyup="CompanySearchAutoCompleteGo();"></span>
    						<div id="CompanyAutoCompleteResult" class="auto_complete_layer" style="display:none"></div>
    						<span id="CompanySearchLectureTermeResult"></span>
    					</li>
    				</ul>
    				<ul class="search">
    					<li>
    						<span class="item01">이름,ID</span>
                        	<input type="text" name="ID" id="ID" style="width:150px">
    					</li>
    					<li>
    						<span class="item01">진도율</span>
                       	  <input type="text" name="Progress1" id="Progress1" style="width:40px"> % ~ <input type="text" name="Progress2" id="Progress2" style="width:40px"> %
                   	  </li>
                   	  <li>
                   	  		<span class="item01">교강사</span>
                        	<select name="Tutor" id="Tutor" style="width:150px">
    							<option value="">전체</option>
    							<?
    							$SQL = "SELECT * FROM StaffInfo WHERE Dept='C' AND Del='N' ORDER BY Name ASC";
    							$QUERY = mysqli_query($connect, $SQL);
    							if($QUERY && mysqli_num_rows($QUERY)){
    								$i = 1;
    								while($Row = mysqli_fetch_array($QUERY)){    
    							?>
    							<option value="<?=$Row['ID']?>"><?=$Row['Name']?> | <?=$Row['ID']?></option>
    							<?
    								$i++;
    								}
    							}
    							?>
    						</select>
	                    </li>
    				</ul>
                    <ul class="search">
    					<li>
    						<span class="item01">중간평가</span>
    						<select name="MidStatus" id="MidStatus" style="width:150px">
    							<option value="">전체</option>
    							<option value="C">응시(채점완료)</option>
    							<option value="Y">응시(채점대기중)</option>
    							<option value="N">미응시</option>
    						</select>
                        </li>
    					<li>
    						<span class="item01">최종평가</span>
    						<select name="TestStatus" id="TestStatus" style="width:150px">
    							<option value="">전체</option>
    							<option value="C">응시(채점완료)</option>
    							<option value="Y">응시(채점대기중)</option>
    							<option value="N">미응시</option>
    						</select>
                        </li>
                        <li>
                        	<span class="item01">과제</span>
    						<select name="ReportStatus" id="ReportStatus" style="width:150px">
    							<option value="">전체</option>
    							<option value="C">응시(채점완료)</option>
    							<option value="Y">응시(채점대기중)</option>
    							<option value="N">미응시</option>
    							<option value="R">반려</option>
    						</select>
                        </li>
                        <li>
                        	<span class="item01">평가 모사</span>
    						<select name="TestCopy" id="TestCopy" style="width:150px">
    							<option value="">전체</option>
    							<option value="D">모사답안의심</option>
    							<option value="Y">모사답안</option>
    						</select>
                        </li>
                        <li><span class="item01">과제 모사</span>
    						<select name="ReportCopy" id="ReportCopy" style="width:150px">
    							<option value="">전체</option>
    							<option value="D">모사답안의심</option>
    							<option value="Y">모사답안</option>
    						</select>
                        </li>
    				</ul>
    				<div class="mt10 tc pb5">
    					<button type="button" name="SearchBtn" id="SearchBtn" class="btn btn_Blue" style="width:200px;" onclick="StudyCorrectSearch2(1)"><i class="fas fa-search"></i> 검색</button>&nbsp;&nbsp;	
    					<button type="button" name="ExcelBtn" id="ExcelBtn" class="btn btn_Green line" style="width:200px;" onclick="StudyCorrect2Excel();"><i class="fas fa-file-excel"></i> 검색 결과 엑셀 출력</button>
    				</div>
    			</div>
			</form>
			<!-- //검색 -->
            
            <div id="SearchResult"><br><br><center><strong>검색 조건을 선택하세요.</strong></center></div>
		</div>
	</div>
</div>

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>