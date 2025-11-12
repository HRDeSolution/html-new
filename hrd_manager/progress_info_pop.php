<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$ID = Replace_Check($ID);
$LectureCode = Replace_Check($LectureCode);
$Study_Seq = Replace_Check($Study_Seq);

$where = "WHERE a.ID='$ID' AND a.LectureCode='$LectureCode' AND a.Seq=$Study_Seq";

$Colume = "a.Seq, a.ServiceType, a.ID, a.LectureStart, a.LectureEnd, a.Progress, a.PassOK, a.certCount, a.StudyEnd, 
    	b.ContentsName,
    	c.Name, c.Depart,
    	d.CompanyName, 
    	e.Name AS TutorName,
        (SELECT SUM(StudyTime) FROM Progress WHERE ID = '$ID' AND Study_Seq = a.Seq) AS TotalStudyTime ";

$JoinQuery = " Study AS a 
		LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
		LEFT OUTER JOIN Member AS c ON a.ID=c.ID 
		LEFT OUTER JOIN Company AS d ON a.CompanyCode=d.CompanyCode 
		LEFT OUTER JOIN StaffInfo AS e ON a.Tutor=e.ID ";

$Sql = "SELECT $Colume FROM $JoinQuery $where ORDER BY a.Seq DESC";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
if($Row) {
	$ServiceType = $Row['ServiceType'];
	$LectureStart = $Row['LectureStart'];
	$LectureEnd = $Row['LectureEnd'];
	$Progress = $Row['Progress'];
	$ContentsName = $Row['ContentsName'];
	$Name = $Row['Name'];
	$Depart = $Row['Depart'];
	$CompanyName = $Row['CompanyName'];
	$TutorName = $Row['TutorName'];
	$PassOK = $Row['PassOK'];
	$certCount = $Row['certCount'];
	$StudyEnd = $Row['StudyEnd'];
	$TotalStudyTime = $Row['TotalStudyTime'];

	//첨삭완료일
	$Tutor_limit_day = strtotime("$LectureEnd +4 days");

	//수료여부
	switch($PassOK) {
		case "N":
			$PassOK_View = "<span class='fcOrg01B'>미수료</span>";
		break;
		case "Y":
			$PassOK_View = "<span class='fcSky01B'>수료</span>";
		break;
		default :
			$PassOK_View = "";
	}
	
	//echo $TotalStudyTime;
	
	//전체수강시간
	if($TotalStudyTime > 86400){
	    $sec = $TotalStudyTime;
	    $h = floor($sec / 3600);
	    $m = floor(($sec % 3600) / 60);
	    $s = $sec % 60;
	    
	    $TotalStudyTime = sprintf("%02d시간 %02d분 %02d초", $h, $m, $s);
	}else{
	    $TotalStudyTime = gmdate("H시간 i분 s초", $TotalStudyTime);
	}
}
?>
<div class="Content">
    <div class="contentBody">
        <h2>학습내역 상세 정보</h2>
        <div class="conZone">        
            <!-- 수강정보 -->
        	<div class="btnAreaTl02"><span class="fs16b fc333B sub_title2">수강 정보</span></div>
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
    			<tr>
        			<th>과정명</th>
        			<th>이름</th>
        			<th>ID</th>
        			<th>사업주</th>			
    			</tr>
    			<tr>
        			<td><?=$ContentsName?></td>
        			<td><?=$Name?></td>
        			<td><?=$ID?></td>
        			<td><?=$CompanyName?></td>
    			</tr>
    			<tr>
        			<th>수강시간(진도율)</th>
        			<th>수강기간</th>
        			<th>수료여부</th>
        			<th>교·강사</th>
    			</tr>
    			<tr>
        			<td><?=$TotalStudyTime?>(<?=$Progress?>%)</td>
        			<td><?=$LectureStart?> ~ <?=$LectureEnd?></td>
        			<td><?=$PassOK_View?></td>
        			<td><?=$TutorName?></td>
    			</tr>
			</table>
	        <!-- //수강정보 -->	

            <!-- 학습내역 -->
			<div class="btnAreaTl02">
				<span class="fs16b fc333B sub_title2">학습 내역</span>
				<button type="button" name="ExcelBtn" id="ExcelBtn" class="btn btn_Green line" onclick="StudyProgressExcel('<?=$ID?>');" style="margin-left: 15px;"><i class="fas fa-file-excel"></i> 학습내역 엑셀 출력</button>
			</div>
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
				<tr>
        			<th>번호</th>
        			<th>과정구분</th>
        			<th>과정명</th>
        			<th>진도율</th>
        			<th>수강시간</th>
        			<th>학습시작일</th>
        			<th>학습종료일</th>
				</tr>
        		<?
        		$k = 1;
        		$SQL = "SELECT  DISTINCT(a.LectureCode), a.ID , a.Study_Seq ,
                        		b.ServiceType , b.ContentsName ,
                        		(SELECT RegDate FROM ProgressLog WHERE ID = a.ID AND LectureCode = a.LectureCode ORDER BY idx LIMIT 1) AS StartDate,
                        		(SELECT RegDate FROM ProgressLog WHERE ID = a.ID AND LectureCode = a.LectureCode ORDER BY idx DESC LIMIT 1) AS EndDate,
                                (SELECT FLOOR((SUM(IF(Progress>100,100,Progress)))/(b.Chapter*100)*100) AS TotalProgress FROM Progress WHERE ID = a.ID AND LectureCode = a.LectureCode) AS TotalProgress,
                        		(SELECT SUM(StudyTime) FROM Progress WHERE ID =  a.ID AND LectureCode = a.LectureCode) AS TotalStudyTime
                        FROM Progress a
                        LEFT OUTER JOIN Course b ON a.LectureCode = b.LectureCode 
                        LEFT JOIN Study c ON a.ID = c.ID
                        WHERE a.ID = '$ID' AND a.RegDate > c.LectureStart  AND a.RegDate < c.LectureEnd ";
        		// echo $SQL;
        		$QUERY = mysqli_query($connect, $SQL);
        		if($QUERY && mysqli_num_rows($QUERY)){
        			while($ROW = mysqli_fetch_array($QUERY)){
        			    $LectureCodeA = $ROW['LectureCode'];
        			    $ServiceTypeA = $ROW['ServiceType'];
        			    $ContentsNameA = $ROW['ContentsName'];
        			    $StartDate = $ROW['StartDate'];
        			    $EndDate = $ROW['EndDate'];
        			    $TotalProgress = $ROW['TotalProgress'];
        			    $TotalStudyTime = $ROW['TotalStudyTime'];
        			    
        			    $TotalStudyTime = gmdate("H시간 i분 s초", $TotalStudyTime);
        			    if($TotalProgress > 100) $TotalProgress = 100;
        		?>
        		<tr bgcolor="#FFFFFF">
        			<td ><?=$k?></td>
        			<td ><?=$ServiceType_array[$ServiceTypeA]?></td>
        			<td class="tl"><a href="Javascript:ProgressInfoLog(<?=$k-1?>,'<?=$ID?>','<?=$LectureCodeA?>','<?=$Study_Seq?>');"><?=$ContentsNameA?></a></td>
        			<td ><?=$TotalProgress?>%</td>
        			<td ><?=$TotalStudyTime?></td>
        			<td ><?=$StartDate?></td>
        			<td ><?=$EndDate?></td>
        		</tr>
        		<tr style="display:none" id="ProgressDetail" >
        			<td colspan="8"><div id="Progress_log"></div></td>
        		</tr>
        		<?
                        $k++;
            		}
        		}else{
        		?>
        		<tr>
        			<td  colspan="20">학습 내역이 없습니다.</td>
        		</tr>
        		<? } ?>
			</table>
	       <!-- //학습내역 -->
	       
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