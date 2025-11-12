<?
$MenuType = "F";
$PageName = "survey";
$ReadPage = "survey_read";
?>
<? include "./include/include_top.php"; ?>
<?
##-- 검색 조건
$where = array();

if($sw){
    if($col=="") $where[] = "";
    else $where[] = "$col LIKE '%$sw%'";
}
$where[] = "a.Del='N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM Review a
		LEFT JOIN Course b ON a.LectureCode = b.LectureCode $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

mysqli_free_result($Result);

##-- 페이지 클래스 생성
include_once("./include/include_page.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
    <div class="contentBody">
    	<h2>수강후기</h2>
      	<div class="conZone">
            <!-- 검색 -->
			<form name="search" method="get">
            	<div class="searchPan">
                	<select name="col">
						<option value="ContentsName" <?if($col=="b.ContentsName") { echo "selected";}?>>과정명</option>
						<option value="ID" <?if($col=="a.ID") { echo "selected";}?>>아이디</option>
						<option value="Title" <?if($col=="a.Title") { echo "selected";}?>>제목</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
                </div>
			</form>
			<!-- //검색 -->
			<div class="btnAreaTr02">
				<button type="button" name="ExcelBtn" id="ExcelBtn" class="btn btn_Green line" onclick="location.href='survey_excel.php?col=<?=$col?>&sw=<?=$sw?>'"><i class="fas fa-file-excel"></i> 검색항목 엑셀 출력</button>
          	</div>
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
				<colgroup>
                	<col width="40px" />
                    <col width="500px" />
                    <col width="150px" />
                    <col width="150px" />
                    <col width="" />
					<col width="150px" />
					<col width="150px" />
					<col width="50px" />
				</colgroup>
				<tr>
                	<th>번호</th>
					<th>과정명</th>
					<th>별점</th>
					<th>아이디</th>
					<th>제목</th>
					<th>등록 IP</th>
					<th>등록일</th>
					<th>조회수</th>
				</tr>
				<?
				$SQL = "SELECT a.idx , a.LectureCode , a.ID , a.StarPoint , a.RegDate , a.IP, a.Title, a.ViewCount, b.ContentsName
						FROM Review a
						LEFT JOIN Course b ON a.LectureCode = b.LectureCode
						$where ORDER BY a.RegDate DESC   LIMIT $PAGE_CLASS->page_start, $page_size";
				//echo $SQL;
				$QUERY = mysqli_query($connect, $SQL);
				if($QUERY && mysqli_num_rows($QUERY)){
                    while($ROW = mysqli_fetch_array($QUERY)){
						extract($ROW);
						$Star = StarPointView($StarPoint);
				?>
				<tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><b><?=$ContentsName?></b></td>
					<td><?=$Star?></td>
					<td><?=$ID?></td>
					<td style="text-align:left"><a href="Javascript:readRun('<?=$idx?>');"><?=$Title?></a></td>
					<td><?=$IP?></td>
					<td><?=$RegDate?></td>
					<td><?=$ViewCount?></td>
				</tr>
                <?
					}
					mysqli_free_result($QUERY);
				}else{
				?>
				<tr><td height="50" class="tc" colspan="10">등록된 수강후기가 없습니다.</td></tr>
				<? 
				}
			    ?>
			</table>
   		  	<?=$BLOCK_LIST?>
      	</div>
    </div>
</div>
<!-- Content // -->
<? include "./include/include_bottom.php"; ?>