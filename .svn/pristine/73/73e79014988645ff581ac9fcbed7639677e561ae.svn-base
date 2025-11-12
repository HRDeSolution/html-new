<?
$MenuType = "G";
$PageName = "course_flex";
$ReadPage = "course_flex_read";
?>
<? include "./include/include_top.php"; ?>
<?
$_SESSION["ctype_session"] = "C";
$ctype_session = "C";
$ctype = "C";

##-- 검색 조건
$where = array();

if($sw){
	if($col=="") {
		$where[] = "";
	}else{
	    if($col=="LectureCode") $where[] = "a.LectureCode='$sw'";  else  $where[] = "a.$col LIKE '%$sw%'";
	}
}
$where[] = "a.Del='N'";
$where[] = "a.ctype='C'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

##-- 정렬조건
if($orderby=="") $str_orderby = "ORDER BY a.RegDate DESC, a.idx DESC";  else  $str_orderby = "ORDER BY $orderby";

$JoinQuery = " CourseFlex AS a
        	LEFT OUTER JOIN CourseFlexCategory AS b ON a.Category1=b.idx
        	LEFT OUTER JOIN CourseFlexCategory AS c ON a.Category2=c.idx ";

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM $JoinQuery $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];
mysqli_free_result($Result);

##-- 페이지 클래스 생성
include_once("./include/include_page.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소

$CompanyScaleTitle01 = "일반훈련생";
$CompanyScaleTitle02 = "취업성공패키지";
$CompanyScaleTitle03 = "근로장려금";
?>
	<div class="contentBody">
    	<h2>컨텐츠 관리</h2>
		<div class="conZone">
        	<form name="search" method="POST">
        		<input type="hidden" name="ctype" id="ctype" value="C">
                <div class="searchPan">
    				<select name="col">
    					<option value="ContentsName" <?if($col=="ContentsName") { echo "selected";}?>>과정명</option>
    					<option value="LectureCode" <?if($col=="LectureCode") { echo "selected";}?>>강의 코드</option>
    				</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
				</div>
			</form>
        	<div class="btnAreaTr02">
        		<button type="button" name="ExcelBtn" id="ExcelBtn" class="btn btn_Green line" style="width:200px;" onclick="CourseFlexExcel();"><i class="fas fa-file-excel"></i> 검색 항목 엑셀 출력</button>
				<?if($AdminWrite=="Y") {?><input type="button" name="Btn" id="Btn" value="신규 등록" class="btn_inputBlue01" onclick="location.href='<?=$PageName?>_write.php?mode=new'"><?}?>
          	</div>
            <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
            	<colgroup>
                    <col width="40px" />
                    <col width="70px" />
                    <col width="" />
                    <col width="120px" />
                    <col width="120px" />
					<col width="150px" />
					<col width="130px" />
					<col width="100px" />
					<col width="80px" />
					<col width="80px" />
              	</colgroup>
              	<tr>
                    <th>번호</th>
					<th>등&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;급<br>과정 코드</th>
					<th>과정분류<br>과&nbsp;&nbsp;정&nbsp;&nbsp;명</th>
					<th>차시</th>
					<th>교육시간</th>
					<th>심사코드</th>
					<th>HRD-NET 과정코드</th>
					<th>유효기간<br>&nbsp;인정만료</th>
					<th>모바일</th>
					<th>사이트<br>노출</th>
              	</tr>
				<?
				$SQL = "SELECT a.*, b.CategoryName AS CategoryName1, c.CategoryName AS CategoryName2
                        FROM $JoinQuery $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
				//echo $SQL;
				$QUERY = mysqli_query($connect, $SQL);
				if($QUERY && mysqli_num_rows($QUERY)){
					while($ROW = mysqli_fetch_array($QUERY)){
						extract($ROW);
				?>
              	<tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><A HREF="Javascript:readRun('<?=$idx?>');"><?=$ClassGrade_array[$ClassGrade]?><br><strong><?=$LectureCode?></strong></A></td>
					<td class="tl"><A HREF="Javascript:readRun('<?=$idx?>');"><?=$CategoryName1?>><?=$CategoryName2?><br><strong><?=$ContentsName?></strong></A></td>
					<td><?if($Chapter != "0") echo $Chapter."차시"; else  echo "없음";?></td>
					<td><?=$ContentsTime?> 분</td>
					<td><?=$PassCode?></td>
					<td><?=$HrdCode?></td>
					<td><?=substr($ContentsPeriod,0,10)?><br><?=substr($ContentsExpire,0,10)?></td>
					<td><?=$UseYN_array[$Mobile]?></td>
					<td><?=$UseYN_array[$UseYN]?></td>
              	</tr>
              	<?
					}
				   mysqli_free_result($QUERY);
				}else{
				?>
				<tr>
					<td height="50" class="tc" colspan="20">등록된 컨텐츠가 없습니다.</td>
				</tr>
				<? 
				}
				?>
            </table>
            
		  	<?=$BLOCK_LIST?>

			<div class="btnAreaTr02">
    	       	<button type="button" name="ExcelBtn" id="ExcelBtn" class="btn btn_Green line" style="width:200px;" onclick="CourseFlexExcel();"><i class="fas fa-file-excel"></i> 검색 항목 엑셀 출력</button>
				<?if($AdminWrite=="Y") {?><input type="button" name="Btn" id="Btn" value="신규 등록" class="btn_inputBlue01" onclick="location.href='<?=$PageName?>_write.php?mode=new'"><?}?>
       		</div>
		</div>
	</div>
</div>
<? include "./include/include_bottom.php"; ?>