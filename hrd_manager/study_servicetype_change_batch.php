<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$SearchGubun = Replace_Check($SearchGubun); //기간, 사업주 검색 구분
$CompanyName = Replace_Check($CompanyName); //사업주명
$SearchYear = Replace_Check($SearchYear); //검색 년도
$SearchMonth = Replace_Check($SearchMonth); //검색 월
$StudyPeriod = Replace_Check($StudyPeriod); //검색 기간1(기간검색)
$StudyPeriod2 = Replace_Check($StudyPeriod2); //검색 기간2(사업주검색)
$CompanyCode = Replace_Check($CompanyCode); //사업자 번호
$OpenChapter = Replace_Check($OpenChapter); //실시회차
$ID = Replace_Check($ID); //이름, 아이디
$SalesID = Replace_Check($SalesID); //영업자 이름, 아이디
$Progress1 = Replace_Check($Progress1); //진도율 시작
$Progress2 = Replace_Check($Progress2); //진도율 종료
$TutorStatus = Replace_Check($TutorStatus); //첨삭 여부
$LectureCode = Replace_Check($LectureCode); //강의 코드
$PassOk = Replace_Check($PassOk); //수료여부
$ServiceType = Replace_Check($ServiceType); //개설용도
$certCount = Replace_Check($certCount); //실명인증 횟수
$LectureStart = Replace_Check($LectureStart); //교육 시작일
$LectureEnd = Replace_Check($LectureEnd); //교육 종료일

//기간 검색 
if($SearchGubun=="A") {
    if($SearchYear)     $where[] = "YEAR(a.LectureStart)=".$SearchYear;
    if($SearchMonth)    $where[] = "MONTH(a.LectureStart)=".$SearchMonth;
    if($CompanyCode)    $where[] = "a.CompanyCode='".$CompanyCode."'";

	if($StudyPeriod) {
		$StudyPeriod_array = explode("~",$StudyPeriod);
		$LectureStart = trim($StudyPeriod_array[0]);
		$LectureEnd = trim($StudyPeriod_array[1]);

		if($LectureStart) $where[] = "a.LectureStart='".$LectureStart."'";
		if($LectureEnd)   $where[] = "a.LectureEnd='".$LectureEnd."'";
	}
}

//사업주  검색
if($SearchGubun=="B") {  
    if($CompanyName)   $where[] = "d.CompanyName LIKE '%".$CompanyName."%'";

	if($StudyPeriod2) {
		$StudyPeriod_array = explode("~",$StudyPeriod2);
		$LectureStart = trim($StudyPeriod_array[0]);
		$LectureEnd = trim($StudyPeriod_array[1]);

		if($LectureStart) $where[] = "a.LectureStart='".$LectureStart."'";
		if($LectureEnd)   $where[] = "a.LectureEnd='".$LectureEnd."'";
	}
}


if($OpenChapter)    $where[] = "a.OpenChapter='".$OpenChapter."'";
if($ID)             $where[] = "(a.ID='".$ID."' OR c.Name='".$ID."')";
if($SalesID)        $where[] = "(a.SalesID='".$SalesID."' OR f.Name='".$SalesID."')";

if($Progress2) {
	if(!$Progress1) {
		$Progress1 = 0;
	}
	$where[] = "(a.Progress BETWEEN ".$Progress1." AND ".$Progress2.")";
}

if($TutorStatus=="N")   $where[] = "a.StudyEnd='N'";
if($LectureCode)        $where[] = "a.LectureCode='".$LectureCode."'";
if($PassOk)             $where[] = "a.PassOk='".$PassOk."'";

if($ServiceType) {
	$where[] = "a.ServiceType='$ServiceType'";
}else{
	$where[] = "a.ServiceType IN ('A','W')";
}

if($certCount) {
	if($certCount=="Y") {
		$where[] = "g.CertDate IS NOT NULL";
	}else{
		$where[] = "g.CertDate IS NULL";
	}
}

if($Tutor)      $where[] = "a.Tutor='".$Tutor."'";
if($EduManager) $where[] = "c.EduManager='".$EduManager."'";


$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$str_orderby = "ORDER BY a.Seq DESC";

$Colume = " a.Seq, a.ServiceType, a.ID, a.LectureStart, a.LectureEnd, a.Progress, a.PassOK, a.certCount, a.StudyEnd, a.OpenChapter, 
    		b.ContentsName,  
    		c.Name, c.Depart, 
    		d.CompanyName, 
    		e.Name AS TutorName,   
    		f.Name AS SalesName, f.Team AS SalesTeam,
    		g.CertDate ";

$JoinQuery = " Study AS a 
			LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
			LEFT OUTER JOIN Member AS c ON a.ID=c.ID 
			LEFT OUTER JOIN Company AS d ON a.CompanyCode=d.CompanyCode 
			LEFT OUTER JOIN StaffInfo AS e ON a.Tutor=e.ID 
			LEFT OUTER JOIN StaffInfo AS f ON a.SalesID=f.ID 
			LEFT OUTER JOIN UserCertOTP AS g ON a.Seq=g.Study_Seq AND a.ID=g.ID AND a.LectureCode = g.LectureCode ";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<head>
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="./css/style.css" type="text/css">
<link rel="stylesheet" type="text/css" href="./include/jquery-ui.css" />
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<script type="text/javascript" src="./include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="./include/function.js"></script>
<script type="text/javascript" src="./smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>

<script type="text/javascript">
var totalcount = 0;
var batching = false;

function ChangeBatch() {
	totalcount = $("input[name='check_seq']").length; //전체 건수
	var checkedbox_count = $(":checkbox[name='check_seq']:checked").length; //체크된 건수
	var ServiceTypeSelected = $("#ServiceType").val();

	if(totalcount<1) {
		alert('검색된 항목이 없습니다.');
		return;
	}
	if(checkedbox_count<1) {
		alert('선택된 항목이 없습니다.');
		return;
	}
	if(ServiceTypeSelected=='') {
		alert('변경하려는 개설용도를 선택하세요..');
		return;
	}

	switch (ServiceTypeSelected) {
		case 'A' :
			serviceTypeMsg = "패키지(환급)";
		break;
		case 'W' :
			serviceTypeMsg = "비환급";
		break;
	}

	$("#ProcesssRatio").show();
	Yes = confirm('체크된 항목의 개설용도를 [ '+serviceTypeMsg+' ] 상태로\n\n변경하시겠습니까?\n\n변경작업은 1번항목부터 '+totalcount+'번 항목까지 순차적으로 진행됩니다.\n\n작업이 완료 될 때 까지 기다려 주세요.\n\n\n\n작업을 진행하시려면 [확인]을 클릭하세요.');
	if(Yes==true) {
		batching = true;
		BatchProcess(0);
	}else{
		batching = false;
		$("#ProcesssRatio").hide();
	}

}

function BatchProcess(i) {
	ProcesssRatioCal = i / totalcount * 100;
	var newNum = new Number(ProcesssRatioCal);
	ProcesssRatioCal = newNum.toFixed(2);
	$("#ProcesssRatio").html("<span style='font-size:25px;'>진행률</span> "+ProcesssRatioCal+" %");

	if(i<totalcount) {

		i2 = i + 1;

		if ($("input:checkbox[id='check_seq_"+i+"']").is(":checked") == false){

			$("div[id='status']:eq("+i+")").html('제외');
			setTimeout('BatchProcess('+i2+')', 200);

		}else{

			$("div[id='status']:eq("+i+")").load('./study_servicetype_change_batch_process.php',
			{ 'Seq': $("input:checkbox[id='check_seq_"+i+"']").val(),
				'ServiceType': $("#ServiceType").val()
			});

			setTimeout(function(){
				BatchProcess(i2);
			},200);

		}

	}else{
		batching = false;
		opener.StudySearch(1);
		alert("변경 일괄처리가 완료되었습니다.\n\n[확인]을 클릭하면 현재 창은 새로고침 되며\n\n실패한 항목의 목록만 다시 로딩됩니다.\n\n목록이 없는 경우는 전부 성공한 경우입니다.");
		location.reload();
	}


}

$(document).ready(function(){
	$(document).bind("scroll", function() {
		if(batching==true) {
			ProcesssRatioTop = $(window).scrollTop() + 300;
			$("div[id='ProcesssRatio']").animate({ top : ProcesssRatioTop }, 200);
		}
	});
});

function CheckAll() {
	totalcount = $("input[name='check_seq']").length; //전체 건수

	for(i=0;i<totalcount;i++) {
		if($("#check_All").is(":checked")==true) {
			$("input[name='check_seq']:eq("+i+")").prop('checked',true);
		}else{
			$("input[name='check_seq']:eq("+i+")").prop('checked',false);
		}
	}
}
</script>
</head>

<body leftmargin="0" topmargin="0">

<div id="wrap">
	<div class="Content">
        <div class="contentBody">
            <h2>개설용도 일괄변경</h2>
            <div class="conZone">
                <div class="tl pt5">
					<span class="fs14 fc333"><img src="images/sub_title.gif" align="absmiddle"> 일괄변경 대상 | 변경을 원하지 않는 항목은 체크를 해제하세요.</span>
				</div>

				<P style="text-align:right">
				<select name="ServiceType" id="ServiceType" style="width:200px; height:35px">
					<option value="">변경하려는 개설용도 선택</option>
					<option value="A" >패키지(환급)</option>
                	<option value="W" >비환급</option>
				</select>&nbsp;&nbsp;
				<input type="button" value="체크항목 일괄 변경하기" class="btn_inputBlue01"  onclick="ChangeBatch()"><P>

                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <tr>
                    <th><input type="checkbox" name="check_All" id="check_All" value="Y" checked onclick="CheckAll();" style="width:17px; height:17px; background:none; border:none;"></th>
					<th>번호</th>
					<th>ID</th>
					<th>성명</th>
					<th>기간</th>
					<th>과정명</th>
					<th>진도율 (%)</th>
					<th>수료여부</th>
					<th>개설용도</th>
					<th>진행상태</th>
                  </tr>
					<?
					$i = 1;
					$SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY)){
						while($ROW = mysqli_fetch_array($QUERY)){
							extract($ROW);

							switch($PassOK) {
								case "N":
									$PassOK_View = "미수료";
								break;
								case "Y":
									$PassOK_View = "<span class='fcSky01B'>수료</span>";
								break;
								default :
									$PassOK_View = "";
							}
					?>
                  <tr>
                    <td><input type="checkbox" name="check_seq" id="check_seq_<?=$i-1?>" value="<?=$Seq?>" checked style="width:17px; height:17px; background:none; border:none;" /></td>
					<td><?=$i?></td>
					<td><?=$ID?></td>
					<td><?=$Name?></td>
					<td><?=$LectureStart?> ~ <?=$LectureEnd?></td>
					<td align="left"><?=$ContentsName?></td>
					<td><?=$Progress?>%</td>
					<td><?=$PassOK_View?></td>
					<td><?if($ServiceType=="A") echo "패키지(환급)"; else echo "비환급";?></td>
					<td><div id="status">-</div></td>
                  </tr>
					<?
                            $i++;
						}
					}else{
					?>
					<tr>
						<td height="28" align="center" colspan="20">검색된 내용이 없습니다.</td>
					</tr>
					<? } ?>
					</table>
					</td>
                  </tr>
                </table>

				<div class="btnAreaTr02">
					<input type="button" value="닫  기" onclick="self.close();" class="btn_inputLine01">
                </div>
      		</div>
        </div>
	</div>
</div>

<div id="ProcesssRatio" style="position:absolute; left:500px;top:400px; width:400px; background-color:#fff;font-size:60px; padding-top:15px;padding-bottom:15px; text-align:center; opacity:0.7; display:none"><span style="font-size:25px;">진행률</span> 0.00 %</div>
</body>
</html>
<?
mysqli_close($connect);
?>