<?
$MenuType = "E";
?>
<? include "./include/include_top.php"; ?>
<?
##-- 검색 조건
$where = array();

if($sw){
    if($col=="") {
        $where[] = "";
    }else{
        if($col=="ContentsName") $where[] = "a.ContentsName LIKE '%$sw%'";
        if($col=="Cnt") $where[] = "a.Cnt = '$sw'";
    }
}

//과정분류
if($Category1){
    $where[] = "a.Category1 = '$Category1'";
    
    if($Category2) $where[] = "a.Category2 = '$Category2'";
}

//직무분야
if($Keyword2) $where[] = "a.Keyword2 = '$Keyword2'";


$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$JoinQuery = " Course a
            LEFT OUTER JOIN CourseCategory b ON a.Category1=b.idx
            LEFT OUTER JOIN CourseCategory c ON a.Category2=c.idx ";

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
?>
<script>
function CourseCategorySelect() {
	var Category1Selected = $('#Category1 option:selected').val();

	$("span[id='Category2Area']").load('./course_category_select.php', { Category1: Category1Selected }, function () {});
}

function CourseCategorySelectAfter(Category1, Category2) {
	$("span[id='Category2Area']").load('./course_category_select.php', { Category1: Category1, Category2: Category2 }, function () {});
}

$(document).ready(function(){
	var Category1 = "<?=$Category1?>";
	var Category2 = "<?=$Category2?>";
	
	if(Category1){
		CourseCategorySelectAfter(Category1,Category2);
	}
});
</script>
	<div class="contentBody">
    	<h2>과정조회 관리</h2>
		<div class="conZone">
        	<form name="search" method="POST">
                <div class="searchPan">
                	<b>과정</b>&nbsp;&nbsp;
                	<select name="Category1" id="Category1" onchange="CourseCategorySelect()">
						<option value="">-- 대분류 선택 --</option>
						<?
						$SQL = "SELECT * FROM CourseCategory WHERE Deep=1 AND UseYN='Y' AND Del='N' ORDER BY OrderByNum ASC, idx ASC";
						//echo $SQL;
						$QUERY = mysqli_query($connect, $SQL);
						if($QUERY && mysqli_num_rows($QUERY)){
							while($ROW = mysqli_fetch_array($QUERY)){
						?>
						<option value="<?=$ROW['idx']?>" <?if($ROW['idx']==$Category1) {?>selected<?}?>><?=$ROW['CategoryName']?></option>
						<?
							}
						}
						?>
					</select>&nbsp;&nbsp;<span id="Category2Area"></span>
    				<b>직무분야</b>&nbsp;&nbsp;
    				<select name="Keyword2" id="Keyword2">
						<option value="" >전체</option>
    					<?
    					$SQL = "SELECT * FROM ContentsKeyword WHERE Category =2 ORDER BY OrderByNum";
    					//echo $SQL;
    					$QUERY = mysqli_query($connect, $SQL);
    					if($QUERY && mysqli_num_rows($QUERY)){
    						while($ROW = mysqli_fetch_array($QUERY)){
    					?>
    					<option value="<?=$ROW['idx']?>" <?if($ROW['idx']==$Keyword2) {?>selected<?}?>><?=$ROW['Keyword']?></option>
    					<?
    						}
    					}
    					?>
					</select>
    				<select name="col">
    					<option value="ContentsName" <?if($col=="ContentsName") { echo "selected";}?>>과정명</option>
    					<option value="Cnt" <?if($col=="Cnt") { echo "selected";}?>>조회수</option>
    				</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
				</div>
			</form>
			<div class="btnAreaTr02">
				<button type="button" name="ExcelBtn" id="ExcelBtn" class="btn btn_Green line" onclick="location.href='contents_count_excel.php?col=<?=$col?>&sw=<?=$sw?>'"><i class="fas fa-file-excel"></i> 검색항목 엑셀 출력</button>
          	</div>
            <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
            	<colgroup>
                    <col width="100px" />
                    <col width="300px" />
                    <col width="300px" />
                    <col width="" />
                    <col width="200px" />
              	</colgroup>
              	<tr>
                    <th>번호</th>
					<th>과정분류</th>
					<th>직무분야</th>
					<th>과정명</th>
					<th>조회수</th>
              	</tr>
				<?
				$SQL = "SELECT a.cnt , a.ContentsName , a.Category1, a.Category2, a.Keyword2 ,
	                           b.CategoryName AS Category1 , c.CategoryName AS Category2,
                               (SELECT Keyword FROM ContentsKeyword WHERE Category =2 AND idx = a.Keyword2) AS Keyword2Name
                        FROM $JoinQuery $where ORDER BY a.cnt , a.ContentsName  LIMIT $PAGE_CLASS->page_start, $page_size";
				//echo $SQL;
				//echo $where;
				$QUERY = mysqli_query($connect, $SQL);
				if($QUERY && mysqli_num_rows($QUERY)){
					while($ROW = mysqli_fetch_array($QUERY)){
						extract($ROW);
				?>
              	<tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><?=$Category1?> > <?=$Category2?></td>
					<td><?=$Keyword2Name?></td>
					<td><?=$ContentsName?></td>
					<td><?=$cnt?></td>
              	</tr>
              	<?
					}
				    mysqli_free_result($QUERY);
				}else{
				?>
				<tr>
					<td height="50" class="tc" colspan="4">등록된 목록이 없습니다.</td>
				</tr>
				<? 
				}
				?>
            </table>
            
		  	<?=$BLOCK_LIST?>
		</div>
	</div>
</div>
<? include "./include/include_bottom.php"; ?>