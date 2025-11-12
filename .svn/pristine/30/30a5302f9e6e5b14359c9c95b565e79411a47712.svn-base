<?
$MenuType = "E";
$PageName = "practice";
?>
<? include "./include/include_top.php"; ?>
<SCRIPT LANGUAGE="JavaScript">
$(document).ready(function(){
	//교육과정 검색기능
	$("#LectureCode1").select2();
	$("#LectureCode2").select2();
	$("#LectureCode3").select2();
	$("#LectureCode4").select2();
	$("#LectureCode5").select2();
	$("#LectureCode6").select2();
	$("#LectureCode7").select2();
	$("#LectureCode8").select2();
	changeSelect2Style();

	//교육일정 달력
	for(var j=1; j<9; j++){
		var data = "#LectureStart"+j+", #LectureEnd"+j;
		
		$(data).datepicker({
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
			buttonImage: "images/icn_calendar.gif", //이미지 주소
			buttonImageOnly: true //이미지만 보이기
		});
		$(data).val("");
		$("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:top; cursor:pointer;"); //이미지 버튼 style적용
		
	}
});

var i = 1;
var chk;
//교육과정 선택 시, 우측에 선택한 교육과정 표출
function chageLangSelect(data){
	var span = "Lecture"+data+"Span";
	var del = "Lecture"+data+"Del";
	var list = "LectureCode"+data+"List";
	
	//var cnt = $("span[name='"+span+"']").length+1;
	var cnt = $("input[name='"+list+"']").length+1;

	console.log(cnt);	
	if(chk != ''){
		i = cnt;
	}
	
	var selectVal = $('#LectureCode'+data).val();
	var LectureCode = selectVal.split('|')[1];
	LectureCode = LectureCode.replace(/\s/gi, "");	

	var onclickFn = "LectureCodeDel('"+span+"', '"+del+"', '"+list+"', '"+i+"')";

	$('#LectureList'+data).show();

	var row = '<span style="font-weight:400;" name="'+span+'" id="'+span+'_'+i+'">'+selectVal+'</span>&nbsp;&nbsp;&nbsp;&nbsp;';
	row += '<span id="'+del+'_'+i+'" onclick="'+onclickFn+'" style="font-weight: bold;">삭제</span><br>';
	row += '<input type="hidden" name="'+list+'" id="'+list+'_'+i+'" value="' + LectureCode + '" readonly>';
	$(row).appendTo('#LectureList'+data);
	i++;
	chk = data;
}

//교육과정 삭제기능
function LectureCodeDel(span, del, list, idx){
	$("span[id='"+span+"_"+idx+"']").remove();
	$("span[id='"+del+"_"+idx+"']").remove();
	$("input[id='"+list+"_"+idx+"']").hide();
	$("input[id='"+list+"_"+idx+"']").val('');
}
</SCRIPT>
	<div class="contentBody">
    	<h2>실시관리</h2>
        <div class="conZone">
            <!-- serach -->
			<form name="search" id="search" method="POST">
    			<div class="neoSearch">
    				<ul class="search">
						<li>
    						<span class="item01">사업주명</span>&nbsp;&nbsp;
    						<span id="SearchGubunResult2"><input type="text" name="CompanyName" id="CompanyName" style="width:450px" placeholder="사업주명 입력" onfocus="CompanySearchAutoCompleteGo('B');" onKeyup="CompanySearchAutoCompleteGo('B');"></span>
    						<div id="CompanyAutoCompleteResult" class="auto_complete_layer" style="display:none"></div>
							<span id="CompanySearchLectureTermeResult"></span>
    					</li>
    				</ul>
					<div class="ScheduleA">
						<div class="title">연간 교육일정(법정교육)</div>
						<ul class="search">
							<li>
								<span class="item01">5대 법정교육</span>
								<select name="Schedule1" id="Schedule1" style="width:150px">
									<option value="">전체</option>
									<option value="1">1분기</option>
									<option value="2">2분기</option>
									<option value="3">3분기</option>
									<option value="4">4분기</option>
								</select>
							</li>
							<li>
        						<span class="item01 select2-label">과정명</span>
                            	<select name="LectureCode1" id="LectureCode1" onchange="chageLangSelect(1)">
        							<option value="">-- 교육 과정 전체 --</option>
        							<?
        							$SQL = "SELECT * FROM Course WHERE Del='N' AND PackageYN='N' AND ctype='A' ORDER BY ContentsName ASC";
        							$QUERY = mysqli_query($connect, $SQL);
        							if($QUERY && mysqli_num_rows($QUERY)){
        								$i = 1;
        								while($Row = mysqli_fetch_array($QUERY)){
        									if($Row['PackageYN']=="Y") {
        										$PackageYN = " (패키지)";
        									}else{
        										$PackageYN = "";
        									}
        							?>
        							<option value="<?=$Row['ContentsName']?> | <?=$Row['LectureCode']?>"><?=$Row['ContentsName']?> | <?=$Row['LectureCode']?> <?=$PackageYN?></option>
        							<?
        								    $i++;
        								}
        							}
        							?>
        						</select><br>
        						<span id="LectureList1" style="display:none;"></span>
                            </li>                        	
                        	<li>
        						<span class="item01">교육일정</span>&nbsp;&nbsp;
        						<input name="LectureStart1" id="LectureStart1" type="text" size="12" value="" autocomplete='off'> ~
        						<input name="LectureEnd1" id="LectureEnd1" type="text" size="12" value="" autocomplete='off'>
        					</li>
						</ul>
						<ul class="search">
							<li>
								<span class="item01">공공기관 일반기관 필수교육</span>
								<select name="Schedule2" id="Schedule2" style="width:150px">
									<option value="">전체</option>
									<option value="1">1분기</option>
									<option value="2">2분기</option>
									<option value="3">3분기</option>
									<option value="4">4분기</option>
								</select>
							</li>
							<li>
        						<span class="item01 select2-label">과정명</span>
                            	<select name="LectureCode2" id="LectureCode2" onchange="chageLangSelect(2)">
        							<option value="">-- 교육 과정 전체 --</option>
        							<?
        							$SQL = "SELECT * FROM Course WHERE Del='N' AND PackageYN='N' AND ctype='A' ORDER BY ContentsName ASC";
        							$QUERY = mysqli_query($connect, $SQL);
        							if($QUERY && mysqli_num_rows($QUERY)){
        								$i = 1;
        								while($Row = mysqli_fetch_array($QUERY)){
        									if($Row['PackageYN']=="Y") {
        										$PackageYN = " (패키지)";
        									}else{
        										$PackageYN = "";
        									}
        							?>
        							<option value="<?=$Row['ContentsName']?> | <?=$Row['LectureCode']?>"><?=$Row['ContentsName']?> | <?=$Row['LectureCode']?> <?=$PackageYN?></option>
        							<?
        								    $i++;
        								}
        							}
        							?>
        						</select><br>
        						<span id="LectureList2" style="display:none;"></span>
                            </li>                        	
                        	<li>
        						<span class="item01">교육일정</span>&nbsp;&nbsp;
        						<input name="LectureStart2" id="LectureStart2" type="text" size="12" value="" autocomplete='off'> ~
        						<input name="LectureEnd2" id="LectureEnd2" type="text" size="12" value="" autocomplete='off'>
        					</li>
						</ul>
						<ul class="search">
							<li>
								<span class="item01">의료기관 법정교육</span>
								<select name="Schedule3" id="Schedule3" style="width:150px">
									<option value="">전체</option>
									<option value="1">1분기</option>
									<option value="2">2분기</option>
									<option value="3">3분기</option>
									<option value="4">4분기</option>
								</select>
							</li>
							<li>
        						<span class="item01 select2-label">과정명</span>
                            	<select name="LectureCode3" id="LectureCode3" onchange="chageLangSelect(3)">
        							<option value="">-- 교육 과정 전체 --</option>
        							<?
        							$SQL = "SELECT * FROM Course WHERE Del='N' AND PackageYN='N' AND ctype='A' ORDER BY ContentsName ASC";
        							$QUERY = mysqli_query($connect, $SQL);
        							if($QUERY && mysqli_num_rows($QUERY)){
        								$i = 1;
        								while($Row = mysqli_fetch_array($QUERY)){
        									if($Row['PackageYN']=="Y") {
        										$PackageYN = " (패키지)";
        									}else{
        										$PackageYN = "";
        									}
        							?>
        							<option value="<?=$Row['ContentsName']?> | <?=$Row['LectureCode']?>"><?=$Row['ContentsName']?> | <?=$Row['LectureCode']?> <?=$PackageYN?></option>
        							<?
        								    $i++;
        								}
        							}
        							?>
        						</select><br>
        						<span id="LectureList3" style="display:none;"></span>
                            </li>                        	
                        	<li>
        						<span class="item01">교육일정</span>&nbsp;&nbsp;
        						<input name="LectureStart3" id="LectureStart3" type="text" size="12" value="" autocomplete='off'> ~
        						<input name="LectureEnd3" id="LectureEnd3" type="text" size="12" value="" autocomplete='off'>
        					</li>
						</ul>
						<ul class="search">
							<li>
								<span class="item01">의료기관 인증 필수교육</span>
								<select name="Schedule4" id="Schedule4" style="width:150px">
									<option value="">전체</option>
									<option value="1">1분기</option>
									<option value="2">2분기</option>
									<option value="3">3분기</option>
									<option value="4">4분기</option>
								</select>
							</li>
							<li>
        						<span class="item01 select2-label">과정명</span>
                            	<select name="LectureCode4" id="LectureCode4" onchange="chageLangSelect(4)">
        							<option value="">-- 교육 과정 전체 --</option>
        							<?
        							$SQL = "SELECT * FROM Course WHERE Del='N' AND PackageYN='N' AND ctype='A' ORDER BY ContentsName ASC";
        							$QUERY = mysqli_query($connect, $SQL);
        							if($QUERY && mysqli_num_rows($QUERY)){
        								$i = 1;
        								while($Row = mysqli_fetch_array($QUERY)){
        									if($Row['PackageYN']=="Y") {
        										$PackageYN = " (패키지)";
        									}else{
        										$PackageYN = "";
        									}
        							?>
        							<option value="<?=$Row['ContentsName']?> | <?=$Row['LectureCode']?>"><?=$Row['ContentsName']?> | <?=$Row['LectureCode']?> <?=$PackageYN?></option>
        							<?
        								    $i++;
        								}
        							}
        							?>
        						</select><br>
        						<span id="LectureList4" style="display:none;"></span>
                            </li>                        	
                        	<li>
        						<span class="item01">교육일정</span>&nbsp;&nbsp;
        						<input name="LectureStart4" id="LectureStart4" type="text" size="12" value="" autocomplete='off'> ~
        						<input name="LectureEnd4" id="LectureEnd4" type="text" size="12" value="" autocomplete='off'>
        					</li>
						</ul>
						<ul class="search">
							<li>
								<span class="item01">요양기관 법정교육</span>
								<select name="Schedule5" id="Schedule5" style="width:150px">
									<option value="">전체</option>
									<option value="1">1분기</option>
									<option value="2">2분기</option>
									<option value="3">3분기</option>
									<option value="4">4분기</option>
								</select>
							</li>
							<li>
        						<span class="item01 select2-label">과정명</span>
                            	<select name="LectureCode5" id="LectureCode5" onchange="chageLangSelect(5)">
        							<option value="">-- 교육 과정 전체 --</option>
        							<?
        							$SQL = "SELECT * FROM Course WHERE Del='N' AND PackageYN='N' AND ctype='A' ORDER BY ContentsName ASC";
        							$QUERY = mysqli_query($connect, $SQL);
        							if($QUERY && mysqli_num_rows($QUERY)){
        								$i = 1;
        								while($Row = mysqli_fetch_array($QUERY)){
        									if($Row['PackageYN']=="Y") {
        										$PackageYN = " (패키지)";
        									}else{
        										$PackageYN = "";
        									}
        							?>
        							<option value="<?=$Row['ContentsName']?> | <?=$Row['LectureCode']?>"><?=$Row['ContentsName']?> | <?=$Row['LectureCode']?> <?=$PackageYN?></option>
        							<?
        								    $i++;
        								}
        							}
        							?>
        						</select><br>
        						<span id="LectureList5" style="display:none;"></span>
                            </li>                        	
                        	<li>
        						<span class="item01">교육일정</span>&nbsp;&nbsp;
        						<input name="LectureStart5" id="LectureStart5" type="text" size="12" value="" autocomplete='off'> ~
        						<input name="LectureEnd5" id="LectureEnd5" type="text" size="12" value="" autocomplete='off'>
        					</li>
						</ul>
						<ul class="search">
							<li>
								<span class="item01">보육기관 법정교육</span>
								<select name="Schedule6" id="Schedule6" style="width:150px">
									<option value="">전체</option>
									<option value="1">1분기</option>
									<option value="2">2분기</option>
									<option value="3">3분기</option>
									<option value="4">4분기</option>
								</select>
							</li>
							<li>
        						<span class="item01 select2-label">과정명</span>
                            	<select name="LectureCode6" id="LectureCode6" onchange="chageLangSelect(6)">
        							<option value="">-- 교육 과정 전체 --</option>
        							<?
        							$SQL = "SELECT * FROM Course WHERE Del='N' AND PackageYN='N' AND ctype='A' ORDER BY ContentsName ASC";
        							$QUERY = mysqli_query($connect, $SQL);
        							if($QUERY && mysqli_num_rows($QUERY)){
        								$i = 1;
        								while($Row = mysqli_fetch_array($QUERY)){
        									if($Row['PackageYN']=="Y") {
        										$PackageYN = " (패키지)";
        									}else{
        										$PackageYN = "";
        									}
        							?>
        							<option value="<?=$Row['ContentsName']?> | <?=$Row['LectureCode']?>"><?=$Row['ContentsName']?> | <?=$Row['LectureCode']?> <?=$PackageYN?></option>
        							<?
        								    $i++;
        								}
        							}
        							?>
        						</select><br>
        						<span id="LectureList6" style="display:none;"></span>
                            </li>                        	
                        	<li>
        						<span class="item01">교육일정</span>&nbsp;&nbsp;
        						<input name="LectureStart6" id="LectureStart6" type="text" size="12" value="" autocomplete='off'> ~
        						<input name="LectureEnd6" id="LectureEnd6" type="text" size="12" value="" autocomplete='off'>
        					</li>
						</ul>
					</div>
					<ul class="search">
						<li style="width:365px">
							<span class="item01">연간 교육일정(직무교육1)</span> 	
							<select name="Schedule7" id="Schedule7" style="width:150px">
    							<option value="">전체</option>
    							<option value="1">1분기</option>
    							<option value="2">2분기</option>
    							<option value="3">3분기</option>
    							<option value="4">4분기</option>
    						</select>
						</li>
						<li>
        					<span class="item01 select2-label">과정명</span>
                            <select name="LectureCode7" id="LectureCode7" >
        						<option value="">-- 교육 과정 전체 --</option>
        						<?
        						$SQL = "SELECT * FROM Course WHERE Del='N' AND PackageYN='N' AND ctype='A' ORDER BY ContentsName ASC";
        						$QUERY = mysqli_query($connect, $SQL);
        						if($QUERY && mysqli_num_rows($QUERY)){
        							$i = 1;
        							while($Row = mysqli_fetch_array($QUERY)){
        								if($Row['PackageYN']=="Y") {
        									$PackageYN = " (패키지)";
        								}else{
        									$PackageYN = "";
        								}
        						?>
        						<option value="<?=$Row['LectureCode']?>"><?=$Row['ContentsName']?> | <?=$Row['LectureCode']?> <?=$PackageYN?></option>
        						<?
        							    $i++;
        							}
        						}
        						?>
        					</select>
                        </li>
                        <li>
    						<span class="item01">교육일정</span>&nbsp;&nbsp;
    						<input name="LectureStart7" id="LectureStart7" type="text" size="12" value="" autocomplete='off'> ~
    						<input name="LectureEnd7" id="LectureEnd7" type="text" size="12" value="" autocomplete='off'>
    					</li>
    				</ul>
    				<ul class="search">
						<li style="width:365px">
							<span class="item01">연간 교육일정(직무교육2)</span> 	
							<select name="Schedule8" id="Schedule8" style="width:150px">
    							<option value="">전체</option>
    							<option value="1">1분기</option>
    							<option value="2">2분기</option>
    							<option value="3">3분기</option>
    							<option value="4">4분기</option>
    						</select>
						</li>
						<li>
        					<span class="item01 select2-label">과정명</span>
                            <select name="LectureCode8" id="LectureCode8" >
        						<option value="">-- 교육 과정 전체 --</option>
        						<?
        						$SQL = "SELECT * FROM Course WHERE Del='N' AND PackageYN='N' AND ctype='A' ORDER BY ContentsName ASC";
        						$QUERY = mysqli_query($connect, $SQL);
        						if($QUERY && mysqli_num_rows($QUERY)){
        							$i = 1;
        							while($Row = mysqli_fetch_array($QUERY)){
        								if($Row['PackageYN']=="Y") {
        									$PackageYN = " (패키지)";
        								}else{
        									$PackageYN = "";
        								}
        						?>
        						<option value="<?=$Row['LectureCode']?>"><?=$Row['ContentsName']?> | <?=$Row['LectureCode']?> <?=$PackageYN?></option>
        						<?
        							    $i++;
        							}
        						}
        						?>
        					</select>
                        </li>
                        <li>
    						<span class="item01">교육일정</span>&nbsp;&nbsp;
    						<input name="LectureStart8" id="LectureStart8" type="text" size="12" value="" autocomplete='off'> ~
    						<input name="LectureEnd8" id="LectureEnd8" type="text" size="12" value="" autocomplete='off'>
    					</li>
    				</ul>
					<div class="pb5" style="margin:10px auto 0 auto; text-align:center; ">
    					<button type="button" name="ExcelBtn" id="ExcelBtn" class="btn btn_Green line" style="width:200px;" onclick="PracticeDownload();">실시계획서 <br> 다운로드</button>
    					<button type="button" name="SendBtn3" id="SendBtn3" class="btn btn_Blue line" style="width:200px;" onclick="PracticeEduManagerMail()">실시계획서<br><i class="xi-mail"></i> 교육담당자 안내 메일 발송</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<? include "./include/include_bottom.php"; ?>

<script>
$( "#DataResult" ).draggable();
</script>
<style>
#DataResult {cursor:move;}
</style>