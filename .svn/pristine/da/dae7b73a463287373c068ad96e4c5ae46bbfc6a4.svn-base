<?
$MenuType = "H";
$PageName = "flex_inquiry";
$ReadPage = "flex_inquiry_read";
?>
<? include "./include/include_top.php"; ?>
<?
##-- 검색 조건
$where = array();

if($sw){
    if($col=="") $where[] = ""; else $where[] = "$col LIKE '%$sw%'";
}
$where[] = "Del='N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

##-- 정렬조건
if($orderby=="") $str_orderby = "ORDER BY RegDate DESC, idx DESC"; else $str_orderby = "ORDER BY $orderby";

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM FlexInquiry $where";
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
    	<h2>FLEX 문의</h2>
        <div class="conZone">
	        <!-- 검색 -->
			<form name="search" method="get">
                <div class="searchPan">
                	<select name="col">
						<option value="CompanyName" <?if($col=="CompanyName") { echo "selected";}?>>회사명</option>
						<option value="Name" <?if($col=="Name") { echo "selected";}?>>문의자 이름</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
                </div>
			</form>
			<!-- //검색 -->
            
            <!--목록 -->
            <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
	            <colgroup>
    	            <col width="80px" />
                    <col width="150px" />
                    <col width="100px" />
                    <col width="80px" />
                    <col width="80px" />
					<col width="80px" />
				</colgroup>
                <tr>
                    <th>번호</th>
                    <th>문의종류</th>
                    <th>회사명</th>
                    <th>문의자 이름</th>
                    <th>문의일</th>
					<th>처리상태</th>
                </tr>
				<?
				$SQL = "SELECT * FROM FlexInquiry $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
				//echo $SQL;
				$QUERY = mysqli_query($connect, $SQL);
				if($QUERY && mysqli_num_rows($QUERY)){
					while($ROW = mysqli_fetch_array($QUERY)){
						extract($ROW);
				?>
				<tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><?=$Inquiry_type_array[$ServiceType]?></td>
					<td><a href="Javascript:readRun('<?=$idx?>');"><?=$CompanyName?></a></td>
					<td><a href="Javascript:readRun('<?=$idx?>');"><?=$Name?></a></td>
					<td><?=$RegDate?></td>
					<td><?=$CounselStatus_array[$Status]?></td>
                </tr>
                <?
					}
    				mysqli_free_result($QUERY);
				}else{
				?>
				<tr>
					<td height="50" class="tc" colspan="5">등록된 내용이 없습니다.</td>
				</tr>
				<? 
				}
				?>
			</table>
			<!-- //목록 -->
                
            <!--페이지-->
	  		<?=$BLOCK_LIST?>
	  		<!--//페이지-->
		</div>
	</div>
</div>

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>