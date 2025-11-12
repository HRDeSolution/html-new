<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$ID = Replace_Check($ID);
$today = Replace_Check($today);
?>
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
	
	$("#StudyDate").change(function(){
		var id = "<?=$ID?>";
		var today = $('#StudyDate').val();
	
		StudyTimeInfo(id, today);
		//$("#changeList").load(location.href+" #changeList",{StudyDate: $('#StudyDate').val()});
	});
});
</script>
<div class="Content">
    <div class="contentBody">
        <h2>일자별 수강시간 정보</h2>
        <div class="conZone">
			<div class="neoSearch">
				<ul class="search">
					<li>
						<span class="item01">수강날짜</span>&emsp;
						<input name="StudyDate" id="StudyDate" type="text" size="12" value="" readonly>
					</li>
				</ul>
			</div>
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20" id="changeList">
				<tr>
        			<th>수강날짜</th>
        			<th>사업주<br>사업주번호</th>
        			<th>이름<br>ID</th>
        			<th>수강시간</th>
				</tr>
        		<?
        		//오늘 학습시간 조회
        		$StudyTimeSum = 0;
        		if($StudyDate)   $today = $StudyDate;
    		    //[1]오늘수강한 LectureCode와 Chapter_Seq값 구하기
        		$SqlD1 = "SELECT LectureCode , Chapter_Seq , ID , RegDate FROM Progress WHERE ID = '$ID' AND RegDate LIKE '%$today%'";
        		//echo $SqlD1;
        		$QueryD1 = mysqli_query($connect, $SqlD1);
        		if($QueryD1 && mysqli_num_rows($QueryD1)){
        		    while($RowD1 = mysqli_fetch_array($QueryD1)){
        		        $LectureCodeD = $RowD1['LectureCode'];
        		        $ChapterSeqD = $RowD1['Chapter_Seq'];
        		        
        		        //[2]각 차시의 수강시간구하기
        		        $SqlD2 = "SELECT MAX(StudyTime) - MIN(StudyTime) FROM ProgressLog
							  WHERE ID = '$ID' AND RegDate LIKE '%$today%' AND LectureCode = '$LectureCodeD' AND Chapter_Seq  = $ChapterSeqD";
        		        $ResultD2 = mysqli_query($connect, $SqlD2);
        		        $RowD2 = mysqli_fetch_array($ResultD2);
        		        $StudyTime = $RowD2[0];
        		        $StudyTimeSum = $StudyTimeSum + $StudyTime;
        		        //echo $SqlD2."<br>";
        		        //echo $StudyTimeSum;
        		    }
        		}
        		$TodayStudyTime = gmdate('H시간 i분 s초', $StudyTimeSum);
        		
        		//수강생정보 조회
        		$Sql = "SELECT a.Name , b.CompanyName , b.CompanyCode
                        FROM Member a
                        LEFT JOIN Company b ON a.CompanyCode = b.CompanyCode 
                        WHERE a.ID = '$ID'";
        		//echo $Sql;
        		$Result = mysqli_query($connect, $Sql);
        		$Row = mysqli_fetch_array($Result);
        		$Name = $Row['Name'];
        		$CompanyName = $Row['CompanyName'];
        		$CompanyCode = $Row['CompanyCode'];
        		?>
        		<tr bgcolor="#FFFFFF">
        			<td><?=$today?></td>
        			<td><?=$CompanyName?><br><?=$CompanyCode?></td>
        			<td><?=$Name?><br><?=$ID?></td>
        			<td><?=$TodayStudyTime?></td>
        		</tr>
			</table>
	       
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
        		<tr>
        			<td align="left" width="200">&nbsp;</td>
        			<td align="center"> </td>
        			<td width="200" align="right"><button type="button" onclick="DataResultClose();" class="btn btn_DGray line">닫기</button></td>
        		</tr>
			</table>
  		</div>
    </div>
</div>
<style>
    #Progress_log {
        display: block;
        max-height: 500px;
        overflow-y: auto;
    }
</style>
<script>
function StudyProgressExcel(id) {
	Yes = confirm('학습내역을 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		var address = './study_progress_excel.php?id=' + id;
		window.location.href = address;
	}
}
</script>