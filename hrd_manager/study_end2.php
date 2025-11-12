<?
$MenuType = "B";
$PageName = "study_end2";
?>
<? include "./include/include_top.php"; ?>
<SCRIPT LANGUAGE="JavaScript">
$(document).ready(function() {
	$("#LectureCode").select2();
	changeSelect2Style();
});
</SCRIPT>
	<div class="contentBody">
    	<h2>과목별 이수증<span class="fs12 description">비환급과정(법정) 개별 이수증 출력할수 있습니다.</span></h2>
        <div class="conZone">
			<script type="text/javascript">
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
	
			<form name="search" id="search" method="POST">
    			<input type="hidden" name="SubmitFunction" id="SubmitFunction" value="StudyEndSearch(1)">
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
            				<span class="item01">실시회차</span>
                        	<input type="text" name="OpenChapter" id="OpenChapter" style="width:100px">
            			</li>
            			<li>
            				<span class="item01 select2-label">과정명</span>
                        	<select name="LectureCode" id="LectureCode" >
            					<option value="">-- 과정 전체 --</option>
            					<?
            					$SQL = "SELECT * FROM Course WHERE Del='N' AND PackageYN = 'N' ORDER BY ContentsName ASC";
            					$QUERY = mysqli_query($connect, $SQL);
            					if($QUERY && mysqli_num_rows($QUERY)){
            						$i = 1;
            						while($Row = mysqli_fetch_array($QUERY)){
            					?>
            					<option value="<?=$Row['LectureCode']?>"><?=$Row['ContentsName']?> | <?=$Row['LectureCode']?></option>
            					<?
            						  $i++;
            						}
            					}
            					?>
            				</select>
                        </li>
    				</ul>
                    <!-- btn -->
    				<div class="mt10 tc pb5">
    					<button type="button" name="SearchBtn" id="SearchBtn" class="btn btn_Blue" style="width:200px;" onclick="StudyEnd2Search()"><i class="fas fa-search"></i> 검색</button>
    				</div>
                    <!-- btn // -->
    			</div>
			</form>
			
			<!--목록 -->
			<div id="SearchResult"><br><br><center><strong>검색 조건을 선택하세요.</strong></center></div>
            <script type="text/javascript">
            $(window).load(function() {            
            	LectureTermeSearch();            
            });
            </script>
        </div>
    </div>
</div>

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>