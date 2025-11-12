<?
$MenuType = "G";
?>
<? include "./include/include_top.php"; ?>
<?
##-- 검색 조건
$where = array();
if($sw){
    if($col=="") {
        $where[] = "";
    }else{
        if($col=="ID") $where[] = "a.ID='$sw'";
        if($col=="Name") $where[] = "c.Name='$sw'";
        if($col=="ContentsName") $where[] = "b.ContentsName='$sw'";
    }
}
$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$JoinQuery = " CourseFlexLike a
            LEFT JOIN CourseFlex b ON a.LectureCode = b.LectureCode
            LEFT JOIN `Member` c ON a.ID = c.ID
            LEFT OUTER JOIN CourseFlexCategory d ON b.Category1=d.idx
            LEFT OUTER JOIN CourseFlexCategory e ON b.Category2=e.idx";

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM $JoinQuery";
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
    	<h2>관심강의 관리</h2>
		<div class="conZone">
        	<form name="search" method="POST">
        		<input type="hidden" name="ctype" id="ctype" value="C">
                <div class="searchPan">
    				<select name="col">
    					<option value="ID" <?if($col=="ID") { echo "selected";}?>>아이디</option>
    					<option value="Name" <?if($col=="Name") { echo "selected";}?>>이름</option>
    					<option value="ContentsName" <?if($col=="ContentsName") { echo "selected";}?>>과정명</option>
    				</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
				</div>
			</form>
            <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
            	<colgroup>
                    <col width="40px" />
                    <col width="200px" />
                    <col width="200px" />
                    <col width="350px" />
                    <col width="" />
              	</colgroup>
              	<tr>
                    <th>번호</th>
					<th>아이디</th>
					<th>이름</th>
					<th>과정분류</th>
					<th>과정명</th>
              	</tr>
				<?
				$SQL = "SELECT a.ID , c.Name , d.CategoryName AS Category1 , e.CategoryName AS Category2  , b.ContentsName 
                        FROM $JoinQuery $where ORDER BY a.RegDate DESC  LIMIT $PAGE_CLASS->page_start, $page_size";
				//echo $SQL;
				$QUERY = mysqli_query($connect, $SQL);
				if($QUERY && mysqli_num_rows($QUERY)){
					while($ROW = mysqli_fetch_array($QUERY)){
						extract($ROW);
				?>
              	<tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><?=$ID?></td>
					<td><?=$Name?></td>
					<td><?=$Category1?> > <?=$Category2?></td>
					<td><?=$ContentsName?></td>
              	</tr>
              	<?
					}
				    mysqli_free_result($QUERY);
				}else{
				?>
				<tr>
					<td height="50" class="tc" colspan="5">등록된 관심강의가 없습니다.</td>
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