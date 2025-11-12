<?
include "../../include/include_function.php";

include "../../include/login_check.php";


if($LoginEduManager!="Y") {
    ?>
<script type="text/javascript">
<!--
	location.href="/";
//-->
</script>
<?
exit;
}


$LectureStart = Replace_Check_XSS2($LectureStart);
$LectureEnd = Replace_Check_XSS2($LectureEnd);
$LectureCode = Replace_Check_XSS2($LectureCode);
$CompanyCode= Replace_Check_XSS2($CompanyCode);

$PassOk = Replace_Check_XSS2($PassOk);
$col = Replace_Check_XSS2($col);
$sw = Replace_Check_XSS2($sw);

if($CompanyCode){
	
}else{
	$Sql = "SELECT *, (SELECT CompanyName FROM Company WHERE CompanyCode=Member.CompanyCode LIMIT 0,1) AS CompanyName FROM Member WHERE ID='$LoginMemberID' AND MemberOut='N' AND UseYN='Y'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$CompanyCode = $Row['CompanyCode']; //사업자 번호
		$CompanyName = $Row['CompanyName']; //소속기업명
	}
}
$Sql = "SELECT a.CompanyCode, a.ServiceType, c.ContentsName, c.LectureCode,
(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND PassOk='Y' and LectureCode='$LectureCode') AS StudyCount, 
(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND PassOk='N' and LectureCode='$LectureCode') AS StudyBeCount
FROM Study AS a 
LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode 
LEFT OUTER JOIN Course AS c ON a.LectureCode=c.LectureCode 
WHERE b.CompanyCode='$CompanyCode' AND a.ServiceType IN ('A') AND a.LectureStart='$LectureStart' AND a.LectureEnd='$LectureEnd' and a.LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$StudyCount = $Row['StudyCount']; //수료인원
	$StudyBeCount = $Row['StudyBeCount']; //미수료인원

	$StudySum = $StudyCount + $StudyBeCount; //전체인원

	$ContentsName = $Row['ContentsName'];
	$ServiceType = $Row['ServiceType'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title><?=$HTML_TITLE?><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Expires" content="-1"> 
<meta http-equiv="Pragma" content="no-cache"> 
<meta http-equiv="Cache-Control" content="No-Cache"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="/common/css/base.css?ver=240418">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" type="text/css" href="/include/jquery-ui.css" />
<script type="text/javascript">
<!--
var browser = "<?=$browser?>";
//-->
</script>
<!-- <script type="text/javascript" src="/include/jquery-1.11.0.min.js"></script> -->
<script type="text/javascript" src="/include/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="/include/jquery-ui.js"></script>
<script type="text/javascript" src="/include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="/include/function.js?t=<?=date('YmdHis')?>"></script>
<script type="text/javascript" src="/include/jquery.bxslider.min.js"></script>
<script type="text/javascript">
<!--
function ManagerSearchOk() {

	/*
	if($("#sw").val()=="") {
		alert("검색어를 입력하세요.");
		return;
	}
	*/
	SearchForm1.submit();

}

function ManagerOrderBy(str) {

	document.SearchForm1.orderby.value = str;
	SearchForm1.submit();

}

function ManagerExcelOut() {
	ExcelForm.submit();
}
//-->
</script>
</head>

<body>
<form name="ExcelForm" method="POST" action="manager_trainee_excel.php" target="_blank">
<input type="hidden" name="searchName" value="<?=$searchName?>">
<input type="hidden" name="sw" value="<?=$sw?>">
<input type="hidden" name="orderby" value="<?=$orderby?>">
<input type="hidden" name="LectureStart" value="<?=$LectureStart?>">
<input type="hidden" name="LectureEnd" value="<?=$LectureEnd?>">
<input type="hidden" name="LectureCode" value="<?=$LectureCode?>">
<input type="hidden" name="ID" id="ID" value="<?=$ID;?>">
<input type="hidden" name="Seq" id="Seq" value="<?=$Seq;?>">
</form>
	<div id="wrap">
    
    	<div class="popupArea">
        	<!-- close -->
            <div class="close"><a href="Javascript:self.close();"><img src="/images/common/btn_close01.png" alt="창닫기" /></a></div>
       	  	<!-- title -->
            <div class="popName">수강현황</div>
            <!-- info Area -->
            <div class="infoArea">
            	
                <!-- ########## -->
            	<div class="managerTxt">
                    <p class="term"><?=$LectureStart?> ~ <?=$LectureEnd?> 개강</p>
                  <p class="title"><?=$ContentsName?></p>
                </div>
                
                <!-- search -->
				<form name="SearchForm1" method="POST" action="/public/mypage/manager_trainee_list.php">
					<input type="hidden" name="orderby" id="orderby" value="c.Seq DESC">
					<input type="hidden" name="LectureStart" id="LectureStart" value="<?=$LectureStart?>">
					<input type="hidden" name="LectureEnd" id="LectureEnd" value="<?=$LectureEnd?>">
					<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
                    <input type="hidden" name="ID" id="ID" value="<?=$ID;?>">
                    <input type="hidden" name="Seq" id="Seq" value="<?=$Seq;?>">
                    <div class="search mt20">
                        <span>
                            <select name="searchName" id="searchName" class="wid150">
                                <option value="">과정명</option>
                            </select>
                        </span>
                        <span><input type="text" name="sw" id="sw" class="wid200" placeholder="검색어 입력" /></span>
                        <span class="btn"><a href="Javascript:ManagerSearchOk();">검색</a></span>
                    </div>
				</form>
                <!-- search // -->
				<?
				##-- 검색 조건
				$where = array();

				$where[] = "c.ServiceType IN ('A')";

                $where[] = "a.ID ='$ID'";

                $where[] = "c.Seq =$Seq";

				if($sw){
					$where[] = "b.ContentsName LIKE '%$sw%'";
				}

				$where = implode(" AND ",$where);
				if($where) $where = "WHERE $where";

				if(!$orderby) {
					$str_orderby = "ORDER BY c.Seq DESC";
				}else{
					$str_orderby = "ORDER BY $orderby";
				}

                $str_groupby = "GROUP BY a.LectureCode ";

                $Colume = "a.LectureCode, b.ctype, a.ID, b.ContentsName, a.Progress, SUM(a.StudyTime) AS StudyTime, c.LectureStart, c.LectureEnd, (SELECT Name FROM `Member` WHERE ID = a.ID) AS Name";
                $JoinQuery = "Progress a
                                LEFT JOIN Course b ON b.LectureCode = a.LectureCode 
                                LEFT JOIN Study c ON c.Seq = a.Study_Seq ";
				?>
                <!-- list -->
                <div class="mt20">
                	<table cellpadding="0" cellspacing="0" class="taList_ty01">
                	  <caption>수강현황 목록</caption>
                	  <colgroup>
                	    <col width="10%" />
                	    <col width="13%" />
                        <col width="*" />
                        <col width="17%" />
                        <col width="17%" />
                        <col width="8%" />
                        <col width="8%" />
                	  </colgroup>
                	  <tr>
                	    <th>과정구분</th>
                	    <th>이름<br />아이디</th>
                	    <th>과정명</th>
                	    <th>진도율</th>
                	    <th>수강시간</th>
                	    <th>학습시작일</th>
                	    <th>학습종료일</th>
                	  </tr>
					  <?
						$i = 1;
						$SQL = "SELECT $Colume FROM $JoinQuery $where $str_groupby $str_orderby ";
						// echo $SQL;
						$QUERY = mysqli_query($connect, $SQL);

                        if($StudyTimePercent == "0") $StudyTimePercent = "1";

						if($QUERY && mysqli_num_rows($QUERY))
						{
							while($ROW = mysqli_fetch_array($QUERY))
							{
								extract($ROW);
                                
                                $StudyTime = gmdate("H:i:s", $StudyTime);
						?>
                	    <tr>
                            <td class="tc"><?=$ServiceType_array[$ctype];?></td>
                            <td class="tc cp"><?=$Name;?><br /><?=$ID;?></td>
                            <td class="tc"><?=$ContentsName;?></td>
                            <td class="tc"><?=$Progress;?>%</td>
                            <td class="tc"><?=$StudyTime?></td>
                            <td class="tc"><?=$LectureStart;?></td>
                            <td class="tc"><?=$LectureEnd;?></td>
               	        </tr>
					    <?
					            $i++;
						    }
                        } else { ?>
                            <tr>
                                <td class="tc" colspan="20" style="text-align:center">수강내역이 없습니다.</td>
                            </tr>
                        <? } 
                            $SqlB = "SELECT SUM(StudyTime) AS StudyTime 
                                    FROM Progress 
                                    WHERE ID = '$ID' AND study_seq = $Seq";
                            // echo $SqlB;
                            $ResultB = mysqli_query($connect, $SqlB);
                            $RowB = mysqli_fetch_array($ResultB);
                            $TotalStudyTime = gmdate("H시간 i분 s초", $RowB[0]);
                            $PassOkYN = ( 54000 >= $RowB[0] ) ? "미수료" : "수료"; //15시간 미만일때 미수료 초과일때 수료
                        ?>

                        <tr>
                	  	    <th colspan="7">최종수강시간 : <?=$TotalStudyTime;?> / 수료여부 : <?=$PassOkYN ?></th>
               	        </tr>
                	</table>
                </div>
                <!-- list // -->
                
                <!-- btn -->
                <div class="btnAreaTl03">
                	<span class="btnSky01"><a href="Javascript:ManagerExcelOut();">검색항목 엑셀출력</a></span>
                </div>
                <!-- ########## // -->
                
            </div>
            <!-- info Area -->
        </div>

	</div>

</body>
</html>
